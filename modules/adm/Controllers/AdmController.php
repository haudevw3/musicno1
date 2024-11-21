<?php

namespace Modules\Adm\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Categories\Category;
use Modules\Categories\Service\Contracts\CategoryService;
use Modules\User\Service\Contracts\UserService;
use Modules\User\User;

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
            'id', 'name', 'username', 'email', 'created_at', 'updated_at'
        ]);

        $users = $paginator->items();

        foreach ($users as $key => $user) {
            $users[$key] = User::create(
                $user, $this->userService->repository()
            );
        }

        $data = [
            'users' => $users,
            'paginator' => $paginator,
        ];

        return view('adm::viewManageUser', $data);
    }

    public function pageManageCategory(Request $request)
    {
        $paginator = $this->categoryService->paginator([
            'name', 'slug', 'tag_type', 'created_at', 'updated_at'
        ]);

        $categories = $paginator->items();

        foreach ($categories as $key => $category) {
            if ($category->isNotPrimary()) {
                $category->badges = null;
            }

            elseif ($category->isPrimary()) {
                $category->badges = Category::make(
                    $category, $this->categoryService->repository()
                )->badges();
            }

            $categories[$key] = $category;
        }

        $data = [
            'categories' => $categories,
            'paginator' => $paginator,
        ];

        return view('adm::viewManageCategory', $data);
    }
}
