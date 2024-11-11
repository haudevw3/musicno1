<?php

namespace Modules\Page\Repository;

use Core\Repository\BaseRepository;
use Modules\Page\Repository\Contracts\PageRepository as PageRepositoryContract;

class PageRepository extends BaseRepository implements PageRepositoryContract
{
    /**
     * The model name.
     *
     * @return string
     */
    public function getModel()
    {
        //
    }
}