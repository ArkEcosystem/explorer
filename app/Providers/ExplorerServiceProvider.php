<?php

namespace App\Providers;

use App\Contracts\Network;
use App\Services\Blockchain\NetworkFactory;
use Illuminate\Support\ServiceProvider;

class ExplorerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Network::class, function ($app) {
            return NetworkFactory::make($app['config']['explorer']['network']);
        });
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
