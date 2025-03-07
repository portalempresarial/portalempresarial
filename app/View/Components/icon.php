<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class icon extends Component { 
    public string $label;
    public string $styles;

    public function __construct(string $label, string $styles = '') {
        $this->label = $label;
        $this->styles = $styles;
    }

    public function render(): View|Closure|string {
        return view('components.icon');
    }
}
