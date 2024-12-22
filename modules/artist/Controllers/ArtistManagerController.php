<?php

namespace Modules\Artist\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Artist\Request\FormCreateArtist;
use Modules\Artist\Request\FormUpdateArtist;
use Modules\Artist\Service\Contracts\ArtistService;

class ArtistManagerController extends Controller
{
    protected $artistService;

    /**
     * @param  \Modules\Artist\Service\Contracts\ArtistService  $artistService
     * @return void
     */
    public function __construct(ArtistService $artistService)
    {
        $this->artistService = $artistService;
    }

    public function pageAddArtist()
    {
        return view('artist::viewFormArtist');
    }

    public function pageEditArtist(Request $request)
    {
        $artist = $this->artistService->findOne(
            $request->route('id')
        );

        return view('artist::viewFormArtist', compact('artist'));
    }

    public function createArtistApi(FormCreateArtist $request)
    {
        $this->artistService->create($request->all());

        return response()->json(
            ['success' => config('artist.label.CREATE_SUCCESS')], 201
        );
    }

    public function updateArtistApi(FormUpdateArtist $request)
    {
        $response = $this->artistService->updateOne(
            $request->input('id'), $request->all()
        );

        return $response->withJson();
    }

    public function deleteArtistApi(Request $request)
    {
        $response = $this->artistService->deleteOne(
            $request->input('id')
        );

        return $response->withJson();
    }

    public function searchArtistApi(Request $request)
    {
        $name = str_ucwords($request->input('name'));

        $data = $this->artistService->findMany([
            'name' => ['$regex' => "/$name/"]
        ]);

        return response()->json(['data' => $data]);
    }
}