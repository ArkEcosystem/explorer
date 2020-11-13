<?php

namespace App\Providers;

use Faker\Factory;
use Faker\Generator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Tests\Wallet;

class DevelopmentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        if (App::environment(['local', 'testing']) === true) {
            $faker = Factory::create();
            $faker->addProvider(new Wallet($faker));

            $this->app->instance(Generator::class, $faker);
        }
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
