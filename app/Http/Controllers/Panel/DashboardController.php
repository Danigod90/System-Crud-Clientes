<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\EntradaConNota;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $rol = $user->roles->first()?->name;
        $esAsesor = $rol === 'Asesor';

        if ($esAsesor) {
$entradas = EntradaConNota::with('charla')->where('asesor_asignado', $user->name)->latest()->take(10)->get();            $elecciones = EntradaConNota::where('asesor_asignado', $user->name)
                ->whereNotNull('fecha_eleccion')
                ->where('fecha_eleccion', '>=', now())
                ->where('fecha_eleccion', '<=', now()->addDays(30))
                ->orderBy('fecha_eleccion')
                ->take(5)
                ->get();
            $stats = [
                'organizaciones'      => EntradaConNota::where('asesor_asignado', $user->name)->count(),
                'charlas_realizadas'  => 0,
                'charlas_pendientes'  => EntradaConNota::where('asesor_asignado', $user->name)->where('asunto_char', true)->count(),
                'elecciones_proximas' => $elecciones->count(),
                'sin_fecha'           => EntradaConNota::where('asesor_asignado', $user->name)->whereNull('fecha_eleccion')->count(),
                'tec_pendientes'      => EntradaConNota::where('asesor_asignado', $user->name)->where('asunto_tec', true)->count(),
                'borradores'          => 0,
            ];
            return view('panel.dashboard-asesor', compact('entradas', 'elecciones', 'stats'));
        }

        $entradas = EntradaConNota::with('charla')->latest()->take(10)->get();
        $elecciones = EntradaConNota::whereNotNull('fecha_eleccion')
            ->where('fecha_eleccion', '>=', now())
            ->where('fecha_eleccion', '<=', now()->addDays(30))
            ->orderBy('fecha_eleccion')
            ->take(5)
            ->get();
        $stats = [
            'organizaciones'      => EntradaConNota::count(),
            'charlas_realizadas'  => 0,
            'charlas_pendientes'  => EntradaConNota::where('asunto_char', true)->count(),
            'elecciones_proximas' => $elecciones->count(),
            'sin_fecha'           => EntradaConNota::whereNull('fecha_eleccion')->count(),
            'tec_pendientes'      => EntradaConNota::where('asunto_tec', true)->count(),
        ];

        return view('panel.dashboard', compact('entradas', 'elecciones', 'stats'));
    }
}
