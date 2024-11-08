<?php

namespace Modules\User;

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
        $this->app->singleton(\Modules\User\Repository\Contracts\UserRepository::class, \Modules\User\Repository\UserRepository::class);
        $this->app->singleton(\Modules\User\Repository\Contracts\LoginRepository::class, \Modules\User\Repository\LoginRepository::class);

        $this->app->singleton(\Modules\User\Service\Contracts\UserService::class, \Modules\User\Service\UserService::class);
        $this->app->singleton(\Modules\User\Service\Contracts\LoginService::class, \Modules\User\Service\LoginService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->mergeConfigFrom(__DIR__.'/config.php', 'user');
        $this->loadViewsFrom(__DIR__.'/Views/desktop', 'user');
    }
}