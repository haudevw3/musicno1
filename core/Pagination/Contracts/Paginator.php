<?php

namespace Core\Pagination\Contracts;

interface Paginator
{
    /**
     * Get the URL for a given page.
     *
     * @param  int  $page
     * @return string
     */
    public function url($page);
    /**
     * The URL for the next page, or null.
     *
     * @return string|null
     */
    public function nextPageUrl();

    /**
     * Get the URL for the previous page, or null.
     *
     * @return string|null
     */
    public function previousPageUrl();

    /**
     * Get all of the items being paginated.
     *
     * @return array
     */
    public function items();

    /**
     * Get the "index" of the first item being paginated.
     *
     * @return int
     */
    public function firstItem();

    /**
     * Get the "index" of the last item being paginated.
     *
     * @return int
     */
    public function lastItem();

    /**
     * Determine how many items are being shown per page.
     *
     * @return int
     */
    public function perPage();

    /**
     * Determine the current page being paginated.
     *
     * @return int
     */
    public function currentPage();

    /**
     * Determine if there are enough items to split into multiple pages.
     *
     * @return bool
     */
    public function hasPages();

    /**
     * Determine if there are more items in the data store.
     *
     * @return bool
     */
    public function hasMorePages();

    /**
     * Get the base path for paginator generated URLs.
     *
     * @return string
     */
    public function path();

    /**
     * Determine if the list of items is empty or not.
     *
     * @return bool
     */
    public function isEmpty();

    /**
     * Determine if the list of items is not empty.
     *
     * @return bool
     */
    public function isNotEmpty();

    /**
     * Get the paginator links as an array.
     *
     * @return array
     */
    public function links();
}
