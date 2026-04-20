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
        <img src="<?php echo e(public_path('images/logo.png')); ?>" alt="Logo">
        <h1>Dirección de Organizaciones Intermedias</h1>
        <h2>Justicia Electoral — República del Paraguay</h2>
        <h3>Reporte de Servicios Realizados</h3>
    </div>

    <div class="periodo">
        Período:
        <strong><?php echo e($fecha_desde == 'inicio' ? 'Desde el inicio' : \Carbon\Carbon::parse($fecha_desde)->format('d/m/Y')); ?></strong>
        hasta
        <strong><?php echo e(\Carbon\Carbon::parse($fecha_hasta)->format('d/m/Y')); ?></strong>
    </div>

    <table>
        <thead>
            <tr>
                <th>N° Entrada</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Teléfono</th>
                <th>Tipo de Servicio</th>
                <th>Asesor</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $entradas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entrada): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($entrada->numero_entrada); ?></td>
                    <td><?php echo e($entrada->nombre); ?></td>
                    <td><?php echo e($entrada->apellido); ?></td>
                    <td><?php echo e($entrada->telefono ?? '—'); ?></td>
                    <td><?php echo e($entrada->tipo_charla); ?></td>
                    <td><?php echo e($entrada->asesor ? $entrada->asesor->nombre . ' ' . $entrada->asesor->apellido : '—'); ?></td>
                    <td><?php echo e($entrada->created_at ? $entrada->created_at->format('d/m/Y') : '—'); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7" style="text-align:center; padding:20px; color:#94a3b8;">
                        No hay entradas para el período seleccionado.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="total">
        Total de servicios: <?php echo e($entradas->count()); ?>

    </div>

    <div class="footer">
        Generado el <?php echo e(now()->format('d/m/Y H:i')); ?>

    </div>

</body>
</html>
<?php /**PATH /var/www/html/resources/views/secretaria/sin_nota/pdf.blade.php ENDPATH**/ ?>