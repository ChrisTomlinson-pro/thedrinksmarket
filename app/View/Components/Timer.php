<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\AdminConfig;

class Timer extends Component
{
    /**
     * User Config
     * 
     * @var AdminConfig
     */
    public $config;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(AdminConfig $config)
    {
        $this->config = $config;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.timer');
    }
}
