<?php

namespace App\Domains\Rentals\Actions;

use App\Domains\Rentals\Rental;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GetRentalsListAction
{

    public function handle(): LengthAwarePaginator
    {
        return Rental::with(['user', 'car'])->paginate();
    }

}
