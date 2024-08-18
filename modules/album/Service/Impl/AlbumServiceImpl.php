<?php

namespace Modules\Album\Service\Impl;

use Core\Service\BaseServiceImpl;
use Modules\Album\Repository\AlbumRepository;
use Modules\Album\Service\AlbumService;
use Modules\Artist\Service\ArtistService;
use Modules\Song\Service\SongService;

class AlbumServiceImpl extends BaseServiceImpl implements AlbumService
{
    protected $baseRepo;
    protected $songService;
    protected $artistService;

    public function __construct(AlbumRepository $baseRepo, ArtistService $artistService, SongService $songService)
    {
        parent::__construct($baseRepo);
        $this->songService = $songService;
        $this->artistService = $artistService;
    }

    public function create(array $data)
    {
        $attributes = [
            'album_id' => $data['album_id'],
            'artist_id' => $data['artist_id'],
            'name' => ucwords(trim($data['name'])),
            'slug' => trim($data['slug']),
            'image' => $data['image'],
            'type' => $data['type'],
            'tags' => $data['tags'],
            'release_year' => $data['release_year'],
            'description' => ! empty($data['description']) ? trim($data['description']) : null,
        ];
        return $this->baseRepo->create($attributes);
    }

    public function updateOne($id, array $data)
    {
        $attributes = [];
        $album = $this->baseRepo->findOne(['id' => $id]);

        if (array_key_exists('name', $data) &&
            $album['name'] !== ($data['name'] = ucwords(trim($data['name'])))) {

            $attributes['name'] = $data['name'];
            $attributes['slug'] = trim($data['slug']);
        }

        if (array_key_exists('image', $data) &&
            $album['image'] !== $data['image']) {

            $attributes['image'] = $data['image'];
        }

        if (array_key_exists('song_image', $data)) {
            if (is_null($album['image'])) {
                $attributes['image'] = $data['song_image'];
            }
        }

        if (array_key_exists('type', $data) &&
            $album['type'] !== $data['type']) {

            $attributes['type'] = $data['type'];
        }

        if (array_key_exists('tags', $data) &&
            $album['tags'] !== $data['tags']) {

            $attributes['tags'] = $data['tags'];
        }

        if (array_key_exists('release_year', $data) &&
            $album['release_year'] !== $data['release_year']) {

            $attributes['release_year'] = $data['release_year'];
        }

        if (! empty($data['description'])) {
            $attributes['description'] = $data['description'];
        }

        if (array_key_exists('song_ids', $data) &&
            $album['song_ids'] !== $data['song_ids']) {

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

    public function getListSongById(array $condition, array $columns = [], $justNeedSong = false)
    {
        $columns = array_key_exists('song_ids', $columns) ? $columns : array_merge($columns, ['song_ids']);
        $album = $this->baseRepo->findOne([array_keys($condition)[0] => array_values($condition)[0]], $columns);
        $songs = $this->songService->findAll(['name', 'image', 'audio', 'duration', 'artist_ids'], ['album_id' => $album['id']]);
        $duration = 0;
        foreach ($songs as $key => $song) {
            $artistIds = explode(',', $song['artist_ids']);
            foreach ($artistIds as $artistId) {
                $song['artists'][] = $this->artistService->findOne(['id' => $artistId], ['artist_id', 'name']);
            }
            if ($justNeedSong) {
                unset($song['artist_ids']);
            } else {
                $duration += convertToDuration($song['duration']);
            }
            $songs[$key] = $song;
        }
        if ($justNeedSong) {
            return $songs;
        }
        $album['total'] = count($songs);
        $album['duration'] = convertSecondsToTime($duration);
        $album['songs'] = $songs;
        return $album;
    }
}