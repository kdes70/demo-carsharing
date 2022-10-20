<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $name
 * @property string $email
 * @property string $password
 */
final class RegisterRequest extends FormRequest
{

    public function authorize(): bool
    {
        return !$this->user();
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'min:3',
                'max:14',
                'string',
                'unique:users',
            ],
            'password' => [
                'required',
                'min:6',
                'max:32',
            ],
            'email' => [
                'required',
                'max:64',
                'email',
                'unique:users',
            ],
        ];
    }

}
