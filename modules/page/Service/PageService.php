<?php

namespace Modules\Page\Service;

use Core\Service\BaseService;
use Modules\Page\Service\Contracts\PageService as PageServiceContract;

class PageService extends BaseService implements PageServiceContract
{
    protected $baseRepo;

    public function __construct($baseRepo = null)
    {
        parent::__construct($baseRepo);
    }
}