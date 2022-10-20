<?php

namespace App\Domains\Rentals\Actions;

use App\Domains\Rentals\Enums\RentalsStatusEnum;
use App\Domains\Rentals\Rental;
use DomainException;

class CompleteRentAction
{

    public function handle(
        Rental $rental
    ): Rental {
        if (!in_array($rental->status,
            [RentalsStatusEnum::RENTED, RentalsStatusEnum::OVERDUE])) {
            throw new DomainException(trans('rental.not_complete'));
        }

        $rental->status = RentalsStatusEnum::RETURNED;
        $rental->save();

        return $rental;
    }

}
