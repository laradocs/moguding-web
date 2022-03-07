<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface AccountRepository
{
    public function getByUserId ( int $userId ): Collection;
}
