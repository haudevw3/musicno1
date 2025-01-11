<?php

namespace Core\Contract\Repository;

use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

interface BaseRepository
{
    /**
     * Get the eloquent model instance.
     */
    public function model(): Model;

    /**
     * Get the eloquent builder instance.
     */
    public function builder(): Builder;

    /**
     * Get a document with the given unique identifier.
     */
    public function get(string $id, array $fields = []): Model;

    /**
     * Count documents with the given conditions.
     */
    public function count(array $conditions = []): int;

    /**
     * Calculate the sum of a field with the given conditions.
     */
    public function sum(string $field, array $conditions = []): float;

    /**
     * Insert one or many data arrays into the database.
     */
    public function create(array $data): Model;

    /**
     * Update one or many documents with the given conditions.
     */
    public function update(array $conditions, array $data, array $options = []): bool;

    /**
     * Update one document with the given unique identifier.
     */
    public function updateOne(string $id, array $data, array $options = []): bool;

    /**
     * Delete one or many documents with the given conditions.
     */
    public function delete(array $conditions): bool;

    /**
     * Delete one document with the given unique identifier.
     */
    public function deleteOne(string $id): bool;

    /**
     * Find one document with the given conditions.
     */
    public function findOne(array|string $conditions, array $fields = []): Model;

    /**
     * Find many documents with the given conditions.
     */
    public function findMany(array $conditions, array $fields = [], array $options = []): Collection;

    /**
     * Build a query statement with the given conditions and options if any.
     */
    public function buildQuery(array $conditions = [], ?array $options = null): Builder;
}