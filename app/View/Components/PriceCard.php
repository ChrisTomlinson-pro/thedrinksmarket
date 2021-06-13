<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Item;

class PriceCard extends Component
{
    /**
     * The item model
     * 
     * @var Item
     */
    public $product;
    
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Item $product)
    {
        $this->product = $product;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.price-card');
    }
}
