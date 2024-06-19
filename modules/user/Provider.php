<?php

namespace Modules\User;

use Foundation\Support\ServiceProvider;

class Provider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom('modules/user/routes.php');
        $this->loadViewsFrom('modules/user/View/desktop', 'user');
    }

    public function register()
    {
        $this->mergeConfigFrom('modules/user/config.php', 'user');
        $this->app->singleton('Modules\User\Repository\UserRepository', 'Modules\User\Repository\Impl\UserRepositoryImpl');
        $this->app->singleton('Modules\User\Service\UserService', 'Modules\User\Service\Impl\UserServiceImpl');
    }
}