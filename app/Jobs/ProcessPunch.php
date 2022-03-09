<?php

namespace App\Jobs;

use App\Models\Task;
use App\Repositories\LogRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Laradocs\Moguding\Client;
use Laradocs\Moguding\Exceptions\RequestTimeoutException;
use Laradocs\Moguding\Exceptions\UnauthenticatedException;

class ProcessPunch implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Task $task;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /** @var LogRepository $logRepository */
        $logRepository = app ( LogRepository::class );
        /** @var Client $moguding */
        $moguding = app ( 'moguding' );
        $userId = $this->task->user->id;
        $device = $this->task->account->device;
        $phone = $this->task->account->phone;
        $password = $this->task->account->password;
        $address = $this->task->address->full_address;
        $type = $this->task->type;
        $runTime = $this->task->run [ 'runTime' ];

        $attributes [ 'userId' ] = $userId;
        $attributes [ 'device' ] = $device;
        $attributes [ 'phone' ] = $phone;
        $attributes [ 'address' ] = $address;
        $attributes [ 'type' ] = $type;
        $attributes [ 'runTime' ] = $runTime;

        try {
            $user = $moguding->login (
                $device,
                $phone,
                $password
            );
        } catch ( UnauthenticatedException|RequestTimeoutException $e ) {
            $attributes [ 'status' ] = 0;
            $attributes [ 'description' ] = $e->getMessage();
            $logRepository->create($attributes);
            return;
        }

        try {
            $plans = $moguding->getPlan (
                $user [ 'token' ],
                $user [ 'userType' ],
                $user [ 'userId' ]
            );
        } catch ( UnauthenticatedException|RequestTimeoutException $e ) {
            $attributes [ 'status' ] = 0;
            $attributes [ 'description' ] = $e->getMessage();
            $logRepository->create($attributes);
            return;
        }

        foreach ( $plans as $plan ) {
            try {
                $saved = $moguding->save (
                    $user [ 'token' ],
                    $user [ 'userId' ],
                    $this->task->address->province,
                    $this->task->address->city,
                    $this->task->address->address,
                    $this->task->address->longitude,
                    $this->task->address->latitude,
                    $type,
                    $device,
                    $plan [ 'planId' ],
                    $this->task->description
                );
            } catch ( UnauthenticatedException|RequestTimeoutException $e ) {
                $attributes [ 'status' ] = 0;
                $attributes [ 'description' ] = $e->getMessage();
                $logRepository->create($attributes);
                return;
            }
            $attributes [ 'status' ] = 1;
            $attributes [ 'description' ] = '打卡成功！';
            $logRepository->create($attributes);
        }
    }
}
