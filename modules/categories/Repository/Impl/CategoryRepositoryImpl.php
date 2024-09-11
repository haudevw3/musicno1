<?php

namespace Modules\Categories\Repository\Impl;

use Core\Repository\BaseRepositoryImpl;
use Modules\Categories\Model\Category;
use Modules\Categories\Repository\CategoryRepository;

class CategoryRepositoryImpl extends BaseRepositoryImpl implements CategoryRepository
{
    public function getModel()
    {
        return Category::class;
    }
}