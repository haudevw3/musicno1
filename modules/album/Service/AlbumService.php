<?php

namespace Modules\Album\Service;

use Core\Http\Response;
use Core\Service\BaseService;
use Modules\Album\Repository\Contracts\AlbumRepository;
use Modules\Album\Service\Contracts\AlbumService as AlbumServiceContract;

class AlbumService extends BaseService implements AlbumServiceContract
{
    protected $baseRepo;

    /**
     * @param  \Modules\Album\Repository\Contracts\AlbumRepository  $baseRepo
     * @return void
     */
    public function __construct(AlbumRepository $baseRepo)
    {
        parent::__construct($baseRepo);
    }

     /**
     * @param  array  $data
     * @return \Core\Http\Response
     */
    public function create(array $data)
    {
        $attributes = [
            'id' => str_random(),
            'name' => str_ucwords(isset_if($data['name'], 'trim')),
            'slug' => isset_if($data['slug'], 'trim'),
            'images' => isset_if($data['images']),
            'artists' => isset_if($data['artists']),
            'release_year' => isset_if($data['release_year'], 'intval', 2000),
            'album_type' => isset_if($data['album_type'], 'trim', 'single'),
            'type' => 'album',
            'created_at' => date_at(),
            'updated_at' => date_at(),
        ];

        $album = $this->baseRepo->create($attributes);

        $response = Response::create()->setStatus(200)->setData([
            'album' => $album,
            'success' => config('album.label.CREATE_SUCCESS'),
        ]);
        
        return $response;
    }

    /**
     * @param  string  $id
     * @param  array   $data
     * @return \Core\Http\Response
     */
    public function updateOne(string $id, array $data)
    {

    }

    /**
     * @param  string  $id
     * @return \Core\Http\Response
     */
    public function deleteOne(string $id)
    {
        $response = Response::create();

        $album = $this->baseRepo->findOne($id);

        if (is_null($album)) {
            $response->errors = config('album.label.NOT_FOUND_ALBUM');
        }

        else {
            $this->baseRepo->deleteOne($id);

            $response->setStatus(200)->setData([
                'success' => config('album.label.DELETE_SUCCESS')
            ]);
        }

        return $response;
    }
}