<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\EntradaConNota;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('layouts.panel', function ($view) {
            $elecciones = EntradaConNota::whereNotNull('fecha_eleccion')
                ->where('fecha_eleccion', '>=', now()->startOfDay())
                ->where('fecha_eleccion', '<=', now()->addDays(30))
                ->orderBy('fecha_eleccion')
                ->take(5)
                ->get();

            $view->with('elecciones', $elecciones);
        });
    }
}
