<?php

namespace Modules\Adm\Views\Components;

use Illuminate\View\Component;

class PageHeaderTitle extends Component
{
    public $icon;
    public $name;

    /**
     * Create a new "page header title" instance.
     *
     * @param  string  $icon
     * @param  string  $name
     * @return void
     */
    public function __construct($icon, $name)
    {
        $this->icon = $icon;
        $this->name = $name;
    }

    /**
     * Get the view / view contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\Support\Htmlable|\Closure|string
     */
    public function render()
    {
        return view('adm::components.page-header-title');
    }
}