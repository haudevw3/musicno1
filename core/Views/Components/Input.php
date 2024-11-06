<?php

namespace Core\Views\Components;

use Illuminate\View\Component;

class Input extends Component
{
    public $class;
    public $name;
    public $type;
    public $value;
    public $placeholder;

    /**
     * Create a new "input" instance.
     *
     * @param  string  $name
     * @param  string  $type
     * @param  string  $placeholder
     * @param  string  $class
     * @param  string  $value
     * @return void
     */
    public function __construct($name, $type, $placeholder, $class = '', $value = '')
    {
        $this->name = $name;
        $this->type = $type;
        $this->class = $class;
        $this->value = $value;
        $this->placeholder = $placeholder;
    }

    /**
     * Get the view / view contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\Support\Htmlable|\Closure|string
     */
    public function render()
    {
        return view('components.input');
    }
}