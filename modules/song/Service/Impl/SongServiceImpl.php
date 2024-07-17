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

    protected function parseData(array $data)
    {
        return [
            'name' => ucwords(trim($data['name'])),
            'slug' => trim($data['slug']),
            'audio' => trim($data['audio']),
            'duration' => trim($data['duration']),
            'artist_id' => (int) $data['artist_id'],
            'album_id' => ! empty($data['album_id']) ? (int) $data['album_id'] : null,
            'composer' => ! empty($data['composer']) ? trim($data['composer']) : null,
            'tags' => ! empty($data['tags']) ? implode(',', $data['tags']) : null,
            'image' => ! empty($data['image']) ? trim($data['image']) : null,
        ];
    }

    public function create(array $data)
    {
        return $this->baseRepo->create($this->parseData($data));
    }

    public function updateOne($id, array $data)
    {
        return $this->baseRepo->updateOne($id, $this->parseData($data));
    }

    public function deleteOne($id)
    {
        return $this->baseRepo->deleteOne($id);
    }

    public function delete(array $condition = [], $forever = false)
    {
        $column = array_keys($condition)[0];
        $values = array_values($condition)[0];
        $values = is_array($values) ? $values : [$values];
        foreach ($values as $key => $value) {
            $this->baseRepo->delete([$column => $value]);
        }
        return true;
    }

    public function listSong(array $columns = [], array $conditions = [], array $sorted = [], $perPage = 10)
    {
        return $this->baseRepo->list($columns, $conditions, $sorted, $perPage);
    }
}