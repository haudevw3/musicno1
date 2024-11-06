<?php

namespace Core\Views\Components;

use Illuminate\View\Component;

class InputGroup extends Component
{
    public $icon;
    public $class;
    public $name;
    public $type;
    public $placeholder;

    /**
     * Create a new "input group" instance.
     *
     * @param  string  $icon
     * @param  string  $name
     * @param  string  $type
     * @param  string  $placeholder
     * @param  string  $class
     * @return void
     */
    public function __construct($icon, $name, $type, $placeholder, $class = 'ps-0')
    {
        $this->icon = $icon;
        $this->class = $class;
        $this->name = $name;
        $this->type = $type;
        $this->placeholder = $placeholder;
    }

    /**
     * Get the view / view contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\Support\Htmlable|\Closure|string
     */
    public function render()
    {
        return view('components.input-group');
    }
}