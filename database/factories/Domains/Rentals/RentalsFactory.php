<?php

namespace Database\Factories\Domains\Rentals;

use App\Domains\Car\Car;
use App\Domains\Rentals\Enums\RentalsStatusEnum;
use App\Domains\Rentals\Rental;
use App\Domains\User\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Domains\Rentals\Rental>
 */
class RentalsFactory extends Factory
{

    protected $model = Rental::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
          'car_id' => Car::factory(),
          'user_id' => User::factory(),
          'comment' => $this->faker->sentence,
          'status' => $this->faker->randomElement(
            RentalsStatusEnum::getStates()
          ),
          'rent_start' => \Carbon\Carbon::now(),
          'rent_end' => \Carbon\Carbon::now()->addDays(rand(1, 5)),
        ];
    }

}
