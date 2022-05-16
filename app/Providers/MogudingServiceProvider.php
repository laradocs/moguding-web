<?php

namespace App\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Laradocs\Moguding\MogudingManager;
use Laradocs\Moguding\MogudingResolverInterface;

class MogudingServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(MogudingResolverInterface::class, MogudingManager::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            MogudingResolverInterface::class,
        ];
    }
}
