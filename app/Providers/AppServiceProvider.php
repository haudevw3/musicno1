<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('core.service.mailgun', \Core\Service\MailgunService::class);
        $this->app->singleton('core.service.smtp', \Core\Service\SmtpService::class);
        $this->app->singleton(\Core\Redis\Contracts\PhpRedisConnection::class, \Core\Redis\Connections\PhpRedisConnection::class);
        $this->app->singleton(\Core\Validation\Contracts\Factory::class, \Core\Validation\RuleManager::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::componentNamespace('Core\\Views\\Components', 'core');
    }
}
