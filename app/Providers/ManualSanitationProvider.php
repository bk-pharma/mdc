<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ManualSanitationProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Services\Contracts\ManualSanitationInterface', function ($app) {
          return new \App\Services\ManualSanitation();
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