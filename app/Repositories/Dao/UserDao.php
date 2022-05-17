<?php

namespace App\Repositories\Dao;

use App\Exceptions\BusinessException;
use App\Exceptions\EmailException;
use App\Exceptions\NameException;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class UserDao implements UserRepository
{
    public function find(int $id, bool $throw = false): ?User
    {
        $model = User::find($id);
        if (is_null($model) && $throw) {
            throw new BusinessException('该用户不存在', Response::HTTP_NOT_FOUND);
        }

        return $model;
    }

    public function updateOrCreate(array $attributes, int $id = 0): User
    {
        $model = $this->find($id);
        if ($model && ! Gate::allows('update', $model)) {
            throw new BusinessException('权限不足', Response::HTTP_FORBIDDEN);
        }
        $name = $attributes['name'];
        if (($model?->name != $name) && $this->existsByName($name)) {
            throw new NameException('该名称已经存在。');
        }
        $email = $attributes['email'];
        if (($model?->email !== $email && $this->existsByEmail($email))) {
            throw new EmailException('该邮箱已经存在。');
        }
        if (is_null($model)) {
            $model = new User();
        }
        $model->name = $name;
        $model->email = $attributes['email'];
        $model->gender = $attributes['gender'];
        $model->password = $attributes['password'];
        $model->save();

        return $model;
    }

    public function existsByEmail(string $email): bool
    {
        return $this->existsBy('email', $email);
    }

    public function existsByName(string $name): bool
    {
        return $this->existsBy('name', $name);
    }

    protected function existsBy(string $column, string $value): bool
    {
        return User::query()
            ->where($column, $value)
            ->exists();
    }
}
