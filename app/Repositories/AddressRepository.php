<?php

namespace App\Repositories;

use App\Models\Address;
use Illuminate\Database\Eloquent\Collection;

interface AddressRepository
{
    public function getByUserIdOrderLatest ( int $userId, array $columns = [ '*' ] ): Collection;

    public function findById ( int $id, bool $throw = false ): ?Address;

    public function createOrUpdate ( int $userId, array $attributes, int $id = 0 ): Address;

    public function findOrFailById ( int $id, int $userId ): Address;

    public function delete ( int $id, int $userId ): void;
}
