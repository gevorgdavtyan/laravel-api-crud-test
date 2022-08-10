<?php

namespace App\Services;

use App\Http\Resources\PostResource;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\UnauthorizedException;
use InvalidArgumentException;

class UserService
{
    /**
     * @var UserRepository
     */
    protected UserRepository $userRep;

    public function __construct()
    {
        $this->userRep = new UserRepository();
    }

    /**
     * @param $params
     * @return array|InvalidArgumentException
     */
    public function register($params)
    {
        $validator = Validator::make($params, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        return $this->userRep->register($params);
    }

    public function login($params): array
    {
        if (Auth::attempt(['email' => $params['email'], 'password' => $params['password']])) {

            return $this->userRep->login();
        } else {
            throw new UnauthorizedException('Unauthorised');
        }
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function getAll(): AnonymousResourceCollection
    {
        return UserResource::collection($this->userRep->getAll());
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function getUserPosts(): AnonymousResourceCollection
    {
        return PostResource::collection($this->userRep->getPosts());
    }

}
