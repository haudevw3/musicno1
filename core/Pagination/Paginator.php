<?php

namespace Core\Pagination;

use Core\Pagination\Contracts\Paginator as PaginatorContract;
use Illuminate\Support\Collection;

class Paginator implements PaginatorContract
{
    /**
     * All of the items being paginated.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $items;

    /**
     * The number of items to be shown per page.
     *
     * @var int
     */
    protected $perPage;

    /**
     * The current page being "viewed".
     *
     * @var int
     */
    protected $currentPage;

    /**
     * The base path to assign to all URLs.
     *
     * @var string
     */
    protected $path = '/';

    /**
     * The paginator options.
     *
     * @var array
     */
    protected $options;

    /**
     * The query string variable used to store the page.
     *
     * @var string
     */
    protected $pageName = 'page-';

    /**
     * The total number of items before slicing.
     *
     * @var int
     */
    protected $total;

    /**
     * The last available page.
     *
     * @var int
     */
    protected $lastPage;

    /**
     * Determine if there are more items in the data source.
     *
     * @return bool
     */
    protected $hasMore;

    /**
     * Create a new paginator instance.
     *
     * @param  mixed  $items
     * @param  int    $total
     * @param  int    $perPage
     * @param  array  $options (force: "path: Full URL of the request", "parameter: The optional parameter of the route")
     * @return void
     */
    public function __construct($items, $total, $perPage, array $options)
    {
        $this->perPage = $perPage;
        $this->total = $total;
        $this->lastPage = max((int) ceil($total / $perPage), 1);
        $this->setPath($options['path']);
        $this->setCurrentPage($options['parameter']);
        $this->setItems($items);
    }

    /**
     * Create a new paginator instance.
     *
     * @param  mixed  $items
     * @param  int    $total
     * @param  int    $perPage
     * @param  array  $options
     * @return $this
     */
    public static function create($items, $total, $perPage, array $options)
    {
        return new static($items, $total, $perPage, $options);
    }

    /**
     * Get the total number of items being paginated.
     *
     * @return int
     */
    public function total()
    {
        return $this->total;
    }

    /**
     * Get the number of items shown per page.
     *
     * @return int
     */
    public function perPage()
    {
        return $this->perPage;
    }

    /**
     * Get the last page.
     *
     * @return int
     */
    public function lastPage()
    {
        return $this->lastPage;
    }

    /**
     * Get the query string variable used to store the page.
     *
     * @return string
     */
    public function getPageName()
    {
        return $this->pageName;
    }

    /**
     * Set the query string variable used to store the page.
     *
     * @param  string  $name
     * @return void
     */
    public function setPageName($name)
    {
        $this->pageName = $name;
    }

    /**
     * Get the base path for paginator generated URLs.
     *
     * @return string
     */
    public function path()
    {
        return $this->path;
    }

    /**
     * Set the base path to assign to all URLs.
     *
     * @param  string  $path
     * @return void
     */
    protected function setPath($path)
    {
        $this->path = $this->parsePath($path);
    }

    /**
     * Parse the base path from the request.
     *
     * @param  string  $path
     * @return string
     */
    protected function parsePath($path)
    {
        $segments = explode('/', $path);

        unset($segments[count($segments) - 1]);

        $path = implode('/', $segments).'/'.$this->getPageName();

        return $path;
    }

    /**
     * Get the current page.
     *
     * @return int
     */
    public function currentPage()
    {
        return $this->currentPage;
    }

    /**
     * Set the current page.
     *
     * @param  string  $parameter
     * @return void
     */
    protected function setCurrentPage($parameter)
    {
        $this->currentPage = $this->parseCurrentPage($parameter);
    }

    /**
     * Parse the current page from the request using the given parameter of the route.
     *
     * @param  string  $parameter
     * @return int
     */
    protected function parseCurrentPage($parameter)
    {
        $segments = explode('-', $parameter);

        $currentPage = typecast(end($segments), 'int');

        return $currentPage;
    }

