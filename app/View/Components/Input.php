<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Input extends Component
{
    public $name;
    public $type;
    public $placeholder;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $type, $placeholder)
    {
        //
        $this->name = $name;
        $this->type = $type;
        $this->placeholder = $placeholder;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.input');
    }
}
