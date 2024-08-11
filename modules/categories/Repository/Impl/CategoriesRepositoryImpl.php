<?php

namespace Modules\Categories\Repository\Impl;

use Core\Repository\BaseRepositoryImpl;
use Modules\Categories\Model\Category;
use Modules\Categories\Repository\CategoriesRepository;

class CategoriesRepositoryImpl extends BaseRepositoryImpl implements CategoriesRepository
{
    public function getModel()
    {
        return Category::class;
    }
}