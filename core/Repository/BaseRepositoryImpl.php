<?php

namespace Core\Repository;

use Foundation\Pagination\Paginator;

abstract class BaseRepositoryImpl implements BaseRepository
{
    protected $model;

    public function __construct()
    {
        $this->setModel();
    }

    abstract public function getModel();

    public function setModel()
    {
        $model = $this->getModel();
        $this->model = new $model;
    }

    protected function model()
    {
        return $this->model;
    }

    public function buildQuery(array $columns = [], array $conditions = [], array $options = [])
    {
        // [key => value] = where
        // [key => value, 'and' => [key => value]]
        // ['and' => [key => value], 'or' => [key => value]]
        // ['and' => [key => value, 'key1' => 'value1]...]
        $query = $this->model()->newQuery()->select($columns);
        if (count($conditions) > 0) {
            foreach ($conditions as $key => $values) {
                $method = 'where';
                if (is_array($values)) {
                    $method = $key.'Where';
                    if (count($values) > 1) {
                        foreach ($values as $column => $value) {
                            $query->{$method}($column, $value);
                        }
                    } else {
                        $query->{$method}(
                            array_keys($values)[0], array_values($values)[0]
                        );
                    }
                } else {
                    $query->{$method}($key, $values);
                }
            }
        }
        // sorted => [column => asc|desc]
        if (count($options) > 0) {
            if (isset($options['sorted'])) {
                $query->orderBy(
                    array_keys($options['sorted'])[0], array_values($options['sorted'])[0]
                );
            }
        }
        return $query;
    }

    public function findOne(array $condition = [], array $columns = [])
    {
        // [key => value]
        return $this->model()->where(
            array_keys($condition)[0], array_values($condition)[0]
        )->get($columns)[0];
    }

    public function findAll(array $columns = [], array $conditions = [], array $sorted = [])
    {
        return $this->buildQuery($columns, $conditions, $sorted)->get();
    }

    public function list(array $columns = [], array $conditions = [], array $sorted = [], $perPage = 10)
    {
        $items = $this->findAll($columns, $conditions, $sorted);
        $paginator = new Paginator($items, $perPage, [], app('request'));
        return $paginator->toArray();
    }

    public function create(array $data = [])
    {
        return $this->model()->create($data);
    }

    public function update(array $condition = [], array $data = [])
    {
        return $this->buildQuery($condition)->update($data);
    }

    public function updateOne($id, array $data = [])
    {
        return $this->model()->update($id, $data);
    }

    public function delete(array $condition = [], $forever = false)
    {
        $column = array_keys($condition)[0];
        $value = array_values($condition)[0];
        return $this->model()->where($column, $value)->delete();
    }

    public function deleteOne($id, $forever = false)
    {
        return $this->model()->delete($id);
    }
}