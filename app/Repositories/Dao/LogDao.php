<?php

namespace App\Repositories\Dao;

use App\Exceptions\NoPermissionException;
use App\Exceptions\RecordNotFoundException;
use App\Models\Log;
use App\Repositories\LogRepository;

class LogDao implements LogRepository
{
    public function findById(int $id, bool $throw = false): ?Log
    {
        $model = Log::find ( $id );
        if ( is_null ( $model ) && $throw ) {
            throw new RecordNotFoundException();
        }

        return $model;
    }

    public function createOrUpdate(int $userId, array $attributes, int $id = 0): Log
    {
        $model = $this->findById($id);
        if ( is_null ( $model ) ) {
            $model = new Log();
            $model->user_id = $userId;
        }
        if ( ! $model->authorize($userId) ) {
            throw new NoPermissionException();
        }

        return $model;
    }
}
