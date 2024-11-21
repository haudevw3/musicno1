<?php

namespace Core\Console;

use Illuminate\Support\ServiceProvider;

class ConsoleServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                \Core\Console\Modules\ModuleMakeCommand::class,
                \Core\Console\Modules\ModelMakeCommand::class,
                \Core\Console\Modules\ControllerMakeCommand::class,
                \Core\Console\Modules\RequestMakeCommand::class,
                \Core\Console\Modules\RepositoryMakeCommand::class,
                \Core\Console\Modules\ServiceMakeCommand::class,
            ]);
        }
    }
}