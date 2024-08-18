<?php

namespace Modules\Song\Service\Impl;

use Core\Service\BaseServiceImpl;
use Modules\Artist\Service\ArtistService;
use Modules\Song\Repository\SongRepository;
use Modules\Song\Service\SongService;

class SongServiceImpl extends BaseServiceImpl implements SongService
{
    protected $baseRepo;
    protected $artistService;

    public function __construct(SongRepository $baseRepo, ArtistService $artistService)
    {
        parent::__construct($baseRepo);
        $this->artistService = $artistService;
    }

    public function create(array $data)
    {
        $attributes = [
            'song_id' => $data['song_id'],
            'album_id' => $data['album_id'],
            'artist_ids' => $data['artist_ids'],
            'tags' => $data['tags'],
            'name' => ucwords(trim($data['name'])),
            'slug' => trim($data['slug']),
            'audio' => trim($data['audio']),
            'image' => trim($data['image']),
            'duration' => trim($data['duration']),
        ];
        return $this->baseRepo->create($attributes);
    }

    public function updateOne($id, array $data)
    {
        $attributes = [];
        $song = $this->baseRepo->findOne(['id' => $id]);
        if (array_key_exists('name', $data) &&
            $song['name'] !== ($data['name'] = ucwords(trim($data['name'])))) {

            $attributes['name'] = $data['name'];
            $attributes['slug'] = trim($data['slug']);
        }

        if (array_key_exists('image', $data) &&
            $song['image'] !== $data['image']) {

            $attributes['image'] = $data['image'];
        }

        if (array_key_exists('audio', $data) &&
            $song['audio'] !== $data['audio']) {

            $attributes['audio'] = $data['audio'];
            $attributes['duration'] = $data['duration'];
        }

        if (array_key_exists('tags', $data) &&
            $song['tags'] !== $data['tags']) {

            $attributes['tags'] = $data['tags'];
        }

        if (array_key_exists('artist_ids', $data) &&
            $song['artist_ids'] !== $data['artist_ids']) {

            $attributes['artist_ids'] = $data['artist_ids'];
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

    public function getListSongByTags(array $tags, array $columns = [])
    {
        $columns = array_key_exists('artist_ids', $columns) ? $columns : array_merge($columns, ['artist_ids']);
        $songs = $this->getListByTags($tags, $columns);
        foreach ($songs as $key => $song) {
            $artistIds = explode(',', $song['artist_ids']);
            foreach ($artistIds as $artistId) {
                $song['artists'][] = $this->artistService->findOne(['id' => $artistId], ['artist_id', 'name']);
            }
            $songs[$key] = $song;
        }
        return $songs;
    }
}