<?php

namespace App\Console;

use App\Jobs\ProcessPunch;
use App\Models\Task;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Laradocs\Moguding\Exceptions\RequestTimeoutException;
use Laradocs\Moguding\Exceptions\UnauthenticatedException;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->job ( function () {
            $tasks = Task::with ( [ 'user', 'account', 'address' ] )->get();
            foreach ( $tasks as $task ) {
                if ( ! $task->status || ! $task->account->status || ( $task->run [ 'runTime' ] != date ( 'H:i' ) ) ) {
                    continue;
                }
                ProcessPunch::dispatch ( $task );
            }
        });
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
