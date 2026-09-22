<?php

namespace App\Http\Controllers\Tecnico;

use App\Http\Controllers\Controller;
use App\Models\EntradaConNota;
use App\Models\DetalleTecnico;

class TecnicoDashboardController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $asesorFiltro = $request->get('asesor');

        $entradas = EntradaConNota::with(['detalleTecnico'])
            ->where('asunto_tec', true)
            ->where('eleccion_suspendida', false)
            ->when($asesorFiltro, fn($q) => $q->where('asesor_asignado', $asesorFiltro))
            ->latest()
            ->take(10)
            ->get();

        $elecciones = EntradaConNota::where('asunto_tec', true)
            ->where('eleccion_suspendida', false)
            ->whereNotNull('fecha_eleccion')
            ->where('fecha_eleccion', '>=', now())
            ->where('fecha_eleccion', '<=', now()->addDays(30))
            ->where('mostrar_en_ticker', true)
            ->orderBy('fecha_eleccion')
            ->take(5)
            ->get();

        $asesores = \App\Models\Asesor::orderBy('nombre')->get();

        // Las suspendidas se excluyen solo de los conteos que representan
        // trabajo PENDIENTE (enviados, pendientes, por_imprimir). "Impresos"
        // y el total no se tocan: un trabajo ya impreso sigue siendo válido
        // aunque la elección se suspenda después.
        $stats = [
            'total_tec'    => EntradaConNota::where('asunto_tec', true)->count(),
            'enviados'     => DetalleTecnico::where('enviado_tecnica', true)
                ->whereHas('entrada', fn($q) => $q->where('asunto_tec', true)->where('eleccion_suspendida', false))
                ->count(),
            'pendientes' => EntradaConNota::where('asunto_tec', true)
                ->where('eleccion_suspendida', false)
                ->where(fn($q) => $q
                    ->whereHas('detalleTecnico', fn($q) => $q->where('tec_realizado', false))
                    ->orWhereDoesntHave('detalleTecnico')
                )->count(),
            'impresos'     => DetalleTecnico::where('impreso', true)
                ->whereHas('entrada', fn($q) => $q->where('asunto_tec', true))
                ->count(),
            'sin_fecha'    => EntradaConNota::where('asunto_tec', true)->whereNull('fecha_eleccion')->count(),
            'por_imprimir' => DetalleTecnico::where('enviado_tecnica', true)->where('impreso', false)
                ->whereHas('entrada', fn($q) => $q->where('asunto_tec', true)->where('eleccion_suspendida', false))
                ->count(),
        ];

        $prioridades = \App\Models\PrioridadTecnica::with(['entrada.detalleTecnico'])
            ->orderBy('orden')
            ->get();

        return view('tecnico.dashboard_tecnico', compact('entradas', 'elecciones', 'stats', 'asesores', 'prioridades'));
    }
}
