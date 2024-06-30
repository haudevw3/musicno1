<?php

namespace Modules\Song;

use Foundation\Support\ServiceProvider;

class Provider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom('modules/song/routes.php');
        $this->loadViewsFrom('modules/song/View/desktop', 'song');
    }

    public function register()
    {
        $this->mergeConfigFrom('modules/song/config.php', 'song');
        $this->app->singleton('Modules\Song\Repository\SongRepository', 'Modules\Song\Repository\Impl\SongRepositoryImpl');
        $this->app->singleton('Modules\Song\Service\SongService', 'Modules\Song\Service\Impl\SongServiceImpl');
    }
}