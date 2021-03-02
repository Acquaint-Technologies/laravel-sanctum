<?php


namespace Anam\SanctumSupport;

use Illuminate\Support\ServiceProvider;

class SanctumSupportServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/views', 'sanctum');
    }
}
