<?php

namespace App\Listeners;

use App\Events\Deleted;
use App\Exceptions\BusinessException;
use App\Repositories\TaskRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class BatchDeleteTask
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(Deleted $event)
    {
        /** @var TaskRepository $tasks */
        $tasks = app(TaskRepository::class);
        DB::transaction(function () use ($event, $tasks) {
            $tasks->deleteBy($this->modelToLowercase($event->model) . '_id', $event->model->id);
            $event->model->delete();
        });
    }

    protected function modelToLowercase($model): string
    {
        $class = get_class($model);

        return strtolower(class_basename($class));
    }
}
