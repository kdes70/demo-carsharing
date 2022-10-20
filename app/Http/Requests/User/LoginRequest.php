<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $email
 * @property string $password
 */
final class LoginRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email|min:4|max:64',
            'password' => 'required',
        ];
    }

    //    public function messages()
    //    {
    //        return [
    //            'email.required' => trans('auth.username.required'),
    //            'email.email' => trans('auth.email.email'),
    //            'password.required' => trans('auth.password.required'),
    //        ];
    //    }

}
