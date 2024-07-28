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

    public function updateAll($id, array $playlistIds)
    {
        $categoryPlaylists = $this->baseRepo->findAll(['id', 'playlist_id'], ['category_id' => $id]);
        if (! empty($categoryPlaylists)) {
            foreach ($categoryPlaylists as $categoryPlaylist) {
                if (! in_array($categoryPlaylist['playlist_id'], $playlistIds)) {
                   $this->baseRepo->deleteOne($categoryPlaylist['id']);
                }
            }
        }
        foreach ($playlistIds as $playlistId) {
            $categoryPlaylist = $this->baseRepo->findOne(['and' => ['category_id' => $id, 'playlist_id' => $playlistId]]);
            if (is_null($categoryPlaylist)) {
                $this->baseRepo->create(['category_id' => $id, 'playlist_id' => $playlistId]);
            }
        }
    }

    public function deleteOne($id)
    {
        return $this->baseRepo->deleteOne($id);
    }
}