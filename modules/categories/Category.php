<?php

namespace Modules\Categories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Traits\ForwardsCalls;
use Modules\Categories\Models\Category as Model;
use Modules\Categories\Repository\Contracts\CategoryRepository;

class Category
{
    use ForwardsCalls;

    /**
     * The category model instance.
     *
     * @var \Modules\Categories\Models\Category
     */
    protected $model;

    /**
     * The category repository instance.
     *
     * @var \Modules\Categories\Repository\Contracts\CategoryRepository
     */
    protected $repository;

    /**
     * The collection instance.
     *
     * @var \Illuminate\Database\Eloquent\Collection
     */
    protected $subcategories;

    /**
     * Create a new category instance.
     *
     * @param  \Modules\Categories\Models\Category                          $model
     * @param  \Modules\Categories\Repository\Contracts\CategoryRepository  $repository
     * @param  \Illuminate\Database\Eloquent\Collection                     $subcategories
     * @return void
     */
    public function __construct(Model $model, CategoryRepository $repository, Collection $subcategories)
    {
        $this->model = $model;
        $this->repository = $repository;
        $this->subcategories = $subcategories;
    }

    /**
     * Create a new category instance.
     *
     * @param  \Modules\Categories\Models\Category|array|string             $value
     * @param  \Modules\Categories\Repository\Contracts\CategoryRepository  $repository
     * @return null|$this
     * 
     */
    public static function make($value, CategoryRepository $repository)
    {
        if (! $value instanceof Model) {
            $value = $repository->findOne($value);
        }

        if (! is_null($value)) {
            return new static(
                $value, $repository,
                $repository->findMany(['parent_id' => $value->_id])
            );
        }

        return $value;
    }

    /**
     * Get subcategories of the primary category if any.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getSubcategories()
    {
        return $this->subcategories;
    }

    /**
     * Determine if the primary category has subcategories.
     *
     * @return bool
     */
    public function hasSubcategories()
    {
        return $this->getSubcategories()->isNotEmpty();
    }

    /**
     * Determine if the primary category has no subcategories.
     *
     * @return bool
     */
    public function hasNoSubcategories()
    {
        return ! $this->hasSubcategories();
    }

    /**
     * Determine if all subcategories are the primary type.
     *
     * @return bool
     */
    public function subcategoriesMustBePrimaryType()
    {  
        if ($this->hasNoSubcategories()) {
            return false;
        }

        foreach ($this->getSubcategories() as $subcategory) {
            if ($subcategory->tag_type > 0) {
                return false;
            }
        }

        return true;
    }

    /**
     * Determine if all subcategories are not the primary type.
     *
     * @return bool
     */
    public function subcategoriesAreNotPrimaryType()
    {
        return ! $this->subcategoriesMustBePrimaryType();
    }

    /**
     * Get badges of subcategories for the primary category.
     *
     * @return string
     */
    public function badges()
    {
        if ($this->hasNoSubcategories()) {
            return;
        }

        $badges = [];

        foreach ($this->getSubcategories() as $subcategory) {
            $badges[] = $this->model->badge($subcategory->tag_type, $subcategory->name);
        }

        return implode(' ', $badges);
    }

    /**
     * @param  string  $attribute
     * @return mixed
     */
    public function __get($attribute)
    {
        return $this->model->$attribute;
    }

    /**
     * Handle dynamic method calls into the model.
     *
     * @param  string  $method
     * @param  array   $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->forwardCallTo($this->model, $method, $parameters);
    }
}