<?php

namespace Modules\Categories\Controller;

use Foundation\Http\Request;
use Modules\Categories\Request\FormCreateCategory;
use Modules\Categories\Request\FormUpdateCategory;
use Modules\Categories\Service\CategoryService;

class CategoryManageController
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function pageManageCategory()
    {
        $pagination = $this->categoryService->pagination(['id', 'name', 'updated_at']);
        $categories = $pagination['data'];
        unset($pagination['data']);
        $data = [
            'label' => 1,
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
            'label' => 2,
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
        $data = [
            'label' => 2,
            'title' => 'Cập nhật danh mục',
            'category' => $category,
            'parents' => $parents,
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