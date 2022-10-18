<?php

namespace App\Domains\Car\Enums;

enum CarStatusEnum: int
{

    case AVAILABLE = 0;

    case RENTED = 1;

    case DAMAGED = 2;

    case REPAIRED = 3;

    static function getStates(): array
    {
        return [
            CarStatusEnum::AVAILABLE,
            CarStatusEnum::RENTED,
            CarStatusEnum::DAMAGED,
            CarStatusEnum::REPAIRED,
        ];
    }

}
