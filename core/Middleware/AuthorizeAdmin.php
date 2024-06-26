<?php

namespace Core\Middleware;

use Closure;
use Foundation\Http\Request;
use Foundation\Support\Facades\Auth;

class AuthorizeAdmin
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
        if (! Auth::check() || Auth::user()->role != 1) {
            return redirect()->route('index');
        }

        return $next($request);
    }
}