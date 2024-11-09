<?php

namespace Core\Redis\Contracts;

interface PhpRedisConnection
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
     * Flush the selected Redis database.
     *
     * @return mixed
     */
    public function flush();

    /**
     * Get connected.
     *
     * @return bool
     */
    public function connected();

    /**
     * Set a connection with the given redis name.
     *
     * @param  string|null  $name
     * @return $this
     * 
     * @throws \InvalidArgumentException
     */
    public function connection($name = null);

    /**
     * Get "Php Redis Connection" instance.
     *
     * @return \Illuminate\Redis\Connections\PhpRedisConnection|null
     */
    public function getConnection();
}