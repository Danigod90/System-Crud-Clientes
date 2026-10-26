<?php
namespace App\Http\Controllers\Secretaria;

use App\Http\Controllers\Controller;
use App\Models\EntradaSinNota;
use App\Models\Asesor;
use Illuminate\Http\Request;

class EntradaSinNotaController extends Controller
{
    public function index(Request $request)
    {
        $query = EntradaSinNota::with('asesor');

        if ($request->filled('nombre')) {
            $query->where(function($q) use ($request) {
                $q->where('nombre_completo', 'like', '%' . $request->nombre . '%');
            });
        }

        if ($request->filled('asesor_id')) {
            $query->where('asesor_id', $request->asesor_id);
        }

        if ($request->filled('tipo_charla')) {
            $query->where('tipo_charla', $request->tipo_charla);
        }

        if ($request->filled('fecha_desde')) {
            $query->whereDate('created_at', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('created_at', '<=', $request->fecha_hasta);
        }

        $entradas = $query->latest()->paginate(10)->withQueryString();
        $asesores = Asesor::where('activo', true)->get();

        return view('secretaria.sin_nota.index', compact('entradas', 'asesores'));
    }

    public function create()
    {
        $asesores = Asesor::where('activo', true)->get();
        return view('secretaria.sin_nota.create', compact('asesores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'telefono'        => 'nullable|string|max:20',
            'tipo_charla'     => 'required|string|max:255',
            'asesor_id'       => 'nullable|exists:asesores,id',
        ]);

        EntradaSinNota::create([
            'nombre_completo' => $request->nombre_completo,
            'telefono'        => $request->telefono,
            'tipo_charla'     => $request->tipo_charla,
            'asesor_id'       => $request->asesor_id,
            'user_id'         => auth()->id(),
            'fecha'           => $request->fecha,
        ]);

        return redirect()->route('secretaria.sin-nota.index')
            ->with('success', 'Entrada registrada correctamente.');
    }

    public function show(EntradaSinNota $sinNota)
    {
        $sinNota->load('asesor');
        return view('secretaria.sin_nota.show', compact('sinNota'));
    }

    public function edit(EntradaSinNota $sinNota)
    {
        $asesores = Asesor::where('activo', true)->get();
        return view('secretaria.sin_nota.edit', compact('sinNota', 'asesores'));
    }

    public function update(Request $request, EntradaSinNota $sinNota)
    {
        $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'telefono'        => 'nullable|string|max:20',
            'tipo_charla'     => 'required|string|max:255',
            'asesor_id'       => 'nullable|exists:asesores,id',
            'fecha'           => 'nullable|date',
        ]);

        $sinNota->update([
            'nombre_completo' => $request->nombre_completo,
            'telefono'        => $request->telefono,
            'tipo_charla'     => $request->tipo_charla,
            'asesor_id'       => $request->asesor_id,
            'fecha'           => $request->fecha,
        ]);

