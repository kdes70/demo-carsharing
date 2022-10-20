<?php

namespace App\Domains\User\Actions;

use App\Domains\User\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

final class RegisterAction
{

    public function handle(
        string $name,
        string $password,
        string $email,
    ): array {
        $user = User::create([
            'name' => $name,
            'password' => Hash::make($password),
            'email' => Str::lower($email),
        ]);

        $token = $user->createToken($email)->plainTextToken;

        return [
            'id' => $user->id,
            'name' => $user->name,
            'token' => $token,
        ];
    }

}
