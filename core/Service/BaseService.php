<?php

namespace Core\Service;

use Core\Service\Contracts\BaseService as BaseServiceContract;
use Illuminate\Support\Traits\ForwardsCalls;

class BaseService implements BaseServiceContract
{
    use ForwardsCalls;

    /**
     * The base repository instance.
     *
     * @var \Core\Repository\BaseRepository
     */
    protected $baseRepo;

    /**
     * The cache service instance.
     *
     * @var \Core\Service\Contracts\CacheService
     */
    protected $cacheService;

    /**
     * Create a new base service instance.
     *
     * @param  \Core\Repository\BaseRepository  $baseRepo
     * @return void
     */
    public function __construct($baseRepo = null)
    {
        $this->baseRepo = $baseRepo;

        if (! is_null($baseRepo)) {
            $this->cacheService = new CacheService($baseRepo);
        }
    }

    /**
     * Get the cache service instance.
     *
     * @return \Core\Service\Contracts\CacheService
     */
    public function cache()
    {
        return $this->cacheService;
    }

    /**
     * Handle dynamic method calls into the base repository.
     *
     * @param  string  $method
     * @param  array   $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->forwardCallTo($this->baseRepo, $method, $parameters);
    }
}