        return redirect()->route('secretaria.sin-nota.show', $sinNota)
            ->with('success', 'Entrada actualizada correctamente.');
    }

    public function destroy(EntradaSinNota $sinNota)
    {
        $sinNota->delete();
        return redirect()->route('secretaria.sin-nota.index')
            ->with('success', 'Entrada eliminada correctamente.');
    }

    public function exportPdf(Request $request)
    {
        $query = EntradaSinNota::with('asesor');

        if ($request->filled('fecha_desde')) {
            $query->whereDate('created_at', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('created_at', '<=', $request->fecha_hasta);
        }

        if ($request->filled('asesor_id')) {
            $query->where('asesor_id', $request->asesor_id);
        }

        if ($request->filled('tipo_charla')) {
            $query->where('tipo_charla', $request->tipo_charla);
        }

        if ($request->filled('nombre')) {
            $query->where(function($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->nombre . '%')
                  ->orWhere('apellido', 'like', '%' . $request->nombre . '%');
            });
        }

        $entradas    = $query->latest()->get();
        $fecha_desde = $request->fecha_desde ?? 'inicio';
        $fecha_hasta = $request->fecha_hasta ?? now()->format('Y-m-d');
        $usuario     = 'Abg. ' . auth()->user()->name;

       if (request()->expectsJson()) {
    $html = view('secretaria.sin_nota.pdf', compact('entradas', 'fecha_desde', 'fecha_hasta', 'usuario'))->render();
    return response()->json(['html' => $html]);
}

$pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('secretaria.sin_nota.pdf', compact('entradas', 'fecha_desde', 'fecha_hasta', 'usuario'));
return $pdf->stream('reporte-entradas-sin-nota.pdf');
    }

    public function log(Request $request)
    {
        $pendientes = \App\Models\EntradaConNota::where(function($q) {
                $q->where('asunto_log', true)
                  ->orWhere('asunto_tec', true);
            })
            ->where('log_estado', 'pendiente')
            ->with(['logDevolucion', 'detalleTecnico'])
            ->latest()
            ->get();

        $entregados = \App\Models\EntradaConNota::where(function($q) {
                $q->where('asunto_log', true)
                  ->orWhere('asunto_tec', true);
            })
            ->where('log_estado', 'entregada')
            ->with(['logDevolucion', 'detalleTecnico'])
            ->latest()
            ->get();

        $devueltos = \App\Models\EntradaConNota::where('asunto_log', true)
            ->where('log_estado', 'realizado')
            ->with(['logDevolucion', 'detalleTecnico'])
            ->latest()
            ->get();

        return view('secretaria.sin_nota.log', compact('pendientes', 'entregados', 'devueltos'));
    }

    // ── Reporte de organizaciones con materiales entregados que todavía
    // ── no devolvieron — para hacer seguimiento/requerir la devolución.
    // Las más recientemente entregadas aparecen primero; las que llevan
    // más tiempo sin devolver quedan al final.
    public function reporteEntregadosPdf(Request $request)
    {
        // Solo asunto_log (o el combo log+tec) tiene materiales que devolver;
        // las organizaciones de solo técnica no cargan logística, así que no
        // corresponde que aparezcan en este reporte de devolución.
        $query = \App\Models\EntradaConNota::where('asunto_log', true)
            ->where('log_estado', 'entregada')
            ->with(['detalleTecnico']);

        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha_entrega', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha_entrega', '<=', $request->fecha_hasta);
        }

        $entregados = $query->orderByDesc('fecha_entrega')->get();

        $fecha_desde = $request->fecha_desde ?? 'inicio';
        $fecha_hasta = $request->fecha_hasta ?? now()->format('Y-m-d');
        $usuario     = 'Abg. ' . auth()->user()->name;

        if (request()->expectsJson()) {
            $html = view('secretaria.sin_nota.reporte-entregados-pdf', compact('entregados', 'fecha_desde', 'fecha_hasta', 'usuario'))->render();
            return response()->json(['html' => $html]);
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('secretaria.sin_nota.reporte-entregados-pdf', compact('entregados', 'fecha_desde', 'fecha_hasta', 'usuario'));
        return $pdf->stream('reporte-entregados-esperando-devolucion.pdf');
    }

    // ── Reporte de organizaciones que ya devolvieron los materiales.
    // Ordenado por fecha de devolución más reciente primero.
    public function reporteDevueltosPdf(Request $request)
    {
        $query = \App\Models\EntradaConNota::where('asunto_log', true)
            ->where('log_estado', 'realizado')
            ->with(['detalleTecnico', 'logDevolucion']);

        if ($request->filled('fecha_desde')) {
            $query->whereHas('logDevolucion', fn($q) => $q->whereDate('created_at', '>=', $request->fecha_desde));
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereHas('logDevolucion', fn($q) => $q->whereDate('created_at', '<=', $request->fecha_hasta));
        }

        $devueltos = $query->get()
            ->sortByDesc(fn($e) => $e->logDevolucion?->created_at)
            ->values();

        $fecha_desde = $request->fecha_desde ?? 'inicio';
        $fecha_hasta = $request->fecha_hasta ?? now()->format('Y-m-d');
        $usuario     = 'Abg. ' . auth()->user()->name;

        if (request()->expectsJson()) {
            $html = view('secretaria.sin_nota.reporte-devueltos-pdf', compact('devueltos', 'fecha_desde', 'fecha_hasta', 'usuario'))->render();
            return response()->json(['html' => $html]);
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('secretaria.sin_nota.reporte-devueltos-pdf', compact('devueltos', 'fecha_desde', 'fecha_hasta', 'usuario'));
        return $pdf->stream('reporte-devueltos.pdf');
    }

    // ── Resumen para el gadget P / D de la barra superior ──
    // P = organizaciones con log ya entregado; D = ya devueltas.
    // Cuenta organizaciones; las unidades (urnas/cuartos/tintas) van al tooltip.
    public function resumenLog()
    {
        $ini = now()->startOfMonth();
        $fin = now()->endOfMonth();

        $prestados = \App\Models\EntradaConNota::where('asunto_log', true)
            ->whereIn('log_estado', ['entregada', 'realizado'])
            ->with('detalleTecnico')
            ->get();

        $devueltos = \App\Models\EntradaConNota::where('asunto_log', true)
            ->where('log_estado', 'realizado')
            ->with('logDevolucion')
            ->get();

        // Cantidades entregadas (mismo criterio que Gestión de Log)
        $entregadas = function ($e, string $campoTec, string $campoLog): int {
            $usaTec = $e->asunto_tec && !$e->logConCantidadesReales();
            $deTec  = $usaTec ? $e->detalleTecnico?->{$campoTec} : null;
            return (int) ($deTec ?? $e->{$campoLog} ?? 0);
        };

        $resumenP = fn($col) => [
            'n'       => $col->count(),
            'urnas'   => $col->sum(fn($e) => $entregadas($e, 'mat_final_urnas', 'log_urnas')),
            'cuartos' => $col->sum(fn($e) => $entregadas($e, 'mat_final_cuartos', 'log_cuartos')),
            'tintas'  => $col->sum(fn($e) => $entregadas($e, 'mat_final_tintas', 'log_tintas')),
        ];
        $resumenD = fn($col) => [
            'n'       => $col->count(),
            'urnas'   => (int) $col->sum(fn($e) => $e->logDevolucion?->urnas_devueltas ?? 0),
            'cuartos' => (int) $col->sum(fn($e) => $e->logDevolucion?->cuartos_devueltos ?? 0),
            'tintas'  => (int) $col->sum(fn($e) => $e->logDevolucion?->tintas_devueltas ?? 0),
        ];

        $pMes = $prestados->filter(fn($e) => $e->fecha_entrega && $e->fecha_entrega->between($ini, $fin));
        $dMes = $devueltos->filter(fn($e) => $e->logDevolucion?->created_at?->between($ini, $fin));

        $pTotal = $resumenP($prestados);
        $dTotal = $resumenD($devueltos);

        return response()->json([
            'p_mes'   => $resumenP($pMes),
            'p_total' => $pTotal,
            'd_mes'   => $resumenD($dMes),
            'd_total' => $dTotal,
            // Lo que todavía no volvió (siempre sobre el total acumulado)
            'falta'   => [
                'urnas'   => max(0, $pTotal['urnas']   - $dTotal['urnas']),
                'cuartos' => max(0, $pTotal['cuartos'] - $dTotal['cuartos']),
                'tintas'  => max(0, $pTotal['tintas']  - $dTotal['tintas']),
            ],
        ]);
    }

    public function storeDevolucion(Request $request, $id)
    {
        $request->validate([
            'devuelto_por'      => 'required|string|max:255',
            'urnas_devueltas'   => 'required|integer|min:0',
            'cuartos_devueltos' => 'required|integer|min:0',
            'tintas_devueltas'  => 'required|integer|min:0',
            'observaciones'     => 'nullable|string',
        ]);

        $entrada = \App\Models\EntradaConNota::findOrFail($id);

        \App\Models\LogDevolucion::create([
            'entrada_id'        => $entrada->id,
            'devuelto_por'      => $request->devuelto_por,
            'urnas_devueltas'   => $request->urnas_devueltas,
            'cuartos_devueltos' => $request->cuartos_devueltos,
            'tintas_devueltas'  => $request->tintas_devueltas,
            'observaciones'     => $request->observaciones,
            'user_id'           => auth()->id(),
        ]);

        $entrada->update(['log_estado' => 'realizado']);

        return redirect()->route('secretaria.sin-nota.log')
            ->with('success', 'Devolución registrada correctamente.');
    }

    // ── Registra la entrega con funcionario y fecha ──────────
    public function entregar(Request $request, $id)
{
    $request->validate([
        'entregado_por'   => 'required|string|max:255',
        'fecha_entrega'   => 'required|date',
        'persona_retira'  => 'required|string|max:255',
        'telefono_retira' => 'required|string|max:30',
    ]);

    $entrada = \App\Models\EntradaConNota::findOrFail($id);

    // Evita duplicados si el formulario se envía más de una vez (doble clic,
    // reintento de red, "volver atrás" del navegador, etc.)
    if ($entrada->log_estado === 'entregada') {
        return redirect()->route('secretaria.sin-nota.log')
            ->with('success', 'Esta entrega ya había sido registrada.');
    }

    $entrada->update([
        'log_estado'      => 'entregada',
        'entregado_por'   => $request->entregado_por,
        'fecha_entrega'   => $request->fecha_entrega,
        'persona_retira'  => $request->persona_retira,
        'telefono_retira' => $request->telefono_retira,
    ]);

    // Crear registro en PDF de servicios realizados
    $asesor = \App\Models\Asesor::whereRaw("CONCAT(nombre, ' ', apellido) = ?", [$entrada->asesor_asignado])->first();

    EntradaSinNota::create([
        'numero_entrada'  => $entrada->codigo_org,
        'nombre_completo' => $entrada->nombre_organizacion,
        'telefono'        => $entrada->telefono_representante ?? null,
        'tipo_charla'     => 'Materiales Entregados',
        'asesor_id'       => $asesor?->id,
        'user_id'         => auth()->id(),
        'fecha'           => \Carbon\Carbon::parse($request->fecha_entrega)->format('Y-m-d'),
    ]);

    return redirect()->route('secretaria.sin-nota.log')
        ->with('success', 'Entrega registrada correctamente.');
}

    // ── Edita funcionario y fecha de una entrega ya registrada
    public function editarEntrega(Request $request, $id)
    {
        $request->validate([
            'entregado_por'   => 'required|string|max:255',
            'fecha_entrega'   => 'required|date',
            'persona_retira'  => 'required|string|max:255',
            'telefono_retira' => 'required|string|max:30',
        ]);

        $entrada = \App\Models\EntradaConNota::findOrFail($id);

        $entrada->update([
            'entregado_por'   => $request->entregado_por,
            'fecha_entrega'   => $request->fecha_entrega,
            'persona_retira'  => $request->persona_retira,
            'telefono_retira' => $request->telefono_retira,
        ]);

        return redirect()->route('secretaria.sin-nota.log')
            ->with('success', 'Datos de entrega actualizados correctamente.');
    }

    // ── Imprime logística (solo LOG) guardando funcionario/fecha
    // ── Reimpresión de solo lectura del recibo (Gestión de Log) ──
    // No guarda nada: no cambia estados, fechas, funcionario ni notifica.
    // Sirve para volver a sacar el recibo si, por ejemplo, falló la impresora.
    public function reimprimirRecibo($id)
    {
        $entrada = \App\Models\EntradaConNota::with('detalleTecnico')->findOrFail($id);

        // Recibo completo de técnica: org solo técnica, o log + tec con
        // técnica ya realizada. En cualquier otro caso, el de logística.
        $usaTecnica = $entrada->asunto_tec
            && $entrada->detalleTecnico
            && (!$entrada->asunto_log || $entrada->detalleTecnico->tec_realizado);

        if ($usaTecnica) {
            return app(\App\Http\Controllers\DetalleTecnicoController::class)
                ->imprimirLogistica($entrada->id, false);
        }

        abort_unless($entrada->asunto_log, 404);

        return (new NotaPdfController())->reciboLogistica($entrada, false);
    }

  public function imprimirLogistica(Request $request, $id)
{
    $request->validate([
        'entregado_por'   => 'nullable|string|max:255',
        'fecha_entrega'   => 'required|date',
        'persona_retira'  => 'required|string|max:255',
        'telefono_retira' => 'required|string|max:30',
        'log_urnas'       => 'nullable|integer|min:0',
        'log_cuartos'     => 'nullable|integer|min:0',
        'log_tintas'      => 'nullable|integer|min:0',
    ]);

    $entrada = \App\Models\EntradaConNota::findOrFail($id);

    // Este botón se puede volver a usar después de entregado (para
    // reimprimir el recibo), así que no bloqueamos la acción completa como
    // en "Entregar" — pero el registro del reporte de "Materiales
    // Entregados" solo debe crearse la primera vez, si no, cada reimpresión
    // (o un doble clic) generaría uno nuevo.
    // Ojo: log_impreso_at también lo marca la impresión del recibo de técnica,
    // así que "ya entregado" se decide por log_estado.
    $yaImpreso = $entrada->logYaEntregado();

    // Desde Gestión de Log (Secretaria Sin Nota) se pide el nombre a mano,
    // porque quien opera el sistema puede no ser quien entrega físicamente.
    // Desde el perfil del asesor o secretaria con nota, en cambio, no se
    // manda ese dato y se toma directo de la sesión (es la misma persona).
    $datosActualizar = [
        'entregado_por'   => $request->filled('entregado_por') ? $request->entregado_por : auth()->user()->name,
        'fecha_entrega'   => $request->fecha_entrega,
        'persona_retira'  => $request->persona_retira,
        'telefono_retira' => $request->telefono_retira,
        'log_impreso_at'  => $entrada->log_impreso_at ?? now(),
        // "log_estado" es el estado combinado que también usa Gestión de Log
        // para el seguimiento de Técnica (entregarTec también lo pone en
        // 'entregada'). Lo marcamos "entregada" siempre, aunque la org tenga
        // también asunto_tec: los materiales de técnica no se devuelven, así
        // que el combo puede pasar directo a "Entregados — esperando
        // devolución" (de la parte log) en cuanto ésta se entrega. El avance
        // de técnica se sigue controlando por su cuenta en otro lado
        // (detalleTecnico->tec_realizado), no depende de este campo.
        'log_estado'      => 'entregada',
    ];

    // Log de Urgencia: permite cargar las cantidades en el mismo paso,
    // para cuando todavía no se cargaron por el formulario normal.
    if ($request->filled('log_urnas'))   $datosActualizar['log_urnas']   = (int) $request->log_urnas;
    if ($request->filled('log_cuartos')) $datosActualizar['log_cuartos'] = (int) $request->log_cuartos;
    if ($request->filled('log_tintas'))  $datosActualizar['log_tintas']  = (int) $request->log_tintas;

    $entrada->update($datosActualizar);

    if (!$yaImpreso) {
    $asesor = \App\Models\Asesor::whereRaw("CONCAT(nombre, ' ', apellido) = ?", [$entrada->asesor_asignado])->first();

    EntradaSinNota::create([
        'numero_entrada'  => $entrada->codigo_org,
        'nombre_completo' => $entrada->nombre_organizacion,
        'telefono'        => $entrada->telefono_representante ?? null,
        'tipo_charla'     => 'Materiales Entregados',
        'asesor_id'       => $asesor?->id,
        'user_id'         => auth()->id(),
        'fecha'           => \Carbon\Carbon::parse($request->fecha_entrega)->format('Y-m-d'),
    ]);
    }

    // Log + Tec con técnica ya realizada: lo que se imprime es el recibo
    // completo de técnica (con la sección de logística ya con los datos
    // reales de esta entrega). Si técnica sigue pendiente, solo el de log.
    if ($entrada->asunto_log && $entrada->asunto_tec && $entrada->detalleTecnico?->tec_realizado) {
        return app(\App\Http\Controllers\DetalleTecnicoController::class)->imprimirLogistica($entrada->id);
    }

    $notaPdfController = new NotaPdfController();
    return $notaPdfController->reciboLogistica($entrada);
}
}
