<?php

namespace Modules\Artist;

use Illuminate\Support\ServiceProvider;

class ArtistServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(\Modules\Artist\Repository\Contracts\ArtistRepository::class, \Modules\Artist\Repository\ArtistRepository::class);
        $this->app->singleton(\Modules\Artist\Service\Contracts\ArtistService::class, \Modules\Artist\Service\ArtistService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->loadViewsFrom(__DIR__.'/Views/Desktop', 'artist');
        $this->mergeConfigFrom(__DIR__.'/config.php', 'artist');
    }
}