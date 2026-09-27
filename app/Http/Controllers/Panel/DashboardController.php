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
if ($rol === 'Supervisor') {
    return redirect()->route('supervisor.dashboard');
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
    $observadoresPendientes = collect();
    return view('panel.dashboard-sin-nota', compact('stats', 'elecciones', 'charlasPendientes', 'observadoresPendientes'));
}
    if ($rol === 'Asesor') {
        $asesor = \App\Models\Asesor::where('user_id', $user->id)->first();
        $nombreAsesor = $asesor ? $asesor->nombre . ' ' . $asesor->apellido : $user->name;
        $entradas = EntradaConNota::with(['charla', 'charlas', 'detalleTecnico'])->where('asesor_asignado', $nombreAsesor)->latest()->take(10)->get();

        // El tinker de Elecciones se comparte entre todos los asesores (igual que
        // en Secretaría/Técnico), para que cualquiera vea rápido qué elección
        // tiene cada colega sin tener que filtrar. La tarjeta de "elecciones
        // próximas" del dashboard sigue contando solo las propias.
        $eleccionesPropiasCount = EntradaConNota::where('asesor_asignado', $nombreAsesor)
            ->whereNotNull('fecha_eleccion')
            ->where('fecha_eleccion', '>=', now())
            ->where('fecha_eleccion', '<=', now()->addDays(30))
            ->where('mostrar_en_ticker', true)
            ->count();

        $elecciones = EntradaConNota::whereNotNull('fecha_eleccion')
            ->where('fecha_eleccion', '>=', now())
            ->where('fecha_eleccion', '<=', now()->addDays(30))
            ->where('mostrar_en_ticker', true)
            ->orderBy('fecha_eleccion')
            ->take(5)
            ->get();
        $charlasPendientes = EntradaConNota::where('asesor_asignado', $nombreAsesor)
            ->where('asunto_char', true)
            ->where(fn($q) => $q
                ->whereDoesntHave('charla')
                ->orWhereHas('charla', fn($q2) => $q2->whereIn('estado', ['pendiente', 'vencida']))
            )
            ->with('charlas')
            ->orderByRaw("COALESCE((SELECT CASE WHEN estado='vencida' THEN 1 WHEN fecha_hora IS NULL THEN 2 ELSE 0 END FROM charlas WHERE charlas.entrada_con_nota_id = entradas_con_nota.id ORDER BY CASE WHEN estado='vencida' THEN 1 WHEN fecha_hora IS NULL THEN 2 ELSE 0 END ASC, fecha_hora ASC LIMIT 1), 2)")
            ->orderBy(
                \App\Models\Charla::select('fecha_hora')
                    ->whereColumn('entrada_con_nota_id', 'entradas_con_nota.id')
                    ->orderByRaw("CASE WHEN estado='vencida' THEN 1 WHEN fecha_hora IS NULL THEN 2 ELSE 0 END ASC")
                    ->orderBy('fecha_hora')
                    ->limit(1)
            )
            ->take(5)
            ->get();

        $observadoresPendientes = EntradaConNota::where('asesor_asignado', $nombreAsesor)
            ->where('asunto_obs', true)
            ->where(fn($q) => $q
                ->whereDoesntHave('observador')
                ->orWhereHas('observador', fn($q2) => $q2->whereIn('estado', ['pendiente', 'vencida']))
            )
            ->with('observador')
            ->orderByRaw("COALESCE((SELECT CASE WHEN estado='vencida' THEN 1 WHEN fecha_hora IS NULL THEN 2 ELSE 0 END FROM observadores WHERE observadores.entrada_con_nota_id = entradas_con_nota.id ORDER BY CASE WHEN estado='vencida' THEN 1 WHEN fecha_hora IS NULL THEN 2 ELSE 0 END ASC, fecha_hora ASC LIMIT 1), 2)")
            ->orderBy(
                \App\Models\Observador::select('fecha_hora')
                    ->whereColumn('entrada_con_nota_id', 'entradas_con_nota.id')
                    ->orderByRaw("CASE WHEN estado='vencida' THEN 1 WHEN fecha_hora IS NULL THEN 2 ELSE 0 END ASC")
                    ->orderBy('fecha_hora')
                    ->limit(1)
            )
            ->take(5)
            ->get();
        $stats = [
    'organizaciones'      => EntradaConNota::where('asesor_asignado', $nombreAsesor)->count(),
    'charlas_pendientes'  => Charla::whereHas('entrada', fn($q) => $q->where('asesor_asignado', $nombreAsesor))->where('estado', 'pendiente')->count(),
    'elecciones_proximas' => $eleccionesPropiasCount,
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
    'sin_enviar_tec' => EntradaConNota::where('asesor_asignado', $nombreAsesor)
    ->where('asunto_tec', true)
    ->where(fn($q) => $q
        ->whereDoesntHave('detalleTecnico')
        ->orWhereHas('detalleTecnico', fn($q) => $q->where('enviado_tecnica', false)->orWhereNull('enviado_tecnica'))
    )->count(),
];
        session(['charlasPendientes' => $charlasPendientes]);
        $prioridades = \App\Models\PrioridadTecnica::with(['entrada.detalleTecnico'])->orderBy('orden')->get();
return view('panel.dashboard-asesor', compact('entradas', 'elecciones', 'stats', 'charlasPendientes', 'observadoresPendientes', 'prioridades'));
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
$charlasPendientes = EntradaConNota::where('asunto_char', true)
        ->where(fn($q) => $q
            ->whereDoesntHave('charla')
            ->orWhereHas('charla', fn($q2) => $q2->whereIn('estado', ['pendiente', 'vencida']))
        )
        ->with('charlas')
        ->orderByRaw("COALESCE((SELECT CASE WHEN estado='vencida' THEN 1 WHEN fecha_hora IS NULL THEN 2 ELSE 0 END FROM charlas WHERE charlas.entrada_con_nota_id = entradas_con_nota.id ORDER BY CASE WHEN estado='vencida' THEN 1 WHEN fecha_hora IS NULL THEN 2 ELSE 0 END ASC, fecha_hora ASC LIMIT 1), 2)")
        ->orderBy(
            \App\Models\Charla::select('fecha_hora')
                ->whereColumn('entrada_con_nota_id', 'entradas_con_nota.id')
                ->orderByRaw("CASE WHEN estado='vencida' THEN 1 WHEN fecha_hora IS NULL THEN 2 ELSE 0 END ASC")
                ->orderBy('fecha_hora')
                ->limit(1)
        )
        ->take(5)
        ->get();

    $observadoresPendientes = EntradaConNota::where('asunto_obs', true)
        ->where(fn($q) => $q
            ->whereDoesntHave('observador')
            ->orWhereHas('observador', fn($q2) => $q2->whereIn('estado', ['pendiente', 'vencida']))
        )
        ->with('observador')
        ->orderByRaw("COALESCE((SELECT CASE WHEN estado='vencida' THEN 1 WHEN fecha_hora IS NULL THEN 2 ELSE 0 END FROM observadores WHERE observadores.entrada_con_nota_id = entradas_con_nota.id ORDER BY CASE WHEN estado='vencida' THEN 1 WHEN fecha_hora IS NULL THEN 2 ELSE 0 END ASC, fecha_hora ASC LIMIT 1), 2)")
        ->orderBy(
            \App\Models\Observador::select('fecha_hora')
                ->whereColumn('entrada_con_nota_id', 'entradas_con_nota.id')
                ->orderByRaw("CASE WHEN estado='vencida' THEN 1 WHEN fecha_hora IS NULL THEN 2 ELSE 0 END ASC")
                ->orderBy('fecha_hora')
                ->limit(1)
        )
        ->take(5)
        ->get();

    return view('panel.dashboard', compact('entradas', 'elecciones', 'stats', 'asesores', 'charlasPendientes', 'observadoresPendientes'));
}
}
