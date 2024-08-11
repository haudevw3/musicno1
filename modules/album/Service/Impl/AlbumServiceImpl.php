<?php

namespace Modules\Album\Service\Impl;

use Core\Service\BaseServiceImpl;
use Modules\Album\Repository\AlbumRepository;
use Modules\Album\Service\AlbumService;

class AlbumServiceImpl extends BaseServiceImpl implements AlbumService
{
    protected $baseRepo;

    public function __construct(AlbumRepository $baseRepo)
    {
        parent::__construct($baseRepo);
    }

    public function create(array $data)
    {
        $attributes = [
            'album_id' => $data['album_id'],
            'artist_id' => $data['artist_id'],
            'name' => ucwords(trim($data['name'])),
            'slug' => trim($data['slug']),
            'type' => $data['type'],
            'image' => $data['image'],
            'description' => ! empty($data['description']) ? trim($data['description']) : null,
        ];
        return $this->baseRepo->create($attributes);
    }

    public function updateOne($id, array $data)
    {
        $attributes = [];
        $album = $this->baseRepo->findOne(['id' => $id]);
        if (array_key_exists('name', $data) && $album['name'] !== ucwords(trim($data['name']))) {
            $attributes['name'] = $data['name'];
            $attributes['slug'] = $data['slug'];
        }
        if (array_key_exists('type', $data) && $album['type'] !== $data['type']) {
            $attributes['type'] = $data['type'];
        }
        if (array_key_exists('image', $data) && $album['image'] !== $data['image']) {
            $attributes['image'] = $data['image'];
        }
        if (! empty($data['description'])) {
            $attributes['description'] = $data['description'];
        }
        if (array_key_exists('song_ids', $data) && $album['song_ids'] !== $data['song_ids']) {
            $attributes['song_ids'] = $data['song_ids'];
        }
        if (array_key_exists('song_id', $data)) {
            $songIds = null;
            if (is_null($album['song_ids'])) {
                $songIds = $data['song_id'];
            } else {
                $songIds = $album['song_ids'].','.$data['song_id'];
            }
            $attributes['song_ids'] = $songIds;
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

    public function listAlbum(array $columns = [], array $conditions = [], array $sorted = ['created_at' => 'desc'], $perPage = 10)
    {
        return $this->baseRepo->list($columns, $conditions, $sorted, $perPage);
    }

    public function getListSongByAlbumId($id, array $columns = [])
    {
        // $songs = [];
        // $songIds = $this->albumSongService->findAll(['song_id'], ['album_id' => $id]);
        // foreach ($songIds as $songId) {
        //     $song = $this->songService->findOne(['id' => $songId['song_id']], $columns);
        //     $song['album_id'] = $id;
        //     $songs[] = $song;
        // }
        // echo '<pre>';
        // print_r($songs);
        // echo '</pre>';
        // foreach ($songs as $key => $song) {
        //     $artists = [];
        //     $artistIds = $this->artistAlbumService->findAll(['artist_id'], ['album_id' => $song['album_id']]);
        //     foreach ($artistIds as $artistId) {
        //         $artists[] = $this->artistService->findOne(['id' => $artistId['artist_id']], ['artist_id', 'name']);
        //     }
        //     $song['artists'] = $artists;
        //     $songs[$key] = $song;
        // }
        // return $songs;
    }
}