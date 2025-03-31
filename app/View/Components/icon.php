<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Icon extends Component
{ 
    public $label;

    public function __construct($label)
    {
        $this->label = $label;
    }

    public function render(): View|Closure|string
    {
        return view('components.icon');
    }
}
