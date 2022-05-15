<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    public function own(User $user, Task $task)
    {
        return $user->isAdministrator() || $user->id === $task->user_id;
    }
}
