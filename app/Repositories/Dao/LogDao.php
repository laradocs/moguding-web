<?php

namespace App\Repositories\Dao;

use App\Models\Log;
use App\Repositories\LogRepository;

class LogDao implements LogRepository
{
    public function create(array $attributes): Log
    {
        $model = new Log();
        $model->user_id = $attributes [ 'userId' ];
        $model->detail = [
            'device' => $attributes [ 'device' ],
            'account' => $attributes [ 'phone' ],
            'address'  => $attributes [ 'address' ],
            'type' => $attributes [ 'type' ],
            'runTime' => $attributes [ 'runTime' ],
            'status' => $attributes [ 'status' ],
            'description' => $attributes [ 'description' ],
        ];
        $model->save();

        return $model;
    }
}
