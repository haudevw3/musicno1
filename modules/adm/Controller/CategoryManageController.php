<?php

namespace Modules\Adm\Controller;

use Foundation\Http\Request;
use Modules\Adm\Request\FormCreateCategory;
use Modules\Adm\Request\FormUpdateCategory;
use Modules\Categories\Service\CategoriesService;
use Foundation\Support\Str;
use Modules\Playlist\Service\PlaylistService;

class CategoryManageController
{
    protected $categoriesService;
    protected $playlistService;

    public function __construct(CategoriesService $categoriesService, PlaylistService $playlistService)
    {
        $this->categoriesService = $categoriesService;
        $this->playlistService = $playlistService;
    }

    public function pageManageCategory()
    {
        $pagination = $this->categoriesService->getListPagination(['id', 'name', 'parent_id', 'created_at', 'updated_at']);
        $categories = $pagination['data'];
        unset($pagination['data']);
        $data = [
            'label' => 1,
            'title' => 'Bảng dữ liệu danh mục',
            'categories' => $categories,
            'pagination' => $pagination,
            'dialog' => config('adm.categories.MESSAGES.DIALOG'),
        ];
        return view('adm.viewManageCategory', $data);
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
            return back()->with('fail', config('adm.categories.MESSAGES.CREATE_FAIL'))
                         ->withInput()->withErrors();
        }
        $data = $request->all();
        $data['category_id'] = Str::random(22);
        $data['image'] = null;
        $data['tags'] = isset($data['tags']) ? implode(',', $data['tags']) : null;
        if ($request->hasFile('image')) {
            $fileName = $request->file('image')->hash()->move('public/uploads/images');
            $data['image'] = asset("uploads/images/$fileName");
        }
        $this->categoriesService->create($data);
        return redirect()->route('adm-manage-category', ['page' => 1])
                         ->with('success', config('adm.categories.MESSAGES.CREATE_SUCCESS'));
    }

    public function pageEditCategory(Request $request)
    {
        $id = $request->input('id');
        $category = $this->categoriesService->findOne(['id' => $id]);
        $categories = $this->categoriesService->findAll(['id','name', 'parent_id'], ['parent_id' => 0], ['priority' => 'desc']);
        $tags = is_null($category['tags']) ? [] : explode(',', $category['tags']);
        $data = [
            'label' => 2,
            'title' => 'Cập nhật danh mục',
            'category' => $category,
            'categories' => $categories,
            'tags' => $tags,
        ];
        return view('adm.viewCrudCategory', $data);
    }

    public function updateCategory(FormUpdateCategory $request)
    {
        $validated = $request->validated();
        if (is_array($validated)) {
            return back()->with('fail', config('adm.categories.MESSAGES.UPDATE_FAIL'))
                         ->withInput()->withErrors();
        }
        $data = $request->all();
        $id = $data['id'];
        $data['parent_id'] = isset($data['parent_id']) ? $data['parent_id'] : 0;
        if ($request->hasFile('image')) {
            $fileName = $request->file('image')->hash()->move('public/uploads/images');
            $data['image'] = asset("uploads/images/$fileName");
        } else {
            $data['image'] = $data['image_url'];
        }
        unset($data['id'], $data['image_url']);
        $data['tags'] = isset($data['tags']) ? implode(',', $data['tags']) : null;
        $this->categoriesService->updateOne($id, $data);
        return redirect()->route('adm-manage-category', ['page' => 1])
                         ->with('success', config('adm.categories.MESSAGES.UPDATE_SUCCESS'));
    }

    public function deleteCategory(Request $request)
    {
        $id = $request->input('id');
        if ($this->categoriesService->deleteOne($id)) {
            return back()->with('success', config('adm.categories.MESSAGES.DELETE_SUCCESS'));
        }
        return back()->with('fail', config('adm.categories.MESSAGES.DELETE_FAIL'));
    }

    public function deleteMultipleCategory(Request $request)
    {
        $ids = $request->input('category_ids');
        $this->categoriesService->delete(['id' => $ids]);
        return redirect()->route('adm-manage-category', ['page' => 1])
                         ->with('success', config('adm.categories.MESSAGES.DELETE_SUCCESS'));
    }

    public function pageChoosePlaylist(Request $request)
    {
        $id = $request->input('id');
        $category = $this->categoriesService->findOne(['id' => $id]);
        $playlists = $this->playlistService->findAll(['id', 'name']);
        $playlistIds = explode(',', $category['playlist_ids']);
        if ($category['parent_id'] > 0) {
            $categories = $this->categoriesService->findAll(['id', 'name', 'parent_id', 'playlist_ids'], ['!=' => ['id' => $id]]);
            foreach ($categories as $cate) {
                if ($cate['parent_id'] == 0) {
                    continue;
                }
                foreach ($playlists as $key => $playlist) {
                    if (in_array($playlist['id'], is_null($cate['playlist_ids']) ? [] : explode(',', $cate['playlist_ids']))) {
                        unset($playlists[$key]);
                    }
                }
            }
        }
        $data = [
            'label' => 2,
            'title' => 'Biểu mẫu chọn danh sách phát cho danh mục',
            'id' => $id,
            'playlists' => $playlists,
            'playlistIds' => $playlistIds,
        ];
        return view('adm.viewChoosePlaylistForCategory', $data);
    }

    public function updatePlaylistForCategory(Request $request)
    {
        if (empty($request->input('playlist_ids'))) {
            return back()->with('fail', config('adm.categories.MESSAGES.CHOOSE_PLAYLIST_FOR_CATEGORY_FAIL'));
        }
        $id = $request->input('id');
        $playlistIds = implode(',', $request->input('playlist_ids'));
        $this->categoriesService->updateOne($id, ['playlist_ids' => $playlistIds]);
        return redirect()->route('adm-manage-category', ['page' => 1])
                         ->with('success', config('adm.categories.MESSAGES.CHOOSE_PLAYLIST_FOR_CATEGORY_SUCCESS'));
    }
}