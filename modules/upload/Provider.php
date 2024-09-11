<?php

namespace Modules\Upload;

use Foundation\Support\ServiceProvider;

class Provider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom('modules/upload/routes.php');
        $this->loadViewsFrom('modules/upload/View/desktop', 'upload');
    }

    public function register()
    {
        $this->mergeConfigFrom('modules/upload/config.php', 'upload');
        $this->app->singleton('Modules\Upload\Repository\UploadRepository', 'Modules\Upload\Repository\Impl\UploadRepositoryImpl');
        $this->app->singleton('Modules\Upload\Service\UploadService', 'Modules\Upload\Service\Impl\UploadServiceImpl');
    }
}