<?php

namespace Modules\Categories\Service;

use Core\Http\ResponseBag;
use Core\Service\BaseService;
use Modules\Categories\Constant;
use Modules\Categories\Objects\Category;
use Modules\Categories\Repository\Contracts\CategoryRepository;
use Modules\Categories\Service\Contracts\CategoryService as CategoryServiceContract;

class CategoryService extends BaseService implements CategoryServiceContract
{
    protected $baseRepo;

    /**
     * @param  \Modules\Categories\Repository\Contracts\CategoryRepository  $baseRepo
     * @return void
     */
    public function __construct(CategoryRepository $baseRepo)
    {
        parent::__construct($baseRepo);
    }

    /**
     * @param  array $data
     * @return \Core\Http\ResponseBag
     */
    public function create(array $data)
    {
        $attributes = [
            'id' => str_random(),
            'name' => isset_if($data['name'], 'str_ucwords'),
            'slug' => isset_if($data['slug'], 'trim'),
            'parent_id' => isset_if($data['parent_id']),
            'priority' => isset_if($data['priority'], 'intval'),
            'tag_type' => isset_if($data['tag_type'], 'intval'),
            'images' => empty_if($data['images'], []),
            'created_at' => current_date(),
            'updated_at' => current_date(),
        ];

        $responseBag = ResponseBag::create();

        if (! is_null($attributes['parent_id'])) {
            $responseBag = $this->parseValueAttributes($attributes, $responseBag);
        }

        if ($responseBag->isEmptyErrors()) {
            $this->baseRepo->create($attributes);

            $responseBag->status(201)->data([
                'success' => config('categories.label.CREATE_SUCCESS')
            ]);
        }

        return $responseBag;
    }

    /**
     * Parse value attribute "tag type" and get the response bag instance.
     *
     * @param  array                   $attributes
     * @param  \Core\Http\ResponseBag  $responseBag
     * @return \Core\Http\ResponseBag
     */
    protected function parseValueAttributes(array $attributes, ResponseBag $responseBag)
    {
        $category = Category::make(
            $attributes['parent_id'], $this->baseRepo
        );

        if ($category->hasNoSubcategories()) {
            return $responseBag;
        }

        // If a category is the primary type and it contains subcategories are the primary type
        // and the given attribute "tag type" is not the primary type
        // then we can't execute this request.
        if ($category->subcategoriesMustBePrimaryType() &&
            $attributes['tag_type'] != Constant::TAG_PRIMARY) {
            $responseBag->errors = preg_replace(
                '/{name}/', $category->name,
                config('categories.label.CATEGORY_DEPENDENCY_PRIMARY_TYPE')
            );
        }

        // If a category is the primary type and it contains subcategories aren't the primary type
        // and the given attribute "tag type" is the primary type
        // then we can't execute it.
        elseif ($category->subcategoriesAreNotPrimaryType() &&
                $attributes['tag_type'] == Constant::TAG_PRIMARY) {
            $responseBag->errors = preg_replace(
                '/{name}/', $category->name,
                config('categories.label.CATEGORY_DEPENDENCY_NON_PRIMARY_TYPE')
            );
        }

        return $responseBag;
    }

    /**
     * @param  string  $id
     * @param  array   $data
     * @return \Core\Http\ResponseBag
     */
    public function updateOne($id, array $data)
    {
        $responseBag = ResponseBag::create();

        $attributes = $this->filterData($data);

        $category = Category::make($id, $this->baseRepo);

        if (is_null($category)) {
            $responseBag->errors = config('categories.label.NOT_FOUND_CATEGORY');
        }

        // If this is a primary category and the given data to
        // update has the attribute "tag_type" and it changed,
        // then we must determine if it has subcategories.
        // If it has then we can't update with this situation.
        elseif ($category->hasSubcategories() &&
            $attributes['tag_type'] !== $category->tag_type) {
            $responseBag->errors = config('categories.label.CATEGORY_UPDATE_BLOCKED_DEPENDENCIES');
        }
        
        elseif (! is_null($attributes['parent_id']) &&
            $attributes['parent_id'] !== $category->parent_id) {
            $responseBag = $this->parseValueAttributes($attributes, $responseBag, $category);
        }
        
        if ($responseBag->isEmptyErrors()) {
            $this->baseRepo->updateOne($id, $attributes);

            $responseBag->status(200)->data([
                'success' => config('categories.label.UPDATE_SUCCESS')
            ]);
        }

        return $responseBag;
    }

    /**
     * Filter with the given data to update.
     * 
     * @param  array  $data
     * @return array
     */
    protected function filterData(array $data)
    {
        $attributes['updated_at'] = current_date();

        foreach ($data as $key => $value) {
            if (in_array($key, ['name', 'slug'])) {
                $attributes[$key] = trim($value);
            } elseif (in_array($key, ['priority', 'tag_type'])) {
                $attributes[$key] = intval($value);
            } elseif (in_array($key, ['images', 'tag_ids'])) {
                $attributes[$key] = is_array($value) ? $value : [];
            } elseif ($key == 'parent_id') {
                $attributes[$key] = is_string($value) ? $value : null;
            }
        }

        return $attributes;
    }

    /**
     * @param  string  $id
     * @return \Core\Http\ResponseBag
     */
    public function deleteOne($id)
    {
        $responseBag = ResponseBag::create();

        $category = Category::make($id, $this->baseRepo);

        if (is_null($category)) {
            $responseBag->errors = config('categories.label.NOT_FOUND_CATEGORY');
        }

        elseif ($category->hasSubcategories()) {
            $categoryIds = [];

            foreach ($category->getSubcategories() as $subcategory) {
                $categoryIds[] = $this->baseRepo::createObjectId($subcategory->_id);
            }

            $this->baseRepo->update(['_id' => ['$in' => $categoryIds]], ['parent_id' => null]);
        }

        if ($responseBag->isEmptyErrors()) {
            $this->baseRepo->deleteOne($id);

            $responseBag->status(200)->data([
                'success' => config('categories.label.DELETE_SUCCESS')
            ]);
        }

        return $responseBag;
    }
}