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
        $presidente = Configuracion::get('presidente_tsje', 'Presidente del TSJE');

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
}
