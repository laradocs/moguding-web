<?php

namespace App\Repositories\Dao;

use App\Exceptions\ModelNotFoundException;
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
     * @return Account|null
     */
    public function findById(int $id): ?Account
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

    public function delete(int $id): void
    {
        $model = $this->findById($id);
        if ( is_null ( $model ) ) {
            throw new ModelNotFoundException('删除失败，该账户不存在。');
        }
        $model->delete();
    }

    public function findOrFailById(int $id): Account
    {
        $model = Account::query()->findOrFail ( $id );

        return $model;
    }
}
