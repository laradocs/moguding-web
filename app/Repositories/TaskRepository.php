<?php

namespace App\Repositories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

interface TaskRepository
{
    public function deleteBy(string $column, string $value): int;

    public function get(int $userId, string $direction = 'desc'): Collection;

    public function find(int $id, bool $throw = false): ?Task;

    public function updateOrCreate(int $userId, array $attributes, int $id = 0): Task;

    public function delete(int $id): Task;

    public function all(string $direction = 'asc'): Collection;

    public function updateStatus(int $id, bool $status): Task;
}
