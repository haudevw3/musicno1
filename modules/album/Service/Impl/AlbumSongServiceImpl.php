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

    public function updateAll($id, array $songIds)
    {
        $albumSongs = $this->baseRepo->findAll(['id', 'song_id'], ['album_id' => $id]);
        if (! empty($albumSongs)) {
            foreach ($albumSongs as $albumSong) {
                if (! in_array($albumSong['song_id'], $songIds)) {
                   $this->baseRepo->deleteOne($albumSong['id']);
                }
            }
        }
        foreach ($songIds as $songId) {
            $albumSong = $this->baseRepo->findOne(['and' => ['album_id' => $id, 'song_id' => $songId]]);
            if (is_null($albumSong)) {
                $this->baseRepo->create(['album_id' => $id, 'song_id' => $songId]);
            }
        }
    }

    public function deleteOne($id)
    {
        return $this->baseRepo->deleteOne($id);
    }
}