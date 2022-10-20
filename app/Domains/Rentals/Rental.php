<?php

namespace App\Domains\Rentals;

use App\Domains\Car\Car;
use App\Domains\Rentals\Enums\RentalsStatusEnum;
use App\Domains\User\User;
use Database\Factories\Domains\Rentals\RentalsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Rental extends Model
{

    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'status' => RentalsStatusEnum::class,
        'rent_start' => 'datetime',
        'rent_end' => 'datetime',
    ];

    protected static function newFactory(): RentalsFactory
    {
        return new RentalsFactory();
    }

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


}
