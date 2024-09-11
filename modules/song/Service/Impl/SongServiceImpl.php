<?php

namespace Modules\Song\Service\Impl;

use Core\Service\BaseServiceImpl;
use Modules\Song\Repository\SongRepository;
use Modules\Song\Service\SongService;
use Foundation\Support\Str;
use Modules\Song\Object\MP3;

class SongServiceImpl extends BaseServiceImpl implements SongService
{
    protected $baseRepo;

    public function __construct(SongRepository $baseRepo)
    {
        parent::__construct($baseRepo);
    }

    public function create(array $data)
    {
        $attributes = [
            '_id' => Str::random(22),
            'album_id' => $data['album_id'],
            'artist_id' => $data['artist_id'],
            'sub_artist_ids' => trim($data['sub_artist_ids']),
            'tags' => empty($data['tags']) ? null : trim($data['tags']),
            'name' => filterName($data['name']),
            'slug' => filterStr($data['slug']),
            'audio' => trim($data['audio']),
            'image' => trim($data['image']),
            'duration' => $data['duration'],
        ];
        $song = tap($this->baseRepo, function ($baseRepo) use ($attributes) {
            $baseRepo->create($attributes);
        })->findOne(['_id' => $attributes['_id']]);
        return $song;
    }

    public function updateOne($id, array $data)
    {
        $attributes = [];
        $song = $this->baseRepo->findOne(['id' => $id]);

        if (array_key_exists('name', $data) &&
           ($song['name'] != $data['name'])) {
            $attributes['name'] = filterName($data['name']);
            $attributes['slug'] = filterStr($data['slug']);
        }

        if (array_key_exists('image', $data) &&
           ($song['image'] != $data['image'])) {
            $attributes['image'] = trim($data['image']);
        }

        if (array_key_exists('audio', $data) &&
           ($song['audio'] != $data['audio'])) {
            $attributes['audio'] = trim($data['audio']);
            $duration = 0;
            $data['duration'] = tap(new MP3($attributes['audio']), function ($mp3) use (&$duration) {
                $duration = $mp3->duration();
            })->format($duration);
            $attributes['duration'] = $data['duration'];
        }

        if (array_key_exists('tags', $data) &&
           ($song['tags'] != $data['tags'])) {
            $attributes['tags'] = trim($data['tags']);
        }

        if (array_key_exists('sub_artist_ids', $data) &&
           ($song['sub_artist_ids'] != $data['sub_artist_ids'])) {
            $attributes['sub_artist_ids'] = trim($data['sub_artist_ids']);
        }

        if (empty($attributes)) {
            return;
        }

        return $this->baseRepo->updateOne($id, $attributes);
    }

    public function deleteOne($id)
    {
        $song = null;
        tap($this->baseRepo, function ($baseRepo) use (&$song, $id) {
            $song = $baseRepo->findOne(['id' => $id]);
        })->deleteOne($id);
        return $song;
    }
}