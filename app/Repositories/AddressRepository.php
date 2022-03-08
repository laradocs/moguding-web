<?php

namespace App\Repositories;

use App\Models\Address;
use Illuminate\Database\Eloquent\Collection;

interface AddressRepository
{
    public function getByUserIdOrderLatest ( int $userId ): Collection;

    public function createOrUpdate ( int $userId, array $attributes, int $id = 0 ): Address;

    public function findOrFailById ( int $id, int $userId ): Address;
}
