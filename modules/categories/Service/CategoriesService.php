<?php

namespace Modules\Categories\Service;

interface CategoriesService
{
    public function create(array $data);

    public function updateOne($id, array $data);

    public function deleteOne($id);

    public function deleteAll(array $condition = [], $forever = false);

    public function listCategories(array $columns = [], array $conditions = [], array $sorted = ['created_at' => 'desc'], $perPage = 10);

    public function getPlaylistByCategoryId($id, array $columns = []);

    public function getTreeCategories(array $columns = [], array $condition = []);
}