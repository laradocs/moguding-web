<?php

namespace App\Repositories;

use App\Models\Address;
use Illuminate\Database\Eloquent\Collection;

interface AddressRepository
{
    public function get(int $userId, string $direction = 'desc'): Collection;

    public function find(int $id, bool $throw = false): ?Address;

    public function updateOrCreate(int $userId, array $attributes, int $id = 0): Address;

    public function delete(int $id): Address;
}
