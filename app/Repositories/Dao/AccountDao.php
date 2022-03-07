<?php

namespace App\Repositories\Dao;

use App\Models\Account;
use App\Models\User;
use App\Repositories\AccountRepository;
use Illuminate\Database\Eloquent\Collection;

class AccountDao implements AccountRepository
{
    public function getByUserId(int $userId): Collection
    {
        $models = Account::where ( 'user_id', $userId )->get();

        return $models;
    }

    /**
     * @param int $id
     * @return User|null
     */
    public function findById ( int $id ): ?User
    {
        $model = Account::find ( $id );

        return $model;
    }

    public function createOrUpdate(int $userId, array $attributes, int $id = 0): Account
    {
        $model = $this->findById($id);
        if ( is_null ( $model ) ) {
            $model = new Account();
            $model->user_id = $userId;
        }
        $model->device = $attributes [ 'device' ];
        $model->phone = $attributes [ 'phone' ];
        $model->password = $attributes [ 'password' ];
        $model->status = true;
        $model->save();

        return $model;
    }
}
