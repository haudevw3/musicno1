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

    public function updateAll($albumId, array $artistIds)
    {
        $artistAlbums = $this->baseRepo->findAll(['id', 'artist_id', 'album_id'], ['album_id' => $albumId]);
        foreach ($artistAlbums as $artistAlbum) {
            if (! in_array($artistAlbum['artist_id'], $artistIds)) {
               $this->baseRepo->deleteOne($artistAlbum['id']);
            }
        }
        foreach ($artistIds as $artistId) {
            $artistAlbum = $this->baseRepo->findOne(['and' => ['artist_id' => $artistId, 'album_id' => $albumId]]);
            if (is_null($artistAlbum)) {
                $this->baseRepo->create(['artist_id' => $artistId, 'album_id' => $albumId]);
            }
        }
    }

    public function deleteOne($id)
    {
        return $this->baseRepo->deleteOne($id);
    }
}