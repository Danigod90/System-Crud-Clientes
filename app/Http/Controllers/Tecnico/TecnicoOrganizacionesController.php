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

    // Las elecciones suspendidas siguen apareciendo en el listado general
    // ("Mis Organizaciones", sin filtro) para que el técnico las vea con
    // su marca en rojo. Solo se excluyen de los filtros que representan
    // trabajo PENDIENTE (Enviado a Técnica, Pendiente, Por Imprimir) —
    // ahí sí ya no corresponde hacer nada. "Impreso" y "Realizado" no se
    // tocan: si el trabajo ya se hizo antes de suspenderse, sigue siendo
    // un registro válido de trabajo terminado.
    if ($request->filled('estado')) {
        if ($request->estado === 'suspendida') {
            $query->where('eleccion_suspendida', true);
        } elseif (in_array($request->estado, ['enviado', 'pendiente', 'por_imprimir'])) {
            $query->where('eleccion_suspendida', false);
        }
    }

    if ($request->filled('organizacion')) {
        $query->where(function ($sub) use ($request) {
            $sub->where('nombre_organizacion', 'like', '%' . $request->organizacion . '%')
                ->orWhere('codigo_org', 'like', '%' . $request->organizacion . '%');
        });
    }

    if ($request->filled('asesor')) {
        $query->where('asesor_asignado', $request->asesor);
    }

    if ($request->filled('estado')) {
        if ($request->estado === 'enviado') {
            $query->whereHas('detalleTecnico', fn($q) => $q->where('enviado_tecnica', true));
        } elseif ($request->estado === 'pendiente') {
            $query->where(fn($q) => $q
                ->whereHas('detalleTecnico', fn($q) => $q->where('tec_realizado', false))
                ->orWhereDoesntHave('detalleTecnico')
            );
        } elseif ($request->estado === 'impreso') {
            $query->whereHas('detalleTecnico', fn($q) => $q->where('impreso', true));
        } elseif ($request->estado === 'por_imprimir') {
            $query->whereHas('detalleTecnico', fn($q) => $q->where('enviado_tecnica', true)->where('impreso', false));
        } elseif ($request->estado === 'sin_fecha') {
            $query->whereNull('fecha_eleccion');
        } elseif ($request->estado === 'realizado') {
            $query->whereHas('detalleTecnico', fn($q) => $q->where('tec_realizado', true));
        }
    }

    if ($request->filled('mes_ingreso')) {
        $query->whereRaw("DATE_FORMAT(created_at, '%Y-%m') = ?", [$request->mes_ingreso]);
    }

    $prioridadIds = \App\Models\PrioridadTecnica::orderBy('orden')->pluck('entrada_con_nota_id')->toArray();

    // Las prioridades manuales solo reordenan la vista general (sin filtros).
    // Con un filtro aplicado, se respeta el orden natural del filtro (evita
    // que una prioridad marcada "salte" por encima aunque no tenga que ver
    // con lo que se está filtrando).
    $hayFiltro = $request->filled('organizacion') || $request->filled('asesor')
        || $request->filled('estado') || $request->filled('mes_ingreso');

    if (!$hayFiltro) {
        $query->orderByRaw("FIELD(id, " . (count($prioridadIds) ? implode(',', $prioridadIds) : '0') . ") DESC");
    }

    // El orden por fecha de envío a técnica solo aplica cuando se filtra
    // puntualmente por "Enviado a técnica". El resto de los filtros (y la
    // vista general) mantienen el orden de siempre (fecha de entrada).
    if ($request->filled('estado') && $request->estado === 'enviado') {
        $query->orderBy(
            \App\Models\DetalleTecnico::select('enviado_tecnica_at')
                ->whereColumn('entrada_id', 'entradas_con_nota.id')
                ->limit(1),
            'desc'
        );
    } elseif ($request->filled('estado') && $request->estado === 'realizado') {
        $query->orderBy(
            \App\Models\DetalleTecnico::select('impreso_at')
                ->whereColumn('entrada_id', 'entradas_con_nota.id')
                ->limit(1),
            'desc'
        );
    }

    $entradas = $query
        ->latest()
        ->paginate(20)->withQueryString();
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

