<?php

namespace App\Repositories;

use App\Models\Account;
use Illuminate\Database\Eloquent\Collection;

interface AccountRepository
{
    public function getByUserId ( int $userId ): Collection;

    public function createOrUpdate ( int $userId, array $attributes, int $id = 0 ): Account;
}
