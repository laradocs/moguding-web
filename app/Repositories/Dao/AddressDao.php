<?php

namespace App\Repositories\Dao;

use App\Events\Deleted;
use App\Exceptions\BusinessException;
use App\Models\Address;
use App\Repositories\AddressRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class AddressDao implements AddressRepository
{
    public function get(int $userId, string $direction = 'desc'): Collection
    {
        $models = Address::query()
            ->where('user_id', $userId)
            ->orderBy('id', $direction)
            ->get();

        return $models;
    }

    public function find(int $id, bool $throw = false): ?Address
    {
        $model = Address::find($id);
        if (is_null($model) && $throw) {
            throw new BusinessException('该地址不存在。', Response::HTTP_NOT_FOUND);
        }

        return $model;
    }

    public function updateOrCreate(int $userId, array $attributes, int $id = 0): Address
    {
        $model = $this->find($id);
        if ($model && ! Gate::allows('own', $model)) {
            throw new BusinessException('权限不足。', Response::HTTP_FORBIDDEN);
        }
        if (is_null($model)) {
            $model = new Address();
            $model->user_id = $userId;
        }
        $model->province = $attributes['province'];
        $model->city = $attributes['city'] ?? '';
        $model->address = $attributes['address'];
        $model->longitude = $attributes['longitude'];
        $model->latitude = $attributes['latitude'];
        $model->save();

        return $model;
    }

    public function delete(int $id): Address
    {
        $model = $this->find($id, true);
        Deleted::dispatch($model);

        return $model;
    }
}
