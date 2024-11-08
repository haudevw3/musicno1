<?php

namespace Core\Service;

use Core\Repository\BaseRepository;
use Core\Service\Contracts\CacheService as CacheServiceContract;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Redis;
use InvalidArgumentException;
use Jenssegers\Mongodb\Eloquent\Model;

class CacheService implements CacheServiceContract
{
    /**
     * The redis connection name.
     *
     * @var string
     */
    protected $name;

    /**
     * Determine if the redis is connected.
     *
     * @var bool
     */
    protected $connected;

    /**
     * The repository instance.
     *
     * @var \Core\Repository\BaseRepository
     */
    protected $repository;

    /**
     * The "Php Redis Connection" instance.
     *
     * @var \Illuminate\Redis\Connections\PhpRedisConnection
     */
    protected $connection;

    /**
     * Create a new cache service instance.
     *
     * @param  \Core\Repository\BaseRepository  $repository
     * @param  string                           $name
     * @return void
     */
    public function __construct(BaseRepository $repository, $name = 'default')
    {
        $this->name = $name;
        $this->repository = $repository;

        $this->setConnection($name);
    }

    /**
     * Determine if the given key exists in the redis.
     *
     * @param  string  $key
     * @return bool
     */
    public function has($key)
    {
        return $this->connection->exists($key);
    }

    /**
     * Returns the value of the given key.
     *
     * @param  string  $key
     * @return mixed
     */
    public function get($key)
    {
        if ($this->has($key)) {
            return unserialize(
                $this->connection->get($key)
            );
        }
        
        return null;
    }

    /**
     * Set the string value in the argument as the value of the key.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @return $this
     */
    public function set($key, $value)
    {
        $this->connection->set(
            $key, serialize($value)
        );

        return $this;
    }

    /**
     * Delete the value in the redis with the given keys.
     *
     * @param  array|string  $keys
     * @return $this
     */
    public function delete($keys)
    {
        $keys = is_array($keys) ? $keys : [$keys];

        foreach ($keys as $key) {
            if (! $this->has($key)) {
                continue;
            }

            $this->connection->del($key);
        }

        return $this;
    }

    /**
     * Push the value on the redis with the given key.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @return $this
     */
    public function push($key, $value)
    {
        if (! $this->has($key)) {
            return;
        }

        $instance = $this->get($key);

        $isCollection = $instance instanceof Collection;

        if (is_array($instance)) {
            $instance[] = $value;
        } elseif ($isCollection && $value instanceof Model) {
            $instance->push($value);
        } elseif ($isCollection && $value instanceof Collection) {
            foreach ($value->all() as $item) {
                $instance->push($item);
            }
        } else {
            $instance = $value;
        }

        $this->set($key, $instance);

        return $this;
    }

    /**
     * Generate the key using the given value and base name.
     *
     * @param  string  $key
     * @return void
     */
    protected function generateKey($key)
    {
        $className = class_name(
            $this->repository->getModel()
        );

        return strtolower($className).'_'.$key;
    }

    /**
     * Set a connection with the given redis name.
     *
     * @param  string  $name
     * @return void
     * 
     * @throws \InvalidArgumentException
     */
    protected function setConnection($name)
    {
        try {
            $this->connected = true;

            $this->connection = Redis::connection($name);
        } catch (InvalidArgumentException $e) {
            $this->connected = false;
        }
    }

    /**
     * Get connected.
     *
     * @return bool
     */
    public function connected()
    {
        return $this->connected;
    }

    /**
     * Get "Php Redis Connection" instance.
     *
     * @return \Illuminate\Redis\Connections\PhpRedisConnection
     */
    public function connection()
    {
        return $this->connection;
    }
}