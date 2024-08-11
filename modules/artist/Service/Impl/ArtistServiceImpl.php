<?php

namespace Modules\Artist\Service\Impl;

use Core\Service\BaseServiceImpl;
use Modules\Artist\Repository\ArtistRepository;
use Modules\Artist\Service\ArtistService;

class ArtistServiceImpl extends BaseServiceImpl implements ArtistService
{
    protected $baseRepo;

    public function __construct(ArtistRepository $baseRepo)
    {
        parent::__construct($baseRepo);
    }

    public function create(array $data)
    {
        $attributes = [
            'artist_id' => $data['artist_id'],
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
        $artist = $this->baseRepo->findOne(['id' => $id]);
        if (array_key_exists('name', $data) && $artist['name'] !== ucwords(trim($data['name']))) {
            $attributes['name'] = $data['name'];
            $attributes['slug'] = trim($data['slug']);
        }
        if (array_key_exists('image', $data) && $artist['image'] !== $data['image']) {
            $attributes['image'] = $data['image'];
        }
        if (array_key_exists('description', $data)) {
            $attributes['description'] = $data['description'];
        }
        if (array_key_exists('album_ids', $data) && $artist['album_ids'] !== $data['album_ids']) {
            $attributes['album_ids'] = $data['album_ids'];
        }
        if (array_key_exists('album_id', $data)) {
            $albumIds = null;
            if (is_null($artist['album_ids'])) {
                $albumIds = $data['album_id'];
            } else {
                $albumIds = $artist['album_ids'].','.$data['album_id'];
            }
            $attributes['album_ids'] = $albumIds;
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
            $this->baseRepo->delete([$column => $value], $forever);
        }
    }

    public function listArtist(array $columns = [], array $conditions = [], array $sorted = ['created_at' => 'desc'], $perPage = 10)
    {
        return $this->baseRepo->list($columns, $conditions, $sorted, $perPage);
    }
}