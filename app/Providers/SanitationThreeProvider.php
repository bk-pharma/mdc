<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class SanitationThreeProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Services\Contracts\SanitationThreeInterface', function ($app) {
          return new \App\Services\SanitationThree();
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