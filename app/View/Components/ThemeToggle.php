<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Cookie;
use Illuminate\View\Component;

class ThemeToggle extends Component
{
    public string $size;
    public string $currentTheme;

    /**
     * Create a new component instance.
     */
    public function __construct(string $size = 'md')
    {
        $this->size = $size;
        $this->currentTheme = Cookie::get('theme', 'light');
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.theme-toggle');
    }
}
