<?php

use App\Domains\Rentals;

class GetRentalsList
{
    public function __invoke(){
       $res =  Rentals::with(['user', 'car'])->get();

       return $res
    }
}
