<?php

namespace Tests\Feature\Domains\User;

use App\Domains\User\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

final class RegisterTest extends TestCase
{

    public function test_a_guest_can_register()
    {
        $this->registerUser([
            'name' => 'JohnDoe',
            'password' => 'p@$$s0rD',
            'email' => 'john@doe.com',
        ])
            ->assertSuccessful()
            ->assertJsonStructure([
                'success',
                'data' => [
                    'id',
                    'name',
                    'token',
                ],
                'message',
            ]);

        $this->assertDatabaseHas('users', [
            'name' => 'JohnDoe',
            'email' => 'john@doe.com',
        ]);

        $user = User::whereName('JohnDoe')->first();
        $this->assertTrue(Hash::check('p@$$s0rD', $user->password));
    }

    public function test_a_user_can_not_register()
    {
        $this->signIn();

        $this->registerUser()
            ->assertStatus(403);
    }

    /** @test */
    public function after_register_created_personal_token()
    {
        $response = $this->registerUser(['name' => 'JohnDoe']);


        $this->assertDatabaseHas('personal_access_tokens', [
            'tokenable_id' => $response->json('data.id'),
        ]);
    }

    /** @test */
    public function it_requires_name()
    {
        $this->registerUser(['name' => ''])
            ->assertJsonValidationErrors('name');
    }

    /** @test */
    public function it_requires_a_name_which_is_min_3_chars()
    {
        $this->registerUser(['name' => 'jo'])
            ->assertJsonValidationErrors('name');
    }

    /** @test */
    public function it_requires_a_name_which_is_max_14_chars()
    {
        $this->registerUser(['name' => 'o_john_doe_name'])
            ->assertJsonValidationErrors('name');
    }

    /** @test */
    public function it_requires_a_correct_name()
    {
        $this->registerUser([
            'name' => 'Jonh_Doe82',
            'email' => 'john1@doe.com',
        ])
            ->assertSuccessful();

        $this->registerUser([
            'name' => 34534534,
            'email' => 'john3@doe.com',
        ])
            ->assertJsonValidationErrors('name');
    }

    /** @test */
    public function it_requires_unique_name()
    {
        $this->registerUser([
            'name' => 'JohnDoe',
            'email' => 'john@doe.com',
        ]);

        $this->registerUser([
            'name' => 'johnDOE',
            'email' => 'john-2@doe.com',
        ])->assertJsonValidationErrors('name');
    }

    /** @test */
    public function it_requires_a_password()
    {
        $this->registerUser(['password' => ''])
            ->assertJsonValidationErrors('password');
    }

    /** @test */
    public function it_requires_a_password_which_is_over_6_chars()
    {
        $this->registerUser(['password' => '12345'])
            ->assertJsonValidationErrors('password');
    }

    /** @test */
    public function it_requires_a_password_which_is_less_32_chars()
    {
        $this->registerUser(['password' => 'very-very-long-and-strong-password'])
            ->assertJsonValidationErrors('password');
    }

    /** @test */
    public function it_requires_an_email()
    {
        $this->registerUser(['email' => ''])
            ->assertJsonValidationErrors('email');
    }

    /** @test */
    public function it_requires_an_email_which_is_less_64_chars()
    {
        $this->registerUser(['email' => 'john_doe_email_which_is_over_64_chars_bla_bla_bla@sometimes.email'])
            ->assertJsonValidationErrors('email');
    }

    /** @test */
    public function it_requires_a_valid_email()
    {
        $this->registerUser(['email' => 'not-valid-email'])
            ->assertJsonValidationErrors('email');
    }

    /** @test */
    public function it_must_be_unique_a_email()
    {
        $this->registerUser([
            'name' => 'JohnDoe1',
            'email' => 'john@doe.com',
        ])
            ->assertSuccessful();

        $this->registerUser([
            'name' => 'JohnDoe2',
            'email' => 'John@Doe.com',
        ])
            ->assertJsonValidationErrors('email');
    }

    /** @test */
    public function email_must_be_save_in_lowercase()
    {
        $this->registerUser(['email' => 'JohnDoe@Gmail.com'])
            ->assertSuccessful();

        $user = User::whereEmail('johndoe@gmail.com')->first();
        $this->assertEquals('johndoe@gmail.com', $user->email);
    }

    protected function registerUser(array $attributes = []): TestResponse
    {
        return $this->postJson(route('api.auth.register'), array_merge([
            'name' => 'JohnDoe',
            'password' => 'p@$$sw0r*',
            'email' => 'john@doe.com',
        ], $attributes));
    }

}
