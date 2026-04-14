<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Database\Eloquent\Collection;

class PanelLayout extends Component
{
    public function __construct(
    public string $title = 'Dashboard',
    public $elecciones = null,
    public $charlasPendientes = null,
) {}

  public function render()
{
    view()->share('charlasPendientes', $this->charlasPendientes);
    view()->share('elecciones', $this->elecciones);
    view()->share('title', $this->title);
    return view('layouts.panel');
}
}
