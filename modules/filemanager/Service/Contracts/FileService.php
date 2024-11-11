<?php

namespace Modules\FileManager\Service\Contracts;

interface FileService
{
    /**
     * @param  array  $data
     * @return \Jenssegers\Mongodb\Eloquent\Model
     */
    public function create(array $data);

    /**
     * @param  \Illuminate\Http\UploadedFile[]  $files
     * @return void
     */
    public function upload(array $files);
}