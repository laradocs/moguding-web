<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function own(User $user, User $model)
    {
        return $user->isAdministrator() || $user->id === $model->id;
    }
}
