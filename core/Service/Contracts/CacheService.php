<?php

namespace Core\Service\Contracts;

interface CacheService
{
    /**
     * Determine if the given key exists in the redis.
     *
     * @param  string  $key
     * @return bool
     */
    public function has($key);

    /**
     * Returns the value of the given key.
     *
     * @param  string  $key
     * @return mixed
     */
    public function get($key);

    /**
     * Set the string value in the argument as the value of the key.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @return $this
     */
    public function set($key, $value);

    /**
     * Delete the value in the redis with the given keys.
     *
     * @param  array|string  $keys
     * @return $this
     */
    public function delete($keys);

    /**
     * Push the value on the redis with the given key.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @return $this
     */
    public function push($key, $value);

    /**
     * Get connected.
     *
     * @return bool
     */
    public function connected();

    /**
     * Get "Php Redis Connection" instance.
     *
     * @return \Illuminate\Redis\Connections\PhpRedisConnection
     */
    public function connection();
}