<?php

namespace Modules\Categories\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Categories\Constant;
use Modules\Categories\Repository\CategoryRepository;
use Modules\Categories\Request\FormCreateCategory;
use Modules\Categories\Request\FormUpdateCategory;
use Modules\Categories\Service\Contracts\CategoryService;

class CategoryManagerController extends Controller
{
    protected $categoryService;

    /**
     * @param  \Modules\Categories\Service\Contracts\CategoryService  $categoryService
     * @return void
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function pageAddCategory()
    {
        return view('categories::viewFormCategory', [
            'primaryCategories' => $this->categoryService->findMany(['tag_type' => Constant::TAG_PRIMARY])
        ]);
    }

    public function pageEditCategory(Request $request)
    {
        $category = $this->categoryService->findOne(
            $request->route('id')
        );

        $conditions = ['tag_type' => Constant::TAG_PRIMARY];

        if ($category->isPrimary()) {
            $conditions = array_merge($conditions, [
                '_id' => ['$ne' => CategoryRepository::createObjectId($category->_id)]
            ]);
        }

        $primaryCategories = $this->categoryService->findMany(
            $conditions, ['name', 'parent_id']
        );

        foreach ($primaryCategories as $key => $primaryCategory) {
            if ($category->_id == $primaryCategory->parent_id) {
                $primaryCategories->forget($key);
            }
        }

        return view('categories::viewFormCategory', [
            'category' => $category,
            'primaryCategories' => $primaryCategories
        ]);
    }

    public function createCategoryApi(FormCreateCategory $request)
    {
        $response = $this->categoryService->create($request->all());

        return $response->withJson();
    }

    public function updateCategoryApi(FormUpdateCategory $request)
    {
        $response = $this->categoryService->updateOne(
            $request->input('id'), $request->all()
        );

        return $response->withJson();
    }

    public function deleteCategoryApi(Request $request)
    {
        $response = $this->categoryService->deleteOne(
            $request->input('id')
        );

        return $response->withJson();
    }
}
