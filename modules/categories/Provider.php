<?php

namespace Modules\Categories;

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
        $this->app->singleton(\Modules\Categories\Repository\Contracts\CategoryRepository::class, \Modules\Categories\Repository\CategoryRepository::class);
        $this->app->singleton(\Modules\Categories\Service\Contracts\CategoryService::class, \Modules\Categories\Service\CategoryService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->loadViewsFrom(__DIR__.'/Views/desktop', 'categories');
        $this->mergeConfigFrom(__DIR__.'/config.php', 'categories');
    }
}