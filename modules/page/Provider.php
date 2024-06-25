<?php

namespace Modules\Page;

use Foundation\Support\ServiceProvider;

class Provider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom('modules/page/routes.php');
        $this->loadViewsFrom('modules/page/View/desktop', 'page');
    }

    public function register()
    {
        $this->mergeConfigFrom('modules/page/config.php', 'page');
    }
}