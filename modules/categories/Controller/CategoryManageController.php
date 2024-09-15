<?php

namespace Modules\Categories\Controller;

use Foundation\Http\Request;
use Modules\Album\Service\AlbumService;
use Modules\Artist\Service\ArtistService;
use Modules\Categories\Request\FormCreateCategory;
use Modules\Categories\Request\FormUpdateCategory;
use Modules\Categories\Service\CategoryService;
use Modules\Playlist\Service\PlaylistService;

class CategoryManageController
{
    protected $categoryService;
    protected $playlistService;
    protected $artistService;
    protected $albumService;

    public function __construct(CategoryService $categoryService, PlaylistService $playlistService, ArtistService $artistService, AlbumService $albumService)
    {
        $this->categoryService = $categoryService;
        $this->playlistService = $playlistService;
        $this->artistService = $artistService;
        $this->albumService = $albumService;
    }

    public function pageManageCategory()
    {
        $pagination = $this->categoryService->pagination(['id', 'name', 'updated_at']);
        $categories = $pagination['data'];
        unset($pagination['data']);
        $data = [
            'categories' => $categories,
            'pagination' => $pagination,
        ];
        return view('categories.viewManageCategory', $data);
    }

    public function pageAddCategory()
    {
        $parents = $this->categoryService->findAll(['id','name'], ['parent_id' => 0], ['priority' => 'desc']);
        $parents = array_merge([['id' => 0, 'name' => 'Không']], is_null($parents) ? [] : $parents);
        $data = [
            'title' => 'Tạo danh mục',
            'parents' => $parents,
        ];
        return view('categories.viewFormManageCategory', $data);
    }

    public function createCategory(FormCreateCategory $request)
    {
        $validated = $request->validated();
        if (is_array($validated)) {
            return response()->json($validated, 500);
        }
        $this->categoryService->create($request->all());
        return response()->json($validated, 201);
    }

    public function pageEditCategory(Request $request)
    {
        $id = $request->input('id');
        $category = $this->categoryService->findOne(['id' => $id]);
        $parents = $this->categoryService->findAll(['id','name'], ['parent_id' => 0], ['priority' => 'desc']);
        $parents = array_merge([['id' => 0, 'name' => 'Không']], $parents);
        $tags = [];
        $tagIds = explode(',', $category['tag_ids']);
        if ($category['type'] > 0) {
            foreach ($tagIds as $tagId) {
                if ($category['type'] == 1) {
                    $tags[] = $this->playlistService->findOne(['id' => $tagId], ['id', 'name']);
                } else if ($category['type'] == 2) {
                    $tags[] = $this->artistService->findOne(['id' => $tagId], ['id', 'name']);
                } else if ($category['type'] == 3) {
                    $tags[] = $this->albumService->findOne(['id' => $tagId], ['id', 'name']);
                }
            }
        }
        $data = [
            'title' => 'Cập nhật danh mục',
            'category' => $category,
            'parents' => $parents,
            'tags' => $tags,
        ];
        return view('categories.viewFormManageCategory', $data);
    }

    public function updateCategory(FormUpdateCategory $request)
    {
        $validated = $request->validated();
        if (is_array($validated)) {
            return response()->json($validated, 500);
        }
        $data = $request->all();
        $id = $data['id'];
        unset($data['id']);
        $this->categoryService->updateOne($id, $data);
        return response()->json($validated);
    }

    public function deleteCategory(Request $request)
    {
        $id = $request->input('id');
        $this->categoryService->deleteOne($id);
        return response()->json();
    }

    public function deleteMultipleCategory(Request $request)
    {
        $categoryIds = $request->input('category_ids');
        $categoryIds = is_array($categoryIds) ? $categoryIds : [$categoryIds];
        foreach ($categoryIds as $id) {
            $this->categoryService->deleteOne($id);
        }
        return response()->json();
    }
}