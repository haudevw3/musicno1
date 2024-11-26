<?php

namespace Modules\Track\Service;

use Core\Service\BaseService;
use Modules\Track\Repository\Contracts\TrackRepository;
use Modules\Track\Service\Contracts\TrackService as TrackServiceContract;

class TrackService extends BaseService implements TrackServiceContract
{
    protected $baseRepo;

    public function __construct(TrackRepository $baseRepo)
    {
        parent::__construct($baseRepo);
    }
}