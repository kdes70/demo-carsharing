<?php

namespace App\Policies;

use App\Domains\Rentals\Rental;
use App\Domains\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RentalsPolicy
{

    use HandlesAuthorization;


    public function complete(User $user, Rental $rentals): bool
    {
        return $user->id === $rentals->user_id;
    }

}
