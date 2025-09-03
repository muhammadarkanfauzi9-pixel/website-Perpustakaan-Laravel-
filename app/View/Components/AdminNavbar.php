<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AdminNavbar extends Component
{
    public $userName;

    /**
     * Create a new component instance.
     */
    public function __construct($userName)
    {
        $this->userName = $userName;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.admin-navbar');
    }
}