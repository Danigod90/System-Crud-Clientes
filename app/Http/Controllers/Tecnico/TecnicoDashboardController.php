<?php

namespace App\Http\Controllers\Tecnico;

use App\Http\Controllers\Controller;
use App\Models\EntradaConNota;
use App\Models\DetalleTecnico;

class TecnicoDashboardController extends Controller
{
    public function index()
    {
        $entradas = EntradaConNota::with(['detalleTecnico'])
            ->where('asunto_tec', true)
            ->latest()
            ->take(10)
            ->get();

        $elecciones = EntradaConNota::where('asunto_tec', true)
            ->whereNotNull('fecha_eleccion')
            ->where('fecha_eleccion', '>=', now())
            ->where('fecha_eleccion', '<=', now()->addDays(30))
            ->where('mostrar_en_ticker', true)
            ->orderBy('fecha_eleccion')
            ->take(5)
            ->get();

        $stats = [
            'total_tec'         => EntradaConNota::where('asunto_tec', true)->count(),
            'enviados'          => DetalleTecnico::where('enviado_tecnica', true)->count(),
            'pendientes'        => DetalleTecnico::where('enviado_tecnica', false)->count(),
            'impresos'          => DetalleTecnico::where('impreso', true)->count(),
            'sin_fecha'         => EntradaConNota::where('asunto_tec', true)->whereNull('fecha_eleccion')->count(),
            'por_imprimir'      => DetalleTecnico::where('enviado_tecnica', true)->where('impreso', false)->count(),
        ];

return view('tecnico.dashboard_tecnico', compact('entradas', 'elecciones', 'stats'));    }
}
