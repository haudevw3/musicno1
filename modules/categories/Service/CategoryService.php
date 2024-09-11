<?php

namespace Modules\Categories\Service;

interface CategoryService
{
    public function create(array $data);

    public function updateOne($id, array $data);

    public function deleteOne($id);

    public function buildTreeCategories($parentId = 0, array $categories);
}