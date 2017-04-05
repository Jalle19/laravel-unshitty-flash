<?php

namespace Jalle19\Laravel\UnshittyFlash;

use Illuminate\Support\ServiceProvider;

/**
 * Class FlashServiceProvider
 * @package Jalle19\Laravel\UnshittyFlash
 */
class FlashServiceProvider extends ServiceProvider
{

    /**
     * Registers bindings into the container
     */
    public function register()
    {
        $this->app->singleton(FlashService::class, function() {
            return new FlashService(config('flash'));
        });
    }


    /**
     *
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/flash.php' => config_path('flash.php'),
        ]);
    }

}
