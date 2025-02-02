<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class SanitationOneProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Services\Contracts\SanitationOneInterface', function ($app) {
          return new \App\Services\SanitationOne();
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