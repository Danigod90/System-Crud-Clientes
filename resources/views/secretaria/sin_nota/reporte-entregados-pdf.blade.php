<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #1e293b;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 14px;
            border-bottom: 2px solid #1e3a5f;
        }
        .header img {
            width: 70px;
            height: 70px;
            margin-bottom: 6px;
        }
        .header h1 {
            font-size: 15px;
            margin: 4px 0;
            text-transform: uppercase;
            color: #1e3a5f;
            letter-spacing: 0.5px;
        }
        .header h2 {
            font-size: 12px;
            margin: 2px 0;
            font-weight: normal;
            color: #475569;
        }
        .header h3 {
            font-size: 11px;
            margin: 6px 0 0;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .periodo {
            text-align: center;
            margin-bottom: 16px;
            font-size: 11px;
            color: #64748b;
            background: #f8fafc;
            padding: 6px 12px;
            border-radius: 4px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 4px;
        }
        th {
            background-color: #1e3a5f;
            color: white;
            padding: 7px 8px;
            text-align: left;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }
        td {
            padding: 5px 8px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 10px;
            color: #374151;
        }
        tr:nth-child(even) td {
            background-color: #f8fafc;
        }
        .total {
            margin-top: 12px;
            text-align: right;
            font-weight: bold;
            font-size: 11px;
            color: #1e3a5f;
        }
        .footer {
            margin-top: 16px;
            text-align: right;
            font-size: 9px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 8px;
        }
    </style>
</head>
<body>

    <div class="header">
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/logo.png'))) }}" alt="Logo">
        <h1>Dirección de Organizaciones Intermedias</h1>
        <h2>Justicia Electoral — República del Paraguay</h2>
        <h3>Reporte de Materiales Entregados — Esperando Devolución</h3>
    </div>

    <div class="periodo">
        <table style="width:100%; border-collapse:collapse;">
            <tr>
                <td style="text-align:left; padding:0;"><strong>Mesa de Entrada:</strong> {{ $usuario }}</td>
                <td style="text-align:right; padding:0;"><strong>Período:</strong> {{ $fecha_desde == 'inicio' ? 'Desde el inicio' : \Carbon\Carbon::parse($fecha_desde)->format('d/m/Y') }} hasta {{ \Carbon\Carbon::parse($fecha_hasta)->format('d/m/Y') }}</td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Organización</th>
                <th>Asunto</th>
                <th>Persona que retira</th>
                <th>Teléfono</th>
                <th>Asesor</th>
                <th>Urnas</th>
                <th>Cuartos</th>
                <th>Tintas</th>
                <th>Fecha entrega</th>
            </tr>
        </thead>
        <tbody>
            @forelse($entregados as $entrada)
                @php
                    $mTec    = $entrada->detalleTecnico;
                    $m       = $mTec->cantidad_mesas ?? 0;
                    $p       = $mTec->cantidad_papeletas ?? 0;
                    $usaTecFila = $entrada->asunto_tec && $entrada->asunto_log && !$entrada->logConCantidadesReales();
                    $urnas   = $usaTecFila ? ($mTec->mat_final_urnas   ?? ($m * $p)) : ($entrada->asunto_log ? ($entrada->log_urnas   ?? 0) : 0);
                    $cuartos = $usaTecFila ? ($mTec->mat_final_cuartos ?? $m)        : ($entrada->asunto_log ? ($entrada->log_cuartos ?? 0) : 0);
                    $tintas  = $usaTecFila ? ($mTec->mat_final_tintas  ?? $m)        : ($entrada->asunto_log ? ($entrada->log_tintas  ?? 0) : 0);
                @endphp
                <tr>
                    <td>{{ $entrada->codigo_org }}</td>
                    <td>{{ $entrada->nombre_organizacion }}</td>
                    <td>{{ $entrada->asunto_tec ? 'LOG + TEC' : 'LOG' }}</td>
                    <td>{{ $entrada->persona_retira ?? '—' }}</td>
                    <td>{{ $entrada->telefono_retira ?? '—' }}</td>
                    <td>{{ $entrada->asesor_asignado ?? '—' }}</td>
                    <td>{{ $urnas }}</td>
                    <td>{{ $cuartos }}</td>
                    <td>{{ $tintas }}</td>
                    <td>{{ $entrada->fecha_entrega ? $entrada->fecha_entrega->format('d/m/Y H:i') : '—' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" style="text-align:center; padding:20px; color:#94a3b8;">
                        No hay organizaciones con materiales entregados pendientes de devolución en el período seleccionado.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="total">
        Total de organizaciones pendientes de devolución: {{ $entregados->count() }}
    </div>

    <div class="footer">
        Generado el {{ now()->format('d/m/Y H:i') }}
    </div>

</body>
</html>
