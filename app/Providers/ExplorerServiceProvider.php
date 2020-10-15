<?php

namespace App\Providers;

use App\Contracts\Network;
use Illuminate\Support\Facades\Config;
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
            $network = $app['config']['explorer']['network'];
            $networkClass = Config::get($app['config']['explorer']['networks'], $network)['driver'];

            return new $networkClass($app->make('HttpClient'));
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
