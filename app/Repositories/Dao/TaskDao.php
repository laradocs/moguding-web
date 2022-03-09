<?php

namespace App\Repositories\Dao;

use App\Exceptions\NoPermissionException;
use App\Exceptions\RecordNotFoundException;
use App\Models\Task;
use App\Repositories\TaskRepository;
use Illuminate\Database\Eloquent\Collection;

class TaskDao implements TaskRepository
{
    public function getByUserIdOrderLatest(int $userId, array $columns = ['*']): Collection
    {
        $models = Task::query()->where ( 'user_id', $userId )
            ->orderBy ( 'updated_at', 'desc' )
            ->get ( $columns );

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
        if ( ! $model->authorize($userId) ) {
            throw new NoPermissionException();
        }
        $model->account_id = $attributes [ 'account_id' ];
        $model->address_id = $attributes [ 'address_id' ];
        $model->type = $attributes [ 'type' ];
        $model->run = [
            'runRole' => $attributes [ 'run_role' ],
            'runTime' => $attributes [ 'run_time' ],
        ];
        $model->description = $attributes [ 'description ' ] ?? '';
        $model->status = $attributes [ 'status' ];
        $model->save();

        return $model;
    }

    public function findOrFailById(int $id, int $userId): Task
    {
        $model = $this->findById($id, true);
        if ( ! $model->authorize($userId) ) {
            throw new NoPermissionException();
        }

        return $model;
    }

    public function delete(int $id, int $userId): void
    {
        $model = $this->findOrFailById($id, $userId);
        $model->delete();
    }
}
