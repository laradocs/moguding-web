<?php

namespace App\Repositories\Dao;

use App\Exceptions\BusinessException;
use App\Models\Task;
use App\Repositories\TaskRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class TaskDao implements TaskRepository
{
    public function deleteBy(string $column, string $value): int
    {
        return Task::query()
            ->where($column, $value)
            ->delete();
    }

    public function get(int $userId, string $direction = 'desc'): Collection
    {
        $models = Task::query()
            ->with(['account', 'address'])
            ->where('user_id', $userId)
            ->orderBy('id', $direction)
            ->get();

        return $models;
    }

    public function find(int $id, bool $throw = false): ?Task
    {
        $model = Task::find($id);
        if (is_null($model) && $throw) {
            throw new BusinessException('任务不存在', Response::HTTP_NOT_FOUND);
        }

        return $model;
    }

    public function updateOrCreate(int $userId, array $attributes, int $id = 0): Task
    {
        $model = $this->find($id);
        if ($model && ! Gate::allows('own', $model)) {
            throw new BusinessException('权限不足', Response::HTTP_FORBIDDEN);
        }
        if (is_null($model)) {
            $model = new Task();
            $model->user_id = $userId;
        }
        $model->account_id = $attributes['account'];
        $model->address_id = $attributes['address'];
        $model->type = $attributes['type'];
        $model->run = [
            'role' => $attributes['run_role'],
            'time' => $attributes['run_time'],
        ];
        $model->description = $attributes['description'] ?? '';
        $model->status = $attributes['status'];
        $model->save();

        return $model;
    }

    public function delete(int $id): Task
    {
        $model = $this->find($id, true);
        if (! Gate::allows('own', $model)) {
            throw new BusinessException('权限不足', Response::HTTP_FORBIDDEN);
        }
        $model->delete();

        return $model;
    }

    public function all(string $direction = 'asc'): Collection
    {
        $models = Task::query()
            ->with(['account', 'address'])
            ->where('status', true)
            ->orderBy('id', $direction)
            ->get();

        return $models;
    }

    public function updateStatus(int $id, bool $status): Task
    {
        $model = $this->find($id, true);
        $model->status = $status;
        $model->save();

        return $model;
    }
}
