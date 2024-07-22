<?php

namespace Modules\Album;

use Foundation\Support\ServiceProvider;

class Provider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom('modules/album/routes.php');
        $this->loadViewsFrom('modules/album/View/desktop', 'album');
    }

    public function register()
    {
        $this->mergeConfigFrom('modules/album/config.php', 'album');
        $this->app->singleton('Modules\Album\Repository\AlbumRepository', 'Modules\Album\Repository\Impl\AlbumRepositoryImpl');
        $this->app->singleton('Modules\Album\Repository\AlbumSongRepository', 'Modules\Album\Repository\Impl\AlbumSongRepositoryImpl');

        $this->app->singleton('Modules\Album\Service\AlbumService', 'Modules\Album\Service\Impl\AlbumServiceImpl');
        $this->app->singleton('Modules\Album\Service\AlbumSongService', 'Modules\Album\Service\Impl\AlbumSongServiceImpl');
    }
}