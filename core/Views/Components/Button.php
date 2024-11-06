<?php

namespace Core\Views\Components;

use Illuminate\View\Component;

class Button extends Component
{
    public $id;
    public $tag;
    public $url;
    public $icon;
    public $class;
    public $name;
    public $type;

    /**
     * Create a new "button" instance.
     *
     * @param  string  $name
     * @param  string  $class
     * @param  string  $id
     * @param  string  $icon
     * @param  string  $url
     * @param  string  $tag
     * @param  string  $type
     * @return void
     */
    public function __construct($name, $class, $id = '', $icon = '', $url = '', $tag = 'button', $type = 'button')
    {
        $this->id = $id;
        $this->name = $name;
        $this->class = $class;
        $this->icon = $icon;
        $this->url = $url;
        $this->tag = $tag;
        $this->type = $type;
    }

    /**
     * Get the view / view contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\Support\Htmlable|\Closure|string
     */
    public function render()
    {
        return view('components.button');
    }
}