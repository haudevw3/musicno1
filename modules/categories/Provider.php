<?php

namespace Modules\Categories;

use Foundation\Support\ServiceProvider;

class Provider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom('modules/categories/routes.php');
        $this->loadViewsFrom('modules/categories/View/desktop', 'categories');
    }

    public function register()
    {
        $this->mergeConfigFrom('modules/categories/config.php', 'categories');
        $this->app->singleton('Modules\Categories\Repository\CategoryRepository', 'Modules\Categories\Repository\Impl\CategoryRepositoryImpl');

        $this->app->singleton('Modules\Categories\Service\CategoryService', 'Modules\Categories\Service\Impl\CategoryServiceImpl');
    }
}