<?php

namespace App\Http\Controllers\Api\Auth;


use App\Domains\User\Actions\RegisterAction;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\User\RegisterRequest;

class RegisterController extends ApiController
{

    public static bool $onlyGuests = true;

    public function __invoke(RegisterRequest $request, RegisterAction $action)
    {
        $user = $action->handle(
            $request->name,
            $request->password,
            $request->email,
        );

        return $this->sendResponse($user, trans('auth.register.success'));
    }

}
