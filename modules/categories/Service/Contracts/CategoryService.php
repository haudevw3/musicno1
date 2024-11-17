<?php

namespace Modules\Categories\Service\Contracts;

interface CategoryService
{
    /**
     * @param  array  $data
     * @return \Core\Http\ResponseBag
     */
    public function create(array $data);

    /**
     * @param  string  $id
     * @param  array   $data
     * @return \Core\Http\ResponseBag
     */
    public function updateOne($id, array $data);

    /**
     * @param  string  $id
     * @return \Core\Http\ResponseBag
     */
    public function deleteOne($id);
}