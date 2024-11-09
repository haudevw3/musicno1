<?php

namespace Core\Redis\Connections;

use Core\Redis\Contracts\PhpRedisConnection as PhpRedisConnectionContract;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Traits\ForwardsCalls;
use InvalidArgumentException;
use Jenssegers\Mongodb\Eloquent\Model;

class PhpRedisConnection implements PhpRedisConnectionContract
{
    use ForwardsCalls;
    
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
     * The "Php Redis Connection" instance.
     *
     * @var \Illuminate\Redis\Connections\PhpRedisConnection
     */
    protected $connection;

    /**
     * The methods are not allowing through.
     *
     * @var array
     */
    protected $notThrough = ['get', 'set'];

    /**
     * Create a new "Php Redis Connection" instance.
     *
     * @param  string|null  $name
     * @return void
     */
    public function __construct($name = null)
    {
        $this->connection($name);
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
        $result = $this->connection->get($key);

        return is_null($result) ? $result : unserialize($result);
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
        $result = $this->get($key);

        if (is_null($result)) {
            return $result;
        }

        $isCollection = $result instanceof Collection;

        if (is_array($result)) {
            $result[] = $value;
        }
        
        elseif ($isCollection && $value instanceof Model) {
            $result->push($value);
        }
        
        elseif ($isCollection && $value instanceof Collection) {
            foreach ($value->all() as $item) {
                $result->push($item);
            }
        }
        
        else {
            $result = $value;
        }

        $this->set($key, $result);

        return $this;
    }

    /**
     * Flush the selected Redis database.
     *
     * @return mixed
     */
    public function flush()
    {
        return Redis::flushdb();
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
     * Set a connection with the given redis name.
     *
     * @param  string|null  $name
     * @return $this
     * 
     * @throws \InvalidArgumentException
     */
    public function connection($name = null)
    {
        try {
            $this->name = $name ?? 'default';
            $this->connected = true;
            $this->connection = Redis::connection($name);
        } catch (InvalidArgumentException $e) {
            $this->connected = false;
            $this->connection = null;
        }

        return $this;
    }

    /**
     * Get "Php Redis Connection" instance.
     *
     * @return \Illuminate\Redis\Connections\PhpRedisConnection|null
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * Handle dynamic method calls into the base repository.
     *
     * @param  string  $method
     * @param  array   $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if (! in_array($method, $this->notThrough)) {
            return $this->forwardCallTo($this->connection, $method, $parameters);
        }
    }
}