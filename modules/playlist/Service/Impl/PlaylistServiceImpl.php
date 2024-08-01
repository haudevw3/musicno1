<?php

namespace Modules\Playlist\Service\Impl;

use Core\Service\BaseServiceImpl;
use Modules\Album\Service\AlbumService;
use Modules\Album\Service\AlbumSongService;
use Modules\Artist\Service\ArtistAlbumService;
use Modules\Artist\Service\ArtistService;
use Modules\Playlist\Repository\PlaylistRepository;
use Modules\Playlist\Service\PlaylistAlbumService;
use Modules\Playlist\Service\PlaylistService;
use Modules\Song\Service\SongService;

class PlaylistServiceImpl extends BaseServiceImpl implements PlaylistService
{
    protected $baseRepo;
    protected $playlistAlbumService;
    protected $artistService;
    protected $artistAlbumService;
    protected $albumService;
    protected $albumSongService;
    protected $songService;

    public function __construct(PlaylistRepository $baseRepo, PlaylistAlbumService $playlistAlbumService, ArtistService $artistService, ArtistAlbumService $artistAlbumService,
                                AlbumService $albumService, AlbumSongService $albumSongService, SongService $songService)
    {
        parent::__construct($baseRepo);
        $this->playlistAlbumService = $playlistAlbumService;
        $this->artistService = $artistService;
        $this->artistAlbumService = $artistAlbumService;
        $this->albumService = $albumService;
        $this->albumSongService = $albumSongService;
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
        $album = $this->baseRepo->findOne(['id' => $id]);
        if (array_key_exists('name', $data) && $album['name'] !== $data['name']) {
            $attributes['name'] = $data['name'];
            $attributes['slug'] = $data['slug'];
        }
        if (array_key_exists('image', $data['image']) && $album['image'] !== $data['image']) {
            $attributes['image'] = $data['image'];
        }
        if (! empty($data['description'])) {
            $attributes['description'] = $data['description'];
        }
        if (empty($attributes)) {
            return;
        }
        return $this->baseRepo->updateOne($id, $data);
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
        $albumIds = $this->playlistAlbumService->findAll(['album_id'], ['playlist_id' => $id]);
        $songs = [];
        foreach ($albumIds as $albumId) {
            $songId = $this->albumSongService->findOne(['album_id' => $albumId['album_id']])['song_id'];
            $song = $this->songService->findOne(['id' => $songId], $columns);
            $song['album_id'] = $albumId['album_id'];
            $songs[] = $song;
        }
        foreach ($songs as $key => $song) {
            $artists = [];
            $artistIds = $this->artistAlbumService->findAll(['artist_id'], ['album_id' => $song['album_id']]);
            foreach ($artistIds as $artistId) {
                $artists[] = $this->artistService->findOne(['id' => $artistId['artist_id']], ['artist_id', 'name']);
            }
            $song['artists'] = $artists;
            $songs[$key] = $song;
            $album = $this->albumService->findOne(['id' => $song['album_id']]);
            $song['album_id'] = $album['album_id'];
            $song['album_name'] = $album['name'];
            $songs[$key] = $song;
        }
        return $songs;
    }
}