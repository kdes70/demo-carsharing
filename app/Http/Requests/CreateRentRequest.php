<?php

namespace App\Http\Requests;

use App\Rules\AlreadyUsed;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

/**
 * @property int $car_id
 * @property string $rent_start
 * @property string $rent_end
 * @property string $comment
 */
class CreateRentRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'car_id' => ['required', 'exists:cars,id', new AlreadyUsed],
            'rent_start' => 'required|date',
            'rent_end' => 'required|date|after:rent_start',
            'comment' => 'string',
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function (Validator $validator) {
            if ($this->isUserAlreadyHasRentalCar()) {
                $validator->errors()->add('user', trans('rental.already'));
            }
        });
    }

    private function isUserAlreadyHasRentalCar(): bool
    {
        return $this->user()->isRentActive();
    }

}
