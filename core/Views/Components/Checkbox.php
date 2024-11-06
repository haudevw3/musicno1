<?php

namespace Core\Views\Components;

use Illuminate\View\Component;

class Checkbox extends Component
{
    public $id;
    public $name;
    public $value;

    /**
     * Create a new "checkbox" instance.
     *
     * @param  string  $id
     * @param  string  $name
     * @param  string  $value
     * @return void
     */
    public function __construct($id, $name = '', $value = '')
    {
        $this->id = $id;
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * Get the view / view contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\Support\Htmlable|\Closure|string
     */
    public function render()
    {
        return view('components.checkbox');
    }
}