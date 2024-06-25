<?php

namespace Core\Middleware;

use Closure;
use Foundation\Http\Request;
use Foundation\Support\Facades\Auth;
use Foundation\Support\Facades\Cookie;

class AuthenticateRemember
{
    /**
     * Undocumented function
     *
     * @param \Foundation\Http\Request\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Cookie::exists('remember_token')) {
            $rememberToken = Cookie::get('remember_token');

            if (Auth::loginUsingToken($rememberToken)) {
                return redirect()->route('home');
            }
        }

        return $next($request);
    }
}