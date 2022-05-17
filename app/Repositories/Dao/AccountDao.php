<?php

namespace App\Repositories\Dao;

use App\Events\Deleted;
use App\Exceptions\BusinessException;
use App\Exceptions\PhoneException;
use App\Models\Account;
use App\Repositories\AccountRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class AccountDao implements AccountRepository
{
    public function get(int $userId, string $direction = 'desc'): Collection
    {
        $models = Account::query()
            ->where('user_id', $userId)
            ->orderBy('id', $direction)
            ->get();

        return $models;
    }

    public function find(int $id, bool $throw = false): ?Account
    {
        $model = Account::find($id);
        if (is_null($model) && $throw) {
            throw new BusinessException('账户不存在', Response::HTTP_NOT_FOUND);
        }

        return $model;
    }

    public function updateOrCreate(int $userId, array $attributes, int $id = 0): Account
    {
        $model = $this->find($id);
        if ($model && (! Gate::allows('own', $model))) {
            throw new BusinessException('权限不足', Response::HTTP_FORBIDDEN);
        }
        $phone = $attributes['phone'];
        if ($model?->phone != $phone && $this->existsByPhone($phone)) {
            throw new PhoneException('该手机号码已经存在。');
        }
        if (is_null($model)) {
            $model = new Account();
            $model->user_id = $userId;
        }
        $model->device = $attributes['device'];
        $model->phone = $phone;
        $model->password = $attributes['password'];
        $model->save();

        return $model;
    }

    public function existsByPhone(string $phone): bool
    {
        return $this->existsBy('phone', $phone);
    }

    protected function existsBy(string $column, string $value): bool
    {
        return Account::query()
            ->where($column, $value)
            ->exists();
    }

    public function updateStatus(int $id, bool $status): Account
    {
        $model = $this->find($id, true);
        $model->status = $status;
        $model->save();

        return $model;
    }

    public function delete(int $id): Account
    {
        $model = $this->find($id, true);
        if (! Gate::allows('own', $model)) {
            throw new BusinessException('权限不足', Response::HTTP_FORBIDDEN);
        }
        Deleted::dispatch($model);

        return $model;
    }
}
