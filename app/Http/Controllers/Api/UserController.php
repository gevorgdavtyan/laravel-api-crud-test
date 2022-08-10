<?php

namespace App\Http\Controllers\Api;

use App\Services\PostService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;

class UserController extends BaseController
{
    /**
     * @var UserService
     */
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->sendResponse($this->userService->getAll(), 'Users retrieved successfully.');
    }

    /**
     * Display a listing of posts by auth user.
     *
     * @return JsonResponse
     */
    public function showPosts(): JsonResponse
    {
        return $this->sendResponse($this->userService->getUserPosts(), 'User posts retrieved successfully.');
    }

}
