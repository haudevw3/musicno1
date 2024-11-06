<?php

namespace Core\Views\Components;

use Core\Pagination\Contracts\Paginator;
use Illuminate\View\Component;

class Pagination extends Component
{
    /**
     * The paginator instance.
     *
     * @var \Core\Pagination\Contracts\Paginator
     */
    public $paginator;

    /**
     * Create a new "pagination" instance.
     *
     * @param  \Core\Pagination\Contracts\Paginator  $paginator
     * @return void
     */
    public function __construct(Paginator $paginator)
    {
        $this->paginator = $paginator;
    }

    /**
     * Get the view / view contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\Support\Htmlable|\Closure|string
     */
    public function render()
    {
        return view('components.pagination');
    }
}