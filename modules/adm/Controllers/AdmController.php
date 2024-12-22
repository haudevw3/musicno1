<?php

namespace Modules\Adm\Controllers;

use App\Http\Controllers\Controller;
use Core\Facades\Redis;
use Illuminate\Http\Request;
use Modules\Album\Service\Contracts\AlbumService;
use Modules\Artist\Service\Contracts\ArtistService;
use Modules\Categories\Category;
use Modules\Categories\Service\Contracts\CategoryService;
use Modules\User\Service\Contracts\UserService;
use Modules\User\User;

class AdmController extends Controller
{
    protected $userService;
    protected $categoryService;
    protected $artistService;
    protected $albumService;

    /**
     * @param  \Modules\User\Service\Contracts\UserService            $userService
     * @param  \Modules\Categories\Service\Contracts\CategoryService  $categoryService
     * @param  \Modules\Artist\Service\Contracts\ArtistService        $artistService
     * @return void
     */
    public function __construct(UserService $userService, CategoryService $categoryService, ArtistService $artistService, AlbumService $albumService)
    {
        $this->userService = $userService;
        $this->categoryService = $categoryService;
        $this->artistService = $artistService;
        $this->albumService = $albumService;
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

    public function pageManageArtist(Request $request)
    {
        $paginator = $this->artistService->paginator([
            'name', 'slug', 'updated_at'
        ]);

        $data = [
            'artists' => $paginator->items(),
            'paginator' => $paginator,
        ];

        return view('adm::viewManageArtist', $data);
    }

    public function pageManageAlbum(Request $request)
    {
        $paginator = $this->albumService->paginator([
            'name', 'slug', 'album_type', 'artists'
        ]);

        $data = [
            'albums' => $paginator->items(),
            'paginator' => $paginator,
        ];

        return view('adm::viewManageAlbum', $data);
    }
}
