<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header img {
            width: 80px;
            height: 80px;
        }
        .header h1 {
            font-size: 16px;
            margin: 5px 0;
            text-transform: uppercase;
        }
        .header h2 {
            font-size: 13px;
            margin: 3px 0;
            font-weight: normal;
        }
        .header h3 {
            font-size: 12px;
            margin: 3px 0;
            font-weight: normal;
            color: #555;
        }
        .periodo {
            text-align: center;
            margin-bottom: 15px;
            font-size: 11px;
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th {
            background-color: #2d6a9f;
            color: white;
            padding: 6px 8px;
            text-align: left;
            font-size: 11px;
        }
        td {
            padding: 5px 8px;
            border-bottom: 1px solid #ddd;
            font-size: 11px;
        }
        tr:nth-child(even) {
            background-color: #f5f5f5;
        }
        .footer {
            margin-top: 20px;
            text-align: right;
            font-size: 10px;
            color: #888;
        }
        .total {
            margin-top: 10px;
            text-align: right;
            font-weight: bold;
            font-size: 12px;
        }
    </style>
</head>
<body>

    <div class="header">
        <img src="{{ public_path('images/logo_tsje.png') }}" alt="Logo">
        <h1>Dirección de Organizaciones Intermedias</h1>
        <h2>Justicia Electoral — República del Paraguay</h2>
        <h3>Reporte de Entradas Sin Nota</h3>
    </div>

    <div class="periodo">
        Período:
        <strong>{{ $fecha_desde == 'inicio' ? 'Desde el inicio' : \Carbon\Carbon::parse($fecha_desde)->format('d/m/Y') }}</strong>
        hasta
        <strong>{{ \Carbon\Carbon::parse($fecha_hasta)->format('d/m/Y') }}</strong>
    </div>

    <table>
        <thead>
            <tr>
                <th>N° Entrada</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Teléfono</th>
                <th>Tipo de Charla</th>
                <th>Asesor</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            @forelse($entradas as $entrada)
                <tr>
                    <td>{{ $entrada->numero_entrada }}</td>
                    <td>{{ $entrada->nombre }}</td>
                    <td>{{ $entrada->apellido }}</td>
                    <td>{{ $entrada->telefono ?? '-' }}</td>
                    <td>{{ $entrada->tipo_charla }}</td>
                    <td>{{ $entrada->asesor ? $entrada->asesor->nombre . ' ' . $entrada->asesor->apellido : '-' }}</td>
                    <td>{{ $entrada->created_at ? $entrada->created_at->format('d/m/Y') : '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align:center; padding: 20px;">
                        No hay entradas para el período seleccionado.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="total">
        Total de entradas: {{ $entradas->count() }}
    </div>

    <div class="footer">
        Generado el {{ now()->format('d/m/Y H:i') }}
    </div>

</body>
</html>
