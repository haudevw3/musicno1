<?php

namespace Modules\Playlist\Service\Impl;

use Core\Service\BaseServiceImpl;
use Modules\Playlist\Repository\PlaylistRepository;
use Modules\Playlist\Service\PlaylistService;
use Foundation\Support\Str;

class PlaylistServiceImpl extends BaseServiceImpl implements PlaylistService
{
    protected $baseRepo;

    public function __construct(PlaylistRepository $baseRepo)
    {
        parent::__construct($baseRepo);
    }

    public function create(array $data)
    {
        $attributes = [
            '_id' => Str::random(22),
            'name' => filterName($data['name']),
            'slug' => filterStr($data['slug']),
            'image' => trim($data['image']),
            'album_ids' => trim($data['album_ids']),
            'priority' => $data['priority'],
            'description' => filterStr($data['description']),
        ];
        return $this->baseRepo->create($attributes);
    }

    public function updateOne($id, array $data)
    {
        $attributes = [];
        $playlist = $this->baseRepo->findOne(['id' => $id]);

        if (array_key_exists('name', $data) &&
           ($playlist['name'] != $data['name'])) {
            $attributes['name'] = filterName($data['name']);
            $attributes['slug'] = filterStr($data['slug']);
        }

        if (array_key_exists('image', $data) &&
           ($playlist['image'] != $data['image'])) {
            $attributes['image'] = trim($data['image']);
        }

        if (array_key_exists('priority', $data) &&
           ($playlist['priority'] != $data['priority'])) {
            $attributes['priority'] = $data['priority'];
        }

        if (array_key_exists('album_ids', $data) &&
           ($playlist['album_ids'] != $data['album_ids'])) {
            $attributes['album_ids'] = trim($data['album_ids']);
        }

        if (array_key_exists('description', $data) &&
           ($playlist['description'] != $data['description'])) {
            $attributes['description'] = filterStr($data['description']);
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
}