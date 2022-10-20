<?php

namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ApiController extends BaseController
{

    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    public static bool $needAuth = false;

    public static bool $onlyGuests = false;

    public function __construct()
    {
        if (static::$needAuth) {
            $this->middleware('auth:sanctum');
        }

        if (static::$onlyGuests) {
            $this->middleware('guest');
        }
    }

    public function sendResponse(
        array|JsonResource $data,
        string $message = ''
    ): JsonResponse {
        $resource = [
            'success' => true,
            'data' => $data,
            'message' => $message,
        ];

        return response()->json($resource, ResponseAlias::HTTP_OK);
    }

    public function sendError(
        string $error,
        array $errorMessages = [],
        int $code = 404
    ) {
        $resource = [
            'success' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $resource['data'] = $errorMessages;
        }

        return response()->json($resource, $code);
    }

}
