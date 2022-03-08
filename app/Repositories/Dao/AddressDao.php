<?php

namespace App\Repositories\Dao;

use App\Exceptions\NoPermissionException;
use App\Exceptions\RecordNotFoundException;
use App\Models\Account;
use App\Models\Address;
use App\Repositories\AddressRepository;
use Illuminate\Database\Eloquent\Collection;

class AddressDao implements AddressRepository
{
    public function getByUserIdOrderLatest(int $userId): Collection
    {
        $models = Address::where ( 'user_id', $userId )
            ->orderBy ( 'updated_at', 'desc' )
            ->get();

        return $models;
    }

    public function findById(int $id, bool $throw = false): ?Address
    {
        $model = Address::find ( $id );
        if ( is_null ( $model ) && $throw ) {
            throw new RecordNotFoundException();
        }

        return $model;
    }

    public function createOrUpdate(int $userId, array $attributes, int $id = 0): Address
    {
        $model = $this->findById($id);
        if ( is_null ( $model ) ) {
            $model = new Address();
            $model->user_id = $userId;
        }
        if ( ! $model->authorize ( $userId ) ) {
            throw new NoPermissionException();
        }
        $model->province = $attributes [ 'province' ];
        $model->city = $attributes [ 'city' ] ?? '';
        $model->address = $attributes [ 'address' ];
        $model->longitude = $attributes [ 'longitude' ];
        $model->latitude = $attributes [ 'latitude' ];
        $model->save();

        return $model;
    }

    public function findOrFailById(int $id, int $userId): Address
    {
        $model = $this->findById($id, true);
        if ( ! $model->authorize($userId) ) {
            throw new NoPermissionException();
        }

        return $model;
    }

    public function delete(int $id, int $userId): void
    {
        $model = $this->findOrFailById($id, $userId);
        $model->delete();
    }
}
