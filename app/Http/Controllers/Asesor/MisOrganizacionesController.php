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
        $query->where(function($sub) {
            $sub->where('nombre_organizacion', 'like', '%' . request('organizacion') . '%')
                ->orWhere('codigo_org', 'like', '%' . request('organizacion') . '%');
        });
    }
    if (request('asunto')) {
        $asunto = request('asunto');
        if (in_array($asunto, ['char_realizada', 'char_pendiente', 'char_suspendida', 'char_cancelada'])) {
            $estado = str_replace('char_', '', $asunto);
            $query->where('asunto_char', true)
                  ->whereHas('charla', fn($q) => $q->where('estado', $estado));
        } elseif ($asunto === 'suspendida') {
            $query->where('eleccion_suspendida', 1);
        } elseif ($asunto === 'tec_sin_enviar') {
            $query->where('asunto_tec', true)
                  ->where(fn($q) => $q
                      ->whereDoesntHave('detalleTecnico')
                      ->orWhereHas('detalleTecnico', fn($q) => $q->where('enviado_tecnica', false)->orWhereNull('enviado_tecnica'))
                  );
        } elseif ($asunto === 'tec_pendiente') {
            $query->where('asunto_tec', true)
                  ->where(fn($q) => $q
                      ->whereHas('detalleTecnico', fn($q) => $q->where('tec_realizado', false))
                      ->orWhereDoesntHave('detalleTecnico')
                  );
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
    if (request('sin_fecha')) {
        $query->whereNull('fecha_eleccion');
    }

    $charlasPendientes = EntradaConNota::where('asesor_asignado', $nombreAsesor)
        ->where('asunto_char', true)
        ->where(fn($q) => $q
            ->whereDoesntHave('charla')
            ->orWhereHas('charla', fn($q2) => $q2->whereIn('estado', ['pendiente', 'vencida']))
        )
        ->with('charla')
        ->orderByRaw("(SELECT fecha_hora FROM charlas WHERE charlas.entrada_con_nota_id = entradas_con_nota.id ORDER BY charlas.created_at ASC LIMIT 1) IS NULL")
        ->orderBy(
            \App\Models\Charla::select('fecha_hora')
                ->whereColumn('entrada_con_nota_id', 'entradas_con_nota.id')
                ->oldest()
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
        ->orderByRaw("(SELECT fecha_hora FROM observadores WHERE observadores.entrada_con_nota_id = entradas_con_nota.id LIMIT 1) IS NULL")
        ->orderBy(
            \App\Models\Observador::select('fecha_hora')
                ->whereColumn('entrada_con_nota_id', 'entradas_con_nota.id')
                ->limit(1)
        )
        ->take(5)
        ->get();

    $prioridades = \App\Models\PrioridadAsesor::where('user_id', $user->id)->get();

    $prioridadIds = $prioridades->pluck('entrada_con_nota_id')->toArray();

    // Las prioridades manuales solo reordenan la vista general (sin filtros).
    // Con un filtro aplicado, se respeta el orden natural del filtro.
    $hayFiltro = request('organizacion') || request('asunto') || request('mes_ingreso')
        || request('mes_eleccion') || request('estado_charla') || request('sin_fecha');

    if (!$hayFiltro) {
        $query->orderByRaw("FIELD(id, " . (count($prioridadIds) ? implode(',', $prioridadIds) : '0') . ") DESC");
    }

    $entradas = $query->latest()->paginate(15)->withQueryString();

    return view('asesor.mis-organizaciones', compact('entradas', 'asesores', 'charlasPendientes', 'observadoresPendientes', 'prioridades'));
}
public function edit(EntradaConNota $entrada)
{
    $user = Auth::user();
    $asesor = \App\Models\Asesor::where('user_id', $user->id)->first();
    $nombreAsesor = $asesor ? $asesor->nombre . ' ' . $asesor->apellido : $user->name;

    $charlasPendientes = EntradaConNota::where('asesor_asignado', $nombreAsesor)
        ->where('asunto_char', true)
        ->where(fn($q) => $q
            ->whereDoesntHave('charla')
            ->orWhereHas('charla', fn($q2) => $q2->whereIn('estado', ['pendiente', 'vencida']))
        )
        ->with('charla')
        ->orderByRaw("(SELECT fecha_hora FROM charlas WHERE charlas.entrada_con_nota_id = entradas_con_nota.id ORDER BY charlas.created_at ASC LIMIT 1) IS NULL")
        ->orderBy(
            \App\Models\Charla::select('fecha_hora')
                ->whereColumn('entrada_con_nota_id', 'entradas_con_nota.id')
                ->oldest()
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
        ->orderByRaw("(SELECT fecha_hora FROM observadores WHERE observadores.entrada_con_nota_id = entradas_con_nota.id LIMIT 1) IS NULL")
        ->orderBy(
            \App\Models\Observador::select('fecha_hora')
                ->whereColumn('entrada_con_nota_id', 'entradas_con_nota.id')
                ->limit(1)
        )
        ->take(5)
        ->get();

    $entrada->load('charla', 'documentos.user');
    return view('asesor.edit', compact('entrada', 'charlasPendientes', 'observadoresPendientes'));
}
}
