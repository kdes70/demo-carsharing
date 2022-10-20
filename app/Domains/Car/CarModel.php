<?php

namespace App\Domains\Car;

use App\Domains\Car\Make;
use Database\Factories\Domains\Car\CarModelFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CarModel extends Model
{

    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    protected static function newFactory(): CarModelFactory
    {
        return new CarModelFactory();
    }

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    public function make(): HasOne
    {
        return $this->hasOne(Make::class);
    }

}
