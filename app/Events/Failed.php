<?php

namespace App\Events;

use App\Models\Account;
use App\Models\Task;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Failed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Task $task;

    public Account $account;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Task $task, Account $account)
    {
        $this->task = $task;
        $this->account = $account;
    }
}
