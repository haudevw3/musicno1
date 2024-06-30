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

    protected function parseData(array $data)
    {
        return [
            'name' => trim($data['name']),
            'slug' => trim($data['slug']),
            'image' => trim($data['image']),
            'tags' => ! empty($data['tags']) ? implode(',', $data['tags']) : null,
            'biography' => ! empty($data['biography']) ? implode(',', $data['biography']) : null,
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

    public function listArtist(array $columns = [], array $conditions = [], array $sorted = [], $perPage = 10)
    {
        return $this->baseRepo->list($columns, $conditions, $sorted, $perPage);
    }
}