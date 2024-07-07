<?php

namespace Modules\Page\Controller;

use Foundation\Http\Request;
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
        return view('page.viewHome');
    }

    public function loadDataPage(Request $request)
    {
        $alias = $request->input('alias');
        return response()->json($this->filterDataForPage($alias));
    }

    protected function filterDataForPage($alias)
    {
        $result = [];
        $categories = [];
        $parents = [];
        $subs = [];
        $columnsCategories = ['id', 'name', 'image', 'slug', 'tags', 'views'];
        $columnsSong = ['id', 'name', 'artist_id', 'composer', 'image', 'audio', 'slug', 'duration', 'tags'];
        $songs = $this->songService->findAll($columnsSong);
        if ($alias == 'home') {
            $options = ['sorted' => ['priority' => 'desc']];
            $categories = $this->categoriesService->findAll($columnsCategories, [], $options);
            foreach ($categories as $key => $category) {
                if (is_null($category['tags'])) {
                    $parents[] = $category;
                } else {
                    $category['tags'] = explode(',', $category['tags']);
                    $subs[] = $category;
                }
            }

            $result['style_01'] = $parents[0];
            $result['style_02'] = $parents[1];
            unset($parents[0], $parents[1]);
            foreach ($subs as $sub) {
                if (in_array($result['style_01']['id'], $sub['tags'])) {
                    $result['style_01']['tags'][] = $sub;
                }
            }

            foreach ($songs as $song) {
                $tags = is_null($song['tags']) ? [] : explode(',', $song['tags']);
                if (in_array($result['style_02']['id'], $tags)) {
                    $song['artist_name'] = $this->artistService->findOne(['id' => $song['artist_id']])['name'];
                    $result['style_02']['tags'][] = $song;
                };
            }

            foreach ($parents as $parent) {
                if ($this->isViewHome($parent['views'])) {
                    foreach ($subs as $sub) {
                        if (in_array($parent['id'], $sub['tags'])) {
                            $parent['tags'][] = $sub;
                        }
                    }
                    $result['style_03'][] = $parent;
                }
            }
        }

        return $result;
    }

    protected function isViewHome($views)
    {
        $views = explode(',', $views);
        return in_array(1, $views);
    }
}