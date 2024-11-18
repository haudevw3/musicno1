<?php

namespace Modules\User\Objects;

class PendingClient
{
    /**
     * @var string
     */
    public $username;

    /**
     * @var string
     */
    public $password;

    /**
     * @var bool
     */
    public $remember;

    /**
     * Create a new pending user instance.
     *
     * @param  string  $username
     * @param  string  $password
     * @param  bool    $remember
     * @return void
     */
    public function __construct($username, $password, $remember)
    {
        $this->username = $username;
        $this->password = $password;
        $this->remember = $remember;
    }

    /**
     * Create a new pending user instance.
     *
     * @param  array  $credentials
     * @return $this
     */
    public static function make(array $credentials)
    {
        return new static(
            trim($credentials['username']),
            trim($credentials['password']),
            $credentials['remember'] === 'true' ? true : false
        );
    }
}