<?php

namespace Modules\FileManager;

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
        $this->app->singleton(\Modules\FileManager\Repository\Contracts\FileRepository::class, \Modules\FileManager\Repository\FileRepository::class);

        $this->app->singleton(\Modules\FileManager\Service\Contracts\FileService::class, \Modules\FileManager\Service\FileService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->mergeConfigFrom(__DIR__.'/config.php', 'filemanager');
        $this->loadViewsFrom(__DIR__.'/Views/desktop', 'filemanager');
    }
}