<?php

namespace Modules\Categories\Service\Impl;

use Core\Service\BaseServiceImpl;
use Modules\Categories\Repository\CategoryArtistRepository;
use Modules\Categories\Service\CategoryArtistService;

class CategoryArtistServiceImpl extends BaseServiceImpl implements CategoryArtistService
{
    protected $baseRepo;

    public function __construct(CategoryArtistRepository $baseRepo)
    {
        parent::__construct($baseRepo);
    }

    public function create(array $data)
    {
        return $this->baseRepo->create($data);
    }

    public function updateOne($categoryId, array $artistIds)
    {
        
    }

    public function deleteOne($id)
    {
        return $this->baseRepo->deleteOne($id);
    }
}