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

    public function dashboard()
    {
        return view('page.viewHome');
    }

    public function page(Request $request)
    {
        // return view('page.viewHome');
    }

    public function renderDataPage(Request $request)
    {
        $slug = $request->input('slug');
        return response()->json($this->filterDataPage($slug));
    }

    protected function filterDataPage($slug)
    {
        $result = [];
        $categories = $this->categoriesService->treeCategories(
            null, $this->categoriesService->findAll(['id', 'name', 'slug', 'parent_id', 'image'])
        );
        $songs = $this->songService->findAll(
            ['id', 'name', 'artist_id', 'composer', 'image', 'audio', 'slug', 'duration', 'tags']
        );
        foreach ($songs as $key => $song) {
            $song['artist_name'] = $this->artistService->findOne(['id' => $song['artist_id']])['name'];
            $categories[1]['songs'][] = $song;
        }
        if ($slug == 'home') {
            $result['style_01'] = $categories[0];
            $result['style_02'] = $categories[1];
            $result['style_03'] = [
                $categories[3],
                $categories[4],
            ];
            $result['style_03'][0]['subs'] = $categories[3]['subs'][0]['subs'];
        }
        if ($slug == 'top-100') {
            $result['style_03'] = $categories[3]['subs'];
        }
        return $result;
    }
}