<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserRepository
{
    /**
     * Returns User or thrown exception
     *
     * @param int $id
     * @return User
     */
    public function find(int $id): User
    {
        return User::query()->findOrFail($id);
    }

    /**
     * @param $params
     * @return array
     */
    public function registerNewUser($params): array
    {
        return $this->generateUserToken(User::create($params));
    }

    /**
     * @param $params
     * @return array
     */
    public function login(): array
    {
        return $this->generateUserToken(Auth::user());
    }

    /**
     * @param $user
     * @return array
     */
    private function generateUserToken($user): array
    {
        return [
            'token' => $user->createToken('CrudApp')->plainTextToken,
            'name' => $user->name,
        ];
    }

}
