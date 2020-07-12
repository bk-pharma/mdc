<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class SanitationTwoProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Services\Contracts\SanitationTwoInterface', function ($app) {
          return new \App\Services\SanitationTwo();
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