<?php

namespace App\Repositories\Dao;

use App\Models\User;
use App\Repositories\UserRepository;

class UserDao implements UserRepository
{
    /**
     * Get a model instance.
     *
     * @param int $id
     * @return User|null
     */
    public function findById(int $id): ?User
    {
        $model = User::find ( $id );

        return $model;
    }

    /**
     * Create or update a model instance.
     *
     * @param array $attributes
     * @param int $id
     * @return User
     */
    public function createOrUpdate(array $attributes, int $id = 0): User
    {
        $model = $this->findById($id);
        if ( is_null ( $model ) ) {
            $model = new User();
            $model->email = $attributes [ 'email' ];
        }
        $model->name = $attributes [ 'name' ];
        $model->gender = $attributes [ 'gender' ];
        $model->avatar = $attributes [ 'avatar' ] ?? '';
        $model->password = $attributes [ 'password' ];
        $model->save();

        return $model;
    }
}
