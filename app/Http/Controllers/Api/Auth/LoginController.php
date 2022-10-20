<?php

namespace App\Http\Controllers\Api\Auth;

use App\Domains\User\Actions\LoginAction;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\User\LoginRequest;

final class LoginController extends ApiController
{

    public static bool $onlyGuests = true;

    public function __invoke(LoginRequest $request, LoginAction $action)
    {
        $user = $action->handle(
            $request->email,
            $request->password,
        );

        return $this->sendResponse($user, trans('auth.login.success'));
    }

}
