<?php

namespace App\Repositories\Dao;

use App\Models\Task;
use App\Repositories\TaskRepository;
use Illuminate\Database\Eloquent\Collection;

class TaskDao implements TaskRepository
{
    public function getByUserIdOrderLatest(int $userId): Collection
    {
        $models = Task::query()->where ( 'user_id', $userId )
            ->orderBy ( 'updated_at', 'desc' )
            ->get();

        return $models;
    }
}
