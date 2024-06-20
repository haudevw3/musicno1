<?php

namespace Modules\Categories\Service;

interface CategoriesService
{
    public function create(array $data);

    public function updateOne($id, array $data);

    public function deleteOne($id);

    public function delete(array $condition = [], $forever = false);

    public function listCategories(array $columns = [], array $conditions = [], array $sorted = [], $perPage = 10);
}