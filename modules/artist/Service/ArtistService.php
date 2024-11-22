<?php

namespace Modules\Artist\Service;

use Core\Http\Response;
use Core\Service\BaseService;
use Modules\Artist\Repository\Contracts\ArtistRepository;
use Modules\Artist\Service\Contracts\ArtistService as ArtistServiceContract;

class ArtistService extends BaseService implements ArtistServiceContract
{
    protected $baseRepo;

    /**
     * @param  \Modules\Artist\Repository\Contracts\ArtistRepository  $baseRepo
     * @return void
     */
    public function __construct(ArtistRepository $baseRepo)
    {
        parent::__construct($baseRepo);
    }

    /**
     * @param  array  $data
     * @return \Modules\Artist\Models\Artist
     */
    public function create(array $data)
    {
        $attributes = [
            'id' => str_random(),
            'name' => str_ucwords(isset_if($data['name'], 'trim')),
            'slug' => isset_if($data['slug'], 'trim'),
            'image' => isset_if($data['image'], 'trim'),
            'created_at' => date_at(),
            'updated_at' => date_at(),
        ];

        return $this->baseRepo->create($attributes);
    }

    /**
     * @param  string  $id
     * @param  array   $data
     * @return \Core\Http\Response
     */
    public function updateOne(string $id, array $data)
    {
        $response = Response::create();

        $artist = $this->baseRepo->findOne($id);

        if (is_null($artist)) {
            $response->errors = config('artist.label.NOT_FOUND_ARTIST');
        }
        
        else {
            $this->baseRepo->updateOne(
                $id, $this->filterData($data)
            );

            $response->setStatus(200)->setData([
                'success' => config('artist.label.UPDATE_SUCCESS')
            ]);
        }

        return $response;
    }

    /**
     * Filter with the given data to update.
     *
     * @param  array  $data
     * @return array
     */
    protected function filterData(array $data)
    {
        $attributes['updated_at'] = date_at();

        foreach ($data as $key => $value) {
            if ($key == 'name') {
                $attributes[$key] = str_ucwords(trim($value));
            } elseif (in_array($key, ['slug', 'image'])) {
                $attributes[$key] = trim($value);
            }
        }

        return $attributes;
    }

    /**
     * @param  string  $id
     * @return \Core\Http\Response
     */
    public function deleteOne(string $id)
    {
        $response = Response::create();

        $artist = $this->baseRepo->findOne($id);

        if (is_null($artist)) {
            $response->errors = config('artist.label.NOT_FOUND_ARTIST');
        }

        else {
            $this->baseRepo->deleteOne($id);

            $response->setStatus(200)->setData([
                'success' => config('artist.label.DELETE_SUCCESS')
            ]);
        }

        return $response;
    }
}