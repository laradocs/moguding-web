<?php

namespace App\Providers;

use App\Jobs\ProcessSign;
use App\Services\ManagerProcessor;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Laradocs\Moguding\MogudingManager;
use Laradocs\Moguding\MogudingResolverInterface;

class AppServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(MogudingResolverInterface::class, MogudingManager::class);

        $this->app->bindMethod([ProcessSign::class, 'handle'], function ($job, $app) {
            return $job->handle($app->make(ManagerProcessor::class));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
