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
            'image' => trim($data['image']),
            'description' => ! empty($data['description']) ? trim($data['description']) : null,
        ];
        return $this->baseRepo->create($attributes);
    }

    public function updateOne($id, array $data)
    {
        $attributes = [];
        $playlist = $this->baseRepo->findOne(['id' => $id]);
        if (array_key_exists('name', $data) && $playlist['name'] !== ucwords(trim($data['name']))) {
            $attributes['name'] = $data['name'];
            $attributes['slug'] = $data['slug'];
        }
        if (array_key_exists('image', $data) && $playlist['image'] !== $data['image']) {
            $attributes['image'] = $data['image'];
        }
        if (array_key_exists('album_ids', $data) && $playlist['album_ids'] !== $data['album_ids']) {
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

    public function deleteAll(array $condition = [], $forever = false)
    {
        $column = array_keys($condition)[0];
        $values = array_values($condition)[0];
        $values = is_array($values) ? $values : [$values];
        foreach ($values as $value) {
            $this->baseRepo->delete([$column => $value]);
        }
    }

    public function listPlaylist(array $columns = [], array $conditions = [], array $sorted = ['created_at' => 'desc'], $perPage = 10)
    {
        return $this->baseRepo->list($columns, $conditions, $sorted, $perPage);
    }

    public function getListSongByPlaylistId($id, array $columns = [])
    {
        // $albumIds = $this->playlistAlbumService->findAll(['album_id'], ['playlist_id' => $id]);
        // $songs = [];
        // foreach ($albumIds as $albumId) {
        //     $songId = $this->albumSongService->findOne(['album_id' => $albumId['album_id']])['song_id'];
        //     $song = $this->songService->findOne(['id' => $songId], $columns);
        //     $song['album_id'] = $albumId['album_id'];
        //     $songs[] = $song;
        // }
        // foreach ($songs as $key => $song) {
        //     $artists = [];
        //     $artistIds = $this->artistAlbumService->findAll(['artist_id'], ['album_id' => $song['album_id']]);
        //     foreach ($artistIds as $artistId) {
        //         $artists[] = $this->artistService->findOne(['id' => $artistId['artist_id']], ['artist_id', 'name']);
        //     }
        //     $song['artists'] = $artists;
        //     $songs[$key] = $song;
        //     $album = $this->albumService->findOne(['id' => $song['album_id']]);
        //     $song['album_id'] = $album['album_id'];
        //     $song['album_name'] = $album['name'];
        //     $song['album_type'] = $album['type'];
        //     $songs[$key] = $song;
        // }
        // return $songs;
    }
}