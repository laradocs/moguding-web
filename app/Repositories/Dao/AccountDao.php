<?php

namespace App\Repositories\Dao;

use App\Models\Account;
use App\Repositories\AccountRepository;
use Illuminate\Database\Eloquent\Collection;

class AccountDao implements AccountRepository
{
    public function getByUserId(int $userId): Collection
    {
        $models = Account::where ( 'user_id', $userId )->get();

        return $models;
    }
}
