<?php

namespace Modules\User\Service\Contracts;

interface UserService
{
    /**
     * @param  array  $data
     * @param  bool   $needSendMail
     * @return \Modules\User\Models\User
     */
    public function create(array $data, $needSendMail = false);

    /**
     * @param  string  $id
     * @param  array   $data
     * @return \Core\Http\Response
     */
    public function updateOne($id, array $data);

    /**
     * @param  string  $id
     * @return \Core\Http\Response
     */
    public function deleteOne($id);

    /**
     * @param  array  $ids
     * @return \Core\Http\Response
     */
    public function deleteMany(array $ids);

    /**
     * @param  array  $data
     * @return \Core\Http\Response
     */
    public function verifyAccount(array $data);

    /**
     * @param  string  $email
     * @return \Core\Http\Response
     */
    public function forgetPassword(string $email);

    /**
     * @param  string  $data
     * @return \Core\Http\Response
     */
    public function refreshTokenToSendMail(string $id);
}