<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Database\Eloquent\Collection;

class PanelLayout extends Component
{
    public function __construct(
        public string $title = 'Dashboard',
        public $elecciones = null,
    ) {}

    public function render()
    {
        return view('layouts.panel');
    }
}
