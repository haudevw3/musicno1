<?php

namespace Modules\Adm\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\User\Service\Contracts\UserService;

class AdmController extends Controller
{
    protected $userService;

    /**
     * @param  \Modules\User\Service\Contracts\UserService  $userService
     * @return void
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function dashboard()
    {
        return view('layout.desktop-backend');
    }

    public function pageManageUser(Request $request)
    {
        $paginator = $this->userService->paginator([
            'name', 'username', 'email', 'created_at', 'updated_at'
        ], [], ['need_cache' => 'list']);

        $data = [
            'users' => $paginator->items(),
            'paginator' => $paginator,
        ];

        return view('adm::viewManageUser', $data);
    }
}
