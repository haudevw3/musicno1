<?php

namespace Modules\Page\Controller;

use Foundation\Http\Request;
use Modules\Album\Service\AlbumService;
use Modules\Artist\Service\ArtistService;
use Modules\Categories\Service\CategoriesService;
use Modules\Playlist\Service\PlaylistService;
use Modules\Song\Service\SongService;

class PageController
{
    protected $categoriesService;
    protected $playlistService;
    protected $artistService;
    protected $albumService;
    protected $songService;

    public function __construct(CategoriesService $categoriesService, PlaylistService $playlistService,
                                ArtistService $artistService, AlbumService $albumService, SongService $songService)
    {
        $this->categoriesService = $categoriesService;
        $this->playlistService = $playlistService;
        $this->artistService = $artistService;
        $this->albumService = $albumService;
        $this->songService = $songService;
    }

    public function home()
    {
        $playlists = $this->playlistService->getListByTags([2], ['playlist_id', 'name', 'image']);
        $songs = $this->songService->getListSongByTags([2], ['song_id', 'artist_ids', 'name', 'image']);
        $categories = $this->categoriesService->getPlaylistOfCategoryByTags([1], ['playlist_id', 'name', 'image']);
        $data = [
            0 => $playlists,
            1 => [
                'id' => 'Rk8dOsoNG0I5OhLhE9YlaQ',
                'name' => 'Bài hát nổi bật',
                'songs' => $songs
            ],
            2 => $categories,
        ];
        return view('page.viewHome', $data);
    }

    public function dashboard()
    {
        return redirect()->route('home');
    }

    public function page(Request $request)
    {
        $data = [];
        $slug = $request->input('slug');
        $category = $this->categoriesService->findOne(['slug' => $slug]);
        if ($slug == 'top-100' || $slug == 'chill') {
            $data = [
                'show_all' => false,
                'remove_margin' => 0,
                2 => $this->categoriesService->getPlaylistOfSubCategoryByParentId($category['id'], ['playlist_id', 'name', 'image']),
            ];
            return view('page.viewShowPlaylist', compact('data'));
        }
    }
}