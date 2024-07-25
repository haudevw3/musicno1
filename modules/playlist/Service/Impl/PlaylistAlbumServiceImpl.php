<?php

namespace Modules\Playlist\Service\Impl;

use Core\Service\BaseServiceImpl;
use Modules\Playlist\Repository\PlaylistAlbumRepository;
use Modules\Playlist\Service\PlaylistAlbumService;

class PlaylistAlbumServiceImpl extends BaseServiceImpl implements PlaylistAlbumService
{
    protected $baseRepo;

    public function __construct(PlaylistAlbumRepository $baseRepo)
    {
        parent::__construct($baseRepo);
    }

    public function create(array $data)
    {
        return $this->baseRepo->create($data);
    }

    public function updateAll($playlistId, array $albumIds)
    {
        $playlistAlbums = $this->baseRepo->findAll(['id', 'playlist_id', 'album_id'], ['playlist_id' => $playlistId]);
        foreach ($playlistAlbums as $playlistAlbum) {
            if (! in_array($playlistAlbum['album_id'], $albumIds)) {
               $this->baseRepo->deleteOne($playlistAlbum['id']);
            }
        }
        foreach ($albumIds as $albumId) {
            $playlistAlbum = $this->baseRepo->findOne(['and' => ['playlist_id' => $playlistId, 'album_id' => $albumId]]);
            if (is_null($playlistAlbum)) {
                $this->baseRepo->create(['playlist_id' => $playlistId, 'album_id' => $albumId]);
            }
        }
    }

    public function deleteOne($id)
    {
        return $this->baseRepo->deleteOne($id);
    }
}