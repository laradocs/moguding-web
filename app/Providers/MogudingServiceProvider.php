<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laradocs\Moguding\Client;

class MogudingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton ( Client::class, function () {
            return new Client();
        } );
        $this->app->alias ( Client::class, 'moguding' );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            Client::class,
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
