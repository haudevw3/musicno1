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

    public function updateOne($artistId, array $data)
    {
        $attributes = [];
        $categoryArtist = $this->baseRepo->findOne(['artist_id' => $artistId]);
        if (is_null($categoryArtist) && ! is_null($data['category_id'])) {
            $data['artist_id'] = $artistId;
            return $this->create($data);
        }
        if (is_null($data['category_id'])) {
            return $this->deleteOne($categoryArtist['id']);
        }
        if (isset($data['category_id']) && $categoryArtist['category_id'] !== $data['category_id']) {
            $attributes['category_id'] = $data['category_id'];
        }
        if (empty($attributes)) {
            return;
        }
        return $this->baseRepo->updateOne($categoryArtist['id'], $attributes);
    }

    public function deleteOne($id)
    {
        return $this->baseRepo->deleteOne($id);
    }
}