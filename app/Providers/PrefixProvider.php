<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class PrefixProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Services\Contracts\PrefixInterface', function ($app) {
          return new \App\Services\Prefix();
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