<?php

namespace Modules\Categories\Controller;

use Foundation\Http\Request;
use Modules\Artist\Service\ArtistService;
use Modules\Categories\Service\CategoriesService;
use Modules\Song\Service\SongService;

class CategoriesController
{
    protected $categoriesService;
    protected $songService;
    protected $artistService;

    public function __construct(CategoriesService $categoriesService, SongService $songService, ArtistService $artistService)
    {
        $this->categoriesService = $categoriesService;
        $this->songService = $songService;
        $this->artistService = $artistService;
    }

    public function renderDataCategory(Request $request)
    {
        $category = $this->categoriesService->findOne(['id' => $request->input('id')]);
        return response()->json($category);
    }

    public function renderDataCategoryWithListSong(Request $request)
    {
        $seconds = 0;
        $category = $this->categoriesService->findOne(['id' => $request->input('cate_id')]);
        $category['time'] = null;
        $category['songs'] = null;
        $songs = $this->songService->findAll(['id', 'name', 'artist_id', 'composer', 'image', 'audio', 'slug', 'duration', 'tags']);
        foreach ($songs as $key => $song) {
            $tags = explode(',', $song['tags']);
            if (in_array($category['id'], $tags)) {
                $song['artist_name'] = $this->artistService->findOne(['id' => $song['artist_id']])['name'];
                $category['songs'][] = $song;
                $seconds += convertToDuration($song['duration']);
            }
        }
        $category['time'] = convertSecondsToTime($seconds);
        return response()->json($category);
    }
}