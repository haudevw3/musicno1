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
            'name' => ucwords(trim($data['name'])),
            'slug' => trim($data['slug']),
            'type' => $data['type'],
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
        if (array_key_exists('type', $data) && $album['type'] !== $data['type']) {
            $attributes['type'] = $data['type'];
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

    public function listAlbum(array $columns = [], array $conditions = [], array $sorted = ['created_at' => 'desc'], $perPage = 10)
    {
        return $this->baseRepo->list($columns, $conditions, $sorted, $perPage);
    }
}