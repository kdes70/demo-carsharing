<?php

namespace App\Domains\Rentals\Enums;

enum RentalsStatusEnum: int
{

    case AVAILABLE = 0;

    case RENTED = 1;

    case RETURNED = 2;

    case RESERVED = 3;

    case OVERDUE = 4;

    static function getStates(): array
    {
        return [
            RentalsStatusEnum::RENTED,
            RentalsStatusEnum::AVAILABLE,
            RentalsStatusEnum::RETURNED,
            RentalsStatusEnum::RESERVED,
            RentalsStatusEnum::OVERDUE,
        ];
    }

}
