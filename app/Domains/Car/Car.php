<?php

namespace App\Domains\Car;

use App\Domains\Car\Enums\CarStatusEnum;
use App\Domains\Car\Enums\CatTypeEnum;
use App\Domains\Car\Enums\TransmissionEnum;
use Database\Factories\Domains\Car\CarFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Car extends Model
{

    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'type' => CatTypeEnum::class,
        'transmission' => TransmissionEnum::class,
        'status' => CarStatusEnum::class,
    ];

    protected static function newFactory(): CarFactory
    {
        return new CarFactory();
    }

    public function carModel(): HasOne
    {
        return $this->hasOne(CarModel::class);
    }

}
