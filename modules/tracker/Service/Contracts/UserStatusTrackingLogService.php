<?php

namespace Modules\Tracker\Service\Contracts;

interface UserStatusTrackingLogService
{
    /**
     * @param  array  $data
     * @return \Core\Http\ResponseBag
     */
    public function create(array $data);

    /**
     * @param  string   $id
     * @param  array    $data
     * @return \Core\Http\ResponseBag
     */
    public function updateOne(string $id, array $data);

    /**
     * @param  string  $id
     * @return \Core\Http\ResponseBag
     */
    public function deleteOne(string $id);
}