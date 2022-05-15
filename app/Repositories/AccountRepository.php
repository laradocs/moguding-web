<?php

namespace App\Repositories;

use App\Models\Account;
use Illuminate\Database\Eloquent\Collection;

interface AccountRepository
{
    public function get(int $userId, string $direction = 'desc'): Collection;

    public function find(int $id, bool $throw = false): ?Account;

    public function updateOrCreate(int $userId, array $attributes, int $id = 0): Account;

    public function existsByPhone(string $phone): bool;

    public function updateStatus(int $id, bool $status): Account;

    public function delete(int $id): Account;
}
