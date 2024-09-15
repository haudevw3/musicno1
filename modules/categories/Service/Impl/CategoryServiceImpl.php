<?php

namespace Modules\Categories\Service\Impl;

use Core\Service\BaseServiceImpl;
use Modules\Categories\Repository\CategoryRepository;
use Modules\Categories\Service\CategoryService;
use Foundation\Support\Str;

class CategoryServiceImpl extends BaseServiceImpl implements CategoryService
{
    protected $baseRepo;
    protected $playlistRepo;

    public function __construct(CategoryRepository $baseRepo)
    {
        parent::__construct($baseRepo);
    }

    public function create(array $data)
    {
        $attributes = [
            '_id' => Str::random(22),
            'name' => filterName($data['name']),
            'slug' => filterStr($data['slug']),
            'type' => $data['type'],
            'priority' => $data['priority'],
            'parent_id' => $data['parent_id'],
            'image' => empty($data['image']) ? null : trim($data['image']),
            'pages' => empty($data['pages']) ? null : trim($data['pages']),
            'tag_ids' => empty($data['tag_ids']) ? null : trim($data['tag_ids']),
        ];
        return $this->baseRepo->create($attributes);
    }

    public function updateOne($id, array $data)
    {
        $attributes = [];
        $category = $this->baseRepo->findOne(['id' => $id]);

        if (array_key_exists('name', $data) &&
           ($category['name'] != $data['name'])) {
            $attributes['name'] = filterName($data['name']);
            $attributes['slug'] = filterStr($data['slug']);
        }

        if (array_key_exists('image', $data) &&
           ($category['image'] != $data['image'])) {
            $attributes['image'] = trim($data['image']);
        }

        if (array_key_exists('pages', $data) &&
           ($category['pages'] != $data['pages'])) {
            $attributes['pages'] = trim($data['pages']);
        }

        if (array_key_exists('type', $data) &&
           ($category['type'] != $data['type'])) {
            $attributes['type'] = $data['type'];
        }

        if (array_key_exists('priority', $data) &&
           ($category['priority'] != $data['priority'])) {
            $attributes['priority'] = $data['priority'];
        }

        if (array_key_exists('parent_id', $data) &&
           ($category['parent_id'] != $data['parent_id'])) {
            $attributes['parent_id'] = $data['parent_id'];
        }

        if (array_key_exists('tag_ids', $data) &&
           ($category['tag_ids'] != $data['tag_ids'])) {
            $attributes['tag_ids'] = trim($data['tag_ids']);
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
        // $results = [];
        // foreach ($categories as $category) {
        //     if ($category['parent_id'] == $parentId) {
        //         $subs = $this->buildTreeCategories($category['id'], $categories);
        //         if (! empty($subs)) {
        //             $category['subs'] = $subs;
        //         }
        //         $results[] = $category;
        //     }
        // }
        // return $results;
    }
}