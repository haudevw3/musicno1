<?php

namespace Core\Repository;

use Core\Repository\Contracts\BaseRepository as BaseRepositoryContract;
use Illuminate\Database\Eloquent\Builder;

abstract class BaseRepository implements BaseRepositoryContract
{
    /**
     * The model instance.
     *
     * @var \Jenssegers\Mongodb\Eloquent\Model
     */
    protected $model;

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
     * Get the model instance.
     *
     * @return \Jenssegers\Mongodb\Eloquent\Model
     */
    public function model()
    {
        return $this->model;
    }

    /**
     * Count documents with the given conditions.
     *
     * @param  array  $conditions
     * @return int
     */
    public function count(array $conditions = [])
    {
        return $this->parseGrammar($conditions)->count();
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
        return $this->parseGrammar($conditions)->sum($field);
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
        return $this->model::where('_id', $id)->first($fields);
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
     * Update one document with the given conditions.
     *
     * @param  array  $conditions
     * @param  array  $data
     * @param  array  $options
     * @return bool
     */
    public function updateOne(array $conditions, array $data, array $options = [])
    {
        return $this->parseGrammar($conditions)->update($data, $options);
    }

    /**
     * Delete one document with the given conditions.
     *
     * @param  array  $conditions
     * @return bool
     */
    public function deleteOne(array $conditions)
    {
        return $this->parseGrammar($conditions)->delete();
    }

    /**
     * Return one document with the given conditions.
     *
     * @param  array  $conditions
     * @param  array  $fields
     * @param  array  $sorted
     * @return \Jenssegers\Mongodb\Eloquent\Model
     */
    public function findOne(array $conditions, array $fields = [], array $sorted = [])
    {
        return $this->parseGrammar(
            $conditions, empty($sorted) ? $sorted : ['sorted' => $sorted]
        )->first($fields);
    }

    /**
     * Return many documents with the given conditions.
     *
     * @param  array  $conditions
     * @param  array  $fields
     * @param  array  $sorted
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findMany(array $conditions = [], array $fields = [], array $sorted = [])
    {
        return $this->parseGrammar(
            $conditions, array_merge(empty($sorted) ? $sorted : ['sorted' => $sorted], ['limit' => 1000])
        )->get($fields);
    }

    /**
     * Parse grammar and build a new query builder for the model's table.
     *
     * @param  array  $conditions
     * @param  array  $options
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function parseGrammar(array $conditions = [], array $options = [])
    {   
        // Get a new query builder for the model's table.
        $builder = $this->model::query();

        if (! empty($conditions)) {
            $builder = $this->parseConditions($conditions, $builder);
        }

        if (! empty($options)) {
            $builder = $this->parseOptions($options, $builder);
        }

        return $builder;
    }

    /**
     * Parse conditions for the model.
     *
     * @param  array  $conditions
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function parseConditions(array $conditions, Builder $builder)
    {
        foreach ($conditions as $column => $value) {
            if (is_array($value) && isset($value['$regex'])) {
                $builder = $builder->where($column, 'regexp', $value['$regex']);
            } else {
                $builder = $builder->where($column, $value);
            }
        }

        return $builder;
    }

    /**
     * Parse options for the model.
     *
     * @param  array  $options
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function parseOptions(array $options, Builder $builder)
    {
        if (isset($options['skip']) && is_numeric($skip = $options['skip'])) {
            $builder = $builder->skip($skip);
        }

        if (isset($options['limit']) && is_numeric($limit = $options['limit'])) {
            $builder = $builder->take($limit);
        }
        
        if (isset($options['sorted']) && is_array($sorted = $options['sorted'])) {
            foreach ($sorted as $key => $value) {
                $builder = $builder->orderBy(
                    $key, (is_string($value) ? ($value == 'desc' ? -1 : 1) : $value)
                );
            }
        }

        return $builder;
    }
}