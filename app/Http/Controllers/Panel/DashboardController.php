<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\EntradaConNota;
use App\Models\Charla;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
{
    $user = Auth::user();
    $rol = $user->roles->first()?->name;

    if ($rol === 'Tecnico') {
        return redirect()->route('tecnico.dashboard');
    }

    if ($rol === 'Asesor') {
        $asesor = \App\Models\Asesor::where('user_id', $user->id)->first();
        $nombreAsesor = $asesor ? $asesor->nombre . ' ' . $asesor->apellido : $user->name;
        $entradas = EntradaConNota::with('charla')->where('asesor_asignado', $nombreAsesor)->latest()->take(10)->get();
        $elecciones = EntradaConNota::where('asesor_asignado', $nombreAsesor)
            ->whereNotNull('fecha_eleccion')
            ->where('fecha_eleccion', '>=', now())
            ->where('fecha_eleccion', '<=', now()->addDays(30))
            ->where('mostrar_en_ticker', true)
            ->orderBy('fecha_eleccion')
            ->take(5)
            ->get();
        $charlasPendientes = \App\Models\Charla::whereHas('entrada', fn($q) => $q->where('asesor_asignado', $nombreAsesor))
            ->where('estado', 'pendiente')
            ->whereNotNull('fecha_hora')
            ->where('fecha_hora', '>=', now())
            ->orderBy('fecha_hora')
            ->take(5)
            ->get();
        $stats = [
            'organizaciones'      => EntradaConNota::where('asesor_asignado', $nombreAsesor)->count(),
            'charlas_realizadas'  => Charla::whereHas('entrada', fn($q) => $q->where('asesor_asignado', $nombreAsesor))->where('estado', 'realizada')->count(),
            'charlas_pendientes'  => Charla::whereHas('entrada', fn($q) => $q->where('asesor_asignado', $nombreAsesor))->where('estado', 'pendiente')->count(),
            'elecciones_proximas' => $elecciones->count(),
            'sin_fecha'           => EntradaConNota::where('asesor_asignado', $nombreAsesor)->whereNull('fecha_eleccion')->count(),
            'tec_pendientes'      => EntradaConNota::where('asesor_asignado', $nombreAsesor)->where('asunto_tec', true)->count(),
            'borradores'          => 0,
        ];
        session(['charlasPendientes' => $charlasPendientes]);
        return view('panel.dashboard-asesor', compact('entradas', 'elecciones', 'stats', 'charlasPendientes'));
    }

    $asesorFiltro = $request->get('asesor');
    $asesores = \App\Models\Asesor::orderBy('nombre')->get();

    $entradas = EntradaConNota::with('charla')
        ->when($asesorFiltro, fn($q) => $q->where('asesor_asignado', $asesorFiltro))
        ->latest()
        ->take(10)
        ->get();

    $elecciones = EntradaConNota::whereNotNull('fecha_eleccion')
        ->where('fecha_eleccion', '>=', now())
        ->where('fecha_eleccion', '<=', now()->addDays(30))
        ->where('mostrar_en_ticker', true)
        ->orderBy('fecha_eleccion')
        ->take(5)
        ->get();

    $stats = [
        'organizaciones'      => EntradaConNota::count(),
        'charlas_realizadas'  => Charla::where('estado', 'realizada')->count(),
        'charlas_pendientes'  => Charla::where('estado', 'pendiente')->count(),
        'elecciones_proximas' => $elecciones->count(),
        'sin_fecha'           => EntradaConNota::whereNull('fecha_eleccion')->count(),
        'tec_pendientes'      => EntradaConNota::where('asunto_tec', true)->count(),
    ];

    return view('panel.dashboard', compact('entradas', 'elecciones', 'stats', 'asesores'));
}
}
