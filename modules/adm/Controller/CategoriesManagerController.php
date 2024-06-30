<?php

namespace Modules\Adm\Controller;

use Foundation\Http\Request;
use Modules\Adm\Request\FormCreateCategory;
use Modules\Adm\Request\FormUpdateCategory;
use Modules\Categories\Service\CategoriesService;

class CategoriesManagerController
{
    protected $categoriesService;

    public function __construct(CategoriesService $categoriesService)
    {
        $this->categoriesService = $categoriesService;
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
        $categories = $this->categoriesService->findAll(['id','name']);
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
        $file = $request->file('image');
        if (! is_null($file)) {
            $fileName = $file->hash()->move('public/uploads/images');
            $data['image'] = asset("uploads/images/$fileName");
        }
        $this->categoriesService->create($data);
        return redirect()->route('adm-manager-categories', ['page' => 1])
                         ->with('success', config('adm.categories.MESSAGE.CREATE_SUCCESS'));
    }

    public function pageEditCategory(Request $request)
    {
        $id = $request->input('id');
        $category = $this->categoriesService->findOne(['id' => $id]);
        $categories = $this->categoriesService->findAll(['id','name']);
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
        $file = $request->file('image');
        if (is_null($file)) {
            $data['image'] = $data['image_url'];
            unset($data['image_url']);
        } else {
            $fileName = $file->hash()->move('public/uploads/images');
            $data['image'] = asset("uploads/images/$fileName");
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
        if ($this->categoriesService->delete(['id' => $request->all()['ids']])) {
            return redirect()->route('adm-manager-categories', ['page' => 1])
                             ->with('success', config('adm.categories.MESSAGE.DELETE_SUCCESS'));
        }
        return back()->with('fail', config('adm.categories.MESSAGE.DELETE_FAIL'));
    }
}