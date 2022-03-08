<?php

namespace App\Repositories\Dao;

use App\Exceptions\NoPermissionException;
use App\Exceptions\RecordNotFoundException;
use App\Models\Account;
use App\Repositories\AccountRepository;
use Illuminate\Database\Eloquent\Collection;

class AccountDao implements AccountRepository
{
    public function getByUserIdOrderLatest(int $userId): Collection
    {
        $models = Account::where ( 'user_id', $userId )
            ->orderBy ( 'updated_at', 'desc' )
            ->get();

        return $models;
    }

    public function findById(int $id, bool $throw = false): ?Account
    {
        $model = Account::find ( $id );
        if ( empty ( $model ) && $throw ) {
            throw new RecordNotFoundException();
        }

        return $model;
    }

    public function findOrFailById(int $id, int $userId): Account
    {
        $model = $this->findById($id, true);
        if ( ! $model->authorize($userId) ) {
            throw new NoPermissionException();
        }

        return $model;
    }

    public function createOrUpdate(int $userId, array $attributes, int $id = 0): Account
    {
        $model = $this->findById($id);
        if ( is_null ( $model ) ) {
            $model = new Account();
            $model->user_id = $userId;
        }
        if ( ! $model->authorize($userId) ) {
            throw new NoPermissionException();
        }
        $model->device = $attributes [ 'device' ];
        $model->phone = $attributes [ 'phone' ];
        $model->password = $attributes [ 'password' ];
        $model->status = true;
        $model->save();

        return $model;
    }

    public function delete(int $id, int $userId): void
    {
        $model = $this->findOrFailById($id, $userId);
        $model->delete();
    }
}
