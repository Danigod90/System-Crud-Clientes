<?php

namespace App\Http\Controllers\Secretaria;

use App\Http\Controllers\Controller;
use App\Models\EntradaConNota;
use App\Models\Asesor;
use Illuminate\Http\Request;

class EntradaConNotaController extends Controller
{
    public function index(Request $request)
    {
        $asesores = Asesor::orderBy('nombre')->get();

        $entradas = EntradaConNota::with(['user', 'charla'])
            ->when($request->organizacion, fn($q) =>
                $q->where('nombre_organizacion', 'like', '%' . $request->organizacion . '%')
            )
            ->when($request->asesor, fn($q) =>
                $q->where('asesor_asignado', $request->asesor)
            )
            ->when($request->asunto, function($q) use ($request) {
    $asunto = $request->asunto;
    if (in_array($asunto, ['char_realizada', 'char_pendiente', 'char_suspendida', 'char_cancelada'])) {
        $estado = str_replace('char_', '', $asunto);
        $q->where('asunto_char', true)
          ->whereHas('charla', fn($q) => $q->where('estado', $estado));
    } elseif ($asunto === 'char') {
        $q->where('asunto_char', true);
    } elseif ($asunto === 'log') {
        $q->where('asunto_log', true);
    } elseif ($asunto === 'tec') {
        $q->where('asunto_tec', true);
    } elseif ($asunto === 'obs') {
        $q->where('asunto_obs', true);
    } elseif ($asunto === 'suspendida') {
        $q->where('eleccion_suspendida', 1);
    }
})


            ->when($request->mes_ingreso, fn($q) =>
                $q->whereYear('created_at', substr($request->mes_ingreso, 0, 4))
                  ->whereMonth('created_at', substr($request->mes_ingreso, 5, 2))
            )
            ->when($request->mes_eleccion, fn($q) =>
                $q->whereYear('fecha_eleccion', substr($request->mes_eleccion, 0, 4))
                  ->whereMonth('fecha_eleccion', substr($request->mes_eleccion, 5, 2))
            )
            ->latest()
->paginate(10)->withQueryString();

$charlasPendientes = \App\Models\Charla::with('entrada')
    ->where('estado', 'pendiente')
    ->whereNotNull('fecha_hora')
    ->where('fecha_hora', '>=', now())
    ->orderBy('fecha_hora')
    ->take(5)
    ->get();

return view('secretaria.con_nota.index', compact('entradas', 'asesores', 'charlasPendientes'));

    }

    public function create()
    {
        $asesores = Asesor::orderBy('nombre')->get();
        $tipos = \App\Models\TipoOrganizacion::orderBy('nombre')->get();
        return view('secretaria.con_nota.create', compact('asesores', 'tipos'));
    }

