<?php

namespace Modules\Categories\Service\Impl;

use Core\Service\BaseServiceImpl;
use Modules\Categories\Repository\CategoriesRepository;
use Modules\Categories\Service\CategoriesService;

class CategoriesServiceImpl extends BaseServiceImpl implements CategoriesService
{
    protected $baseRepo;

    public function __construct(CategoriesRepository $baseRepo)
    {
        parent::__construct($baseRepo);
    }

    public function create(array $data)
    {
        $attributes = [
            'name' => ucwords(trim($data['name'])),
            'slug' => trim($data['slug']),
            'priority' => $data['priority'],
            'parent_id' => isset($data['parent_id']) ? $data['parent_id'] : 0,
        ];
        return $this->baseRepo->create($attributes);
    }

    public function updateOne($id, array $data)
    {
        $attributes = [];
        $category = $this->baseRepo->findOne(['id' => $id]);
        if (array_key_exists('name', $data) && $category['name'] !== ucwords(trim($data['name']))) {
            $attributes['name'] = $data['name'];
            $attributes['slug'] = trim($data['slug']);
        }
        if (array_key_exists('priority', $data) && $category['priority'] !== $data['priority']) {
            $attributes['priority'] = $data['priority'];
        }
        if (array_key_exists('parent_id', $data) && $category['parent_id'] !== $data['parent_id']) {
            $attributes['parent_id'] = $data['parent_id'];
        }
        if (empty($attributes)) {
            return;
        }
        return $this->baseRepo->updateOne($id, $attributes);
    }

    public function deleteOne($id)
    {
        return $this->baseRepo->deleteOne($id);
    }

    public function deleteAll(array $condition = [], $forever = false)
    {
        $column = array_keys($condition)[0];
        $values = array_values($condition)[0];
        $values = is_array($values) ? $values : [$values];
        foreach ($values as $value) {
            $this->baseRepo->delete([$column => $value], $forever);
        }
    }

    public function listCategories(array $columns = [], array $conditions = [], array $sorted = ['created_at' => 'desc'], $perPage = 10)
    {
        return $this->baseRepo->list($columns, $conditions, $sorted, $perPage);
    }

    public function treeCategories($parentId = null, array $categories = [])
    {
        $result = [];
        foreach ($categories as $category) {
            if ($category['parent_id'] == $parentId) {
                $subs = $this->treeCategories($category['id'], $categories);
                if (! empty($subs)) {
                    $category['subs'] = $subs;
                }
                $result[] = $category;
            }
        }
        return $result;
    }
}