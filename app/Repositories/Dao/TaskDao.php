<?php

namespace App\Repositories\Dao;

use App\Exceptions\RecordNotFoundException;
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

    public function findById(int $id, bool $throw = false): ?Task
    {
        $model = Task::find ( $id );
        if ( is_null ( $model ) && $throw ) {
            throw new RecordNotFoundException();
        }

        return $model;
    }

    public function createOrUpdate(int $userId, array $attributes, int $id = 0): Task
    {
        $model = $this->findById($id);
        if ( is_null ( $model ) ) {
            $model = new Task();
            $model->user_id = $userId;
        }
        $model->account_id = $attributes [ 'account_id' ];
        $model->address_id = $attributes [ 'address_id' ];
        $model->type = $attributes [ 'type' ];
        $model->run = [
            'run_role' => $attributes [ 'run_role' ],
            'run_time' => $attributes [ 'run_time' ],
        ];
        $model->description = $attributes [ 'description ' ] ?? '';
        $model->status = $attributes [ 'status' ];
        $model->save();

        return $model;
    }
}