   public function store(Request $request)
{
   $request->validate([
    'nombre_organizacion'    => 'required|string|max:255',
    'tipo_organizacion'      => 'required|string|max:255',
    'nombre_representante'   => 'required|string|max:255',
    'telefono_representante' => 'nullable|string|max:50',
    'fecha_eleccion'         => 'nullable|date',
    'asesor_asignado'        => 'required|string|max:255',
    'via_ingreso'            => 'required|in:correo,presencial',
    'asunto'                 => 'required|array|min:1',
    'asunto.*'               => 'in:char,log,tec,obs',
    'direccion'              => 'nullable|string|max:255',
]);

    $entrada = EntradaConNota::create([
        'nombre_organizacion'    => $request->nombre_organizacion,
        'tipo_organizacion'      => $request->tipo_organizacion,
        'nombre_representante'   => $request->nombre_representante,
        'telefono_representante' => $request->telefono_representante,
        'fecha_eleccion'         => $request->fecha_eleccion,
        'asesor_asignado'        => $request->asesor_asignado,
        'via_ingreso'            => $request->via_ingreso,
        'asunto_char'            => in_array('char', $request->asunto),
        'asunto_log'             => in_array('log', $request->asunto),
        'asunto_tec'             => in_array('tec', $request->asunto),
        'log_urnas'              => in_array('log', $request->asunto) ? (int)$request->log_urnas : 0,
        'log_cuartos'            => in_array('log', $request->asunto) ? (int)$request->log_cuartos : 0,
        'log_tintas'             => in_array('log', $request->asunto) ? (int)$request->log_tintas : 0,
        'user_id'                => auth()->id(),
        'asunto_obs'             => in_array('obs', $request->asunto),
        'direccion'     => $request->direccion,
    ]);
// Notificaciones según rol
if (auth()->user()->hasRole('Asesor')) {
    $secretarias = \App\Models\User::role('Secretaria Con Nota')->get();
    foreach ($secretarias as $secretaria) {
        $secretaria->notify(new \App\Notifications\TrabajoPendienteNotification(
            'Nueva entrada: ' . $request->nombre_organizacion . ' cargada por ' . auth()->user()->name,
            'Mesa de Entrada',
            $entrada->id
        ));
        if ($secretaria->notifications()->count() > 8) {
            $secretaria->notifications()->latest()->skip(8)->take(100)->delete();
        }
    }
    return redirect()->route('asesor.organizacion.edit', $entrada)
        ->with('success', 'Mesa de entrada registrada correctamente.');
} else {
    $asesor = \App\Models\Asesor::whereRaw("CONCAT(nombre, ' ', apellido) = ?", [$request->asesor_asignado])->first();
    if ($asesor && $asesor->user_id) {
        $usuario = \App\Models\User::find($asesor->user_id);
        $usuario?->notify(new \App\Notifications\TrabajoPendienteNotification(
            'Nueva entrada asignada: ' . $request->nombre_organizacion,
            'Mis Organizaciones',
            $entrada->id
        ));
        if ($usuario && $usuario->notifications()->count() > 8) {
            $usuario->notifications()->latest()->skip(8)->take(100)->delete();
        }
    }

    // Notificar al Supervisor
    $supervisores = \App\Models\User::role('Supervisor')->get();
    foreach ($supervisores as $supervisor) {
        $supervisor->notify(new \App\Notifications\TrabajoPendienteNotification(
            'Nueva entrada: ' . $request->nombre_organizacion,
            'Mis Organizaciones',
            $entrada->id
        ));
        if ($supervisor->notifications()->count() > 8) {
            $supervisor->notifications()->latest()->skip(8)->take(100)->delete();
        }
    }

    return redirect()->route('secretaria.con-nota.show', $entrada)
        ->with('success', 'Mesa de entrada registrada correctamente.');
}
}
    public function show(EntradaConNota $conNota)
{
    $conNota->load(['charlas', 'charla', 'detalleTecnico', 'observador', 'documentos.user']);

    $charlasPendientes = \App\Models\Charla::with('entrada')
        ->where('estado', 'pendiente')
        ->whereNotNull('fecha_hora')
        ->where('fecha_hora', '>=', now())
        ->orderBy('fecha_hora')
        ->take(5)
        ->get();

    return view('secretaria.con_nota.show', compact('conNota', 'charlasPendientes'));
}

    public function edit(EntradaConNota $conNota)
    {
        $asesores = Asesor::orderBy('nombre')->get();
        $tipos = \App\Models\TipoOrganizacion::orderBy('nombre')->get();
        return view('secretaria.con_nota.edit', compact('conNota', 'asesores', 'tipos'));
    }

    public function update(Request $request, EntradaConNota $conNota)
    {
        $request->validate([
            'nombre_organizacion'    => 'required|string|max:255',
            'tipo_organizacion'      => 'required|string|max:255',
            'nombre_representante'   => 'required|string|max:255',
            'telefono_representante' => 'nullable|string|max:50',
            'fecha_eleccion'         => 'nullable|date',
            'asesor_asignado'        => 'required|string|max:255',
            'via_ingreso'            => 'required|in:correo,presencial',
            'asunto'                 => 'required|array|min:1',
            'asunto.*'               => 'in:char,log,tec,obs',
            'direccion' => 'nullable|string|max:255',
        ]);

        $conNota->update([
            'nombre_organizacion'    => $request->nombre_organizacion,
            'tipo_organizacion'      => $request->tipo_organizacion,
            'nombre_representante'   => $request->nombre_representante,
            'telefono_representante' => $request->telefono_representante,
            'fecha_eleccion'         => $request->fecha_eleccion,
            'asesor_asignado'        => $request->asesor_asignado,
            'via_ingreso'            => $request->via_ingreso,
            'asunto_char'            => in_array('char', $request->asunto ?? []),
            'asunto_log'             => in_array('log', $request->asunto ?? []),
            'asunto_tec'             => in_array('tec', $request->asunto ?? []),
            'log_urnas'              => in_array('log', $request->asunto ?? []) ? (int)$request->log_urnas : 0,
            'log_cuartos'            => in_array('log', $request->asunto ?? []) ? (int)$request->log_cuartos : 0,
            'log_tintas'             => in_array('log', $request->asunto ?? []) ? (int)$request->log_tintas : 0,
            'asunto_obs'             => in_array('obs', $request->asunto ?? []),
            'direccion'             => $request->direccion,
        ]);

       if ($request->from === 'asesor') {
    return redirect()->route('asesor.organizacion.edit', $conNota->id)
        ->with('success', 'Entrada actualizada correctamente.');
}

        return redirect()->route('secretaria.con-nota.show', $conNota)
            ->with('success', 'Entrada actualizada correctamente.');
    }

