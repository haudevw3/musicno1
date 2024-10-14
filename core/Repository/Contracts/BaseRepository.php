<?php

namespace Core\Repository\Contracts;

interface BaseRepository
{
    /**
     * Get the model name of the sub-class when it extends from the parent class.
     *
     * @return string
     */
    public function getModel();

    /**
     * Get the model instance.
     *
     * @return \Jenssegers\Mongodb\Eloquent\Model
     */
    public function model();

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
     * Update one document with the given conditions.
     *
     * @param  array  $conditions
     * @param  array  $data
     * @param  array  $options
     * @return bool
     */
    public function updateOne(array $conditions, array $data, array $options = []);

    /**
     * Delete one document with the given conditions.
     *
     * @param  array  $conditions
     * @return bool
     */
    public function deleteOne(array $conditions);

    /**
     * Return one document with the given conditions.
     *
     * @param  array  $conditions
     * @param  array  $fields
     * @param  array  $sorted
     * @return \Jenssegers\Mongodb\Eloquent\Model
     */
    public function findOne(array $conditions, array $fields = [], array $sorted = []);

    /**
     * Return many documents with the given conditions.
     *
     * @param  array  $conditions
     * @param  array  $fields
     * @param  array  $sorted
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findMany(array $conditions = [], array $fields = [], array $sorted = []);

    /**
     * Parse grammar and Build a new query builder for the model's table.
     *
     * @param  array  $conditions
     * @param  array  $options
     * @return \Jenssegers\Mongodb\Eloquent\Model
     */
    public function parseGrammar(array $conditions = [], array $options = []);
}