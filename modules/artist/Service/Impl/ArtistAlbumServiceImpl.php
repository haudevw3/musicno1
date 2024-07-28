<?php

namespace Modules\Artist\Service\Impl;

use Core\Service\BaseServiceImpl;
use Modules\Artist\Repository\ArtistAlbumRepository;
use Modules\Artist\Service\ArtistAlbumService;

class ArtistAlbumServiceImpl extends BaseServiceImpl implements ArtistAlbumService
{
    protected $baseRepo;

    public function __construct(ArtistAlbumRepository $baseRepo)
    {
        parent::__construct($baseRepo);
    }

    public function create(array $data)
    {
        return $this->baseRepo->create($data);
    }

    public function updateAll($id, array $albumIds)
    {
        $artistAlbums = $this->baseRepo->findAll(['id', 'album_id'], ['artist_id' => $id]);
        if (! empty($artistAlbums)) {
            foreach ($artistAlbums as $artistAlbum) {
                if (! in_array($artistAlbum['album_id'], $albumIds)) {
                   $this->baseRepo->deleteOne($artistAlbum['id']);
                }
            }
        }
        foreach ($albumIds as $albumId) {
            $artistAlbum = $this->baseRepo->findOne(['and' => ['artist_id' => $id, 'album_id' => $albumId]]);
            if (is_null($artistAlbum)) {
                $this->baseRepo->create(['artist_id' => $id, 'album_id' => $albumId]);
            }
        }
    }

    public function deleteOne($id)
    {
        return $this->baseRepo->deleteOne($id);
    }
}