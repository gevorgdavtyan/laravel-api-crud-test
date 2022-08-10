<?php

namespace App\Http\Controllers\Api;

use App\Services\UserService;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;

class AuthController extends BaseController
{
    /**
     * Register api
     *
     * @param Request $request
     * @param UserService $userService
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request, UserService $userService)
    {
        try {
            $result = $userService->register($request->all());
        } catch (\Exception $exception) {
            return $this->sendError('Validation Error.', ['error' => $exception->getMessage()], 422);
        }

        return $this->sendResponse($result, 'User register successfully.');
    }

    /**
     * Login api
     *
     * @param Request $request
     * @param UserService $userService
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request, UserService $userService)
    {
        try {
            return $this->sendResponse($userService->login($request->only(
                'email',
                'password'
            )), 'User login successfully.');
        } catch (\Exception $exception) {
            return $this->sendError('Unauthorised.', ['error' => $exception->getMessage()], 401);
        }
    }

}
