<?php

namespace App\Http\Controllers\Api\V1\Rentals;

use App\Domains\Rentals\Actions\CompleteRentAction;
use App\Domains\Rentals\Rental;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\CompleteRentRequest;
use App\Http\Resources\RentalsResource;
use Illuminate\Http\JsonResponse;

class RentalCompleteController extends ApiController
{

    public static bool $needAuth = true;

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(
        CompleteRentRequest $request,
        CompleteRentAction $action

    ): JsonResponse {
        $rental = Rental::findOrFail($request->rental_id);

        $this->authorize('complete', $rental);

        $rent = $action->handle($rental);

        return $this->sendResponse(new RentalsResource($rent),
            trans('rental.completed'));
    }

}
