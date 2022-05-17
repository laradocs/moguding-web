<?php

namespace App\Policies;

use App\Models\Address;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AddressPolicy
{
    use HandlesAuthorization;

    public function own(User $user, Address $address)
    {
        return $user->isAdministrator() || $user->id === $address->user_id;
    }
}
