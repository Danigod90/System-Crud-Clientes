<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\EntradaConNota;
use App\Models\Asesor;
use Illuminate\Http\Request;

class SupervisorController extends Controller
{
    public function index(Request $request)
    {
        $asesores = Asesor::orderBy('nombre')->get();

        $entradas = EntradaConNota::with(['charla', 'charlas', 'detalleTecnico', 'observador'])
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
    } elseif ($asunto === 'cargado_si') {
        $q->where('supervisor_cargado', true);
    } elseif ($asunto === 'cargado_no') {
        $q->where('supervisor_cargado', false);
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
            ->when($request->cargado, function($q) use ($request) {
                if ($request->cargado === 'si') {
                    $q->where('supervisor_cargado', true);
                } elseif ($request->cargado === 'no') {
                    $q->where('supervisor_cargado', false);
                }
            })
            ->latest()
            ->paginate(10)->withQueryString();

        return view('supervisor.index', compact('entradas', 'asesores'));
    }

    public function show(EntradaConNota $entrada)
    {
        $entrada->load(['charlas', 'charla', 'detalleTecnico', 'observador', 'documentos.user']);
        return view('supervisor.show', compact('entrada'));
    }

    public function marcarCargado(EntradaConNota $entrada)
    {
        $entrada->update([
            'supervisor_cargado'    => true,
            'supervisor_cargado_at' => now(),
        ]);
        return response()->json(['success' => true]);
    }

    public function dashboard()
    {
        $stats = [
            'total'     => EntradaConNota::count(),
            'cargados'  => EntradaConNota::where('supervisor_cargado', true)->count(),
            'pendientes'=> EntradaConNota::where('supervisor_cargado', false)->count(),
            'este_mes'  => EntradaConNota::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count(),
        ];

        $recientes = EntradaConNota::with(['charla', 'detalleTecnico'])
            ->latest()
            ->take(10)
            ->get();

        return view('supervisor.dashboard', compact('stats', 'recientes'));
    }
    public function exportPdf(Request $request)
{
    $entradas = EntradaConNota::with(['charla', 'detalleTecnico'])
        ->when($request->organizacion, fn($q) =>
            $q->where('nombre_organizacion', 'like', '%' . $request->organizacion . '%')
        )
        ->when($request->asesor, fn($q) =>
            $q->where('asesor_asignado', $request->asesor)
        )
        ->when($request->asunto, function($q) use ($request) {
            $asunto = $request->asunto;
            if ($asunto === 'char')     $q->where('asunto_char', true);
            elseif ($asunto === 'log')  $q->where('asunto_log', true);
            elseif ($asunto === 'tec')  $q->where('asunto_tec', true);
            elseif ($asunto === 'obs')  $q->where('asunto_obs', true);
        })
        ->when($request->cargado, function($q) use ($request) {
            if ($request->cargado === 'si')     $q->where('supervisor_cargado', true);
            elseif ($request->cargado === 'no') $q->where('supervisor_cargado', false);
        })
        ->when($request->mes_ingreso, fn($q) =>
            $q->whereYear('created_at', substr($request->mes_ingreso, 0, 4))
              ->whereMonth('created_at', substr($request->mes_ingreso, 5, 2))
        )
        ->when($request->mes_eleccion, fn($q) =>
            $q->whereYear('fecha_eleccion', substr($request->mes_eleccion, 0, 4))
              ->whereMonth('fecha_eleccion', substr($request->mes_eleccion, 5, 2))
        )
        ->latest()->get();

    $fecha      = now()->format('d/m/Y H:i');
    $logoPath   = public_path('images/logo.png');
    $logoBase64 = base64_encode(file_get_contents($logoPath));
    $logoSrc    = 'data:image/png;base64,' . $logoBase64;

    $filtros = [];
    if ($request->organizacion) $filtros[] = 'Org: ' . $request->organizacion;
    if ($request->asesor)       $filtros[] = 'Asesor: ' . $request->asesor;
    if ($request->asunto)       $filtros[] = 'Asunto: ' . strtoupper($request->asunto);
    if ($request->cargado)      $filtros[] = 'Cargado: ' . ($request->cargado === 'si' ? 'Sí' : 'No');
    if ($request->mes_ingreso)  $filtros[] = 'Ingreso: ' . $request->mes_ingreso;
    if ($request->mes_eleccion) $filtros[] = 'Elección: ' . $request->mes_eleccion;
    $filtroTexto = count($filtros) ? implode(' · ', $filtros) : 'Sin filtros — listado completo';

    $filas = '';
    foreach ($entradas as $e) {
        $asunto = collect([
            $e->asunto_char ? 'Char' : null,
            $e->asunto_log  ? 'Log'  : null,
            $e->asunto_tec  ? 'Tec'  : null,
            $e->asunto_obs  ? 'Obs'  : null,
        ])->filter()->implode(' · ');

        $estado = $e->supervisor_cargado
            ? '<span style="background:#d1fae5;color:#065f46;padding:2px 8px;border-radius:4px;font-size:9px;font-weight:700;">✓ Cargado</span>'
            : '<span style="background:#fef3c7;color:#92400e;padding:2px 8px;border-radius:4px;font-size:9px;font-weight:700;">Pendiente</span>';

        $filas .= '
<tr>
    <td>' . htmlspecialchars($e->codigo_org) . '</td>
    <td>' . htmlspecialchars($e->nombre_organizacion) . '</td>
    <td>' . htmlspecialchars($e->asesor_asignado ?? '—') . '</td>
    <td>' . htmlspecialchars($e->nombre_representante ?? '—') . '</td>
    <td>' . htmlspecialchars($e->telefono_representante ?? '—') . '</td>
    <td>' . htmlspecialchars($e->direccion ?? '—') . '</td>
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
        tbody tr:nth-child(even) td { background:#f9fafb; }
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
            <p>Avda. E. Ayala No. 2929 c/Pasaje Tembetary &nbsp;|&nbsp; Teléf. 6180452</p>
        </div>
    </div>
    <div class="filtro">Filtros: ' . $filtroTexto . '</div>
    <div class="total">Total: ' . count($entradas) . ' registros</div>
    <table>
        <thead>
            <tr>
               <th>Código</th>
<th>Organización</th>
<th>Asesor/a</th>
<th>Contacto</th>
<th>Teléfono</th>
<th>Dirección</th>
<th style="text-align:center;">Fecha Elección</th>
<th style="text-align:center;">Asunto</th>
            </tr>
        </thead>
        <tbody>' . $filas . '</tbody>
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
        'Content-Disposition' => 'inline; filename="listado-supervisor-' . now()->format('Y-m-d') . '.pdf"',
    ]);
}
}
