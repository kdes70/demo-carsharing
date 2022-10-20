<?php

namespace App\Http\Controllers\Api\Auth;

use App\Domains\User\Actions\LogoutAction;
use App\Http\Controllers\Api\ApiController;
use Exception;
use Illuminate\Http\Request;

final class LogoutController extends ApiController
{

    public static bool $needAuth = true;

    /**
     * @throws Exception
     */
    public function __invoke(Request $request, LogoutAction $action)
    {
        $action->handle(
            $request->user()->id,
            $request->user()->currentAccessToken(),
        );
    }

}
