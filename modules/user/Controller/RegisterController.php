<?php

namespace Modules\User\Controller;

use Modules\User\Request\FormRegister;
use Modules\User\Service\UserService;

class RegisterController
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
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
        array_merge($data, ['roles' => 2]);
        $this->userService->create($data);
        return redirect()->route('page-login');
    }
}