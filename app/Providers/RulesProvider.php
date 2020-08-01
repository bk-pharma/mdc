<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RulesProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Services\Contracts\RulesInterface', function ($app) {
          return new \App\Services\Rules();
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