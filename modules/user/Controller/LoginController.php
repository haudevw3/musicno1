<?php

namespace Modules\User\Controller;

use Foundation\Http\Request;
use Foundation\Support\Facades\Auth;
use Modules\User\Service\UserService;

class LoginController
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    
    public function pageLogin()
    {
        return view('user.viewLogin');
    }

    public function login(Request $request)
    {
        $data = $request->all();
        $remember = isset($data['remember']) ? true : false;
        unset($data['remember']);
        if (Auth::attempt($data, $remember)) {
            return redirect()->route('home');
        }
        return back()->with('fail', config('user.MESSAGE.LOGIN_FAIL'))->withInput();
    }
}