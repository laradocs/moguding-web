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
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(UserRepository::class, UserDao::class);
        $this->app->singleton(AccountRepository::class, AccountDao::class);
        $this->app->singleton(AddressRepository::class, AddressDao::class);
        $this->app->singleton(TaskRepository::class, TaskDao::class);
        $this->app->singleton(LogRepository::class, LogDao::class);
    }

    public function provides()
    {
        return [
            UserRepository::class,
            AccountRepository::class,
            AddressRepository::class,
            TaskRepository::class,
            LogRepository::class,
        ];
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
