<?php

namespace Modules\FileManager\Service;

use Core\Service\BaseService;
use Modules\FileManager\FileParser;
use Modules\FileManager\Repository\Contracts\FileRepository;
use Modules\FileManager\Service\Contracts\FileService as FileServiceContract;

class FileService extends BaseService implements FileServiceContract
{
    protected $baseRepo;

    /**
     * @param  \Modules\FileManager\Repository\Contracts\FileRepository  $baseRepo
     * @return void
     */
    public function __construct(FileRepository $baseRepo)
    {
        parent::__construct($baseRepo);
    }

    /**
     * @param  array  $data
     * @return \Jenssegers\Mongodb\Eloquent\Model
     */
    public function create(array $data)
    {
        $attributes = [
            'id' => str_random(),
            'name' => isset_if($data['name']),
            'type' => isset_if($data['type']),
            'size' => isset_if($data['size']),
            'url' => isset_if($data['url']),
            'created_at' => date_at(),
            'updated_at' => date_at(),
        ];

        return $this->baseRepo->create($attributes);
    }

    /**
     * @param  \Illuminate\Http\UploadedFile[]  $files
     * @return void
     */
    public function upload(array $files)
    {
        foreach ($files as $file) {
            $this->create(
                (new FileParser($file))->store()->toArray()
            );
        }
    }
}