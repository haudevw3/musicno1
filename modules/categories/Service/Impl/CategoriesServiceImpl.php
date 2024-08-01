<?php

namespace Modules\Categories\Service\Impl;

use Core\Service\BaseServiceImpl;
use Modules\Categories\Repository\CategoriesRepository;
use Modules\Categories\Service\CategoriesService;
use Modules\Categories\Service\CategoryPlaylistService;
use Modules\Playlist\Service\PlaylistService;

class CategoriesServiceImpl extends BaseServiceImpl implements CategoriesService
{
    protected $baseRepo;
    protected $categoryPlaylistService;
    protected $playlistService;

    public function __construct(CategoriesRepository $baseRepo, CategoryPlaylistService $categoryPlaylistService, PlaylistService $playlistService)
    {
        parent::__construct($baseRepo);
        $this->categoryPlaylistService = $categoryPlaylistService;
        $this->playlistService = $playlistService;
    }

    public function create(array $data)
    {
        $attributes = [
            'category_id' => $data['category_id'],
            'name' => ucwords(trim($data['name'])),
            'slug' => trim($data['slug']),
            'priority' => $data['priority'],
            'parent_id' => isset($data['parent_id']) ? $data['parent_id'] : 0,
        ];
        return $this->baseRepo->create($attributes);
    }

    public function updateOne($id, array $data)
    {
        $attributes = [];
        $category = $this->baseRepo->findOne(['id' => $id]);
        if (array_key_exists('name', $data) && $category['name'] !== ucwords(trim($data['name']))) {
            $attributes['name'] = $data['name'];
            $attributes['slug'] = trim($data['slug']);
        }
        if (array_key_exists('priority', $data) && $category['priority'] !== $data['priority']) {
            $attributes['priority'] = $data['priority'];
        }
        if (array_key_exists('parent_id', $data) && $category['parent_id'] !== $data['parent_id']) {
            $attributes['parent_id'] = $data['parent_id'];
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

    public function listCategories(array $columns = [], array $conditions = [], array $sorted = ['created_at' => 'desc'], $perPage = 10)
    {
        return $this->baseRepo->list($columns, $conditions, $sorted, $perPage);
    }

    public function getPlaylistByCategoryId($id, array $columns = []) {
        $playlists = [];
        $categoryPlaylists = $this->categoryPlaylistService->findAll(['playlist_id'], ['category_id' => $id]);
        if (is_null($categoryPlaylists)) {
            return;
        }
        foreach ($categoryPlaylists as $categoryPlaylist) {
            $playlist = $this->playlistService->findOne(['id' => $categoryPlaylist['playlist_id']], $columns);
            $playlists[] = $playlist;
        }
        if (count($playlists) == 1) {
            $playlists = $playlists[0];
        }
        return $playlists;
    }

    public function getTreeCategories(array $columns = [], array $condition = [])
    {
        $columns = array_merge($columns, ['parent_id']);
        $categories = $this->baseRepo->findAll($columns);
        $treeCategories = $this->treeCategories(0, $categories);
        if (empty($condition)) {
            return $treeCategories;
        }
        foreach ($treeCategories as $category) {
            if (array_values($condition)[0] === $category[array_keys($condition)[0]]) {
                $treeCategories = $category;
            }
        }
        return $treeCategories;
    }

    protected function treeCategories($parentId = 0, array $categories = [])
    {
        $result = [];
        foreach ($categories as $category) {
            if ($category['parent_id'] == $parentId) {
                $subs = $this->treeCategories($category['id'], $categories);
                if (! empty($subs)) {
                    $category['subs'] = $subs;
                }
                $result[] = $category;
            }
        }
        return $result;
    }
}