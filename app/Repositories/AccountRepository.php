<?php

namespace App\Repositories;

use App\Models\Account;
use Illuminate\Database\Eloquent\Collection;

interface AccountRepository
{
    public function getByUserIdOrderLatest ( int $userId, array $columns = [ '*' ] ): Collection;

    public function findById ( int $id, bool $throw = false ): ?Account;

    public function createOrUpdate ( int $userId, array $attributes, int $id = 0 ): Account;

    public function findOrFailById ( int $id, int $userId ): Account;

    public function delete ( int $id, int $userId ): void;
}
