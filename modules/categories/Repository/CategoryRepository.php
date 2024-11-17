<?php

namespace Modules\Categories\Repository;

use Core\Repository\BaseRepository;
use Modules\Categories\Models\Category;
use Modules\Categories\Repository\Contracts\CategoryRepository as CategoryRepositoryContract;

class CategoryRepository extends BaseRepository implements CategoryRepositoryContract
{
    /**
     * The model name.
     *
     * @return string
     */
    public function getModel()
    {
        return Category::class;
    }
}