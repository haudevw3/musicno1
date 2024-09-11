<?php

namespace Core\Service;

use Foundation\Support\Traits\ForwardsCalls;

class BaseServiceImpl implements BaseService
{
    use ForwardsCalls;

    protected $baseRepo;

    public function __construct($baseRepo = null)
    {
        $this->baseRepo = $baseRepo;
    }

    public function __call($method, $params)
    {
        return $this->forwardCallTo($this->baseRepo, $method, $params);
    }
}