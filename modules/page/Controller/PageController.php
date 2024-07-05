<?php

namespace Modules\Page\Controller;

use Modules\Artist\Service\ArtistService;
use Modules\Categories\Service\CategoriesService;
use Modules\Song\Service\SongService;

class PageController
{
    protected $categoriesService;
    protected $artistService;
    protected $songService;

    public function __construct(CategoriesService $categoriesService, ArtistService $artistService, SongService $songService)
    {
        $this->categoriesService = $categoriesService;
        $this->artistService = $artistService;
        $this->songService = $songService;
    }

    public function index()
    {
        $data = $this->renderData();
        return view('page.viewHome', $data);
    }

    public function home()
    {
        $data = $this->renderData();
        return view('page.viewHome', $data);
    }
    
    protected function renderData()
    {
        $categories = $this->categoriesService->findAll(['id', 'name', 'image', 'slug', 'tags'], [], ['sorted' => ['priority' => 'desc']]);
        $result = [];
        $result['music_style_01'] = $categories[0];
        $result['music_style_02'] = $categories[1];
        $result['music_style_03'] = [];
        foreach ($categories as $category) {
            $tags = ! is_null($category['tags']) ? explode(',', $category['tags']) : [];
            if (in_array($result['music_style_01']['id'], $tags)) {
                $result['music_style_01']['tags'][] = $category;
            }
            if (! empty($tags)) {
                foreach ($tags as $key) {
                    $result['music_style_03'][$key][] = $category;
                }
            }
        }
        $artists = $this->artistService->findAll(['id', 'name']);
        $songs = $this->songService->findAll(['id', 'name', 'artist_id', 'composer', 'image', 'audio', 'slug', 'duration', 'tags']);
        foreach ($songs as $song) {
            $tags = ! is_null($song['tags']) ? explode(',', $song['tags']) : [];
            if (in_array($result['music_style_02']['id'], $tags)) {
                foreach ($artists as $artist) {
                    if ($song['artist_id'] == $artist['id']) {
                        $song['artist_name'] = $artist['name'];
                    }
                }
                $result['music_style_02']['tags'][] = $song;
            };
        }
        unset($categories[0], $categories[1]);
        $temp = [];
        foreach ($result['music_style_03'] as $id => $values) {
            foreach ($categories as $key => $category) {
                if ($id == $category['id']) {
                    $category['tags'] = $values;
                    $temp[] = $category;
                }
            }
        }
        $result['music_style_03'] = $temp;
        return [
            'musicStyle01' => $result['music_style_01'],
            'musicStyle02' => $result['music_style_02'],
            'musicStyle03' => $result['music_style_03'],
        ];
    }
}