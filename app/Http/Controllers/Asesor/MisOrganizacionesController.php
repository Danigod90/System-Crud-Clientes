<?php

namespace App\Http\Controllers\Asesor;

use App\Http\Controllers\Controller;
use App\Models\EntradaConNota;
use App\Models\Asesor;
use Illuminate\Support\Facades\Auth;

class MisOrganizacionesController extends Controller
{
    public function index()
{
    $user = Auth::user();
    $asesores = Asesor::orderBy('nombre')->get();

    $asesor = \App\Models\Asesor::where('user_id', $user->id)->first();
    $nombreAsesor = $asesor ? $asesor->nombre . ' ' . $asesor->apellido : $user->name;
    $query = EntradaConNota::where('asesor_asignado', $nombreAsesor);

    if (request('organizacion')) {
        $query->where('nombre_organizacion', 'like', '%' . request('organizacion') . '%');
    }
    if (request('asunto')) {
        $asunto = request('asunto');
        if (in_array($asunto, ['char_realizada', 'char_pendiente', 'char_suspendida', 'char_cancelada'])) {
            $estado = str_replace('char_', '', $asunto);
            $query->where('asunto_char', true)
                  ->whereHas('charla', fn($q) => $q->where('estado', $estado));
        } else {
            $query->where('asunto_' . $asunto, true);
        }
    }
    if (request('mes_ingreso')) {
    $query->whereYear('created_at', substr(request('mes_ingreso'), 0, 4))
          ->whereMonth('created_at', substr(request('mes_ingreso'), 5, 2));
}
if (request('mes_eleccion')) {
    $query->whereYear('fecha_eleccion', substr(request('mes_eleccion'), 0, 4))
          ->whereMonth('fecha_eleccion', substr(request('mes_eleccion'), 5, 2));
}
    if (request('estado_charla')) {
        $query->whereHas('charla', fn($q) => $q->where('estado', request('estado_charla')));
    }


    $charlasPendientes = \App\Models\Charla::whereHas('entrada', fn($q) => $q->where('asesor_asignado', $nombreAsesor))
        ->where('estado', 'pendiente')
        ->whereNotNull('fecha_hora')
        ->where('fecha_hora', '>=', now())
        ->orderBy('fecha_hora')
        ->take(5)
        ->get();

    $prioridades = \App\Models\PrioridadAsesor::where('user_id', $user->id)->get();

$prioridadIds = $prioridades->pluck('entrada_con_nota_id')->toArray();

$entradas = $query->orderByRaw("FIELD(id, " . (count($prioridadIds) ? implode(',', $prioridadIds) : '0') . ") DESC")
    ->latest()
    ->paginate(15);

return view('asesor.mis-organizaciones', compact('entradas', 'asesores', 'charlasPendientes', 'prioridades'));
}

public function edit(EntradaConNota $entrada)
{
    $user = Auth::user();
    $asesor = \App\Models\Asesor::where('user_id', $user->id)->first();
    $nombreAsesor = $asesor ? $asesor->nombre . ' ' . $asesor->apellido : $user->name;

    $charlasPendientes = \App\Models\Charla::whereHas('entrada', fn($q) => $q->where('asesor_asignado', $nombreAsesor))
        ->where('estado', 'pendiente')
        ->whereNotNull('fecha_hora')
        ->where('fecha_hora', '>=', now())
        ->orderBy('fecha_hora')
        ->take(5)
        ->get();

    $entrada->load('charla');
    return view('asesor.edit', compact('entrada', 'charlasPendientes'));
}
}
