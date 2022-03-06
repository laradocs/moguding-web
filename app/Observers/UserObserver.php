<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    public function creating ( User $user )
    {
        if ( $user->gender ) {
            $user->avatar = 'avatars/boy.png';
        } else {
            $user->avatar = 'avatars/girl.png';
        }
    }
}
