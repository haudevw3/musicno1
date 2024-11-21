<?php

namespace Modules\Adm;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AdmServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->loadViewsFrom(__DIR__.'/Views/desktop', 'adm');
        $this->mergeConfigFrom(__DIR__.'/config.php', 'adm');

        Blade::componentNamespace('Modules\\Adm\\Views\\Components', 'adm');
    }
}