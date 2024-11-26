<?php

namespace Modules\Album;

use Illuminate\Support\ServiceProvider;

class AlbumServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(\Modules\Album\Repository\Contracts\AlbumRepository::class, \Modules\Album\Repository\AlbumRepository::class);
        $this->app->singleton(\Modules\Album\Service\Contracts\AlbumService::class, \Modules\Album\Service\AlbumService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->loadViewsFrom(__DIR__.'/Views/desktop', 'album');
        $this->mergeConfigFrom(__DIR__.'/config.php', 'album');
    }
}