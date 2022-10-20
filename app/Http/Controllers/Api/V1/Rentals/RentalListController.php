<?php

namespace App\Http\Controllers\Api\V1\Rentals;

use App\Domains\Rentals\Actions\GetRentalsListAction;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\RentalsResource;
use Illuminate\Http\JsonResponse;

class RentalListController extends ApiController
{

    public static bool $needAuth = true;


    public function __invoke(GetRentalsListAction $action): JsonResponse
    {
        $rents = $action->handle();

        return $this->sendResponse(RentalsResource::collection($rents));
    }

}
