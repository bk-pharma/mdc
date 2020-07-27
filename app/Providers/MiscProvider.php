<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MiscProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Services\Contracts\MiscInterface', function ($app) {
          return new \App\Services\Misc();
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
