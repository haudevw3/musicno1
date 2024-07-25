<?php

namespace Modules\Playlist;

use Foundation\Support\ServiceProvider;

class Provider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom('modules/playlist/routes.php');
        $this->loadViewsFrom('modules/playlist/View/desktop', 'playlist');
    }

    public function register()
    {
        $this->mergeConfigFrom('modules/playlist/config.php', 'playlist');
        $this->app->singleton('Modules\Playlist\Repository\PlaylistRepository', 'Modules\Playlist\Repository\Impl\PlaylistRepositoryImpl');
        $this->app->singleton('Modules\Playlist\Repository\PlaylistAlbumRepository', 'Modules\Playlist\Repository\Impl\PlaylistAlbumRepositoryImpl');

        $this->app->singleton('Modules\Playlist\Service\PlaylistService', 'Modules\Playlist\Service\Impl\PlaylistServiceImpl');
        $this->app->singleton('Modules\Playlist\Service\PlaylistAlbumService', 'Modules\Playlist\Service\Impl\PlaylistAlbumServiceImpl');
    }
}