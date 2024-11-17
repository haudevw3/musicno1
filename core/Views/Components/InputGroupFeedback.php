<?php

namespace Core\Views\Components;

use Illuminate\View\Component;

class InputGroupFeedback extends Component
{
    public $id;
    public $label;
    public $icon;
    public $name;
    public $type;
    public $value;
    public $class;
    public $placeholder;

    /**
     * Create a new "input group feedback" instance.
     *
     * @param  string  $id
     * @param  string  $label
     * @param  string  $icon
     * @param  string  $name
     * @param  string  $type
     * @param  string  $placeholder
     * @param  string  $class
     * @param  string  $value
     * @return void
     */
    public function __construct($id, $label, $icon, $name, $type, $placeholder, $class = '', $value = '')
    {
        $this->id = $id;
        $this->label = $label;
        $this->icon = $icon;
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
        return view('components.input-group-feedback');
    }
}