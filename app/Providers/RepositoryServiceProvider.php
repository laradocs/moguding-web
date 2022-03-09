<?php

namespace App\Providers;

use App\Repositories\AccountRepository;
use App\Repositories\AddressRepository;
use App\Repositories\Dao\AccountDao;
use App\Repositories\Dao\AddressDao;
use App\Repositories\Dao\LogDao;
use App\Repositories\Dao\TaskDao;
use App\Repositories\Dao\UserDao;
use App\Repositories\LogRepository;
use App\Repositories\TaskRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind ( UserRepository::class, UserDao::class );
        $this->app->bind ( AccountRepository::class, AccountDao::class );
        $this->app->bind ( AddressRepository::class, AddressDao::class );
        $this->app->bind ( TaskRepository::class, TaskDao::class );
        $this->app->bind ( LogRepository::class, LogDao::class );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
