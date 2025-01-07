<?php

namespace Core\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Core\Http\Exception\ForbiddenResponseException;

class AuthenticationAdminApi
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): JsonResponse
    {
        if (! Auth::check() || ! Auth::user()->isAdmin()) {
            throw new ForbiddenResponseException;
        }

        return $next($request);
    }
}