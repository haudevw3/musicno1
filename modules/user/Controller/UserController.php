<?php

namespace Modules\User\Controller;

use Core\Service\OAuthService;
use Foundation\Http\Request;
use Foundation\Support\Facades\Auth;
use Modules\User\Request\FormRegister;
use Modules\User\Service\UserService;

class UserController
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function pageLogin(Request $request)
    {
        $oauth = OAuthService::getInstance();
        $authUrl = $oauth->url();
        if ($request->input('code')) {
            $attributes = $oauth->oauth($request->input('code'));
            if (Auth::attempt([
                'username' => $attributes['username'],
                'password' => $attributes['password']
            ], true)) {
                return redirect()->route('dashboard');
            }
        }
        return view('user.viewLogin', compact('authUrl'));
    }

    public function login(Request $request)
    {
        $data = $request->all();
        $remember = isset($data['remember']) ? true : false;
        unset($data['remember']);
        if (Auth::attempt($data, $remember)) {
            return redirect()->route('dashboard');
        }
        return back()->with('fail', config('user.MESSAGE.LOGIN_FAIL'))->withInput();
    }

    public function pageRegister()
    {
        return view('user.viewRegister');
    }

    public function register(FormRegister $request)
    {
        $validated = $request->validated();
        if (is_array($validated)) {
            return back()->withInput()->withErrors();
        }
        $data = $request->all();
        $data['role'] = 2;
        $this->userService->create($data);
        return redirect()->route('page-login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('index');
    }
}