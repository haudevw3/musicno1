<?php

namespace Core\Views\Components;

use Illuminate\View\Component;

class FaIcon extends Component
{
    public $class;
    public $type;
    public $icon;
    public $event;

    /**
     * Create a new "fa icon" instance.
     *
     * @param  string       $icon
     * @param  string|null  $type
     * @param  string       $class
     * @param  string       $event
     * @return void
     */
    public function __construct($icon, $type = null, $class = '', $event = '')
    {
        $this->icon = $icon;
        $this->type = $type;
        $this->class = $class;
        $this->event = $event;
    }

    /**
     * Get the view / view contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\Support\Htmlable|\Closure|string
     */
    public function render()
    {
        return view('components.fa-icon');
    }
}