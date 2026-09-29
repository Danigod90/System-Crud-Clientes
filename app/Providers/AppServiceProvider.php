<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\EntradaConNota;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        \Carbon\Carbon::setLocale('es');

        View::composer('layouts.panel', function ($view) {
    if (!Auth::check()) return;

    // El tinker de Elecciones se comparte entre todos los roles (Secretaria,
    // Tecnico y Asesor), sin filtrar por asesor asignado.
    $elecciones = EntradaConNota::whereNotNull('fecha_eleccion')
        ->where('fecha_eleccion', '>=', now()->startOfDay())
        ->where('fecha_eleccion', '<=', now()->addDays(30))
        ->where('mostrar_en_ticker', true)
        ->orderBy('fecha_eleccion')
        ->take(10)
        ->get();

    $view->with('elecciones', $elecciones);
});
    }
}
