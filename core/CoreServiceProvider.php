<?php

namespace Core;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::componentNamespace('Core\\Views\\Components', 'core');
        
        if ($this->app->runningInConsole()) {
            $this->commands([
                \Core\Console\Command\ContractMakeCommand::class,
                \Core\Console\Command\ControllerMakeCommand::class,
                \Core\Console\Command\ModelMakeCommand::class,
                \Core\Console\Command\ModuleStructureMakeCommand::class,
                \Core\Console\Command\RequestMakeCommand::class,
                \Core\Console\Command\RepositoryMakeCommand::class,
                \Core\Console\Command\ServiceMakeCommand::class,
            ]);
        }
    }
}