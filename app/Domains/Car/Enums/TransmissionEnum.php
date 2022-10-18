<?php

namespace App\Domains\Car\Enums;

enum TransmissionEnum: int
{

    case AUTOMATIC = 0;
    case MECHANIC = 1;

    static function getTransmissions(): array
    {
        return [
            TransmissionEnum::AUTOMATIC,
            TransmissionEnum::MECHANIC,
        ];
    }

}
