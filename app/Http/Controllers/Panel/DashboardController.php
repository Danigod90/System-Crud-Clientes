<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\EntradaConNota;

class DashboardController extends Controller
{
    public function index()
    {
        $entradas = EntradaConNota::with('user')
            ->latest()
            ->take(10)
            ->get();

        $elecciones = EntradaConNota::whereNotNull('fecha_eleccion')
            ->where('fecha_eleccion', '>=', now())
            ->where('fecha_eleccion', '<=', now()->addDays(30))
            ->orderBy('fecha_eleccion')
            ->take(5)
            ->get();


            $stats = [
    'organizaciones'       => EntradaConNota::count(),
    'charlas_realizadas'   => 0,
    'charlas_pendientes' => EntradaConNota::where('asunto_char', true)->count(),
    'elecciones_proximas'  => $elecciones->count(),
    'sin_fecha'            => EntradaConNota::whereNull('fecha_eleccion')->count(),
    'tec_pendientes' => EntradaConNota::where('asunto_tec', true)->count(),
];


        return view('panel.dashboard', compact('entradas', 'elecciones', 'stats'));
    }
}
