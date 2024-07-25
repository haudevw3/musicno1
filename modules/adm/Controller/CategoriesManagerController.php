<?php

namespace Modules\Adm\Controller;

use Foundation\Http\Request;
use Modules\Adm\Request\FormCreateCategory;
use Modules\Adm\Request\FormUpdateCategory;
use Modules\Artist\Service\ArtistService;
use Modules\Categories\Service\CategoriesService;
use Modules\Categories\Service\CategoryArtistService;
use Modules\Categories\Service\CategoryPlaylistService;
use Modules\Playlist\Service\PlaylistService;
use Foundation\Support\Str;

class CategoriesManagerController
{
    protected $categoriesService;
    protected $categoryPlaylistService;
    protected $categoryArtistService;
    protected $playlistService;
    protected $artistService;

    public function __construct(CategoriesService $categoriesService, PlaylistService $playlistService, ArtistService $artistService,
                                CategoryPlaylistService $categoryPlaylistService, CategoryArtistService $categoryArtistService)
    {
        $this->categoriesService = $categoriesService;
        $this->categoryPlaylistService = $categoryPlaylistService;
        $this->categoryArtistService = $categoryArtistService;
        $this->playlistService = $playlistService;
        $this->artistService = $artistService;
    }

    public function pageManagerCategories()
    {
        $pagination = $this->categoriesService->listCategories();
        $categories = $pagination['data'];
        unset($pagination['data']);
        $data = [
            'label' => 1,
            'title' => 'Bảng dữ liệu danh mục',
            'categories' => $categories,
            'pagination' => $pagination,
            'dialog' => config('adm.categories.MESSAGE.DIALOG'),
        ];
        return view('adm.viewManagerCategories', $data);
    }

    public function pageAddCategory()
    {   
        $categories = $this->categoriesService->findAll(['id','name', 'parent_id'], ['parent_id' => 0], ['priority' => 'desc']);
        $playlists = $this->playlistService->findAll(['id', 'name']);
        foreach ($playlists as $key => $playlist) {
            $categoryPlaylist = $this->categoryPlaylistService->findOne(['playlist_id' => $playlist['id']]);
            if (! is_null($categoryPlaylist)) {
                unset($playlists[$key]);
            }
        }
        $data = [
            'label' => 2,
            'title' => 'Biểu mẫu tạo danh mục',
            'categories' => $categories,
            'playlists' => $playlists,
        ];
        return view('adm.viewCrudCategory', $data);
    }

    public function createCategory(FormCreateCategory $request)
    {
        $validated = $request->validated();
        if (is_array($validated)) {
            return back()->with('fail', config('adm.categories.MESSAGE.CREATE_FAIL'))
                         ->withInput()->withErrors();
        }
        $data = $request->all();
        $data['category_id'] = Str::random(22);
        $playlistIds = null;
        if (isset($data['playlist_ids'])) {
            $playlistIds = $data['playlist_ids'];
            unset($data['playlist_ids']);
        }
        $category = tap($this->categoriesService, function ($subject) use ($data) {
            $subject->create($data);
        })->findOne(['category_id' => $data['category_id']]);
        if (! is_null($playlistIds)) {
            foreach ($playlistIds as $playlistId) {
                $this->categoryPlaylistService->create(['category_id' => $category['id'], 'playlist_id' => $playlistId]);
            }
        }
        return redirect()->route('adm-manager-categories', ['page' => 1])
                         ->with('success', config('adm.categories.MESSAGE.CREATE_SUCCESS'));
    }

    public function pageEditCategory(Request $request)
    {
        $id = $request->input('id');
        $category = $this->categoriesService->findOne(['id' => $id]);
        $categories = $this->categoriesService->findAll(['id','name', 'parent_id'], ['parent_id' => 0], ['priority' => 'desc']);
        $categoryPlaylists = $this->categoryPlaylistService->findAll(['playlist_id'], ['category_id' => $id]);
        $playlists = $this->playlistService->findAll(['id', 'name']);
        $playlistIds = [];
        if (! empty($categoryPlaylists)) {
            foreach ($categoryPlaylists as $value) {
                $playlistIds[] = $value['playlist_id'];
            }
        }
        foreach ($playlists as $key => $playlist) {
            $categoryPlaylist = $this->categoryPlaylistService->findOne(['playlist_id' => $playlist['id']]);
            if (! is_null($categoryPlaylist)) {
                if (in_array($categoryPlaylist['playlist_id'], $playlistIds)) {
                    continue;
                }
                unset($playlists[$key]);
            }
        }
        $data = [
            'label' => 2,
            'title' => 'Cập nhật danh mục',
            'category' => $category,
            'categories' => $categories,
            'playlists' => $playlists,
            'playlistIds' => $playlistIds,
        ];
        return view('adm.viewCrudCategory', $data);
    }

    public function updateCategory(FormUpdateCategory $request)
    {
        $validated = $request->validated();
        if (is_array($validated)) {
            return back()->with('fail', config('adm.categories.MESSAGE.UPDATE_FAIL'))
                         ->withInput()->withErrors();
        }
        $data = $request->all();
        $id = $data['id'];
        unset($data['id']);
        $playlistIds = [];
        if (isset($data['playlist_ids'])) {
            $playlistIds = $data['playlist_ids'];
            unset($data['playlist_ids']);
        }
        $this->categoriesService->updateOne($id, $data);
        $this->categoryPlaylistService->updateAll($id, $playlistIds);
        return redirect()->route('adm-manager-categories', ['page' => 1])
                         ->with('success', config('adm.categories.MESSAGE.UPDATE_SUCCESS'));
    }

    public function deleteCategory(Request $request)
    {
        $id = $request->input('id');
        if ($this->categoriesService->deleteOne($id)) {
            return back()->with('success', config('adm.categories.MESSAGE.DELETE_SUCCESS'));
        }
        return back()->with('fail', config('adm.categories.MESSAGE.DELETE_FAIL'));
    }

    public function deleteMultipleCategory(Request $request)
    {
        $this->categoriesService->deleteAll(['id' => $request->all()['ids']]);
        return redirect()->route('adm-manager-categories', ['page' => 1])
                         ->with('success', config('adm.categories.MESSAGE.DELETE_SUCCESS'));
    }
}