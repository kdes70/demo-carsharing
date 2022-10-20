<?php

namespace App\Http\Controllers\Api\V1\Rentals;

use App\Domains\Rentals\Actions\CreateRentAction;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\CreateRentRequest;
use App\Http\Resources\RentalsResource;
use Illuminate\Http\JsonResponse;

class RentalCreateController extends ApiController
{

    public static bool $needAuth = true;


    public function __invoke(
        CreateRentRequest $request,
        CreateRentAction $action

    ): JsonResponse {
        $user = $request->user();

        $rent = $action->handle(
            $user,
            $request->car_id,
            $request->rent_start,
            $request->rent_end,
            $request->comment
        );

        return $this->sendResponse(new RentalsResource($rent));
    }

}
