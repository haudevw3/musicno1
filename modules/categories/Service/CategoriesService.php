<?php

namespace Modules\Categories\Service;

interface CategoriesService
{
    public function create(array $data);

    public function updateOne($id, array $data);

    public function deleteOne($id);

    public function buildTreeCategories($parentId = 0, array $categories);

    public function getPlaylistOfCategoryByTags(array $tags, array $columns = []);

    public function getPlaylistOfSubCategoryByParentId($id, array $columns = []);
}