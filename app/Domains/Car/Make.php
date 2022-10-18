<?php

namespace App\Domains\Car;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Make extends Model
{

    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

}
