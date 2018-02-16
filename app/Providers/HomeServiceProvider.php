<?php

namespace App\Providers;


use App\Helpers\HomeControllersHelpers;
use Illuminate\Support\ServiceProvider;

class HomeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Helpers\Contracts\HomeHelpers', 'App\Helpers\HomeControllersHelpers');

    }
}
