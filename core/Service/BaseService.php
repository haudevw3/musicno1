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
     * Create a new base service instance.
     *
     * @param  \Core\Repository\BaseRepository  $baseRepo
     * @return void
     */
    public function __construct($baseRepo = null)
    {
        $this->baseRepo = $baseRepo;
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