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
                ModuleMakeCommand::class,
                ModelMakeCommand::class,
                ControllerMakeCommand::class,
                RequestMakeCommand::class,
                RepositoryMakeCommand::class,
                ServiceMakeCommand::class,
            ]);
        }
    }
}