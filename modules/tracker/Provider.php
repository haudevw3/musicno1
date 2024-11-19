<?php

namespace Modules\Tracker;

use Illuminate\Support\ServiceProvider;

class Provider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(\Modules\Tracker\Repository\Contracts\UserTrackingLogRepository::class, \Modules\Tracker\Repository\UserTrackingLogRepository::class);

        $this->app->singleton(\Modules\Tracker\Service\Contracts\UserTrackingLogService::class, \Modules\Tracker\Service\UserTrackingLogService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->loadViewsFrom(__DIR__.'/Views/desktop', 'tracker');
        $this->mergeConfigFrom(__DIR__.'/config.php', 'tracker');
    }
}