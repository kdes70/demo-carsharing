<?php

namespace App\Domains\Car\Enums;

enum CatTypeEnum: int
{

    case HATCHBACK = 0;
    case SEDAN = 1;
    case MPV = 2;
    case SUV = 3;
    case CROSSOVER = 4;
    case COUPE = 5;
    case CONVERTIBLE = 6;

    static function getCatTypes(): array
    {
        return [
            CatTypeEnum::HATCHBACK,
            CatTypeEnum::SEDAN,
            CatTypeEnum::MPV,
            CatTypeEnum::SUV,
            CatTypeEnum::CROSSOVER,
            CatTypeEnum::COUPE,
            CatTypeEnum::CONVERTIBLE,
        ];
    }

}

