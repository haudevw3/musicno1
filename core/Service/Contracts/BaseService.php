<?php

namespace Core\Service\Contracts;

interface BaseService
{
    /**
     * Get the cache service instance.
     *
     * @return \Core\Service\Contracts\CacheService
     */
    public function cache();
}