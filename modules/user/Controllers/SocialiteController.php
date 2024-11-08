<?php

namespace Modules\User\Controllers;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Modules\User\Service\Contracts\LoginService;

class SocialiteController extends Controller
{
    protected $loginService;

    /**
     * @param  \Modules\User\Service\Contracts\LoginService  $loginService
     * @return void
     */
    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $user = Socialite::driver('google')->user();

        $this->loginService->withGoogle($user);

        return redirect('/');
    }
}