    public function destroy(EntradaConNota $conNota)
    {
        $nombre = $conNota->nombre_organizacion;
        $codigo = $conNota->codigo_org;
        $conNota->delete();
        return redirect()->route('secretaria.con-nota.index')
            ->with('error', 'Se elimino la entrada ' . $codigo . ' — ' . $nombre . '.');
    }

    public function entregarLog(EntradaConNota $conNota)
{
    $conNota->update(['log_estado' => 'entregada']);

    $asesor = \App\Models\Asesor::whereRaw("CONCAT(nombre, ' ', apellido) = ?", [$conNota->asesor_asignado])->first();

    \App\Models\EntradaSinNota::create([
    'nombre_completo' => $conNota->nombre_organizacion,
    'tipo_charla'     => 'Materiales Entregados',
    'asesor_id'       => $asesor?->id,
    'user_id'         => auth()->id(),
]);

    return redirect()->route('secretaria.con-nota.show', $conNota)
        ->with('success', 'Logística entregada — ' . $conNota->codigo_org);
}
    public function toggleTicker(EntradaConNota $conNota)
{
    $conNota->update(['mostrar_en_ticker' => !$conNota->mostrar_en_ticker]);
    $conNota->refresh();
    return response()->json(['mostrar_en_ticker' => $conNota->mostrar_en_ticker]);
}
public function entregarTec(EntradaConNota $conNota)
{
    $conNota->update(['log_estado' => 'entregada']);

    $asesor = \App\Models\Asesor::whereRaw("CONCAT(nombre, ' ', apellido) = ?", [$conNota->asesor_asignado])->first();

    \App\Models\EntradaSinNota::create([
    'nombre_completo' => $conNota->nombre_organizacion,
    'tipo_charla'     => 'Materiales Entregados',
    'asesor_id'       => $asesor?->id,
    'user_id'         => auth()->id(),
]);

    return redirect()->back()->with('success', 'Marcado como entregado correctamente.');
}
public function exportPdf(Request $request)
{
    $entradas = EntradaConNota::with(['charla'])
        ->when($request->organizacion, fn($q) =>
            $q->where('nombre_organizacion', 'like', '%' . $request->organizacion . '%')
        )
        ->when($request->asesor, fn($q) =>
            $q->where('asesor_asignado', $request->asesor)
        )
        ->when($request->asunto, function($q) use ($request) {
            $asunto = $request->asunto;
            if (in_array($asunto, ['char_realizada', 'char_pendiente', 'char_suspendida', 'char_cancelada'])) {
                $estado = str_replace('char_', '', $asunto);
                $q->where('asunto_char', true)
                  ->whereHas('charla', fn($q) => $q->where('estado', $estado));
            } elseif ($asunto === 'char') { $q->where('asunto_char', true); }
            elseif ($asunto === 'log')    { $q->where('asunto_log', true); }
            elseif ($asunto === 'tec')    { $q->where('asunto_tec', true); }
            elseif ($asunto === 'obs')    { $q->where('asunto_obs', true); }
            elseif ($asunto === 'suspendida') { $q->where('eleccion_suspendida', 1); }

        })
        ->when($request->mes_ingreso, fn($q) =>
            $q->whereYear('created_at', substr($request->mes_ingreso, 0, 4))
              ->whereMonth('created_at', substr($request->mes_ingreso, 5, 2))
        )
        ->when($request->mes_eleccion, fn($q) =>
            $q->whereYear('fecha_eleccion', substr($request->mes_eleccion, 0, 4))
              ->whereMonth('fecha_eleccion', substr($request->mes_eleccion, 5, 2))
        )
        ->latest()
        ->get();

    $fecha      = now()->format('d/m/Y H:i');
    $logoPath   = public_path('images/logo.png');
    $logoBase64 = base64_encode(file_get_contents($logoPath));
    $logoSrc    = 'data:image/png;base64,' . $logoBase64;

    // Descripción del filtro activo
    $filtros = [];
    if ($request->organizacion) $filtros[] = 'Org: ' . $request->organizacion;
    if ($request->asesor)       $filtros[] = 'Asesor: ' . $request->asesor;
    if ($request->asunto)       $filtros[] = 'Asunto: ' . strtoupper($request->asunto);
    if ($request->mes_ingreso) {
    $meses = ['01'=>'Enero','02'=>'Febrero','03'=>'Marzo','04'=>'Abril','05'=>'Mayo','06'=>'Junio','07'=>'Julio','08'=>'Agosto','09'=>'Septiembre','10'=>'Octubre','11'=>'Noviembre','12'=>'Diciembre'];
    $partes = explode('-', $request->mes_ingreso);
    $filtros[] = 'Ingreso: ' . $partes[0] . '-' . ($meses[$partes[1]] ?? $partes[1]);
}
    if ($request->mes_eleccion) {
    $meses = ['01'=>'Enero','02'=>'Febrero','03'=>'Marzo','04'=>'Abril','05'=>'Mayo','06'=>'Junio','07'=>'Julio','08'=>'Agosto','09'=>'Septiembre','10'=>'Octubre','11'=>'Noviembre','12'=>'Diciembre'];
    $partes = explode('-', $request->mes_eleccion);
    $filtros[] = 'Elección: ' . $partes[0] . '-' . ($meses[$partes[1]] ?? $partes[1]);
}
    $filtroTexto = count($filtros) ? implode(' · ', $filtros) : 'Sin filtros — listado completo';

    $filas = '';
    foreach ($entradas as $e) {
        $asunto = collect([
            $e->asunto_char ? 'Char' : null,
            $e->asunto_log  ? 'Log'  : null,
            $e->asunto_tec  ? 'Tec'  : null,
            $e->asunto_obs  ? 'Obs'  : null,
        ])->filter()->implode(' · ');

        $filas .= '
        <tr>
            <td>' . htmlspecialchars($e->codigo_org) . '</td>
            <td>' . htmlspecialchars($e->nombre_organizacion) . '</td>
            <td>' . htmlspecialchars($e->asesor_asignado ?? '—') . '</td>
            <td style="text-align:center;">' . ($e->fecha_eleccion ? $e->fecha_eleccion->format('d/m/Y') : '—') . '</td>
            <td style="text-align:center;">' . $asunto . '</td>
        </tr>';
    }

    $html = '
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 10px; color: #000; margin: 20px 30px; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        .header { display:flex; align-items:center; gap:12px; border-bottom:3px solid #1e3a5f; padding-bottom:8px; margin-bottom:10px; }
        .inst h1 { font-size:12px; font-weight:700; margin:0 0 2px; text-transform:uppercase; color:#1e3a5f; }
        .inst p  { font-size:8px; color:#555; margin:0; }
        .filtro  { font-size:9px; color:#555; margin-bottom:10px; border:1px solid #e5e7eb; padding:5px 8px; border-radius:4px; background:#f9fafb; }
        .total   { font-size:9px; font-weight:700; color:#1e3a5f; margin-bottom:8px; }
        table    { width:100%; border-collapse:collapse; }
       thead tr { background:#1e3a5f; color:#fff; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        thead th { padding:6px 8px; font-size:9px; text-align:left; text-transform:uppercase; letter-spacing:0.5px; }
        tbody tr:nth-child(even) { background:#f9fafb; }
        tbody td { padding:6px 8px; border-bottom:1px solid #e5e7eb; font-size:9px; }
        .footer  { margin-top:16px; font-size:8px; color:#aaa; text-align:right; }
    </style>
</head>
<body>
    <div class="header">
        <img src="' . $logoSrc . '" style="width:48px; height:48px;">
        <div class="inst">
            <h1>Dirección de Organizaciones Intermedias</h1>
            <p>Tribunal Superior de Justicia Electoral — República del Paraguay</p>
            <p>Avda. E. Ayala No. 2929 c/Pasaje Tembetary &nbsp;|&nbsp; Teléf. 6180452 &nbsp;|&nbsp; org.intermedias@gmail.com</p>
        </div>
    </div>

    <div class="filtro">Filtros aplicados: ' . $filtroTexto . '</div>
    <div class="total">Total de registros: ' . count($entradas) . '</div>

    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Organización</th>
                <th>Asesor/a</th>
                <th style="text-align:center;">Fecha Elección</th>
                <th style="text-align:center;">Asunto</th>
            </tr>
        </thead>
        <tbody>
            ' . $filas . '
        </tbody>
    </table>

    <div class="footer">Generado el ' . $fecha . ' — Sistema de Gestión Electoral</div>
</body>
</html>';

   if (request()->expectsJson()) {
    return response()->json(['html' => $html]);
}

$dompdf = new \Dompdf\Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('letter', 'portrait');
$dompdf->render();

return new \Illuminate\Http\Response($dompdf->output(), 200, [
    'Content-Type'        => 'application/pdf',
    'Content-Disposition' => 'inline; filename="listado-con-nota-' . now()->format('Y-m-d') . '.pdf"',
]);
}
public function toggleSuspender(EntradaConNota $conNota)
{
    $suspendida = !$conNota->eleccion_suspendida;
    $conNota->update([
        'eleccion_suspendida'    => $suspendida,
        'eleccion_suspendida_at' => $suspendida ? now() : null,
    ]);
    return response()->json([
        'suspendida' => $suspendida,
        'fecha'      => $suspendida ? now()->format('d/m/Y H:i') : null,
    ]);
}
}
