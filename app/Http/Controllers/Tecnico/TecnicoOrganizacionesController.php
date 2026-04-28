<?php

namespace App\Http\Controllers\Tecnico;

use App\Http\Controllers\Controller;
use App\Models\EntradaConNota;
use Illuminate\Http\Request;

class TecnicoOrganizacionesController extends Controller
{
    public function index(Request $request)
{
    $query = EntradaConNota::with(['detalleTecnico'])
        ->where('asunto_tec', true);

    if ($request->filled('organizacion')) {
        $query->where('nombre_organizacion', 'like', '%' . $request->organizacion . '%');
    }

    if ($request->filled('asesor')) {
        $query->where('asesor_asignado', $request->asesor);
    }

    if ($request->filled('estado')) {
        if ($request->estado === 'enviado') {
            $query->whereHas('detalleTecnico', fn($q) => $q->where('enviado_tecnica', true));
        } elseif ($request->estado === 'pendiente') {
    $query->whereHas('detalleTecnico', fn($q) => $q->where('tec_realizado', false)->orWhereNull('tec_realizado'));
} elseif ($request->estado === 'impreso') {
            $query->whereHas('detalleTecnico', fn($q) => $q->where('impreso', true));
        }

    }

    if ($request->filled('mes_ingreso')) {
        $query->whereRaw("DATE_FORMAT(created_at, '%Y-%m') = ?", [$request->mes_ingreso]);
    }

   $prioridadIds = \App\Models\PrioridadTecnica::orderBy('orden')->pluck('entrada_con_nota_id')->toArray();

$entradas = $query->orderByRaw("FIELD(id, " . (count($prioridadIds) ? implode(',', $prioridadIds) : '0') . ") DESC")
    ->latest()
    ->paginate(20)
    ->withQueryString();
    $asesores = \App\Models\Asesor::orderBy('nombre')->get();

    $prioridades = \App\Models\PrioridadTecnica::all();
return view('tecnico.organizaciones_tecnico', compact('entradas', 'asesores', 'prioridades'));
}

public function edit($entrada_id)
{
    $entrada = EntradaConNota::with(['detalleTecnico'])->findOrFail($entrada_id);
    return view('tecnico.edit_tecnico', compact('entrada'));
}

}

