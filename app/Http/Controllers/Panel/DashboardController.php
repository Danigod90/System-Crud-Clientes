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
if ($rol === 'Secretaria Sin Nota') {
    $stats = [
        'entradas_mes'    => \App\Models\EntradaSinNota::whereMonth('created_at', now()->month)->count(),
        'log_pendientes'  => \App\Models\EntradaConNota::where('asunto_log', true)->where('log_estado', 'pendiente')->count(),
        'log_entregados'  => \App\Models\EntradaConNota::where('asunto_log', true)->where('log_estado', 'entregada')->count(),
        'log_devueltos'   => \App\Models\EntradaConNota::where('asunto_log', true)->where('log_estado', 'realizado')->count(),
    ];
    $elecciones = \App\Models\EntradaConNota::whereNotNull('fecha_eleccion')
        ->where('fecha_eleccion', '>=', now())
        ->where('fecha_eleccion', '<=', now()->addDays(30))
        ->where('mostrar_en_ticker', true)
        ->orderBy('fecha_eleccion')
        ->take(5)
        ->get();
    $charlasPendientes = collect();
    return view('panel.dashboard-sin-nota', compact('stats', 'elecciones', 'charlasPendientes'));
}
    if ($rol === 'Asesor') {
        $asesor = \App\Models\Asesor::where('user_id', $user->id)->first();
        $nombreAsesor = $asesor ? $asesor->nombre . ' ' . $asesor->apellido : $user->name;
        $entradas = EntradaConNota::with(['charla', 'charlas', 'detalleTecnico'])->where('asesor_asignado', $nombreAsesor)->latest()->take(10)->get();
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
    'charlas_pendientes'  => Charla::whereHas('entrada', fn($q) => $q->where('asesor_asignado', $nombreAsesor))->where('estado', 'pendiente')->count(),
    'elecciones_proximas' => $elecciones->count(),
    'sin_fecha'           => EntradaConNota::where('asesor_asignado', $nombreAsesor)->whereNull('fecha_eleccion')->count(),
    'tec_pendientes' => EntradaConNota::where('asesor_asignado', $nombreAsesor)
        ->where('asunto_tec', true)
        ->where(fn($q) => $q
            ->whereHas('detalleTecnico', fn($q) => $q->where('tec_realizado', false))
            ->orWhereDoesntHave('detalleTecnico')
        )->count(),
    'obs_pendientes' => EntradaConNota::where('asesor_asignado', $nombreAsesor)
        ->where('asunto_obs', true)
        ->where(fn($q) => $q
            ->whereHas('observador', fn($q) => $q->where('estado', 'pendiente'))
            ->orWhereDoesntHave('observador')
        )->count(),
    'borradores' => 0,
];
        session(['charlasPendientes' => $charlasPendientes]);
        $prioridades = \App\Models\PrioridadTecnica::with(['entrada.detalleTecnico'])->orderBy('orden')->get();
return view('panel.dashboard-asesor', compact('entradas', 'elecciones', 'stats', 'charlasPendientes', 'prioridades'));
    }

    $asesorFiltro = $request->get('asesor');
    $asesores = \App\Models\Asesor::orderBy('nombre')->get();

    $entradas = EntradaConNota::with(['charla', 'charlas', 'detalleTecnico', 'observador'])
    ->when($asesorFiltro, fn($q) => $q->where('asesor_asignado', $asesorFiltro))
    ->latest()
    ->take(20)
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
    'tec_pendientes' => EntradaConNota::where('asunto_tec', true)
        ->whereHas('detalleTecnico', fn($q) => $q->where('tec_realizado', false))
        ->orWhere(fn($q) => $q->where('asunto_tec', true)->whereDoesntHave('detalleTecnico'))
        ->count(),
    'obs_pendientes' => EntradaConNota::where('asunto_obs', true)
        ->where(fn($q) => $q
            ->whereHas('observador', fn($q) => $q->where('estado', 'pendiente'))
            ->orWhereDoesntHave('observador')
        )->count(),
];
$charlasPendientes = \App\Models\Charla::where('estado', 'pendiente')
        ->whereNotNull('fecha_hora')
        ->where('fecha_hora', '>=', now())
        ->orderBy('fecha_hora')
        ->take(5)
        ->get();

    return view('panel.dashboard', compact('entradas', 'elecciones', 'stats', 'asesores', 'charlasPendientes'));
}
}
