<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SelectWithSearch extends Component
{
    /**
     * List items
     * 
     * @var object
     */
    public $listItems;

    /**
     * Include none option or not
     * 
     * @var bool
     */
    public $includeNone;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(object $listItems, bool $includeNone)
    {
        $this->listItems = $listItems;
        $this->includeNone = $includeNone;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.select-with-search');
    }
}
