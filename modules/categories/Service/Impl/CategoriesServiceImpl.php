<?php

namespace Modules\Categories\Service\Impl;

use Core\Service\BaseServiceImpl;
use Modules\Categories\Repository\CategoriesRepository;
use Modules\Categories\Service\CategoriesService;
use Modules\Playlist\Repository\PlaylistRepository;

class CategoriesServiceImpl extends BaseServiceImpl implements CategoriesService
{
    protected $baseRepo;
    protected $playlistRepo;

    public function __construct(CategoriesRepository $baseRepo, PlaylistRepository $playlistRepo)
    {
        parent::__construct($baseRepo);
        $this->playlistRepo = $playlistRepo;
    }

    public function create(array $data)
    {
        $attributes = [
            'category_id' => $data['category_id'],
            'name' => ucwords(trim($data['name'])),
            'slug' => trim($data['slug']),
            'image' => $data['image'],
            'tags' => $data['tags'],
            'priority' => $data['priority'],
            'parent_id' => isset($data['parent_id']) ? $data['parent_id'] : 0,
        ];
        return $this->baseRepo->create($attributes);
    }

    public function updateOne($id, array $data)
    {
        $attributes = [];
        $category = $this->baseRepo->findOne(['id' => $id]);

        if (array_key_exists('name', $data) &&
            $category['name'] !== ($data['name'] = ucwords(trim($data['name'])))) {

            $attributes['name'] = $data['name'];
            $attributes['slug'] = trim($data['slug']);
        }

        if (array_key_exists('image', $data) &&
            $category['image'] !== $data['image']) {

            $attributes['image'] = $data['image'];
        }

        if (array_key_exists('tags', $data) &&
            $category['tags'] !== $data['tags']) {

            $attributes['tags'] = $data['tags'];
        }

        if (array_key_exists('priority', $data) &&
            $category['priority'] !== $data['priority']) {

            $attributes['priority'] = $data['priority'];
        }

        if (array_key_exists('parent_id', $data) &&
            $category['parent_id'] !== $data['parent_id']) {

            $attributes['parent_id'] = $data['parent_id'];
        }

        if (array_key_exists('playlist_ids', $data) &&
            $category['playlist_ids'] !== $data['playlist_ids']) {

            $attributes['playlist_ids'] = $data['playlist_ids'];
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

    public function buildTreeCategories($parentId = 0, array $categories)
    {
        $results = [];
        foreach ($categories as $category) {
            if ($category['parent_id'] == $parentId) {
                $subs = $this->buildTreeCategories($category['id'], $categories);
                if (! empty($subs)) {
                    $category['subs'] = $subs;
                }
                $results[] = $category;
            }
        }
        return $results;
    }

    public function getPlaylistOfCategoryByTags(array $tags, array $columns = [])
    {
        $categories = $this->getListByTags([1], ['name', 'slug', 'playlist_ids'], ['priority' => 'desc']);
        foreach ($categories as $key => $category) {
            $playlistIds = explode(',', $category['playlist_ids']);
            foreach ($playlistIds as $playlistId) {
                $category['playlists'][] = $this->playlistRepo->findOne(['id' => $playlistId], $columns);
            }
            $categories[$key] = $category;
        }
        return $categories;
    }

    public function getPlaylistOfSubCategoryByParentId($id, array $columns = [])
    {
        // $featuredPlaylists = [];
        // $columns = array_key_exists('tags', $columns) ? $columns : array_merge($columns, ['tags']);
        $subCategories = $this->findAll(['name', 'playlist_ids'], ['parent_id' => $id]);
        foreach ($subCategories as $key => $subCategory) {
            $playlistIds = explode(',', $subCategory['playlist_ids']);
            foreach ($playlistIds as $id) {
                // $playlist = $this->playlistRepo->findOne(['id' => $id], $columns);
                // $tags = explode(',', $playlist['tags']);
                // if (in_array(1, $tags)) {
                //     $featuredPlaylists[] = $playlist;
                // }
                // $subCategory['playlists'][] = $playlist;
                $subCategory['playlists'][] = $this->playlistRepo->findOne(['id' => $id], $columns);
            }
            $subCategories[$key] = $subCategory;
        }
        // $results = array_merge([['name' => 'Nổi bật', 'playlists' => $featuredPlaylists]], $subCategories);
        // return $results;
        return $subCategories;
    }
}