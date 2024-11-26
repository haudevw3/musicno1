<?php

namespace Modules\Track;

use Illuminate\Support\ServiceProvider;

class TrackServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(\Modules\Track\Repository\Contracts\TrackRepository::class, \Modules\Track\Repository\TrackRepository::class);
        $this->app->singleton(\Modules\Track\Service\Contracts\TrackService::class, \Modules\Track\Service\TrackService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->loadViewsFrom(__DIR__.'/Views/desktop', 'track');
        $this->mergeConfigFrom(__DIR__.'/config.php', 'track');
    }
}