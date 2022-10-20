<?php

namespace App\Domains\Car;

use Database\Factories\Domains\Car\MakeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Make extends Model
{

    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    protected static function newFactory(): MakeFactory
    {
        return new MakeFactory();
    }

}
