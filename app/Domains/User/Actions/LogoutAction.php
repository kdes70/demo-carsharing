<?php

namespace App\Domains\User\Actions;


use App\Domains\User\User;
use Exception;
use Laravel\Sanctum\PersonalAccessToken;

final class LogoutAction
{

    /**
     * @throws Exception
     */
    public function handle(
        string $userId,
        ?PersonalAccessToken $token = null
    ): void {
        if ($token) {
            $token->delete();
        } else {
            $user = User::findOrFail($userId);
            $user->tokens()->delete();
        }
    }

}
