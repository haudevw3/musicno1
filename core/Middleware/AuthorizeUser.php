<?php

namespace Core\Middleware;

use Closure;
use Foundation\Http\Request;
use Foundation\Support\Facades\Auth;

class AuthorizeUser
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
        if (! Auth::check()) {
            return redirect()->route('index');
        }

        return $next($request);
    }
}