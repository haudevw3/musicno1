<?php

namespace Modules\Album\Service\Impl;

use Core\Service\BaseServiceImpl;
use Modules\Album\Repository\AlbumRepository;
use Modules\Album\Service\AlbumService;
use Foundation\Support\Str;

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
            '_id' => Str::random(22),
            'artist_id' => $data['artist_id'],
            'name' => filterName($data['name']),
            'slug' => filterStr($data['slug']),
            'type' => $data['type'],
            'release_year' => $data['release_year'],
            'image' => empty($data['image']) ? null : trim($data['image']),
            'description' => empty($data['description']) ? null : filterStr($data['description']),
        ];
        $album = tap($this->baseRepo, function ($baseRepo) use ($attributes) {
            $baseRepo->create($attributes);
        })->findOne(['_id' => $attributes['_id']]);
        return $album;
    }

    public function updateOne($id, array $data)
    {
        $attributes = [];
        $album = $this->baseRepo->findOne(['id' => $id]);

        if (array_key_exists('name', $data) &&
           ($album['name'] != $data['name'])) {
            $attributes['name'] = filterName($data['name']);
            $attributes['slug'] = filterStr($data['slug']);
        }

        if (array_key_exists('image', $data) &&
           ($album['image'] != $data['image'])) {
            $attributes['image'] = trim($data['image']);
        }

        if (array_key_exists('type', $data) &&
           ($album['type'] != $data['type'])) {
            $attributes['type'] = $data['type'];
        }

        if (array_key_exists('release_year', $data) &&
           ($album['release_year'] != $data['release_year'])) {
            $attributes['release_year'] = $data['release_year'];
        }

        if (array_key_exists('description', $data) &&
           ($album['description'] != $data['description'])) {
            $attributes['description'] = filterStr($data['description']);
        }

        if (array_key_exists('song_id', $data)) {
            if (is_null($album['song_ids'])) {
                $attributes['song_ids'] = $data['song_id'];
            } else {
                $attributes['song_ids'] = $album['song_ids'].','.$data['song_id'];
            }
        }

        if (empty($attributes)) {
            return;
        }

        return $this->baseRepo->updateOne($id, $attributes);
    }

    public function deleteOne($id)
    {
        $album = null;
        tap($this->baseRepo, function ($baseRepo) use (&$album, $id) {
            $album = $baseRepo->findOne(['id' => $id]);
        })->deleteOne($id);
        return $album;
    }
}