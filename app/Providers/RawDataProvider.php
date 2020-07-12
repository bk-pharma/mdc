<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RawDataProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Services\Contracts\RawDataInterface', function ($app) {
          return new \App\Services\RawData();
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