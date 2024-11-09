<?php

namespace Core\Service\Contracts;

interface BaseService
{
    /**
     * Paginate the given query.
     *
     * @param  array  $fields
     * @param  array  $conditions
     * @param  array  $options
     * @return \Core\Pagination\Contracts\Paginator
     */
    public function paginator(array $fields = [], array $conditions = [], array $options = []);
}