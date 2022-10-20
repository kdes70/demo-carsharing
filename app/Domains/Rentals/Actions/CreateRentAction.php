<?php

namespace App\Domains\Rentals\Actions;

use App\Domains\Rentals\Enums\RentalsStatusEnum;
use App\Domains\Rentals\Rental;
use App\Domains\User\User;

class CreateRentAction
{

    public function handle(
        User $user,
        int $carId,
        $rentStartAt,
        $rentEndAt,
        $comment
    ): Rental {
        $rent = new Rental();
        $rent->car_id = $carId;
        $rent->user_id = $user->id;
        $rent->rent_start = $rentStartAt;
        $rent->rent_end = $rentEndAt;
        $rent->comment = $comment;
        $rent->status = RentalsStatusEnum::RENTED;
        $rent->save();

        $rent->setRelation('user', $user);

        return $rent->load(['car']);
    }

}
