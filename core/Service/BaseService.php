<?php

namespace Core\Service;

interface BaseService
{
    public function delete(array $condition, $forever = false);
    
    public function getListByTags(array $tags, array $columns, array $sorted = []);

    public function getListPagination(array $columns = [], array $conditions = [], array $sorted = [], $perPage = 10);
}