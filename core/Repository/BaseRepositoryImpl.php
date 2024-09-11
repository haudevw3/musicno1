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
        // ['and' => [key => value, 'key' => 'value',...]]
        // ['and' => [key => value,...], 'or' => [key => value,...]]
        $query = $this->model()->newQuery()->select($columns);
        if (count($conditions) > 0) {
            foreach ($conditions as $key => $values) {
                $method = 'where';
                $operator = '=';
                if (is_array($values)) {
                    if (in_array($key, ['or', 'and'])) {
                        $method = $key.'Where';
                    } else {
                        $operator = $key;
                    }
                    if (count($values) > 1) {
                        $b = true;
                        foreach ($values as $column => $value) {
                            if ($b) {
                                $b = false;
                                $query->where($column, $operator, $value);
                            } else {
                                $query->$method($column, $operator, $value);
                            }
                        }
                    } else {
                        $query->$method(array_keys($values)[0], $operator, array_values($values)[0]);
                    }
                } else {
                    $query->$method($key, ($values === 0) ? '0' : $values);
                }
            }
        }
        if (count($options) > 0) {
            if (array_key_exists('sorted', $options)) {
                $query->orderBy(array_keys($options['sorted'])[0], array_values($options['sorted'])[0]);
            }
        }
        return $query;
    }

    public function findOne(array $conditions = [], array $columns = [])
    {
        $query = $this->buildQuery($columns, $conditions);
        return is_null($query->get($columns)) ? null : $query->get($columns)[0];
    }

    public function findAll(array $columns = [], array $conditions = [], array $sorted = [])
    {
        $sorted = ! empty($sorted) ? $sorted : ['created_at' => 'asc'];
        $query = $this->buildQuery($columns, $conditions, ['sorted' => $sorted]);
        return $query->get();
    }

    public function pagination(array $columns = [], array $conditions = [], array $sorted = [], $perPage = 10)
    {
        $items = [];
        $sorted = ! empty($sorted) ? $sorted : ['created_at' => 'desc'];
        $items = $this->findAll($columns, $conditions, $sorted);
        $paginator = new Paginator($items, $perPage, [], app('request'));
        return $paginator->toArray();
    }

    public function create(array $data)
    {
        return $this->model()->create($data);
    }

    public function update(array $condition, array $data)
    {
        $query = $this->buildQuery($condition);
        return $query->update($data);
    }

    public function updateOne($id, array $data)
    {
        return $this->model()->update($id, $data);
    }

    public function delete(array $condition)
    {
        return $this->model()->where(array_keys($condition)[0], array_values($condition)[0])->delete();
    }

    public function deleteOne($id)
    {
        return $this->model()->delete($id);
    }
}