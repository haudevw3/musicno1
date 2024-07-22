<?php

namespace Modules\Album\Service\Impl;

use Core\Service\BaseServiceImpl;
use Modules\Album\Repository\AlbumSongRepository;
use Modules\Album\Service\AlbumSongService;

class AlbumSongServiceImpl extends BaseServiceImpl implements AlbumSongService
{
    protected $baseRepo;

    public function __construct(AlbumSongRepository $baseRepo)
    {
        parent::__construct($baseRepo);
    }

    public function create(array $data)
    {
        return $this->baseRepo->create($data);
    }

    public function updateAll($songId, array $albumIds)
    {
        $albumSongs = $this->baseRepo->findAll(['id', 'album_id', 'song_id'], ['song_id' => $songId]);
        foreach ($albumSongs as $albumSong) {
            if (! in_array($albumSong['album_id'], $albumIds)) {
               $this->baseRepo->deleteOne($albumSong['id']);
            }
        }
        foreach ($albumIds as $albumId) {
            $albumSong = $this->baseRepo->findOne(['and' => ['album_id' => $albumId, 'song_id' => $songId]]);
            if (is_null($albumSong)) {
                $this->baseRepo->create(['album_id' => $albumId, 'song_id' => $songId]);
            }
        }
    }

    public function deleteOne($id)
    {
        return $this->baseRepo->deleteOne($id);
    }
}