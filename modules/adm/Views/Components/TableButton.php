<?php

namespace Modules\Adm\Views\Components;

use Illuminate\View\Component;

class TableButton extends Component
{
    public $url;
    public $tag;
    public $icon;
    public $class;
    public $extra;

    /**
     * Create a new "page header title" instance.
     *
     * @param  string  $icon
     * @param  string  $class
     * @param  string  $url
     * @param  string  $tag
     * @param  string  $extra
     * @return void
     */
    public function __construct($icon, $class = '', $url = '', $tag = 'button', $extra = '')
    {
        $this->tag = $tag;
        $this->url = $url;
        $this->icon = $icon;
        $this->class = $class;
        $this->extra = $extra;
    }

    /**
     * Get the view / view contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\Support\Htmlable|\Closure|string
     */
    public function render()
    {
        return view('adm::components.table-button');
    }
}