<?php

namespace Modules\Artist\Service\Impl;

use Core\Service\BaseServiceImpl;
use Modules\Artist\Repository\ArtistRepository;
use Modules\Artist\Service\ArtistService;
use Foundation\Support\Str;


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
            '_id' => Str::random(22),
            'name' => filterName($data['name']),
            'slug' => filterStr($data['slug']),
            'image' => trim($data['image']),
            'description' => filterStr($data['description']),
        ];
        return $this->baseRepo->create($attributes);
    }

    public function updateOne($id, array $data)
    {
        $attributes = [];
        $artist = $this->baseRepo->findOne(['id' => $id]);

        if (array_key_exists('name', $data) &&
           ($artist['name'] != $data['name'])) {
            $attributes['name'] = filterName($data['name']);
            $attributes['slug'] = filterStr($data['slug']);
        }

        if (array_key_exists('image', $data) &&
           ($artist['image'] != $data['image'])) {
            $attributes['image'] = trim($data['image']);
        }

        if (array_key_exists('description', $data) &&
           ($artist['description'] != $data['description'])) {
            $attributes['description'] = filterStr($data['description']);
        }

        if (array_key_exists('album_id', $data)) {
            if (is_null($artist['album_ids'])) {
                $attributes['album_ids'] = $data['album_id'];
            } else {
                $attributes['album_ids'] = $artist['album_ids'].','.$data['album_id'];
            }
        }

        if (array_key_exists('delete_album_id', $data)) {
            $albumIds = explode(',', $artist['album_ids']);
            foreach ($albumIds as $key => $value) {
                if ($value == $data['delete_album_id']) {
                    unset($albumIds[$key]);
                    break;
                }
            }
            $attributes['album_ids'] = implode(',', $albumIds);
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