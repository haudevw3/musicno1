<?php

namespace Core\Repository\Contracts;

interface BaseRepository
{
    /**
     * Get the eloquent model instance.
     *
     * @return \Jenssegers\Mongodb\Eloquent\Model
     */
    public function model();

    /**
     * Get the eloquent builder instance.
     *
     * @return \Jenssegers\Mongodb\Eloquent\Builder
     */
    public function builder();

    /**
     * Get the record with the given unique identifier.
     *
     * @param  string  $id
     * @param  array   $fields
     * @return \Jenssegers\Mongodb\Eloquent\Model
     */
    public function get(string $id, array $fields = []);

    /**
     * Count documents with the given conditions.
     *
     * @param  array  $conditions
     * @return int
     */
    public function count(array $conditions = []);

    /**
     * Calculate the sum with the given conditions.
     *
     * @param  string  $field
     * @param  array   $conditions
     * @return float
     */
    public function sum(string $field, array $conditions = []);

    /**
     * Insert one or many new data into the database.
     *
     * @param  array  $data
     * @return \Jenssegers\Mongodb\Eloquent\Model
     */
    public function create(array $data);

    /**
     * Update documents with the given conditions.
     *
     * @param  array  $conditions
     * @param  array  $data
     * @param  array  $options
     * @return bool
     */
    public function update(array $conditions, array $data, array $options = []);

    /**
     * Update one document with the given unique identifier.
     *
     * @param  string  $id
     * @param  array   $data
     * @param  array   $options
     * @return bool
     */
    public function updateOne(string $id, array $data, array $options = []);

    /**
     * Delete documents with the given conditions.
     *
     * @param  array  $conditions
     * @return bool
     */
    public function delete(array $conditions);

    /**
     * Delete one document with the given unique identifier.
     *
     * @param  string  $id
     * @return bool
     */
    public function deleteOne(string $id);

    /**
     * Return one document with the given conditions.
     *
     * @param  array|string  $conditions
     * @param  array         $fields
     * @param  array         $options
     * @return \Jenssegers\Mongodb\Eloquent\Model
     */
    public function findOne($conditions, array $fields = [], array $options = []);

    /**
     * Return many documents with the given conditions.
     *
     * @param  array  $conditions
     * @param  array  $fields
     * @param  array  $options
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findMany(array $conditions, array $fields = [], array $options = []);

    /**
     * Build a query statement with the given conditions and options if any.
     *
     * @param  array  $conditions
     * @param  array  $options
     * @return \Jenssegers\Mongodb\Eloquent\Builder
     */
    public function buildQuery(array $conditions = [], array $options = []);
}