<?php

namespace Core\Service;

use Core\Facades\Redis;
use Core\Pagination\Paginator;
use Core\Service\Contracts\BaseService as BaseServiceContract;
use Illuminate\Support\Traits\ForwardsCalls;

class BaseService implements BaseServiceContract
{
    use ForwardsCalls;

    /**
     * The base repository instance.
     *
     * @var mixed
     */
    protected $baseRepo;

    /**
     * Create a new base service instance.
     *
     * @param  mixed  $baseRepo
     * @return void
     */
    public function __construct($baseRepo = null)
    {
        $this->baseRepo = $baseRepo;
    }

    /**
     * Get the repository instance.
     *
     * @return mixed
     */
    public function repository()
    {
        return $this->baseRepo;
    }

    /**
     * Paginate the given query.
     *
     * @param  array  $fields
     * @param  array  $conditions
     * @param  array  $options
     * @return \Core\Pagination\Contracts\Paginator
     */
    public function paginator(array $fields = [], array $conditions = [], array $options = [])
    {
        $perPage = 20;
        $path = request()->fullUrl();
        $parameter = request()->route('page');
        $count = Redis::get($key = $this->basename('count'));

        if (is_null($count)) {
            Redis::set($key, $count = $this->count(['_id' => ['$ne' => null]]));
        }

        $paginator = new Paginator($count, $perPage, [
            'path' => $path,
            'parameter' => $parameter,
        ]);

        $items = Redis::get($key = $this->basename('paginate:'.$parameter));

        if (is_null($items)) {
            Redis::set($key, $items = $this->findMany(
                ['_id' => ['$ne' => null]], [],
                ['skip' => $paginator->getOffset(), 'limit' => $perPage]
            )->toArray());
        }

        $paginator->setItems($items);

        return $paginator;
    }

    /**
     * Generate the base name using the given key.
     *
     * @param  string  $key
     * @return string
     */
    protected function basename($key)
    {
        $className = class_name(
            $this->getModel()
        );

        return strtolower($className).':'.$key;
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
        return $this->forwardCallTo($this->baseRepo, $method, $parameters);
    }
}