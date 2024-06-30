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

    protected function parseData(array $data)
    {
        return [
            'name' => trim($data['name']),
            'slug' => trim($data['slug']),
            'image' => trim($data['image']),
            'priority' => ! empty($data['priority']) ? $data['priority'] : 0,
            'subs' => ! empty($data['subs']) ? implode(',', $data['subs']) : null,
        ];
    }

    public function create(array $data)
    {
        return $this->baseRepo->create($this->parseData($data));
    }

    public function updateOne($id, array $data)
    {
        return $this->baseRepo->updateOne($id, $this->parseData($data));
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