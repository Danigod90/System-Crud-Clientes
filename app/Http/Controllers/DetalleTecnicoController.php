<?php

namespace App\Http\Controllers;

use App\Models\DetalleTecnico;
use App\Models\EntradaConNota;
use Illuminate\Http\Request;

class DetalleTecnicoController extends Controller
{
    // ── PANEL ASESOR ──
    public function createAsesor($entrada_id)
    {
        $entrada = EntradaConNota::findOrFail($entrada_id);
        $detalle = DetalleTecnico::firstOrNew(['entrada_id' => $entrada_id]);
        return view('detalle_tecnico.asesor', compact('entrada', 'detalle'));
    }

    public function saveAsesor(Request $request, $entrada_id)
{
    $detalle = DetalleTecnico::firstOrNew(['entrada_id' => $entrada_id]);

    $detalle->entrada_id               = $entrada_id;
    $detalle->organo_electoral         = $request->organo_electoral;
    $detalle->cantidad_listas          = $request->cantidad_listas;
    $detalle->cantidad_papeletas       = $request->cantidad_papeletas;
    $detalle->cantidad_mesas           = $request->cantidad_mesas;
    $detalle->sistema_eleccion_general = null;

    // Papeletas — solo actualiza si vienen en el request
// Papeletas — solo actualiza si vienen en el request con valor
for ($p = 1; $p <= 10; $p++) {
    for ($l = 1; $l <= 5; $l++) {
        if ($request->has("pap_{$p}_lista_{$l}_nombre")) {
            $detalle->{"pap_{$p}_lista_{$l}_nombre"} = $request->{"pap_{$p}_lista_{$l}_nombre"} ?: null;
        }
        if ($request->has("pap_{$p}_lista_{$l}_candidatura")) {
            $detalle->{"pap_{$p}_lista_{$l}_candidatura"} = $request->{"pap_{$p}_lista_{$l}_candidatura"} ?: null;
        }
    }
    if ($request->has("pap_{$p}_sistema_eleccion")) {
        $detalle->{"pap_{$p}_sistema_eleccion"} = $request->{"pap_{$p}_sistema_eleccion"} ?: null;
    }
}
if ($request->has('mat_final_actas'))    $detalle->mat_final_actas    = (int)$request->mat_final_actas;
if ($request->has('mat_final_padrones')) $detalle->mat_final_padrones = (int)$request->mat_final_padrones;
if ($request->has('mat_final_cuartos'))  $detalle->mat_final_cuartos  = (int)$request->mat_final_cuartos;
if ($request->has('mat_final_urnas'))    $detalle->mat_final_urnas    = (int)$request->mat_final_urnas;
if ($request->has('mat_final_tintas'))   $detalle->mat_final_tintas   = (int)$request->mat_final_tintas;
if ($request->has('mat_final_papeletas')) {
    $detalle->mat_final_papeletas = (int)$request->mat_final_papeletas;
    $detalle->mat_matriz_boletin  = (int)$request->mat_final_papeletas;
}
if ($request->has('mat_final_papeletas_formato'))  $detalle->mat_final_papeletas_formato  = $request->mat_final_papeletas_formato;
if ($request->has('mat_final_actas_formato'))      $detalle->mat_final_actas_formato      = $request->mat_final_actas_formato;
if ($request->has('mat_final_padrones_formato'))   $detalle->mat_final_padrones_formato   = $request->mat_final_padrones_formato;
if ($request->has('nota_asesor')) $detalle->nota_asesor = $request->nota_asesor;
 $detalle->asesor_updated_at = now();
 $detalle->tecnico_updated_at = now();
    $detalle->save();

    return redirect()->back()->with('success', 'Datos técnicos guardados correctamente.');
}

   public function enviarTecnica($entrada_id)
{
    $detalle = DetalleTecnico::where('entrada_id', $entrada_id)->firstOrFail();
    $detalle->enviado_tecnica    = true;
    $detalle->enviado_tecnica_at = now();
    $detalle->asesor_updated_at = now();
    $detalle->save();

    $entrada = EntradaConNota::findOrFail($entrada_id);
    $tecnicos = \App\Models\User::role('Tecnico')->get();
    foreach ($tecnicos as $tecnico) {
    $tecnico->notify(new \App\Notifications\TrabajoPendienteNotification(
        'Nuevo trabajo: ' . $entrada->nombre_organizacion . ' enviado a técnica por ' . $entrada->asesor_asignado,
        'Panel Técnico',
        $entrada->id
    ));
   if ($tecnico->notifications()->count() > 8) {
    $tecnico->notifications()->latest()->skip(8)->take(100)->delete();
}
}

    return redirect()->back()->with('success', 'Enviado a técnica correctamente.');
}

