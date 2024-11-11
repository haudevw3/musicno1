<?php

namespace Modules\FileManager\Service;

use Core\Service\BaseService;
use Modules\FileManager\Objects\FileParser;
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
            'name' => $data['name'],
            'type' => $data['type'],
            'size' => $data['size'],
            'url' => $data['url'],
            'created_at' => current_date(),
            'updated_at' => current_date(),
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