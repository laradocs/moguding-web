<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface TaskRepository
{
    public function getByUserIdOrderLatest ( int $userId ): Collection;
}