    // ── PANEL TÉCNICO ──
    public function createTecnico($entrada_id)
    {
        $entrada = EntradaConNota::findOrFail($entrada_id);
        $detalle = DetalleTecnico::firstOrNew(['entrada_id' => $entrada_id]);
        return view('detalle_tecnico.tecnico', compact('entrada', 'detalle'));
    }

    public function saveTecnico(Request $request, $entrada_id)
{
    $detalle = DetalleTecnico::firstOrNew(['entrada_id' => $entrada_id]);
        $detalle->entrada_id = $entrada_id;

       // Papeletas — solo actualiza si vienen en el request
for ($p = 1; $p <= 10; $p++) {
    for ($l = 1; $l <= 5; $l++) {
        if ($request->has("pap_{$p}_lista_{$l}_nombre")) {
            $detalle->{"pap_{$p}_lista_{$l}_nombre"} = $request->{"pap_{$p}_lista_{$l}_nombre"} ?: null;
        }
        if ($request->has("pap_{$p}_lista_{$l}_candidatura")) {
            $detalle->{"pap_{$p}_lista_{$l}_candidatura"} = $request->{"pap_{$p}_lista_{$l}_candidatura"} ?: null;
        }
    }
    if ($request->has("pap_{$p}_sistema_eleccion")) {
        $detalle->{"pap_{$p}_sistema_eleccion"} = $request->{"pap_{$p}_sistema_eleccion"} ?: null;
    }
}


      // Materiales finales calculados
$detalle->mat_final_actas    = $request->mat_final_actas;
$detalle->mat_final_padrones = $request->mat_final_padrones;
if ($request->has('mat_final_cuartos') && $request->mat_final_cuartos !== null) $detalle->mat_final_cuartos = $request->mat_final_cuartos;
if ($request->has('mat_final_urnas')   && $request->mat_final_urnas   !== null) $detalle->mat_final_urnas   = $request->mat_final_urnas;
$mesas = $detalle->cantidad_mesas ?? 0;
$detalle->mat_mesas                     = $request->mat_mesas ?? $detalle->cantidad_mesas ?? $mesas;
$detalle->mat_actas_electorales         = $request->mat_actas_electorales ?? $detalle->mat_final_actas ?? ($mesas * 3);
$detalle->mat_actas_electorales_formato = $request->mat_actas_electorales_formato ?? $detalle->mat_final_actas_formato;
$detalle->mat_padron                    = $request->mat_padron ?? $detalle->mat_final_padrones ?? ($mesas * 3);
$detalle->mat_padron_formato            = $request->mat_padron_formato ?? $detalle->mat_final_padrones_formato;
$detalle->mat_matriz_boletin            = $request->mat_matriz_boletin ?? $detalle->mat_final_papeletas ?? $detalle->cantidad_papeletas;
$detalle->mat_matriz_boletin_formato    = $request->mat_matriz_boletin_formato ?? $detalle->mat_final_papeletas_formato;
// Sincronizar formatos con campos del asesor
if ($request->mat_actas_electorales_formato) $detalle->mat_final_actas_formato    = $request->mat_actas_electorales_formato;
if ($request->mat_padron_formato)            $detalle->mat_final_padrones_formato  = $request->mat_padron_formato;
if ($request->mat_matriz_boletin_formato)    $detalle->mat_final_papeletas_formato = $request->mat_matriz_boletin_formato;
$detalle->mat_actas_proclamacion        = $request->mat_actas_proclamacion;
$detalle->mat_certificados              = $request->mat_certificados;
$detalle->mat_cuenta_votos              = $request->mat_cuenta_votos;

// Padrón
$detalle->padron_definitivo         = $request->has('padron_definitivo') ? 1 : 0;
$detalle->padron_con_cedula         = $request->has('padron_con_cedula') ? 1 : 0;
$detalle->cantidad_electores        = $request->cantidad_electores;
$detalle->cantidad_electores_sin_ci = $request->cantidad_electores_sin_ci;

// Responsables
$detalle->resp_actas_electorales = $request->resp_actas_electorales;
$detalle->resp_papeletas         = $request->resp_papeletas;
$detalle->resp_padron_electoral  = $request->resp_padron_electoral;

$detalle->save();

return redirect()->back()->with('success', 'Datos técnicos guardados correctamente.');
}

