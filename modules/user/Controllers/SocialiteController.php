<?php

namespace Modules\User\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Modules\User\Service\Contracts\ClientService;
use Modules\User\Service\Contracts\UserService;

class SocialiteController extends Controller
{
    protected $userService;
    protected $clientService;

    /**
     * @param  \Modules\User\Service\Contracts\UserService    $userService
     * @param  \Modules\User\Service\Contracts\ClientService  $clientService
     * @return void
     */
    public function __construct(UserService $userService, ClientService $clientService)
    {
        $this->userService = $userService;
        $this->clientService = $clientService;
    }

    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $user = Socialite::driver('google')->user();

        $this->clientService->loginByGoogle($user);

        return redirect('/');
    }
}
