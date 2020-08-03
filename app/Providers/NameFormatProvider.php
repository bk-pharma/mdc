<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class NameFormatProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Services\Contracts\NameFormatInterface', function ($app) {
          return new \App\Services\NameFormat();
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