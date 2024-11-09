<?php

namespace Core\Repository;

use Core\Repository\Contracts\BaseRepository as BaseRepositoryContract;
use Illuminate\Support\Traits\Macroable;
use MongoDB\BSON\ObjectId;

abstract class BaseRepository implements BaseRepositoryContract
{
    use Macroable;

    /**
     * The primary key name in Mongo DB.
     *
     * @var string
     */
    protected $primaryKey = '_id';
    
    /**
     * The eloquent model instance.
     *
     * @var \Jenssegers\Mongodb\Eloquent\Model
     */
    protected $model;

    /**
     * The eloquent builder instance.
     *
     * @var \Jenssegers\Mongodb\Eloquent\Builder
     */
    protected $builder;

    /**
     * Create a new base repository instance.
     * 
     * @return void
     */
    public function __construct()
    {
        $this->setModel($this->getModel());
    }

    /**
     * Get the model name of the sub-class when it extends from the parent class.
     *
     * @return string
     */
    abstract public function getModel();

    /**
     * Set the model name with the given name.
     *
     * @param  string  $model
     * @return void
     */
    protected function setModel($model)
    {
        $this->model = app($model);
    }

    /**
     * Get the eloquent model instance.
     *
     * @return \Jenssegers\Mongodb\Eloquent\Model
     */
    public function model()
    {
        return $this->model;
    }

    /**
     * Get the eloquent builder instance.
     *
     * @return \Jenssegers\Mongodb\Eloquent\Builder
     */
    public function builder()
    {
        return $this->builder;
    }

    /**
     * Count documents with the given conditions.
     *
     * @param  array  $conditions
     * @return int
     */
    public function count(array $conditions = [])
    {
        return $this->buildQuery($conditions)->count();
    }

    /**
     * Calculate the sum with the given conditions.
     *
     * @param  string  $field
     * @param  array   $conditions
     * @return float
     */
    public function sum(string $field, array $conditions = [])
    {
        return $this->buildQuery($conditions)->sum($field);
    }

    /**
     * Get one document with the given unique identifier.
     *
     * @param  string  $id
     * @param  array   $fields
     * @return \Jenssegers\Mongodb\Eloquent\Model
     */
    public function get(string $id, array $fields = [])
    {
        return $this->model::where($this->primaryKey, $id)->first($fields);
    }

    /**
     * Insert one or many new data into the database.
     *
     * @param  array  $data
     * @return \Jenssegers\Mongodb\Eloquent\Model
     */
    public function create(array $data)
    {
        return $this->model::create($data);
    }

    /**
     * Update documents with the given conditions.
     *
     * @param  array  $conditions
     * @param  array  $data
     * @param  array  $options
     * @return bool
     */
    public function update(array $conditions, array $data, array $options = [])
    {
        return $this->buildQuery($conditions)->update($data, $options);
    }

    /**
     * Update one document with the given unique identifier.
     *
     * @param  string  $id
     * @param  array   $data
     * @param  array   $options
     * @return bool
     */
    public function updateOne(string $id, array $data, array $options = [])
    {
        return $this->model::where($this->primaryKey, $id)->update($data, $options);
    }

    /**
     * Delete documents with the given conditions.
     *
     * @param  array  $conditions
     * @return bool
     */
    public function delete(array $conditions)
    {
        return $this->buildQuery($conditions)->delete();
    }

    /**
     * Delete one document with the given unique identifier.
     *
     * @param  string  $id
     * @return bool
     */
    public function deleteOne(string $id)
    {
        return $this->model::where($this->primaryKey, $id)->delete();
    }

    /**
     * Return one document with the given conditions.
     *
     * @param  array|string  $conditions
     * @param  array         $fields
     * @return \Jenssegers\Mongodb\Eloquent\Model
     */
    public function findOne($conditions, array $fields = [])
    {
        return $this->buildQuery(
            is_array($conditions) ? $conditions : [$this->primaryKey => $conditions]
        )->first($fields);
    }

    /**
     * Return many documents with the given conditions.
     *
     * @param  array  $conditions
     * @param  array  $fields
     * @param  array  $options
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findMany(array $conditions = [], array $fields = [], array $options = [])
    {
        return $this->buildQuery(
            $conditions, isset($options['limit']) ? $options : array_merge($options, ['limit' => 1000])
        )->get($fields);
    }

    /**
     * Build a query statement with the given conditions and options if any.
     *
     * @param  array  $conditions
     * @param  array  $options
     * @return \Jenssegers\Mongodb\Eloquent\Builder
     */
    public function buildQuery(array $conditions = [], array $options = [])
    {
        // Get a new eloquent query builder for the model's table.
        $this->builder = $this->model::query();

        if (! empty($conditions)) {
            $this->parseConditions($conditions);
        }

        if (! empty($options)) {
            $this->parseOptions($options);
        }

        return $this->builder;
    }

    /**
     * Parse conditions and convert them to the "query" standard in Mongo DB.
     *
     * @param  array  $conditions
     * @return $this
     */
    protected function parseConditions(array $conditions)
    {
        $identifiers =  $this->hasPrimaryKey($conditions) &&
                        $this->hasOperator($conditions[$this->primaryKey], '$in')
                        ? $conditions[$this->primaryKey]['$in'] : [];

        if (! empty($identifiers)) {
            $objectIds = [];

            foreach ($identifiers as $identifier) {
                $objectIds[] = new ObjectId($identifier);
            }

            $conditions[$this->primaryKey]['$in'] = $objectIds;
        }

        foreach ($conditions as $key => $value) {
            if (is_array($value) && $this->hasOperator($value, '$regex')) {
                $this->builder = $this->builder->where($key, 'regexp', $value['$regex']);
            } else {
                $this->builder = $this->builder->where($key, $value);
            }
        }

        return $this;
    }

    /**
     * Parse optional parameters addition as (skip, limit, sorted) and
     * convert them to the "query" standard in Mongo DB.
     *
     * @param  array  $options
     * @return $this
     */
    protected function parseOptions(array $options)
    {
        if (isset($options['skip']) && is_numeric($skip = $options['skip'])) {
            $this->builder = $this->builder->skip($skip);
        }

        if (isset($options['limit']) && is_numeric($limit = $options['limit'])) {
            $this->builder = $this->builder->take($limit);
        }
        
        if (isset($options['sorted']) && is_array($sorted = $options['sorted'])) {
            foreach ($sorted as $key => $value) {
                $this->builder = $this->builder->orderBy(
                    $key, (is_string($value) ? ($value == 'desc' ? -1 : 1) : $value)
                );
            }
        }

        return $this;
    }

    /**
     * Determine if the primary key exists in the given conditions.
     * 
     * @param  array  $conditions
     * @return bool
     */
    protected function hasPrimaryKey(array $conditions)
    {
        return isset($conditions[$this->primaryKey]);
    }

    /**
     * Determine if the comparison query operator exists in the given array.
     *
     * @param  mixed   $array
     * @param  string  $operator
     * @return bool
     */
    protected function hasOperator($array, $operator)
    {
        return is_array($array) && isset($array[$operator]);
    }
}