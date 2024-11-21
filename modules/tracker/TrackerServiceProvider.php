<?php

namespace Modules\Tracker;

use Illuminate\Support\ServiceProvider;

class TrackerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(\Modules\Tracker\Repository\Contracts\UserStatusTrackingLogRepository::class, \Modules\Tracker\Repository\UserStatusTrackingLogRepository::class);
        $this->app->singleton(\Modules\Tracker\Service\Contracts\UserStatusTrackingLogService::class, \Modules\Tracker\Service\UserStatusTrackingLogService::class);
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