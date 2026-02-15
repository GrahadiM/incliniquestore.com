<?php

namespace App\View\Components\Dashboard;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Stat extends Component
{
    public $title;
    public $value;
    public $icon;

    /**
     * Create a new component instance.
     */
    public function __construct($title, $value, $icon)
    {
        $this->title = $title;
        $this->value = $value;
        $this->icon = $icon;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dashboard.stat');
    }
}
