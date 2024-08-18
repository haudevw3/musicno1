<?php

namespace Core\Service;

use Foundation\Support\Traits\ForwardsCalls;

class BaseServiceImpl implements BaseService
{
    use ForwardsCalls;

    protected $baseRepo;

    public function __construct($baseRepo = null)
    {
        $this->baseRepo = $baseRepo;
    }

    public function delete(array $condition = [], $forever = false)
    {
        $column = array_keys($condition)[0];
        $values = array_values($condition)[0];
        $values = is_array($values) ? $values : [$values];
        foreach ($values as $value) {
            $this->baseRepo->delete([$column => $value], $forever);
        }
    }

    public function getListByTags(array $tags, array $columns, array $sorted = [])
    {
        $data = [];
        $columns = array_key_exists('tags', $columns) ? $columns : array_merge($columns, ['tags']);
        $results = $this->baseRepo->findAll($columns, [], $sorted);
        foreach ($results as $result) {
            $arrayTags = is_null($result['tags']) ? null : explode(',', $result['tags']);
            if (! is_null($arrayTags)) {
                foreach ($tags as $value) {
                    if (in_array($value, $arrayTags)) {
                        $result['tags'] = $arrayTags;
                        $data[] = $result;
                    }
                }
            }
        }
        return $data;
    }

    public function getListPagination(array $columns = [], array $conditions = [], array $sorted = [], $perPage = 10)
    {
        return $this->baseRepo->list($columns, $conditions, $sorted, $perPage);
    }

    public function __call($method, $params)
    {
        return $this->forwardCallTo($this->baseRepo, $method, $params);
    }
}