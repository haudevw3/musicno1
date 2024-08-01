<?php

namespace Modules\Page\Controller;

use Foundation\Http\Request;
use Modules\Categories\Service\CategoriesService;
use Modules\Playlist\Service\PlaylistService;

class PageController
{
    protected $categoriesService;
    protected $playlistService;

    public function __construct(CategoriesService $categoriesService, PlaylistService $playlistService)
    {
        $this->categoriesService = $categoriesService;
        $this->playlistService = $playlistService;
    }

    public function home()
    {
        $result = [];
        $categories = $this->categoriesService->getTreeCategories(['id', 'name', 'slug']);
        $result['first'] = $this->categoriesService->getPlaylistByCategoryId($categories[0]['id'], ['playlist_id', 'name', 'image']);
        $playlistId = $this->categoriesService->getPlaylistByCategoryId($categories[1]['id'], ['id'])['id'];
        $result['second'] = $this->playlistService->findOne(['id' => $playlistId], ['playlist_id', 'name']);
        $result['second']['songs'] = $this->playlistService->getListSongByPlaylistId($playlistId, ['song_id', 'name', 'duration', 'image']);
        unset($categories[0], $categories[1]);
        foreach ($categories as $key => $category) {
            $categoryId = null;
            if (isset($category['subs'])) {
                $categoryId = $category['subs'][0]['id'];
                unset($category['subs']);
            } else {
                $categoryId = $category['id'];
            }
            $category['playlists'] = $this->categoriesService->getPlaylistByCategoryId($categoryId);
            $result['third'][] = $category;
        }
        return view('page.viewHome', ['data' => $result]);
    }

    public function dashboard()
    {
        return redirect()->route('home');
    }

    public function page(Request $request)
    {
        $data = [];
        $slug = $request->input('slug');
        if ($slug == 'top-100') {
            $data['third'] = $this->top100()['subs'];
            $data['remove_margin'] = 0;
            return view('page.viewTop100', compact('data'));
        }
    }

    protected function top100()
    {
        $categories = $this->categoriesService->getTreeCategories(['id', 'name', 'slug'], ['slug' => 'top-100']);
        foreach ($categories['subs'] as $key => $category) {
            $category['playlists'] = $this->categoriesService->getPlaylistByCategoryId($category['id']);
            $categories['subs'][$key] = $category;
        }
        return $categories;
    }
}