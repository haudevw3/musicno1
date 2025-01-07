<?php

namespace Core\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;

class Cors
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response|RedirectResponse
    {
        $allowedOrigins = ['https://musicno1.online'];
        $allowedMethods = 'GET, POST, PUT, PATCH, DELETE, OPTIONS';
        $allowedHeaders = 'X-Requested-With, X-Token-Auth, Content-Type, Authorization, X-XSRF-TOKEN';

        if ($request->server('HTTP_ORIGIN')) {
            $origin = $request->server('HTTP_ORIGIN');
        } elseif ($request->server('HTTP_REFERER')) {
            $origin = $request->server('HTTP_REFERER');
        } else {
            $origin = '*';
        }

        $response = $next($request);

        if (in_array($origin, $allowedOrigins)) {
            $response->headers->set('Access-Control-Allow-Origin', $origin);
            $response->headers->set('Access-Control-Allow-Methods', $allowedMethods);
            $response->headers->set('Access-Control-Allow-Headers', $allowedHeaders);
            // $response->headers->set('Access-Control-Allow-Credentials', 'true');
        }

        return $response;
    }
}