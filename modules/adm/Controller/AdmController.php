<?php

namespace Modules\Adm\Controller;

use Foundation\Http\Request;
use Modules\User\Service\UserService;

class AdmController
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function pageManageDashboard(Request $request)
    {
        return view('adm.viewManageDashboard');
    }
}