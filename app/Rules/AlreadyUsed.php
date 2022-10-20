<?php

namespace App\Rules;

use App\Domains\Rentals\Rental;
use Illuminate\Contracts\Validation\InvokableRule;

class AlreadyUsed implements InvokableRule
{

    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     *
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        if (Rental::where('car_id', $value)->exists()) {
            $fail(trans('rental.car_rented'));
        }
    }

}
