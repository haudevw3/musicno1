<?php

namespace Core\Facades;

use Core\Redis\Contracts\PhpRedisConnection;
use Illuminate\Support\Facades\Facade;

/**
 * @method static bool   has(string $key)
 * @method static mixed  get(string $key)
 * @method static bool   connected()
 * @method static mixed  flush()
 * @method static \Core\Redis\Contracts\PhpRedisConnection  set(string $key, mixed $value)
 * @method static \Core\Redis\Contracts\PhpRedisConnection  delete(array|string $keys)
 * @method static \Core\Redis\Contracts\PhpRedisConnection  push(string $key, mixed $value)
 * @method static \Core\Redis\Contracts\PhpRedisConnection  connection($name = null)
 * @method static \Illuminate\Redis\Connections\PhpRedisConnection|null getConnection()
 *
 * @see \Core\Redis
 */
class Redis extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return PhpRedisConnection::class;
    }
}