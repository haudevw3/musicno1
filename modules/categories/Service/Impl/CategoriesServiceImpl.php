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
            'name' => trim($data['name']),
            'priority' => ! empty($data['priority']) ? $data['priority'] : 0,
            'sub_id' => ! empty($data['subs']) ? implode(',', $data['subs']) : null,
            'display_limit' => ! empty($data['display_limit']) ? $data['display_limit'] : 0,
            'slug' => trim($data['slug']),
            'image' => ! empty($data['image']) ? trim($data['image']) : null
        ];

        return $this->baseRepo->create($attributes);
    }

    public function updateOne($id, array $data)
    {
        $data['sub_id'] = ! empty($data['subs']) ? implode(',', $data['subs']) : null;
        unset($data['subs']);
        return $this->baseRepo->updateOne($id, $data);
    }

    public function deleteOne($id)
    {
        return $this->baseRepo->deleteOne($id);
    }

    public function delete(array $condition = [], $forever = false)
    {
        $column = array_keys($condition)[0];
        $values = array_values($condition)[0];
        $values = is_array($values) ? $values : [$values];
        foreach ($values as $key => $value) {
            $this->baseRepo->delete([$column => $value]);
        }
        return true;
    }

    public function listCategories(array $columns = [], array $conditions = [], array $sorted = [], $perPage = 10)
    {
        return $this->baseRepo->list($columns, $conditions, $sorted, $perPage);
    }
}