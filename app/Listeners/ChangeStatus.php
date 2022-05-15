<?php

namespace App\Listeners;

use App\Events\Failed;
use App\Repositories\AccountRepository;
use App\Repositories\TaskRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class ChangeStatus
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
    public function handle(Failed $event)
    {
        /** @var TaskRepository $tasks */
        $tasks = app(TaskRepository::class);
        /** @var AccountRepository $accounts */
        $accounts = app(AccountRepository::class);
        DB::transaction(function () use ($event, $tasks, $accounts) {
            $tasks->updateStatus($event->task->id, false);
            $accounts->updateStatus($event->account->id, false);
        });
    }
}
