<?php

namespace Core\Views\Components;

use Illuminate\View\Component;

class BaseInput extends Component
{
    public $icon;
    public $name;
    public $type;
    public $placeholder;

    /**
     * Create a new "base input" instance.
     *
     * @param  string  $icon
     * @param  string  $name
     * @param  string  $type
     * @param  string  $placeholder
     * @return void
     */
    public function __construct($icon, $name, $type, $placeholder)
    {
        $this->icon = $icon;
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
        return view('components.base-input');
    }
}