    /**
     * Get the slice of items being paginated.
     *
     * @return array
     */
    public function items()
    {
        return $this->items->all();
    }

    /**
     * Set the items for the paginator.
     *
     * @param  mixed  $items
     * @return void
     */
    protected function setItems($items)
    {
        $offset = ($this->currentPage() == 1) ? 0 : ($this->currentPage() - 1) * $this->perPage;

        $this->items = $items instanceof Collection ? $items : Collection::make($items);

        $this->hasMore = $this->items->count() > $this->perPage;

        $this->items = $this->items->slice($offset, $this->perPage);
    }

    /**
     * Determine if there are enough items to split into multiple pages.
     *
     * @return bool
     */
    public function hasPages()
    {
        return $this->currentPage() != 1 || $this->hasMorePages();
    }

    /**
     * Determine if there are more items in the data source.
     *
     * @return bool
     */
    public function hasMorePages()
    {
        return $this->hasMore;
    }

    /**
     * Get the URL for a given page number.
     *
     * @param  int     $page
     * @return string
     */
    public function url($page)
    {
        if ($page <= 0) {
            $page = 1;
        }

        return $this->path().$page;
    }

    /**
     * Get the number for the previous page.
     *
     * @return int
     */
    public function previousPage()
    {
        return ($this->currentPage() == 1)
                ? 1 : $this->currentPage() - 1;
    }

    /**
     * Get the URL for the previous page.
     *
     * @return string|null
     */
    public function previousPageUrl()
    {
        if ($this->currentPage() > 1) {
            return $this->url($this->currentPage() - 1);
        }
    }

    /**
     * Get the number for the next page.
     *
     * @return int
     */
    public function nextPage()
    {
        return ($this->currentPage() == $this->lastPage())
                ? $this->currentPage()
                : $this->currentPage() + 1;
    }

    /**
     * Get the URL for the next page.
     *
     * @return string|null
     */
    public function nextPageUrl()
    {
        if ($this->hasMorePages()) {
            return $this->url($this->currentPage() + 1);
        }
    }

    /**
     * Get the paginator links as an array.
     *
     * @return array
     */
    public function links()
    {
        $links = [];

        for ($index = 1; $index <= $this->lastPage(); $index++) {
            $links[$index] = $this->url($index); 
        }

        return $links;
    }

    /**
     * Determine if the list of items is empty.
     *
     * @return bool
     */
    public function isEmpty()
    {
        return $this->items->isEmpty();
    }

    /**
     * Determine if the list of items is not empty.
     *
     * @return bool
     */
    public function isNotEmpty()
    {
        return $this->items->isNotEmpty();
    }

    /**
     * Get the number of items for the current page.
     *
     * @return int
     */
    public function count()
    {
        return $this->items->count();
    }

    /**
     * Get the number of the first item in the slice.
     *
     * @return int
     */
    public function firstItem()
    {
        return count($this->items) > 0 ? ($this->currentPage - 1) * $this->perPage + 1 : null;
    }

    /**
     * Get the number of the last item in the slice.
     *
     * @return int
     */
    public function lastItem()
    {
        return count($this->items) > 0 ? $this->firstItem() + $this->count() - 1 : null;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'current_page' => $this->currentPage(),
            'data' => $this->items->toArray(),
            'first_page_url' => $this->url(1),
            'from' => $this->firstItem(),
            'last_page' => $this->lastPage(),
            'last_page_url' => $this->url($this->lastPage()),
            'links' => $this->links(),
            'next_page' => $this->nextPage(),
            'next_page_url' => $this->nextPageUrl(),
            'path' => $this->path(),
            'per_page' => $this->perPage(),
            'prev_page' => $this->previousPage(),
            'prev_page_url' => $this->previousPageUrl(),
            'to' => $this->lastItem(),
            'total' => $this->total(),
        ];
    }

    /**
     * Convert the object into something JSON serializable.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param  int  $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->jsonSerialize(), $options);
    }
}