<?php

namespace Tests\Feature\Domains\User;

use App\Domains\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\PersonalAccessToken;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class LogoutTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function a_user_can_logout()
    {
        /** @var User $user */
        $user = User::factory()->create([
            'email' => 'john@doe.com',
        ]);

        $token = $user->createToken('test1')->plainTextToken;

        $this->assertDatabaseHas('personal_access_tokens', [
            'tokenable_id' => $user->id,
        ]);

        $this->postJson(route('api.auth.logout'), [], [
            'Authorization' => 'Bearer '.$token,
        ])->assertSuccessful();

        $this->assertDatabaseMissing('personal_access_tokens', [
            'tokenable_id' => $user->id,
        ]);
    }

    /** @test */
    public function a_guest_can_not_logout()
    {
        $this->postJson(route('api.auth.logout'))->assertStatus(401);
    }

    /** @test */
    public function after_failed_logout_must_be_user_log_created()
    {
        /** @var User $user */
        $user = User::factory()->create([
            'email' => 'john@doe.com',
        ]);

        $token = $user->createToken('test1')->plainTextToken;

        $this->postJson(route('api.auth.logout'), [], [
            'Authorization' => 'Bearer '.$token,
        ])->assertSuccessful();
    }

    /** @test */
    public function when_user_logout_delete_revoke_only_current_token()
    {
        /** @var User $user */
        $user = User::factory()->create([
            'email' => 'john@doe.com',
        ]);

        $token = $user->createToken('test1')->plainTextToken;

        $user->createToken('test2')->plainTextToken;

        $this->assertEquals(2,
            PersonalAccessToken::where('tokenable_id', $user->id)->count());

        $this->postJson(route('api.auth.logout'), [], [
            'Authorization' => 'Bearer '.$token,
        ])->assertSuccessful();

        $this->assertEquals(1,
            PersonalAccessToken::where('tokenable_id', $user->id)->count());
    }

}
