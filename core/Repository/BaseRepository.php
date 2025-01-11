<?php

namespace Core\Repository;

use MongoDB\BSON\ObjectId;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Core\Contract\Repository\BaseRepository as BaseRepositoryContract;

abstract class BaseRepository implements BaseRepositoryContract
{
    /**
     * The primary key name in Mongo DB.
     *
     * @var string
     */
    protected $primaryKey = '_id';

    /**
     * The default direction for sort order.
     *
     * @var string
     */
    protected $direction = 'asc';
    
    /**
     * The eloquent model instance.
     *
     * @var Model
     */
    protected $model;

    /**
     * The eloquent builder instance.
     *
     * @var Builder
     */
    protected $builder;

    /**
     * Create a new "base repository" instance.
     */
    public function __construct()
    {
        $this->setModel($this->getModel());
    }

    /**
     * Get the model name of the sub-class when it extends from the parent class.
     */
    abstract public function getModel(): string;

    /**
     * Set the model instance with the given name.
     */
    protected function setModel(string $model): void
    {
        $this->model = app($model);
    }

     /**
     * Get the eloquent model instance.
     */
    public function model(): Model
    {
        return $this->model;
    }

    /**
     * Get the eloquent builder instance.
     */
    public function builder(): Builder
    {
        return $this->builder;
    }

    /**
     * Get a document with the given unique identifier.
     */
    public function get(string $id, array $fields = []): Model
    {
        return $this->model::where($this->primaryKey, $id)->first($fields);
    }

    /**
     * Count documents with the given conditions.
     */
    public function count(array $conditions = []): int
    {
        return $this->buildQuery($conditions)->count();
    }

    /**
     * Calculate the sum of a field with the given conditions.
     */
    public function sum(string $field, array $conditions = []): float
    {
        return $this->buildQuery($conditions)->sum($field);
    }

    /**
     * Insert one or many data arrays into the database.
     */
    public function create(array $data): Model
    {
        return $this->model::create($data);
    }

    /**
     * Update one or many documents with the given conditions.
     */
    public function update(array $conditions, array $data, array $options = []): bool
    {
        return $this->buildQuery($conditions)->update($data, $options);
    }

    /**
     * Update one document with the given unique identifier.
     */
    public function updateOne(string $id, array $data, array $options = []): bool
    {
        return $this->model::where($this->primaryKey, $id)->update($data, $options);
    }

    /**
     * Delete one or many documents with the given conditions.
     */
    public function delete(array $conditions): bool
    {
        return $this->buildQuery($conditions)->delete();
    }

    /**
     * Delete one document with the given unique identifier.
     */
    public function deleteOne(string $id): bool
    {
        return $this->model::where($this->primaryKey, $id)->delete();
    }

    /**
     * Find one document with the given conditions.
     */
    public function findOne(array|string $conditions, array $fields = []): Model
    {
        return $this->buildQuery(
            is_array($conditions) ? $conditions : [$this->primaryKey => $conditions]
        )->first($fields);
    }

    /**
     * Find many documents with the given conditions.
     */
    public function findMany(array $conditions, array $fields = [], array $options = []): Collection
    {
        return $this->buildQuery($conditions, $options)->get($fields);
    }

    /**
     * Build a query statement with the given conditions and options if any.
     */
    public function buildQuery(array $conditions = [], ?array $options = null): Builder
    {
        // Get a new eloquent query builder for the model's table.
        $this->builder = $this->model::query();

        if (! empty($conditions)) {
            $this->parseConditions($conditions);
        }

        if (! is_null($options)) {
            $this->parseOptions($options);
        }

        return $this->builder;
    }

    /**
     * Parse conditions and convert them to the query standard in Laravel.
     */
    protected function parseConditions(array $conditions): self
    {
        foreach ($conditions as $key => $value) {
            if (is_array($value) && isset($value['$regex'])) {
                $this->builder->where($key, 'regexp', $value['$regex']);
            } else {
                $this->builder->where($key, $value);
            }
        }

        return $this;
    }

    /**
     * Parse optional parameters and convert them to the query standard in Laravel.
     */
    protected function parseOptions(array $options): self
    {
        $this->builder->skip(
            isset($options['skip']) ? intval($options['skip']) : 0
        )->take(
            isset($options['limit']) ? intval($options['limit']) : 1000
        );

        $sorts = array_merge(
            isset($options['sort']) && is_array($options['sort']) ? $options['sort'] : [],
            [$this->primaryKey => $this->direction]
        );

        foreach ($sorts as $key => $value) {
            if ($key != $this->primaryKey) {
                $this->direction = $value;
            }

            $this->builder->orderBy($key, $this->direction);
        }

        return $this;
    }

    /**
     * Create a new object identifier with the given identifier.
     */
    public static function createObjectId($identifier): ObjectId
    {
        return new ObjectId($identifier);
    }
}