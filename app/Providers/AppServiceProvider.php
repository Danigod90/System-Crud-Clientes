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
        View::composer('layouts.panel', function ($view) {
            if (!Auth::check()) return;

            $user = Auth::user();
            $rol = $user->roles->first()?->name;

            $query = EntradaConNota::whereNotNull('fecha_eleccion')
                ->where('fecha_eleccion', '>=', now()->startOfDay())
                ->where('fecha_eleccion', '<=', now()->addDays(30))
                ->orderBy('fecha_eleccion')
                ->take(10);

            if ($rol === 'Asesor') {
                $query->where('asesor_asignado', $user->name);
            }

            $elecciones = $query->get();

            $view->with('elecciones', $elecciones);
        });
    }
}
