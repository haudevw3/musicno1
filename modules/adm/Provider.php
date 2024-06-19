<?php

namespace Modules\Adm;

use Foundation\Support\ServiceProvider;

class Provider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom('modules/adm/routes.php');
        $this->loadViewsFrom('modules/adm/View/desktop', 'adm');
    }

    public function register()
    {
        $this->mergeConfigFrom('modules/adm/config.php', 'adm');
    }
}