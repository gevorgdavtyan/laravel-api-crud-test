<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
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
    public function register($params): array
    {
        return $this->generateUserToken(User::create($params));
    }

    /**
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

    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return User::all();
    }

    /**
     * @return mixed
     */
    public function getPosts(): mixed
    {
        return Auth::user()->posts()->get();
    }

}
