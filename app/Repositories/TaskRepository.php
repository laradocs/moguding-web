<?php

namespace App\Repositories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

interface TaskRepository
{
    public function getByUserIdOrderLatest ( int $userId ): Collection;

    public function findById ( int $id, bool $throw = false ): ?Task;

    public function createOrUpdate ( int $userId, array $attributes, int $id = 0 ): Task;

    public function findOrFailById ( int $id, int $userId ): Task;
}
