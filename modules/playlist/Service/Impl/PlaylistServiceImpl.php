<?php

namespace Modules\Playlist\Service\Impl;

use Core\Service\BaseServiceImpl;
use Modules\Album\Service\AlbumService;
use Modules\Artist\Service\ArtistService;
use Modules\Playlist\Repository\PlaylistRepository;
use Modules\Playlist\Service\PlaylistService;
use Modules\Song\Service\SongService;

class PlaylistServiceImpl extends BaseServiceImpl implements PlaylistService
{
    protected $baseRepo;
    protected $artistService;
    protected $albumService;
    protected $songService;

    public function __construct(PlaylistRepository $baseRepo, ArtistService $artistService,
                                AlbumService $albumService, SongService $songService)
    {
        parent::__construct($baseRepo);
        $this->artistService = $artistService;
        $this->albumService = $albumService;
        $this->songService = $songService;
    }

    public function create(array $data)
    {
        $attributes = [
            'playlist_id' => $data['playlist_id'],
            'name' => ucwords(trim($data['name'])),
            'slug' => trim($data['slug']),
            'image' => $data['image'],
            'tags' => $data['tags'],
            'priority' => $data['priority'],
            'description' => ! empty($data['description']) ? trim($data['description']) : null,
        ];
        return $this->baseRepo->create($attributes);
    }

    public function updateOne($id, array $data)
    {
        $attributes = [];
        $playlist = $this->baseRepo->findOne(['id' => $id]);

        if (array_key_exists('name', $data) &&
            $playlist['name'] !== ($data['name'] = ucwords(trim($data['name'])))) {

            $attributes['name'] = $data['name'];
            $attributes['slug'] = trim($data['slug']);
        }

        if (array_key_exists('image', $data) &&
            $playlist['image'] !== $data['image']) {

            $attributes['image'] = $data['image'];
        }

        if (array_key_exists('tags', $data) &&
            $playlist['tags'] !== $data['tags']) {

            $attributes['tags'] = $data['tags'];
        }

        if (array_key_exists('priority', $data) &&
            $playlist['priority'] !== $data['priority']) {

            $attributes['priority'] = $data['priority'];
        }

        if (array_key_exists('album_ids', $data) &&
            $playlist['album_ids'] !== $data['album_ids']) {

            $attributes['album_ids'] = $data['album_ids'];
        }

        if (! empty($data['description'])) {
            $attributes['description'] = $data['description'];
        }

        if (empty($attributes)) {
            return;
        }

        return $this->baseRepo->updateOne($id, $attributes);
    }

    public function deleteOne($id)
    {
        return $this->baseRepo->deleteOne($id);
    }

    public function getListAlbumAndSongById(array $condition, array $columns = [], $justNeedSong = false)
    {
        $columns =  array_key_exists('album_ids', $columns) ? $columns : array_merge($columns, ['album_ids']);
        $playlist = $this->baseRepo->findOne([array_keys($condition)[0] => array_values($condition)[0]], $columns);
        if (is_null($playlist['album_ids'])) {
            return null;
        }
        $songs = [];
        $duration = 0;
        $albumIds = explode(',', $playlist['album_ids']);
        foreach ($albumIds as $albumId) {
            $album = $this->albumService->findOne(['id' => $albumId], ['album_id', 'name', 'type', 'song_ids']);
            $songIds = explode(',', $album['song_ids']);
            $song = $this->songService->findOne(['id' => $songIds[0]], ['name', 'image', 'audio', 'duration', 'artist_ids']);
            $artistIds = explode(',', $song['artist_ids']);
            foreach ($artistIds as $artistId) {
                $song['artists'][] = $this->artistService->findOne(['id' => $artistId], ['artist_id', 'name']);
            }
            if ($justNeedSong) {
                unset($song['artist_ids']);
            } else {
                $song['album'] = $album;
                $duration += convertToDuration($song['duration']);
            }
            $songs[] = $song;
        }
        if ($justNeedSong) {
            return $songs;
        }
        $playlist['total'] = count($songs);
        $playlist['duration'] = convertSecondsToTime($duration);
        $playlist['songs'] = $songs;
        return $playlist;
    }
}