   public function imprimirLogistica($entrada_id)
{
    $entrada = EntradaConNota::findOrFail($entrada_id);
$entrada->refresh();
$detalle = DetalleTecnico::where('entrada_id', $entrada_id)->firstOrFail();

    // Marcar como impreso
    $detalle->impreso    = true;
    $detalle->impreso_at = now();
    $detalle->save();
    $detalle->refresh();

    // Datos base
    $fecha      = now()->format('d/m/Y');
    $org        = strtoupper($entrada->nombre_organizacion);
    $codigo     = $entrada->codigo_org;
    $mesas      = $detalle->cantidad_mesas ?? 0;
    $papeletas  = $detalle->cantidad_papeletas ?? 0;
    $listas     = $detalle->cantidad_listas ?? 1;
    $ordinal    = ['Primera','Segunda','Tercera','Cuarta','Quinta','Sexta','Séptima','Octava','Novena','Décima'];

    // Papeletas HTML
    $papeletasHtml = '';
    if ($papeletas > 0) {
        for ($p = 1; $p <= min($papeletas, 10); $p++) {
            $listaNombres = [];
            for ($l = 1; $l <= min($listas, 5); $l++) {
                $n = $detalle->{"pap_{$p}_lista_{$l}_nombre"} ?? null;
                if ($n) $listaNombres[] = $n;
            }
            $listaTag    = count($listaNombres) ? '<span style="background:#e5e7eb; padding:1px 6px; border-radius:3px; font-size:8px; white-space:nowrap;">Lista ' . implode(' / ', $listaNombres) . '</span>' : '';
            $candidatura = $detalle->{"pap_{$p}_lista_1_candidatura"} ?? '—';
            $sistema     = $detalle->{"pap_{$p}_sistema_eleccion"} ?? '—';

            $papeletasHtml .= '
            <div style="display:flex; align-items:center; gap:8px; padding:3px 6px; background:#f9fafb; border:1px solid #e5e7eb; border-radius:3px; margin-bottom:3px; font-size:9px;">
                <span style="font-weight:700; color:#1e3a5f; white-space:nowrap; min-width:90px;">' . $ordinal[$p-1] . ' Papeleta</span>
                ' . $listaTag . '
                <span style="flex:1;">' . $candidatura . '</span>
                <span style="color:#555; white-space:nowrap;">' . $sistema . '</span>
            </div>';
        }
    }

    // Materiales técnicos
    $matMesas    = $detalle->mat_mesas ?? $mesas;
    $matActas    = $detalle->mat_actas_electorales ?? ($mesas * 3);
    $matActasFmt  = $detalle->mat_final_actas_formato    ? ucfirst($detalle->mat_final_actas_formato)    : ($detalle->mat_actas_electorales_formato    ? ucfirst($detalle->mat_actas_electorales_formato)    : '');
    $matPadron   = $detalle->mat_padron ?? ($mesas * 3);
    $matPadronFmt = $detalle->mat_final_padrones_formato  ? ucfirst($detalle->mat_final_padrones_formato)  : ($detalle->mat_padron_formato                ? ucfirst($detalle->mat_padron_formato)                : '');
    $matBoletin  = $detalle->mat_matriz_boletin ?? $papeletas;
    $matBoletinFmt= $detalle->mat_final_papeletas_formato ? ucfirst($detalle->mat_final_papeletas_formato) : ($detalle->mat_matriz_boletin_formato         ? ucfirst($detalle->mat_matriz_boletin_formato)         : '');
    $matProclamacion = $detalle->mat_actas_proclamacion ?? 3;
    $matCertificados = $detalle->mat_certificados ?? '—';
    $matCuentaVotos  = $detalle->mat_cuenta_votos ?? '—';

    // Estimado logístico
    $estActas   = $detalle->mat_final_actas   ?? ($mesas * 3);
    $estPadrones= $detalle->mat_final_padrones ?? ($mesas * 3);
    $estCuartos = $detalle->mat_final_cuartos  ?? $mesas;
    $estUrnas   = $detalle->mat_final_urnas    ?? ($mesas * $papeletas);
    $estTintas  = $detalle->mat_final_tintas   ?? $mesas;

    // Logística préstamo
    $logUrnas   = $entrada->log_urnas   ?? 0;
    $logCuartos = $entrada->log_cuartos ?? 0;
    $logTintas  = $entrada->log_tintas  ?? 0;

    // Padrón
   $padronDefSI = $detalle->padron_definitivo ? '[X]' : '[  ]';
$padronDefNO = $detalle->padron_definitivo ? '[  ]' : '[X]';
$padronCISI  = $detalle->padron_con_cedula ? '[X]' : '[  ]';
$padronCINO  = $detalle->padron_con_cedula ? '[  ]' : '[X]';
    $electores  = $detalle->cantidad_electores ?? '—';
    $sinCI      = $detalle->cantidad_electores_sin_ci ?? '—';

    // Responsables
    $respActas  = $detalle->resp_actas_electorales ?? '—';
    $respPap    = $detalle->resp_papeletas ?? '—';
    $respPadron = $detalle->resp_padron_electoral ?? '—';
    $asesor     = $entrada->asesor_asignado ?? '—';
    $fechaElec  = $entrada->fecha_eleccion?->format('d/m/Y') ?? '—';

    $logoPath = public_path('images/logo.png');
    $logoBase64 = base64_encode(file_get_contents($logoPath));
    $logoSrc = 'data:image/png;base64,' . $logoBase64;

    $html = '
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; color: #000; margin: 2px 32px; line-height: 1.4; }
        .header { display:flex; align-items:center; gap:12px; border-bottom:3px solid #1e3a5f; padding-bottom:8px; margin-bottom:10px; }
        .inst h1 { font-size:12px; font-weight:700; margin:0 0 2px; text-transform:uppercase; color:#1e3a5f; }
        .inst p { font-size:8px; color:#555; margin:0; }
        .inst .codigo { font-size:10px; font-weight:700; color:#1e3a5f; margin-top:2px; }
        .org-box { background:#f0f4f8; border-left:4px solid #1e3a5f; padding:5px 8px; margin-bottom:8px; }
        .org-name { font-size:11px; font-weight:700; text-transform:uppercase; color:#1e3a5f; }
        .org-meta { font-size:8px; color:#555; margin-top:1px; }
        .sec-title { background:#1e3a5f; color:#fff; font-size:9px; font-weight:700; padding:3px 8px; margin:8px 0 6px; text-transform:uppercase; letter-spacing:0.5px; }
        .subsec { font-size:9px; font-weight:700; color:#1e3a5f; border-bottom:1px solid #e5e7eb; padding-bottom:1px; margin:6px 0 4px; }
        .mat-card { display:table-cell; border:1px solid #d1d5db; padding:4px; text-align:center; width:33%; }
        .mat-label { font-size:7px; color:#666; text-transform:uppercase; margin-bottom:2px; }
        .mat-val { font-size:14px; font-weight:700; color:#1e3a5f; }
        .mat-fmt { font-size:7px; color:#c00; font-weight:700; }
        .resp-box { border:1px solid #000; padding:4px 6px; font-size:8px; margin-bottom:6px; }
        .est-table { width:100%; border-collapse:collapse; margin-bottom:6px; }
        .est-table td { border:1px solid #bfdbfe; background:#eff6ff; padding:4px; text-align:center; }
        .est-label { font-size:7px; color:#1e40af; text-transform:uppercase; display:block; margin-bottom:1px; }
        .est-val { font-size:15px; font-weight:700; color:#1e40af; }
        .separador { border:none; border-top:2px dashed #1e3a5f; margin:10px 0; }
        .padron-row { font-size:9px; margin-bottom:3px; }
        .firma-table { width:100%; border-collapse:collapse; margin-top:16px; }
        .firma-table td { text-align:center; font-size:8px; color:#555; border-top:1px solid #000; padding-top:2px; }
        .dev-box { font-size:9px; margin-bottom:6px; }
        .dev-grid { display:table; width:100%; border-collapse:separate; border-spacing:4px; margin:6px 0; }
        .dev-cell { display:table-cell; border-bottom:1px solid #000; padding-bottom:2px; font-size:9px; width:33%; }
        .aviso { border:2px solid #1e3a5f; background:#f0f4f8; padding:6px 8px; font-size:8px; font-weight:700; text-align:center; line-height:1.5; color:#1e3a5f; margin-top:6px; }
        .fecha-gen { text-align:right; font-size:9px; color:#888; margin-bottom:4px; }
    </style>
</head>
<body>

<div class="fecha-gen">Generado el ' . $fecha . ' — Sistema de Gestión Electoral</div>

<div class="header">
    <img src="' . $logoSrc . '" style="width:52px; height:52px;">
    <div class="inst">
        <h1>Dirección de Organizaciones Intermedias</h1>
        <p>Tribunal Superior de Justicia Electoral — República del Paraguay</p>
        <p>Avda. E. Ayala No. 2929 c/Pasaje Tembetary &nbsp;|&nbsp; Teléf. 6180452 &nbsp;|&nbsp; org.intermedias@gmail.com</p>
        <div class="codigo">Código: ' . $codigo . '</div>
    </div>
</div>

<div class="org-box">
    <div class="org-name">' . $org . '</div>
    <div class="org-meta">
        <strong>Asesor/a:</strong> ' . $asesor . ' &nbsp;&nbsp;
        <strong>Fecha de Elección:</strong> ' . $fechaElec . ' &nbsp;&nbsp;
        <strong>Asunto:</strong> ' . $entrada->asunto_texto . '
    </div>
</div>

<div class="sec-title">[ 1 ] Parte Técnica — Entrega de Materiales Electorales</div>

<div class="subsec">Materiales Entregados</div>
<table style="width:100%; border-collapse:separate; border-spacing:3px; margin-bottom:6px;">
    <tr>
        <td class="mat-card"><div class="mat-label">Mesa/s</div><div class="mat-val">' . str_pad($matMesas, 2, '0', STR_PAD_LEFT) . '</div></td>
        <td class="mat-card"><div class="mat-label">Actas Electorales</div><div class="mat-val">' . str_pad($matActas, 2, '0', STR_PAD_LEFT) . '</div><div class="mat-fmt">' . $matActasFmt . '</div></td>
        <td class="mat-card"><div class="mat-label">Padrón Electoral</div><div class="mat-val">' . str_pad($matPadron, 2, '0', STR_PAD_LEFT) . '</div><div class="mat-fmt">' . $matPadronFmt . '</div></td>
    </tr>
    <tr>
        <td class="mat-card"><div class="mat-label">Matriz de Boletín</div><div class="mat-val">' . str_pad($matBoletin, 2, '0', STR_PAD_LEFT) . '</div><div class="mat-fmt">' . $matBoletinFmt . '</div></td>
        <td class="mat-card"><div class="mat-label">Actas de Proclamación</div><div class="mat-val">' . str_pad($matProclamacion, 2, '0', STR_PAD_LEFT) . '</div></td>
        <td class="mat-card"><div class="mat-label">Certificados de Resultados</div><div class="mat-val">' . ($matCertificados == '—' ? '—' : str_pad($matCertificados, 2, '0', STR_PAD_LEFT)) . '</div></td>
    </tr>
</table>

<div class="resp-box">
    <strong>Matriz:</strong> ' . $respPap . ' &nbsp;&nbsp;
    <strong>Padrón:</strong> ' . $respPadron . ' &nbsp;&nbsp;
    <strong>Actas:</strong> ' . $respActas . ' &nbsp;&nbsp;
    <strong>Asesor/a:</strong> ' . $asesor . '
</div>

<table style="width:100%; border-collapse:collapse; margin-bottom:6px;">
<tr>
<td style="width:50%; vertical-align:top; padding-right:8px;">
    <div class="subsec">Padrón</div>
    <table style="width:100%; border-collapse:collapse; margin-bottom:4px;">
<tr>
    <td style="font-size:9px; padding:4px 6px; border:1px solid #d1d5db; background:#f9fafb; width:50%;">
        <strong>Padrón Definitivo</strong> &nbsp;&nbsp; SI ' . $padronDefSI . ' &nbsp; NO ' . $padronDefNO . '
    </td>
    <td style="font-size:9px; padding:4px 6px; border:1px solid #d1d5db; background:#f9fafb; width:50%;">
        <strong>Padrón con Cédula</strong> &nbsp;&nbsp; SI ' . $padronCISI . ' &nbsp; NO ' . $padronCINO . '
    </td>
</tr>
</table>
    <div class="padron-row">Electores: <strong>' . $electores . '</strong> &nbsp;&nbsp; Sin C.I.: <strong>' . $sinCI . '</strong></div>
    <div style="font-size:8px; font-style:italic; color:#1e3a5f; border:1px solid #bfdbfe; background:#eff6ff; padding:4px 6px; margin:6px 0;">
    Recibo conforme y declaro que los datos que obran en el presente padrón están correctos y coinciden con los datos que he presentado para su confección por parte de la Dirección de Organizaciones Intermedias.
</div>
</td>


<td style="width:50%; vertical-align:top; padding-left:8px; border-left:1px solid #e5e7eb;">
    ' . ($papeletas > 0 ? '<div class="subsec">Sistema de Elección</div>' . $papeletasHtml : '') . '
</td>
</tr>
</table>'

. ($entrada->asunto_log ? '
<div style="font-size:9px; font-weight:700; color:#1e3a5f; border-bottom:1px solid #e5e7eb; padding-bottom:1px; margin:6px 0 4px;">Materiales Logísticos Entregados</div>
<table style="width:100%; border-collapse:collapse; margin-bottom:6px;">
    <tr>
        <td style="border:1px solid #bfdbfe; background:#eff6ff; padding:4px; text-align:center;width:33%;">
            <span style="font-size:7px; color:#1e40af; text-transform:uppercase; display:block; margin-bottom:1px;">Cuartos Oscuros</span>
            <span style="font-size:13px; font-weight:700; color:#1e40af;">' . $estCuartos . '</span>
        </td>
        <td style="border:1px solid #bfdbfe; background:#eff6ff; padding:4px; text-align:center;width:33%;">
            <span style="font-size:7px; color:#1e40af; text-transform:uppercase; display:block; margin-bottom:1px;">Urnas</span>
            <span style="font-size:13px; font-weight:700; color:#1e40af;">' . $estUrnas . '</span>
        </td>
        <td style="border:1px solid #bfdbfe; background:#eff6ff; padding:4px; text-align:center;width:33%;">
            <span style="font-size:7px; color:#1e40af; text-transform:uppercase; display:block; margin-bottom:1px;">Tintas</span>
            <span style="font-size:13px; font-weight:700; color:#1e40af;">' . $estTintas . '</span>
        </td>
    </tr>
</table>' : '')

. '
<div style="font-size:8px;
    Recibo conforme y declaro que los datos que obran en el presente padrón están correctos y coinciden con los datos que he presentado para su confección por parte de la Dirección de Organizaciones Intermedias.
</div>

<div style="margin-top:14px;">
    <div style="font-size:9px; font-weight:700; margin-bottom:24px;">Datos de quien retira:</div>
    <table style="width:100%; border-collapse:collapse;">
        <tr>
            <td style="border-top:1px solid #000; padding-top:3px; text-align:center; font-size:8px; color:#555;">Firma</td>
            <td style="border-top:1px solid #000; padding-top:3px; text-align:center; font-size:8px; color:#555;">Aclaración</td>
            <td style="border-top:1px solid #000; padding-top:3px; text-align:center; font-size:8px; color:#555;">N° de Teléfono</td>
        </tr>
    </table>
</div>

' . ($entrada->asunto_log ? '
<div class="separador"></div>

<div class="sec-title">[ 2 ] Devolución y Contraseña — Dirección de Organizaciones Intermedias</div>

<div class="dev-box">
    <strong>Código:</strong> ' . $codigo . ' &nbsp;&nbsp;
    <strong>Organización:</strong> ' . $org . '
</div>
<div class="dev-box"><strong>Fecha de entrega:</strong> _______ / _______ / _______</div>
<div class="dev-box"><strong>Detalle:</strong> (' . str_pad($estUrnas, 2, '0', STR_PAD_LEFT) . ') urna(s) de plástico, (' . str_pad($estCuartos, 2, '0', STR_PAD_LEFT) . ') cuarto(s) oscuros, (' . str_pad($estTintas, 2, '0', STR_PAD_LEFT) . ') frasco(s) de tinta indeleble.</div>

<table class="dev-grid">
    <tr>
        <td class="dev-cell">Fecha de devolución: _______ / _______ / _______</td>
        <td class="dev-cell">Urnas devueltas: _______</td>
        <td class="dev-cell">Cuartos devueltos: _______</td>
    </tr>
</table>
<div class="dev-box">Tintas devueltas: _______ &nbsp;&nbsp;&nbsp; Funcionario que recibe: _________________________________________________</div>

<div class="aviso">
    LOS MATERIALES OTORGADOS EN CALIDAD DE PRÉSTAMO DEBEN SER DEVUELTOS EN LA DIRECCIÓN DE ORGANIZACIONES INTERMEDIAS 72 HS POSTERIORES A LA REALIZACIÓN DE LAS ELECCIONES DE AUTORIDADES.
</div>' : '') . '

</body>
</html>';

    $dompdf = new \Dompdf\Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('letter', 'portrait');
    $dompdf->render();

// Solo actualizar log_estado si tiene Log SIN Tec
if ($entrada->asunto_log && !$entrada->asunto_tec) {
    $entrada->update([
        'log_impreso_at' => now(),
        'log_estado'     => 'entregada',
    ]);
} else {
    // Log+Tec o Tec solo — solo marcar impreso, no cambiar estado
    $entrada->update([
        'log_impreso_at' => now(),
    ]);
}

// Notificar a Secretaria Sin Nota
$secretarias = \App\Models\User::role('Secretaria Sin Nota')->get();
foreach ($secretarias as $secretaria) {
    $secretaria->notify(new \App\Notifications\TrabajoPendienteNotification(
        'Logística impresa: ' . $entrada->nombre_organizacion . ' (' . $entrada->codigo_org . ')',
        'Panel Logístico',
        $entrada->id
    ));
    if ($secretaria->notifications()->count() > 8) {
        $secretaria->notifications()->latest()->skip(8)->take(100)->delete();
    }
}

return new \Illuminate\Http\Response($dompdf->output(), 200, [
    'Content-Type'        => 'application/pdf',
    'Content-Disposition' => 'inline; filename="recibo-tec-' . $codigo . '.pdf"',
]);

}
   public function marcarRealizado($entrada_id)
{
    $detalle = DetalleTecnico::where('entrada_id', $entrada_id)->firstOrFail();
    $detalle->tec_realizado    = true;
    $detalle->tec_realizado_at = now();
    $detalle->save();

    $entrada = EntradaConNota::findOrFail($entrada_id);
    if ($entrada->asunto_tec) {
        $entrada->log_estado = 'entregada';
        $entrada->save();
    }

    // Notificar al asesor
    $asesor = \App\Models\Asesor::whereRaw("CONCAT(nombre, ' ', apellido) = ?", [$entrada->asesor_asignado])->first();
    if ($asesor && $asesor->user_id) {
        $usuario = \App\Models\User::find($asesor->user_id);
        $usuario?->notify(new \App\Notifications\TrabajoPendienteNotification(
    'Trabajo técnico completado: ' . $entrada->nombre_organizacion,
    'Mis Organizaciones',
    $entrada->id
));
if ($usuario && $usuario->notifications()->count() > 8) {
    $usuario->notifications()->latest()->skip(8)->take(100)->delete();
}
    }

    return redirect()->back()->with('success', 'Trabajo técnico marcado como realizado.');
}
public function checkAsesorUpdate($entrada_id)
{
    $detalle = DetalleTecnico::where('entrada_id', $entrada_id)->firstOrFail();
    return response()->json([
        'asesor_updated_at'   => $detalle->asesor_updated_at,
        'tecnico_updated_at'  => $detalle->tecnico_updated_at,
    ]);
}
}
