<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class SanitationProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Services\Contracts\SanitationInterface', function ($app) {
          return new \App\Services\Sanitation();
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