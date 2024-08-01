<?php

namespace Modules\Adm\Controller;

use Foundation\Http\Request;
use Modules\Adm\Request\FormCreateCategory;
use Modules\Adm\Request\FormUpdateCategory;
use Modules\Categories\Service\CategoriesService;
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

    public function __construct(CategoriesService $categoriesService, PlaylistService $playlistService, CategoryPlaylistService $categoryPlaylistService)
    {
        $this->categoriesService = $categoriesService;
        $this->categoryPlaylistService = $categoryPlaylistService;
        $this->playlistService = $playlistService;
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
        $categories = $this->categoriesService->findAll(['id','name'], ['parent_id' => 0], ['priority' => 'desc']);
        $data = [
            'label' => 2,
            'title' => 'Biểu mẫu tạo danh mục',
            'categories' => $categories,
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
        $this->categoriesService->create($data);
        return redirect()->route('adm-manager-categories', ['page' => 1])
                         ->with('success', config('adm.categories.MESSAGE.CREATE_SUCCESS'));
    }

    public function pageEditCategory(Request $request)
    {
        $id = $request->input('id');
        $category = $this->categoriesService->findOne(['id' => $id]);
        $categories = $this->categoriesService->findAll(['id','name', 'parent_id'], ['parent_id' => 0], ['priority' => 'desc']);
        $data = [
            'label' => 2,
            'title' => 'Cập nhật danh mục',
            'category' => $category,
            'categories' => $categories,
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
        if (! isset($data['parent_id'])) {
            $data['parent_id'] = 0;
        }
        $this->categoriesService->updateOne($id, $data);
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
        $ids = $request->input('ids');
        $this->categoriesService->deleteAll(['id' => $ids]);
        return redirect()->route('adm-manager-categories', ['page' => 1])
                         ->with('success', config('adm.categories.MESSAGE.DELETE_SUCCESS'));
    }

    public function choosePlaylistForCategory(Request $request)
    {
        $id = $request->input('id');
        $category = $this->categoriesService->findOne(['id' => $id], ['id']);
        $playlists = $this->playlistService->findAll(['id', 'name']);
        $playlistIds = [];
        $categoryPlaylists = $this->categoryPlaylistService->findAll(['playlist_id'], ['category_id' => $id]);
        if (! empty($categoryPlaylists)) {
            foreach ($categoryPlaylists as $categoryPlaylist) {
                $playlistIds[] = $categoryPlaylist['playlist_id'];
            }
        }
        if (! empty($playlists)) {
            foreach ($playlists as $key => $playlist) {
                $categoryPlaylist = $this->categoryPlaylistService->findOne(['playlist_id' => $playlist['id']]);
                if (! is_null($categoryPlaylist)) {
                    if (in_array($categoryPlaylist['playlist_id'], $playlistIds)) {
                        continue;
                    }
                    unset($playlists[$key]);
                }
            }
        }
        $data = [
            'label' => 2,
            'title' => 'Biểu mẫu chọn album cho playlist',
            'category' => $category,
            'playlists' => $playlists,
            'playlistIds' => $playlistIds,
        ];
        return view('adm.viewChoosePlaylistForCategory', $data);
    }

    public function updatePlaylistForCategory(Request $request)
    {
        $id = $request->input('id');
        $playlistIds = $request->input('playlist_ids');
        if (empty($playlistIds)) {
            return back()->with('fail', config('adm.categories.MESSAGE.CHOOSE_PLAYLIST_FOR_CATEGORY_FAIL'));
        }
        $this->categoryPlaylistService->updateAll($id, $playlistIds);
        return redirect()->route('adm-manager-categories', ['page' => 1])
                         ->with('success', config('adm.categories.MESSAGE.CHOOSE_PLAYLIST_FOR_CATEGORY_SUCCESS'));
    }
}