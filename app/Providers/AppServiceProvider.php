<?php

namespace App\Providers;

use App\Jobs\ProcessSign;
use App\Services\ManagerProcessor;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
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
