<?php

namespace App\Jobs;

use App\Events\Failed;
use App\Models\Account;
use App\Repositories\TaskRepository;
use App\Services\ManagerProcessor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Exception;

class ProcessSign implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(ManagerProcessor $processor)
    {
        /** @var TaskRepository $tasks */
        $tasks = app(TaskRepository::class)->all();
        foreach ($tasks as $task) {
            $account = (clone $task)->account;
            if (! $this->enable($account) || ! $this->timeout($task->run['time'])) {
                continue;
            }
            try {
                $user = $processor->login($account->device, $account->phone, $account->password);
            } catch (Exception) {
                Failed::dispatch($task, $account);
                continue;
            }
            $address = (clone $task)->address;
            $plans = $processor->getPlan($user['token'], $user['userType'], $user['userId']);
            foreach ($plans as $plan) {
                $processor->save(
                    $user['token'],
                    $user['userId'],
                    $address->province,
                    $address->city,
                    $address->address,
                    $address->longitude,
                    $address->latitude,
                    $task->type,
                    $account->device,
                    $plan['planId'],
                    $task->description
                );
            }
        }
    }

    protected function enable(Account $account): bool
    {
        return $account->status ? true : false;
    }

    protected function timeout(string $time): bool
    {
        return date('H:i') == $time;
    }
}
