<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\EntradaConNota;
use App\Models\Asesor;
use Illuminate\Http\Request;

class SupervisorController extends Controller
{
    public function index(Request $request)
    {
        $asesores = Asesor::orderBy('nombre')->get();

        $entradas = EntradaConNota::with(['charla', 'charlas', 'detalleTecnico', 'observador'])
            ->when($request->organizacion, fn($q) =>
                $q->where('nombre_organizacion', 'like', '%' . $request->organizacion . '%')
            )
            ->when($request->asesor, fn($q) =>
                $q->where('asesor_asignado', $request->asesor)
            )
            ->when($request->asunto, function($q) use ($request) {
    $asunto = $request->asunto;
    if (in_array($asunto, ['char_realizada', 'char_pendiente', 'char_suspendida', 'char_cancelada'])) {
        $estado = str_replace('char_', '', $asunto);
        $q->where('asunto_char', true)
          ->whereHas('charla', fn($q) => $q->where('estado', $estado));
    } elseif ($asunto === 'char') {
        $q->where('asunto_char', true);
    } elseif ($asunto === 'log') {
        $q->where('asunto_log', true);
    } elseif ($asunto === 'tec') {
        $q->where('asunto_tec', true);
    } elseif ($asunto === 'obs') {
        $q->where('asunto_obs', true);
    } elseif ($asunto === 'cargado_si') {
        $q->where('supervisor_cargado', true);
    } elseif ($asunto === 'cargado_no') {
        $q->where('supervisor_cargado', false);
    }
})
            ->when($request->mes_ingreso, fn($q) =>
                $q->whereYear('created_at', substr($request->mes_ingreso, 0, 4))
                  ->whereMonth('created_at', substr($request->mes_ingreso, 5, 2))
            )
            ->when($request->mes_eleccion, fn($q) =>
                $q->whereYear('fecha_eleccion', substr($request->mes_eleccion, 0, 4))
                  ->whereMonth('fecha_eleccion', substr($request->mes_eleccion, 5, 2))
            )
            ->when($request->cargado, function($q) use ($request) {
                if ($request->cargado === 'si') {
                    $q->where('supervisor_cargado', true);
                } elseif ($request->cargado === 'no') {
                    $q->where('supervisor_cargado', false);
                }
            })
            ->latest()
            ->paginate(10);

        return view('supervisor.index', compact('entradas', 'asesores'));
    }

    public function show(EntradaConNota $entrada)
    {
        $entrada->load(['charlas', 'charla', 'detalleTecnico', 'observador', 'documentos.user']);
        return view('supervisor.show', compact('entrada'));
    }

    public function marcarCargado(EntradaConNota $entrada)
    {
        $entrada->update([
            'supervisor_cargado'    => true,
            'supervisor_cargado_at' => now(),
        ]);
        return response()->json(['success' => true]);
    }

    public function dashboard()
    {
        $stats = [
            'total'     => EntradaConNota::count(),
            'cargados'  => EntradaConNota::where('supervisor_cargado', true)->count(),
            'pendientes'=> EntradaConNota::where('supervisor_cargado', false)->count(),
            'este_mes'  => EntradaConNota::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count(),
        ];

        $recientes = EntradaConNota::with(['charla', 'detalleTecnico'])
            ->latest()
            ->take(10)
            ->get();

        return view('supervisor.dashboard', compact('stats', 'recientes'));
    }
}