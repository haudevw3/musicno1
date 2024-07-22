<?php

namespace Modules\Song\Service\Impl;

use Core\Service\BaseServiceImpl;
use Modules\Song\Repository\SongRepository;
use Modules\Song\Service\SongService;

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
            'song_id' => $data['song_id'],
            'name' => ucwords(trim($data['name'])),
            'slug' => trim($data['slug']),
            'audio' => trim($data['audio']),
            'image' => trim($data['image']),
            'duration' => trim($data['duration']),
            'artist_names' => implode(', ', $data['artist_names'])
        ];
        return $this->baseRepo->create($attributes);
    }

    public function updateOne($id, array $data)
    {
        $attributes = [];
        $song = $this->baseRepo->findOne(['id' => $id]);
        if (array_key_exists('name', $data) && $song['name'] !== $data['name']) {
            $attributes['name'] = $data['name'];
        }
        if (array_key_exists('image', $data) && $song['image'] !== $data['image']) {
            $attributes['image'] = $data['image'];
        }
        if (array_key_exists('audio', $data) && $song['audio'] !== $data['audio']) {
            $attributes['audio'] = $data['audio'];
            $attributes['duration'] = $data['duration'];
        }
        if (array_key_exists('artist_names', $data) && $song['artist_names'] !== ($artistNames = implode(', ', $data['artist_names']))) {
            $attributes['artist_names'] = $artistNames;
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

    public function listSong(array $columns = [], array $conditions = [], array $sorted = ['created_at' => 'desc'], $perPage = 10)
    {
        return $this->baseRepo->list($columns, $conditions, $sorted, $perPage);
    }
}