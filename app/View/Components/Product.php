<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Item;
use App\Models\AdminConfig;

class Product extends Component
{
    /**
     * The product model
     * 
     * @var Item
     */
    public $product;

    /**
     * The current admin configuration
     * 
     * @var AdminConfig
     */
    public $config;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Item $product, AdminConfig $config)
    {
        $this->product = $product;
        $this->config = $config;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.product');
    }
}
