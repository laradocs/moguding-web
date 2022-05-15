<?php

namespace App\Policies;

use App\Models\Account;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AccountPolicy
{
    use HandlesAuthorization;

    public function own(User $user, Account $account)
    {
        return $user->isAdministrator() || $user->id === $account->user_id;
    }
}
