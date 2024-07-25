<?php

namespace Modules\Categories\Service\Impl;

use Core\Service\BaseServiceImpl;
use Modules\Categories\Repository\CategoryPlaylistRepository;
use Modules\Categories\Service\CategoryPlaylistService;

class CategoryPlaylistServiceImpl extends BaseServiceImpl implements CategoryPlaylistService
{
    protected $baseRepo;

    public function __construct(CategoryPlaylistRepository $baseRepo)
    {
        parent::__construct($baseRepo);
    }

    public function create(array $data)
    {
        return $this->baseRepo->create($data);
    }

    public function updateAll($categoryId, array $playlistIds)
    {
        $categoryPlaylists = $this->baseRepo->findAll(['id', 'playlist_id'], ['category_id' => $categoryId]);
        foreach ($categoryPlaylists as $value) {
            if (! in_array($value['playlist_id'], $playlistIds)) {
               $this->baseRepo->deleteOne($value['id']);
            }
        }
        foreach ($playlistIds as $playlistId) {
            $categoryPlaylist = $this->baseRepo->findOne(['and' => ['category_id' => $categoryId, 'playlist_id' => $playlistId]]);
            if (is_null($categoryPlaylist)) {
                $this->baseRepo->create(['category_id' => $categoryId, 'playlist_id' => $playlistId]);
            }
        }
    }

    public function deleteOne($id)
    {
        return $this->baseRepo->deleteOne($id);
    }
}