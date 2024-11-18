<?php

namespace Modules\Adm\Controllers;

use App\Http\Controllers\Controller;
use Core\Facades\Redis;
use Illuminate\Http\Request;
use Modules\Categories\Service\Contracts\CategoryService;
use Modules\User\Service\Contracts\UserService;

class AdmController extends Controller
{
    protected $userService;
    protected $categoryService;

    /**
     * @param  \Modules\User\Service\Contracts\UserService            $userService
     * @param  \Modules\Categories\Service\Contracts\CategoryService  $categoryService
     * @return void
     */
    public function __construct(UserService $userService, CategoryService $categoryService)
    {
        $this->userService = $userService;
        $this->categoryService = $categoryService;
    }

    public function dashboard()
    {
        return view('layout.desktop-backend');
    }

    public function pageManageUser(Request $request)
    {
        $paginator = $this->userService->paginator([
            'name', 'username', 'email', 'created_at', 'updated_at'
        ]);

        $data = [
            'users' => $paginator->items(),
            'paginator' => $paginator,
        ];

        return view('adm::viewManageUser', $data);
    }

    public function pageManageCategory(Request $request)
    {
        $paginator = $this->categoryService->paginator([
            'name', 'slug', 'tag_type', 'created_at', 'updated_at'
        ]);

        $data = [
            'categories' => $paginator->items(),
            'paginator' => $paginator,
        ];

        return view('adm::viewManageCategory', $data);
    }
}
