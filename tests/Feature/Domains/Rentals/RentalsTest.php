<?php

namespace Tests\Feature\Domains;

use App\Domains\Car\Car;
use App\Domains\Rentals\Enums\RentalsStatusEnum;
use App\Domains\Rentals\Rental;
use App\Domains\User\User;
use Tests\TestCase;

class RentalsTest extends TestCase
{

    public function test_unauthorized_user_cannot_rent()
    {
        $car = Car::factory()->create();

        $this
            ->postJson(route('api.rentals.add'), [
                'car_id' => $car->id,
            ])->assertUnauthorized();
    }

    public function test_user_it_rental_is_work(): void
    {
        $user = User::factory()->create();
        $car = Car::factory()->create();

        $this->signIn($user);

        $response = $this
            ->postJson(route('api.rentals.add'), [
                'car_id' => $car->id,
                'rent_start' => now(),
                'rent_end' => now()->addDay(),
                'comment' => 'Test rental car',
            ])->assertSuccessful()
            ->assertJsonStructure([
                'success',
                'data' => [
                    'id',
                    'car',
                    'user',
                    'status',
                    'rent_start',
                    'rent_end',
                ],
                'message',
            ]);


        $this->assertDatabaseHas((new Rental)->getTable(), [
            'id' => $response->json('data.id'),
            'car_id' => $response->json('data.car.id'),
            'user_id' => $response->json('data.user.id'),
            'status' => RentalsStatusEnum::RENTED,
        ]);
    }

    public function test_user_can_only_rent_one_car_at_time()
    {
        $user = User::factory()->create();
        $car1 = Car::factory()->create();

        Rental::factory([
            'user_id' => $user->id,
            'car_id' => $car1->id,
            'status' => RentalsStatusEnum::RENTED,
        ])->create();

        $car2 = Car::factory()->create();

        $this->signIn($user);

        $this
            ->postJson(route('api.rentals.add'), [
                'car_id' => $car2->id,
                'rent_start' => now(),
                'rent_end' => now()->addDay(),
                'comment' => 'Test rental car',
            ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['user' => trans('rental.already')]);

        $this->assertDatabaseCount((new Rental)->getTable(), 1);
    }

    public function test_cannot_rent_car_that_has_already_been_rented()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $car1 = Car::factory()->create();

        Rental::factory([
            'user_id' => $user1->id,
            'car_id' => $car1->id,
            'status' => RentalsStatusEnum::RENTED,
        ])->create();

        $this->signIn($user2);

        $this
            ->postJson(route('api.rentals.add'), [
                'car_id' => $car1->id,
                'rent_start' => now(),
                'rent_end' => now()->addDay(),
                'comment' => 'Test rental car',
            ])->assertUnprocessable()
            ->assertJsonValidationErrors(['car_id' => trans('rental.car_rented')]);

        $this->assertDatabaseCount((new Rental)->getTable(), 1);
    }


    public function test_start_date_lease_is_less_than_end_date()
    {
        $user = User::factory()->create();
        $car = Car::factory()->create();

        $this->signIn($user);

        $this
            ->postJson(route('api.rentals.add'), [
                'car_id' => $car->id,
                'rent_start' => now(),
                'rent_end' => now()->subDay(),
                'comment' => 'Test rental car',
            ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'rent_end' => trans('validation.after',
                    [
                        'attribute' => 'rent end',
                        'date' => 'rent start',
                    ]),
            ]);
    }


    public function test_user_it_complete_rental_is_work()
    {
        $user = User::factory()->create();
        $car = Car::factory()->create();

        $rentals = Rental::factory([
            'user_id' => $user->id,
            'car_id' => $car->id,
            'status' => RentalsStatusEnum::RENTED,
        ])->create();

        $this->signIn($user);

        $this
            ->putJson(route('api.rentals.complete'), [
                'rental_id' => $rentals->id,
            ])->assertSuccessful()
            ->assertJsonStructure([
                'success',
                'data' => [
                    'id',
                    'status',
                    'rent_start',
                    'rent_end',
                ],
                'message',
            ]);

        $this->assertDatabaseHas((new Rental)->getTable(), [
            'id' => $rentals->id,
            'status' => RentalsStatusEnum::RETURNED,
        ]);
    }

    public function test_user_it_complete_rental_is_guest()
    {
        $user = User::factory()->create();
        $car = Car::factory()->create();

        $rentals = Rental::factory([
            'user_id' => $user->id,
            'car_id' => $car->id,
            'status' => RentalsStatusEnum::RENTED,
        ])->create();

        $this
            ->putJson(route('api.rentals.complete'), [
                'rental_id' => $rentals->id,
            ])->assertUnauthorized();
    }

    public function test_user_cannot_end_rental_of_car_that_is_not_their_own()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $car = Car::factory()->create();

        $rentals = Rental::factory([
            'user_id' => $user1->id,
            'car_id' => $car->id,
            'status' => RentalsStatusEnum::RENTED,
        ])->create();

        $this->signIn($user2);

        $this
            ->putJson(route('api.rentals.complete'), [
                'rental_id' => $rentals->id,
            ])->assertForbidden();
    }

    public function test_canot_finish_car_that_hasn_been_rented()
    {
        $user = User::factory()->create();
        $car = Car::factory()->create();

        $rentals = Rental::factory([
            'user_id' => $user->id,
            'car_id' => $car->id,
            'status' => RentalsStatusEnum::RESERVED,
        ])->create();

        $this->signIn($user);

        $this
            ->putJson(route('api.rentals.complete'), [
                'rental_id' => $rentals->id,
            ])->assertStatus(500)
            ->assertJsonFragment([
                'message' => trans('rental.not_complete'),
            ]);
    }


    public function test_get_list_rentals_is_work()
    {
        $user = User::factory()->create();

        Rental::factory()->count(3)->create();

        $this->signIn($user);

        $this
            ->getJson(route('api.rentals.list'))
            ->assertSuccessful()
            ->assertJsonStructure([
                'success',
                'data' => [
                    [
                        'id',
                        'car',
                        'user',
                        'status',
                        'rent_start',
                        'rent_end',
                    ],
                ],
                'message',
            ]);
    }

    public function test_get_list_rentals_is_guest()
    {
        Rental::factory()->count(3)->create();
        $this
            ->getJson(route('api.rentals.list'))
            ->assertUnauthorized();
    }

}
