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
        $fecha      = now()->locale('es')->isoFormat('D [de] MMMM [del] YYYY');
        $fechaCorta = now()->format('d/m/Y');
        $org        = strtoupper($conNota->nombre_organizacion);
        $codigo     = $conNota->codigo_org;

        // Armar detalle de materiales
        $materiales = [];
        if ($conNota->log_urnas   > 0) $materiales[] = '(' . $conNota->log_urnas   . ') urna(s) de plastico';
        if ($conNota->log_cuartos > 0) $materiales[] = '(' . $conNota->log_cuartos . ') cuarto(s) oscuro(s)';
        if ($conNota->log_tintas  > 0) $materiales[] = '(' . $conNota->log_tintas  . ') tinta(s)';
        $detalleMateriales = implode(', ', $materiales) ?: '—';

        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <style>
                body {
                    font-family: Arial, sans-serif;
                    font-size: 12px;
                    margin: 50px;
                    color: #000;
                    line-height: 1.7;
                }
                h2 { font-size: 14px; text-align: center; margin-bottom: 4px; text-transform: uppercase; }
                .subtitulo { text-align: center; font-size: 11px; color: #444; margin-bottom: 24px; }
                .dato { margin-bottom: 10px; }
                .dato span { font-weight: bold; }
                .linea-firma { border-top: 1px solid #000; width: 60%; margin: 40px auto 4px auto; }
                .firma-label { text-align: center; font-size: 11px; }
                .separador {
                    border: none;
                    border-top: 2px dashed #000;
                    margin: 40px 0;
                }
                .parte-inferior { font-size: 11px; }
                .parte-inferior h3 { font-size: 12px; text-align: center; margin-bottom: 12px; }
                .aviso {
                    margin-top: 20px;
                    font-size: 10px;
                    font-style: italic;
                    border: 1px solid #000;
                    padding: 8px 12px;
                    line-height: 1.5;
                }
            </style>
        </head>
        <body>

            {{-- PARTE SUPERIOR — se lleva la organización --}}
            <h2>Direccion de Organizaciones Intermedias</h2>
            <p class="subtitulo">Recibo de Prestamo de Materiales Logisticos</p>

            <div class="dato">Codigo: <span>' . $codigo . '</span></div>
            <div class="dato">Organizacion: <span>' . $org . '</span></div>
            <div class="dato">Representante: <span>' . $conNota->nombre_representante . '</span></div>
            <div class="dato">Fecha de entrega: <span>' . $fechaCorta . '</span></div>
            <div class="dato">Materiales entregados: <span>' . $detalleMateriales . '</span></div>
            <div class="dato">Fecha de eleccion: <span>' . ($conNota->fecha_eleccion?->format('d/m/Y') ?? '—') . '</span></div>

            <br>
            <div class="dato">Nombre de quien retira: _______________________________________________</div>
            <div class="dato">CI: ___________________________</div>

            <div class="linea-firma"></div>
            <p class="firma-label">Firma de quien retira</p>

            {{-- SEPARADOR PUNTEADO — se corta acá --}}
            <hr class="separador">

            {{-- PARTE INFERIOR — se queda en la direccion --}}
            <div class="parte-inferior">
                <h3>Constancia de Devolucion — Direccion de Organizaciones Intermedias</h3>

                <div class="dato">Codigo: <span>' . $codigo . '</span></div>
                <div class="dato">Organizacion: <span>' . $org . '</span></div>
                <div class="dato">Materiales prestados: <span>' . $detalleMateriales . '</span></div>
                <div class="dato">Fecha de entrega: <span>' . $fechaCorta . '</span></div>
                <div class="dato">Fecha de devolucion: _____ / _____ / _________</div>
                <div class="dato">Funcionario/a que recibe: _______________________________________________</div>

                <div class="aviso">
                    LOS MATERIALES OTORGADOS EN CALIDAD DE PRESTAMO DEBEN SER DEVUELTOS EN LA
                    DIRECCION DE SERVICIOS ELECTORALES 72 HS POSTERIORES A LA REALIZACION DE
                    LAS ELECCIONES DE AUTORIDADES.
                </div>
            </div>

        </body>
        </html>';

        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return new Response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="recibo-log-' . $codigo . '.pdf"',
        ]);
    }
}
