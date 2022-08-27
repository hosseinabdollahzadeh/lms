<?php

namespace App\View\Components;

use Illuminate\View\Component;

class File extends Component
{
    public $name;
    public $placeholder;
    public $value;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $placeholder, $value=null)
    {
        $this->value = $value;
        $this->name = $name;
        $this->placeholder = $placeholder;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.file');
    }
}
