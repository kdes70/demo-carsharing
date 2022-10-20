<?php

namespace App\Domains\User\Actions;

use App\Domains\User\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

final class LoginAction
{

    private ?User $user;

    /**
     * @throws ValidationException
     */
    public function handle(string $email, string $password): array
    {
        $this->user = User::whereEmail($email)
            ->first();

        if (!$this->user || !$this->verifyPassword($password)) {
            $this->badCredentials();
        }

        if (!$this->user->email_verified_at) {
            $this->userIsBlocked();
        }

        return [
            'id' => $this->user->id,
            'name' => $this->user->username,
            'token' => $this->createAuthToken(),
        ];
    }

    private function verifyPassword(string $password): bool
    {
        return Hash::check(
            $password,
            $this->user->password
        );
    }

    private function createAuthToken(): string
    {
        return $this->user
            ->createToken($this->user->email)
            ->plainTextToken;
    }

    /**
     * @throws ValidationException
     */
    private function userIsBlocked()
    {
        throw ValidationException::withMessages(['email' => __('auth.blocked')]);
    }

    /**
     * @throws ValidationException
     */
    private function badCredentials(): void
    {
        throw ValidationException::withMessages(['email' => __('auth.failed')]);
    }

}
