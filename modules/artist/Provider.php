<?php

namespace Modules\Artist;

use Foundation\Support\ServiceProvider;

class Provider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom('modules/artist/routes.php');
        $this->loadViewsFrom('modules/artist/View/desktop', 'artist');
    }

    public function register()
    {
        $this->mergeConfigFrom('modules/artist/config.php', 'artist');
        $this->app->singleton('Modules\Artist\Repository\ArtistRepository', 'Modules\Artist\Repository\Impl\ArtistRepositoryImpl');

        $this->app->singleton('Modules\Artist\Service\ArtistService', 'Modules\Artist\Service\Impl\ArtistServiceImpl');
    }
}