<?php

namespace Core\Support;

class DataBag
{
    /**
     * @var array
     */
    protected $data;

    /**
     * Create a new data bag instance.
     *
     * @param  array  $data
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Create a new data bag instance.
     *
     * @param  array  $data
     * @return $this
     */
    public static function create(array $data = [])
    {
        return new static($data);
    }

    /**
     * Set the data with the given value.
     *
     * @param  array  $data
     * @return void
     */
    public function set(array $data)
    {
        $this->data = $data;
    }

    /**
     * Get all of the data.
     * 
     * @return array
     */
    public function all()
    {
        return $this->data;
    }

    /**
     * Determine if the data is empty.
     *
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->data) ? true : false;
    }

    /**
     * Determine if the data is empty.
     *
     * @return bool
     */
    public function isNotEmpty()
    {
        return ! $this->isEmpty();
    }

    /**
     * Determine if the given key exists in the data.
     *
     * @param  string  $key
     * @return bool
     */
    public function has($key)
    {
        return isset($this->data[$key]) ? true : false;
    }

    /**
     * @param  string  $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->data[$key];
    }

    /**
     * @param  string  $key
     * @param  mixed   $value
     * 
     * @return void
     */
    public function __set($key, $value)
    {
        $this->data[$key] = $value;
    }
}