<?php

namespace App\Http\Controllers\Secretaria;

use App\Http\Controllers\Controller;
use App\Models\EntradaConNota;
use App\Models\Configuracion;
use Illuminate\Http\Response;

class NotaPdfController extends Controller
{
    public function notaPresidente(EntradaConNota $conNota)
    {
        $presidente = Configuracion::where('clave', 'presidente_actual')->value('valor') ?? 'Presidente del TSJE';

        $servicios = [];
        if ($conNota->asunto_char) $servicios[] = '"Char" Charla Electoral';
        if ($conNota->asunto_log)  $servicios[] = '"Log" Apoyo Logistico';
        if ($conNota->asunto_tec)  $servicios[] = '"Tec" Apoyo Tecnico';
        $serviciosTexto = implode(' – ', $servicios);

        $fecha = now()->locale('es')->isoFormat('D [de] MMMM [del] YYYY');
        $fechaEleccion = $conNota->fecha_eleccion?->format('d/m/Y') ?? '___/___/______';

        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <style>
                body { font-family: Arial, sans-serif; font-size: 13px; margin: 60px; color: #000; line-height: 1.6; }
                .fecha-ref { text-align: right; margin-bottom: 40px; }
                .destinatario { margin-bottom: 30px; }
                .destinatario p { margin: 2px 0; }
                .cuerpo { text-align: justify; margin-bottom: 40px; }
                .cuerpo p { text-indent: 60px; }
                .despedida { margin-bottom: 60px; }
                .firma { text-align: center; margin-top: 80px; }
                .firma p { margin: 2px 0; }
            </style>
        </head>
        <body>
            <div class="fecha-ref">
                <p>Asuncion, ' . $fecha . '</p>
            </div>

            <div class="destinatario">
                <p><strong>' . $presidente . '</strong></p>
                <p>Presidente del TSJE</p>
            </div>

            <br>

            <div class="cuerpo">
                <p>
                    Por medio de la presente, en representacion de
                    <strong>"' . strtoupper($conNota->nombre_organizacion) . '"</strong>,
                    solicitamos el uso de los servicios de la Direccion de Organizaciones Intermedias,
                    los servicios correspondientes a dicha direccion ' . $serviciosTexto . ',
                    la eleccion a realizarse el <strong>' . $fechaEleccion . '</strong>.
                </p>
            </div>

            <div class="despedida">
                <p>Sin otro particular me despido de usted atentamente.</p>
            </div>

            <div class="firma">
                <p>_______________________________</p>
                <p>Firma</p>
            </div>
        </body>
        </html>';

        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return new Response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="nota-' . $conNota->codigo_org . '.pdf"',
        ]);
    }

    public function reciboLogistica(EntradaConNota $conNota)
{
    $fechaCorta = now()->format('d/m/Y');
    $org        = strtoupper($conNota->nombre_organizacion);
    $codigo     = $conNota->codigo_org;
    $fechaElec  = $conNota->fecha_eleccion?->format('d/m/Y') ?? '—';

    $urnas   = str_pad($conNota->log_urnas   ?? 0, 2, '0', STR_PAD_LEFT);
    $cuartos = str_pad($conNota->log_cuartos ?? 0, 2, '0', STR_PAD_LEFT);
    $tintas  = str_pad($conNota->log_tintas  ?? 0, 2, '0', STR_PAD_LEFT);

    $logoPath   = public_path('images/logo.png');
    $logoBase64 = base64_encode(file_get_contents($logoPath));
    $logoSrc    = 'data:image/png;base64,' . $logoBase64;

    $html = '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; color: #000; margin: 8px 36px; line-height: 1.4; }
        .header { display:flex; align-items:center; gap:12px; border-bottom:3px solid #1e3a5f; padding-bottom:8px; margin-bottom:10px; }
        .inst h1 { font-size:12px; font-weight:700; margin:0 0 2px; text-transform:uppercase; color:#1e3a5f; }
        .inst p { font-size:8px; color:#555; margin:0; }
        .inst .codigo { font-size:10px; font-weight:700; color:#1e3a5f; margin-top:2px; }
        .org-box { background:#f0f4f8; border-left:4px solid #1e3a5f; padding:6px 10px; margin-bottom:10px; }
        .org-name { font-size:12px; font-weight:700; text-transform:uppercase; color:#1e3a5f; }
        .org-meta { font-size:9px; color:#555; margin-top:2px; }
        .sec-title { background:#1e3a5f; color:#fff; font-size:9px; font-weight:700; padding:3px 8px; margin:8px 0 6px; text-transform:uppercase; }
        .dato { font-size:10px; margin-bottom:6px; }
        .mat-grid { width:100%; border-collapse:collapse; margin:8px 0; }
        .mat-grid td { border:1px solid #bfdbfe; background:#eff6ff; padding:6px; text-align:center; width:33%; }
        .mat-label { font-size:8px; color:#1e40af; text-transform:uppercase; display:block; margin-bottom:2px; }
        .mat-val { font-size:16px; font-weight:700; color:#1e40af; }
        .firma-table { width:100%; border-collapse:collapse; margin-top:20px; }
        .firma-table td { text-align:center; font-size:9px; color:#555; border-top:1px solid #000; padding-top:3px; }
        .separador { border:none; border-top:2px dashed #1e3a5f; margin:14px 0; }
        .aviso { border:2px solid #1e3a5f; background:#f0f4f8; padding:7px 10px; font-size:9px; font-weight:700; text-align:center; line-height:1.6; color:#1e3a5f; margin-top:8px; }
        .dev-row { font-size:10px; margin-bottom:5px; }
        .fecha-gen { text-align:right; font-size:9px; color:#888; margin-bottom:4px; }
    </style>
</head>
<body>

<div class="fecha-gen">Generado el ' . $fechaCorta . ' — Sistema de Gestión Electoral</div>

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
        <strong>Asesor/a:</strong> ' . ($conNota->asesor_asignado ?? '—') . ' &nbsp;&nbsp;
        <strong>Fecha de Elección:</strong> ' . $fechaElec . ' &nbsp;&nbsp;
        <strong>Fecha de Entrega:</strong> ' . $fechaCorta . '
    </div>
</div>

<div class="sec-title">[ 1 ] Préstamo de Materiales Logísticos</div>

<div class="dato">La Dirección de Organizaciones Intermedias del Tribunal Superior de Justicia Electoral, <strong>otorga en calidad de préstamo</strong> los siguientes materiales:</div>

<table class="mat-grid">
    <tr>
        <td><span class="mat-label">Cuartos Oscuros</span><span class="mat-val">' . $cuartos . '</span></td>
        <td><span class="mat-label">Urnas</span><span class="mat-val">' . $urnas . '</span></td>
        <td><span class="mat-label">Tintas</span><span class="mat-val">' . $tintas . '</span></td>
    </tr>
</table>

<div style="font-size:10px; margin-top:10px; font-weight:700;">Datos de quien retira:</div>

<table class="firma-table">
    <tr>
        <td>Firma</td>
        <td>Aclaración</td>
        <td>N° de Teléfono</td>
    </tr>
</table>
<div style="font-size:10px; margin-top:10px; border-bottom:1px solid #000; padding-bottom:2px;">Nombre del funcionario que otorga: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>

<hr class="separador">

<div class="sec-title">[ 2 ] Devolución y Constancia — Dirección de Organizaciones Intermedias</div>

<div class="dato"><strong>Código:</strong> ' . $codigo . ' &nbsp;&nbsp; <strong>Organización:</strong> ' . $org . '</div>
<div class="dato"><strong>Detalle:</strong> (' . $urnas . ') urna(s) de plástico, (' . $cuartos . ') cuarto(s) oscuros, (' . $tintas . ') frasco(s) de tinta indeleble.</div>
<div class="dato"><strong>Fecha de entrega:</strong> ' . $fechaCorta . '</div>

<table style="width:100%; border-collapse:collapse; margin:8px 0;">
    <tr>
        <td style="font-size:9px; border-bottom:1px solid #999; padding:2px 4px; width:40%;">Fecha de devolución: _______ / _______ / _______</td>
        <td style="font-size:9px; border-bottom:1px solid #999; padding:2px 4px; width:20%;">Urnas devueltas: _______</td>
        <td style="font-size:9px; border-bottom:1px solid #999; padding:2px 4px; width:20%;">Cuartos devueltos: _______</td>
        <td style="font-size:9px; border-bottom:1px solid #999; padding:2px 4px; width:20%;">Tintas devueltas: _______</td>
    </tr>
</table>
<div style="font-size:10px; border-bottom:1px solid #000; padding-bottom:2px; margin-bottom:8px;">Funcionario que recibe: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>

<div class="aviso">
    LOS MATERIALES OTORGADOS EN CALIDAD DE PRÉSTAMO DEBEN SER DEVUELTOS EN LA DIRECCIÓN DE ORGANIZACIONES INTERMEDIAS 72 HS POSTERIORES A LA REALIZACIÓN DE LAS ELECCIONES DE AUTORIDADES.
</div>

</body>
</html>';

    $dompdf = new \Dompdf\Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('letter', 'portrait');
    $dompdf->render();

  if ($conNota->asunto_log && !$conNota->asunto_tec) {
    $conNota->update([
        'log_impreso_at' => now(),
        'log_estado'     => 'entregada',
    ]);
} else {
    $conNota->update([
        'log_impreso_at' => now(),
    ]);
}
// Notificar a Secretaria Sin Nota
$secretarias = \App\Models\User::role('Secretaria Sin Nota')->get();
foreach ($secretarias as $secretaria) {
    $secretaria->notify(new \App\Notifications\TrabajoPendienteNotification(
        'Logística impresa: ' . $conNota->nombre_organizacion . ' (' . $conNota->codigo_org . ')',
        'Panel Logístico',
        $conNota->id
    ));
    if ($secretaria->notifications()->count() > 8) {
        $secretaria->notifications()->latest()->skip(8)->take(100)->delete();
    }
}
return new Response($dompdf->output(), 200, [
    'Content-Type'        => 'application/pdf',
    'Content-Disposition' => 'inline; filename="recibo-log-' . $codigo . '.pdf"',
]);
}
}
