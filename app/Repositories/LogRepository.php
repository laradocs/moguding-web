<?php

namespace App\Repositories;

use App\Models\Log;

interface LogRepository
{
    public function findById ( int $id, bool $throw = false ): ?Log;

    public function createOrUpdate ( int $userId, array $attributes, int $id = 0 ): Log;
}
