<?php

namespace App\Domains;

use App\Domains\Car\Car;
use App\Domains\Rentals\Enums\RentalsStatusEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Rentals extends Model
{

    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'status' => RentalsStatusEnum::class,
        'rent_start' => 'datetime',
        'rent_end' => 'datetime',
    ];

    public function car(): HasOne
    {
        return $this->hasOne(Car::class);
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }


}
