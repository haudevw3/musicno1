<?php

namespace Modules\Tracker\Service\Contracts;

interface UserStatusTrackingLogService
{
    /**
     * @param  array  $data
     * @return \Core\Http\Response
     */
    public function create(array $data);

    /**
     * @param  string   $id
     * @param  array    $data
     * @return \Core\Http\Response
     */
    public function updateOne(string $id, array $data);

    /**
     * @param  string  $id
     * @return \Core\Http\Response
     */
    public function deleteOne(string $id);
}