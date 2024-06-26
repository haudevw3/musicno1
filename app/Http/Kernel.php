<?php

namespace App\Http;

use Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $middleware = [];
    protected $middlewareGroups = [];
    protected $routeMiddleware = [
        'auth.remember' => \Core\Middleware\AuthenticateRemember::class,
        'auth.admin' => \Core\Middleware\AuthorizeAdmin::class,
        'auth.user' => \Core\Middleware\AuthorizeUser::class,
    ];
}