<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class LoginController extends \App\Http\Controllers\Auth\LoginController
{

    /**
     * Login using api POST request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {

        $this->validateLogin($request);

        if ($this->attemptLogin($request)) {
            $user = $this->guard()->user();
            $user->generateToken();

            return response()->returnJson($user->toArray());
        }

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Logout using api POST request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $user = Auth::guard('api')->user();

        if ($user) {
            $user->api_token = null;
            $user->save();
        }

        $result = ['msg' => 'User logged out.'];

        return response()->returnJson($result);
    }

    /**
     * Send failed login response
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        $exception = new \Exception(trans('auth.failed'), Response::HTTP_UNPROCESSABLE_ENTITY);

        return response()->returnJson([], $exception, Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}