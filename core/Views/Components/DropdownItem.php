<?php

namespace Core\Views\Components;

use Illuminate\View\Component;

class DropdownItem extends Component
{
    public $url;
    public $icon;
    public $name;

    /**
     * Create a new "dropdown item" instance.
     *
     * @param  string  $icon
     * @param  string  $name
     * @param  string  $url
     * @return void
     */
    public function __construct($icon, $name, $url = '')
    {
        $this->url = $url;
        $this->name = $name;
        $this->icon = $icon;
    }

    /**
     * Get the view / view contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\Support\Htmlable|\Closure|string
     */
    public function render()
    {
        return view('components.dropdown-item');
    }
}