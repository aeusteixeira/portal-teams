<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ActionsButtons extends Component
{

    public $content;
    public $actions = [];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($content, $actions = [])
    {
        $this->content = $content;
        $this->actions = $actions;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.actions-buttons');
    }
}
