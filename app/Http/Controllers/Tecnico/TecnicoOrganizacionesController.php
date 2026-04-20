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
            $query->whereDoesntHave('detalleTecnico', fn($q) => $q->where('enviado_tecnica', true));
        } elseif ($request->estado === 'impreso') {
            $query->whereHas('detalleTecnico', fn($q) => $q->where('impreso', true));
        }

    }

    if ($request->filled('mes_ingreso')) {
        $query->whereRaw("DATE_FORMAT(created_at, '%Y-%m') = ?", [$request->mes_ingreso]);
    }

    $entradas = $query->latest()->paginate(20)->withQueryString();
    $asesores = \App\Models\Asesor::orderBy('nombre')->get();

    return view('tecnico.organizaciones_tecnico', compact('entradas', 'asesores'));
}

public function edit($entrada_id)
{
    $entrada = EntradaConNota::with(['detalleTecnico'])->findOrFail($entrada_id);
    return view('tecnico.edit_tecnico', compact('entrada'));
}

}

