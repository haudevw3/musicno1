<?php

namespace Core\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Providers\RouteServiceProvider;
use Modules\User\Repository\UserRepository;

class AuthenticationCustom
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response|RedirectResponse
    {
        $user = app(UserRepository::class)->findOne([
            'id' => $request->route('id') ?? $request->input('id')
        ]);

        if (is_null($user) && ! Auth::check()) {
            return redirect(RouteServiceProvider::HOME);
        }

        return $next($request);
    }
}