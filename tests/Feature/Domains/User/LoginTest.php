<?php

namespace Tests\Feature\Domains\User;

use App\Domains\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class LoginTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function a_guest_can_login_by_email()
    {
        User::factory()->create([
            'email' => 'john@doe.com',
            'email_verified_at' => now(),
        ]);

        $this->login()
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
    }

    /** @test */
    public function a_guest_can_not_login_if_not_active()
    {
        User::factory()->create([
            'email' => 'john@doe.com',
            'email_verified_at' => null,
        ]);

        $res = $this->login()
            ->assertJsonValidationErrors([
                'email' => __('auth.blocked'),
            ]);
    }

    /** @test */
    public function a_user_can_not_login()
    {
        $this->signIn();

        $this->login()
            ->assertForbidden();;
    }


    /** @test */
    public function it_requires_email()
    {
        $this->login(['email' => null])
            ->assertJsonValidationErrors('email');

        $this->login(['email' => 'this-is-no-email'])
            ->assertJsonValidationErrors('email');
    }

    /** @test */
    public function it_requires_password()
    {
        $this->login(['password' => null])
            ->assertJsonValidationErrors('password');
    }

    /** @test */
    public function it_requires_correct_password()
    {
        User::factory()->create([
            'email' => 'john@doe.com',
        ]);

        $this->login(['password' => 'incorrect-password'])
            ->assertJsonValidationErrors([
                'email' => __('auth.failed'),
            ]);
    }


    protected function login($attributes = []): TestResponse
    {
        return $this->postJson(route('api.auth.login'), array_merge([
            'email' => 'john@doe.com',
            'password' => 'password',
        ], $attributes));
    }

}
