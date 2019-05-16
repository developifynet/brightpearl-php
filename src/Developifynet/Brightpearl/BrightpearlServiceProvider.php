<?php

namespace Developifynet\Brightpearl;

use Illuminate\Support\ServiceProvider;

class BrightpearlServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('brightpearl', function () {
            return $this->app->make('Developifynet\Brightpearl\BrightpearlClient');
        });
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {

    }

}
