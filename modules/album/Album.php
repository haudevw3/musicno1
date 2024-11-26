<?php

namespace Modules\Album;

use Modules\Album\Models\Album as Model;
use Modules\Album\Repository\Contracts\AlbumRepository;

class Album
{
    /**
     * The album model instance.
     *
     * @var \Modules\Album\Models\Album
     */
    protected $model;

    /**
     * The album repository instance.
     *
     * @var \Modules\Album\Repository\Contracts\AlbumRepository
     */
    protected $repository;

    public function __construct(Model $model, AlbumRepository $repository = null)
    {
        $this->model = $model;
        $this->repository = $repository ?? app(AlbumRepository::class);
    }
}