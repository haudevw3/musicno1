<?php

namespace Modules\Categories\Repository\Impl;

use Core\Repository\BaseRepositoryImpl;
use Modules\Categories\Model\Categories;
use Modules\Categories\Repository\CategoriesRepository;

class CategoriesRepositoryImpl extends BaseRepositoryImpl implements CategoriesRepository
{
    public function getModel()
    {
        return Categories::class;
    }
}