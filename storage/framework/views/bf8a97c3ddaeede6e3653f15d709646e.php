<?php if (isset($component)) { $__componentOriginald3474b09374f7a1c6aabd4f89d6847dc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald3474b09374f7a1c6aabd4f89d6847dc = $attributes; } ?>
<?php $component = App\View\Components\PanelLayout::resolve(['title' => 'Ver Entrada — '.e($conNota->codigo_org).'','charlasPendientes' => $charlasPendientes] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('panel-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\PanelLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

<div class="px-2 py-2">
    <div style="max-width:760px; margin:0 auto;">

        <?php if(session('success')): ?>
        <div style="background:#d1fae5; color:#065f46; padding:10px 14px; border-radius:8px; margin-bottom:14px; font-size:13px;">
            <?php echo e(session('success')); ?>

        </div>
        <?php endif; ?>

        
        <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:20px; margin-bottom:14px; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
            <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                <div>
                    <span style="font-family:monospace; color:#185FA5; font-weight:700; font-size:18px;"><?php echo e($conNota->codigo_org); ?></span>
                    <p style="font-size:11px; color:#9ca3af; margin-top:4px;">Registrado por <?php echo e($conNota->registrado_por); ?> el <?php echo e($conNota->created_at?->format('d/m/Y H:i') ?? '-'); ?></p>
                    <div style="display:flex; align-items:center; gap:8px; margin-top:8px;">
                        <div id="ticker-box"
                             onclick="toggleTicker()"
                             style="width:18px; height:18px; border-radius:4px; border:1.5px solid <?php echo e($conNota->mostrar_en_ticker ? '#16a34a' : '#d1d5db'); ?>; background:transparent; display:flex; align-items:center; justify-content:center; cursor:pointer; flex-shrink:0;">
                            <svg id="ticker-check" width="12" height="12" fill="none" stroke="#16a34a" stroke-width="2.5" viewBox="0 0 24 24"
                                 style="display:<?php echo e($conNota->mostrar_en_ticker ? 'block' : 'none'); ?>;">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                        </div>
                        <span id="ticker-label" style="font-size:12px; color:#6b7280; cursor:pointer;" onclick="toggleTicker()">
                            <?php echo e($conNota->mostrar_en_ticker ? 'Mostrar en ticker' : 'Oculto del ticker'); ?>

                        </span>
                    </div>
                </div>

                <div style="display:flex; gap:8px; flex-wrap:wrap; justify-content:flex-end;">
                    <a href="<?php echo e(route('secretaria.con-nota.edit', ['conNota' => $conNota->id])); ?><?php echo e(request('from') == 'asesor' ? '?from=asesor' : ''); ?>"
                       style="display:inline-flex; align-items:center; gap:6px; background:#f59e0b; color:white; padding:8px 14px; border-radius:8px; font-size:13px; text-decoration:none;">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                        </svg>
                        Editar
                    </a>

                    <?php if($conNota->via_ingreso == 'presencial'): ?>
                    <a href="<?php echo e(route('secretaria.con-nota.nota-pdf', $conNota->id)); ?>" target="_blank"
                       style="display:inline-flex; align-items:center; gap:6px; background:#1e3a5f; color:white; padding:8px 14px; border-radius:8px; font-size:13px; text-decoration:none;">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                        </svg>
                        Imprimir Nota
                    </a>
                    <?php endif; ?>

                    <?php if($conNota->asunto_log && !$conNota->asunto_tec): ?>
                    <a href="<?php echo e(route('secretaria.con-nota.recibo-logistica', $conNota->id)); ?>" target="_blank"
                       style="display:inline-flex; align-items:center; gap:6px; background:#065f46; color:white; padding:8px 14px; border-radius:8px; font-size:13px; text-decoration:none;">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                        </svg>
                        Imprimir Logístico
                    </a>
                    <?php endif; ?>

                    <?php if($conNota->asunto_log && !$conNota->asunto_tec && $conNota->log_estado !== 'entregada'): ?>
                    <form method="POST" action="<?php echo e(route('secretaria.con-nota.entregar-log', $conNota->id)); ?>" style="display:inline;">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PATCH'); ?>
                        <button type="submit"
                                onclick="return confirm('¿Confirmar entrega logística de <?php echo e($conNota->nombre_organizacion); ?>?')"
                                style="display:inline-flex; align-items:center; gap:6px; background:#065f46; color:white; padding:8px 14px; border-radius:8px; font-size:13px; border:none; cursor:pointer;">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                            Marcar entregado
                        </button>
                    </form>
                    <?php elseif($conNota->asunto_log && !$conNota->asunto_tec && $conNota->log_estado === 'entregada'): ?>
                    <span style="display:inline-flex; align-items:center; gap:6px; background:#d1fae5; color:#065f46; padding:8px 14px; border-radius:8px; font-size:13px; font-weight:500;">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                        Entregado
                    </span>
                    <?php endif; ?>

                    <a href="<?php echo e(request('from') == 'asesor' ? route('asesor.mis-organizaciones') : route('secretaria.con-nota.index')); ?>"
                       style="display:inline-flex; align-items:center; gap:6px; background:#f3f4f6; color:#374151; padding:8px 14px; border-radius:8px; font-size:13px; text-decoration:none;">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <polyline points="15 18 9 12 15 6"/>
                        </svg>
                        Volver
                    </a>
                </div>
            </div>
        </div>

        
        <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:20px; margin-bottom:14px; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
            <h3 style="font-size:13px; font-weight:600; color:#374151; margin-bottom:16px; padding-bottom:10px; border-bottom:1px solid #f3f4f6; text-transform:uppercase; letter-spacing:0.5px;">Datos de la organización</h3>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                <div>
                    <p style="font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px;">Organización</p>
                    <p style="font-size:14px; font-weight:600; color:#111827; margin:0;"><?php echo e($conNota->nombre_organizacion); ?></p>
                    <p style="font-size:12px; color:#6b7280; margin:2px 0 0;"><?php echo e($conNota->tipo_organizacion); ?></p>
                </div>
                <div>
                    <p style="font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px;">Representante</p>
                    <p style="font-size:14px; font-weight:600; color:#111827; margin:0;"><?php echo e($conNota->nombre_representante); ?></p>
                    <?php if($conNota->telefono_representante): ?>
                    <p style="font-size:12px; color:#6b7280; margin:2px 0 0;"><?php echo e($conNota->telefono_representante); ?></p>
                    <?php endif; ?>
                </div>
                <div>
                    <p style="font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px;">Asesor asignado</p>
                    <p style="font-size:14px; font-weight:600; color:#111827; margin:0;"><?php echo e($conNota->asesor_asignado ?? '-'); ?></p>
                </div>
                <div>
                    <p style="font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px;">Vía de ingreso</p>
                    <p style="font-size:14px; font-weight:600; color:#111827; margin:0; text-transform:capitalize;"><?php echo e($conNota->via_ingreso); ?></p>
                </div>
                <div>
                    <p style="font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px;">Fecha de elección</p>
                    <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">
                        <?php echo e($conNota->fecha_eleccion ? $conNota->fecha_eleccion->format('d/m/Y') : '—'); ?>

                    </p>
                </div>
                <div>
                    <p style="font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px;">Asunto</p>
                    <p style="font-size:14px; font-weight:700; color:#111827; font-family:monospace; margin:0;"><?php echo e($conNota->asunto_texto); ?></p>
                </div>
            </div>
        </div>

        
        <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:20px; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
            <h3 style="font-size:13px; font-weight:600; color:#374151; margin-bottom:16px; padding-bottom:10px; border-bottom:1px solid #f3f4f6; text-transform:uppercase; letter-spacing:0.5px;">Servicios solicitados</h3>

            <div style="display:flex; gap:10px; flex-wrap:nowrap;">
                <span style="display:inline-flex; align-items:center; gap:6px; padding:6px 14px; border-radius:20px; font-size:13px; font-weight:500;
                    background:<?php echo e($conNota->asunto_char ? '#dbeafe' : '#f3f4f6'); ?>;
                    color:<?php echo e($conNota->asunto_char ? '#1d4ed8' : '#9ca3af'); ?>;
                    text-decoration:<?php echo e($conNota->asunto_char ? 'none' : 'line-through'); ?>;">
                    CHARLA
                </span>
                <span style="display:inline-flex; align-items:center; gap:6px; padding:6px 14px; border-radius:20px; font-size:13px; font-weight:500;
    background:<?php echo e($conNota->asunto_log ? '#d1fae5' : '#f3f4f6'); ?>;
    color:<?php echo e($conNota->asunto_log ? '#065f46' : '#9ca3af'); ?>;
    text-decoration:<?php echo e($conNota->asunto_log ? 'none' : 'line-through'); ?>;">
    LOGÍSTICA
</span>
                <span style="display:inline-flex; align-items:center; gap:6px; padding:6px 14px; border-radius:20px; font-size:13px; font-weight:500;
                    background:<?php echo e($conNota->asunto_tec ? '#ede9fe' : '#f3f4f6'); ?>;
                    color:<?php echo e($conNota->asunto_tec ? '#6d28d9' : '#9ca3af'); ?>;
                    text-decoration:<?php echo e($conNota->asunto_tec ? 'none' : 'line-through'); ?>;">
                    TECNICA
                </span>
                <span style="display:inline-flex; align-items:center; gap:6px; padding:6px 14px; border-radius:20px; font-size:13px; font-weight:500;
                    background:<?php echo e($conNota->asunto_obs ? '#fef3c7' : '#f3f4f6'); ?>;
                    color:<?php echo e($conNota->asunto_obs ? '#92400e' : '#9ca3af'); ?>;
                    text-decoration:<?php echo e($conNota->asunto_obs ? 'none' : 'line-through'); ?>;">
                    OBSERVADORES
                </span>
            </div>

            <?php if($conNota->asunto_log && !$conNota->asunto_tec): ?>
            <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:20px; margin-top:14px; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
                <h3 style="font-size:13px; font-weight:600; color:#374151; margin-bottom:16px; padding-bottom:10px; border-bottom:1px solid #f3f4f6; text-transform:uppercase; letter-spacing:0.5px; display:flex; align-items:center; gap:8px;">
                    Detalle Logístico
                    <?php $logDot = ($conNota->log_estado ?? 'pendiente') === 'entregada' ? '#16a34a' : '#eab308'; ?>
                    <span style="display:inline-flex; align-items:center; gap:4px; font-size:11px; font-weight:500; color:#6b7280; text-transform:none;">
                        <span style="width:9px; height:9px; border-radius:50%; background:<?php echo e($logDot); ?>; display:inline-block;"></span>
                        <?php echo e(($conNota->log_estado ?? 'pendiente') === 'entregada' ? 'Entregada' : 'Pendiente'); ?>

                    </span>
                </h3>
                <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:16px;">
                    <div style="text-align:center;">
                        <p style="font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px;">Urnas</p>
                        <p style="font-size:14px; font-weight:600; color:#111827; margin:0;"><?php echo e($conNota->log_urnas ?? 0); ?></p>
                    </div>
                    <div style="text-align:center;">
                        <p style="font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px;">Cuartos oscuros</p>
                        <p style="font-size:14px; font-weight:600; color:#111827; margin:0;"><?php echo e($conNota->log_cuartos ?? 0); ?></p>
                    </div>
                    <div style="text-align:center;">
                        <p style="font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px;">Tintas</p>
                        <p style="font-size:14px; font-weight:600; color:#111827; margin:0;"><?php echo e($conNota->log_tintas ?? 0); ?></p>
                    </div>
                </div>
            </div>
            <?php endif; ?>

<?php if($conNota->detalleTecnico): ?>
<?php $mTec = $conNota->detalleTecnico; ?>
<div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:20px; margin-top:14px; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
    <h3 style="font-size:13px; font-weight:600; color:#374151; text-transform:uppercase; letter-spacing:0.5px; margin:0 0 16px; padding-bottom:10px; border-bottom:1px solid #f3f4f6; display:flex; align-items:center; gap:8px;">
        Datos del Asesor
        <span style="display:inline-flex; align-items:center; gap:4px; font-size:11px; font-weight:500; color:#6b7280; text-transform:none;">
            <span style="width:9px; height:9px; border-radius:50%; background:<?php echo e($mTec->enviado_tecnica ? '#16a34a' : '#eab308'); ?>; display:inline-block;"></span>
            <?php echo e($mTec->enviado_tecnica ? 'Enviado a Técnica' : 'Pendiente'); ?>

        </span>
    </h3>
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:12px;">
        <div>
            <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase;">Órgano Electoral</label>
            <p style="font-size:14px; font-weight:600; color:#111827; margin:0;"><?php echo e($mTec->organo_electoral ?? '—'); ?></p>
        </div>
        <div>
            <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase;">Cantidad de Listas</label>
            <p style="font-size:14px; font-weight:600; color:#111827; margin:0;"><?php echo e($mTec->cantidad_listas ?? '—'); ?></p>
        </div>
        <div>
            <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase;">Cantidad de Papeletas</label>
            <p style="font-size:14px; font-weight:600; color:#111827; margin:0;"><?php echo e($mTec->cantidad_papeletas ?? '—'); ?></p>
        </div>
        <div>
            <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase;">Cantidad de Mesas</label>
            <p style="font-size:14px; font-weight:600; color:#111827; margin:0;"><?php echo e($mTec->cantidad_mesas ?? '—'); ?></p>
        </div>
    </div>

    <?php
        $cantPap = $mTec->cantidad_papeletas ?? 0;
        $ordinal = ['Primera','Segunda','Tercera','Cuarta','Quinta','Sexta','Séptima','Octava','Novena','Décima'];
    ?>
    <?php if($cantPap > 0): ?>
    <div style="margin-bottom:12px;">
        <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:8px; text-transform:uppercase;">Papeletas</label>
        <?php for($p = 1; $p <= min($cantPap, 10); $p++): ?>
        <?php
            $listaNombres = [];
            for ($l = 1; $l <= ($mTec->cantidad_listas ?? 1); $l++) {
                $n = $mTec->{"pap_{$p}_lista_{$l}_nombre"} ?? null;
                if ($n) $listaNombres[] = $n;
            }
        ?>
        <div style="display:flex; align-items:center; gap:12px; padding:8px 12px; background:#f9fafb; border:1px solid #e5e7eb; border-radius:8px; margin-bottom:6px;">
            <span style="font-size:12px; font-weight:700; color:#374151; white-space:nowrap;"><?php echo e($ordinal[$p-1]); ?> Papeleta</span>
            <?php if(count($listaNombres)): ?>
            <span style="font-size:11px; background:#e5e7eb; color:#374151; padding:2px 8px; border-radius:4px; white-space:nowrap;">Lista <?php echo e(implode(', ', $listaNombres)); ?></span>
            <?php endif; ?>
            <span style="font-size:13px; color:#111827; flex:1;"><?php echo e($mTec->{"pap_{$p}_lista_1_candidatura"} ?? '—'); ?></span>
            <span style="font-size:11px; color:#6b7280; white-space:nowrap;"><?php echo e($mTec->{"pap_{$p}_sistema_eleccion"} ?? '—'); ?></span>
        </div>
        <?php endfor; ?>
    </div>
    <?php endif; ?>

    <?php
        $estActas    = $mTec->mat_final_actas    !== null ? $mTec->mat_final_actas    : (($mTec->cantidad_mesas ?? 0) * 3);
        $estPadrones = $mTec->mat_final_padrones !== null ? $mTec->mat_final_padrones : (($mTec->cantidad_mesas ?? 0) * 3);
        $estCuartos  = $mTec->mat_final_cuartos  !== null ? $mTec->mat_final_cuartos  : ($mTec->cantidad_mesas ?? 0);
        $estUrnas    = $mTec->mat_final_urnas    !== null ? $mTec->mat_final_urnas    : (($mTec->cantidad_mesas ?? 0) * ($mTec->cantidad_papeletas ?? 0));
        $estTintas   = $mTec->mat_final_tintas   !== null ? $mTec->mat_final_tintas   : ($mTec->cantidad_mesas ?? 0);
    ?>
    <div style="background:#eff6ff; border:1px solid #bfdbfe; border-radius:8px; padding:12px 16px;">
        <p style="font-size:11px; font-weight:700; color:#1e40af; text-transform:uppercase; margin:0 0 10px;">Materiales a Entregar</p>
        <div style="display:grid; grid-template-columns:repeat(6,1fr); gap:8px;">
    <div style="text-align:center;">
        <p style="font-size:11px; color:#6b7280; margin:0 0 2px;">Papeletas</p>
        <p style="font-size:18px; font-weight:700; color:#1e40af; margin:0;"><?php echo e($mTec->mat_final_papeletas ?? $mTec->cantidad_papeletas ?? 0); ?></p>
        <?php if($mTec->mat_final_papeletas_formato): ?>
        <p style="font-size:10px; color:#6b7280; margin:2px 0 0;"><?php echo e(ucfirst($mTec->mat_final_papeletas_formato)); ?></p>
        <?php endif; ?>
    </div>
    <div style="text-align:center;">
        <p style="font-size:11px; color:#6b7280; margin:0 0 2px;">Actas</p>
        <p style="font-size:18px; font-weight:700; color:#1e40af; margin:0;"><?php echo e($estActas); ?></p>
        <?php if($mTec->mat_final_actas_formato): ?>
        <p style="font-size:10px; color:#6b7280; margin:2px 0 0;"><?php echo e(ucfirst($mTec->mat_final_actas_formato)); ?></p>
        <?php endif; ?>
    </div>
    <div style="text-align:center;">
        <p style="font-size:11px; color:#6b7280; margin:0 0 2px;">Padrones</p>
        <p style="font-size:18px; font-weight:700; color:#1e40af; margin:0;"><?php echo e($estPadrones); ?></p>
        <?php if($mTec->mat_final_padrones_formato): ?>
        <p style="font-size:10px; color:#6b7280; margin:2px 0 0;"><?php echo e(ucfirst($mTec->mat_final_padrones_formato)); ?></p>
        <?php endif; ?>
    </div>
    <div style="text-align:center;">
        <p style="font-size:11px; color:#6b7280; margin:0 0 2px;">Cuartos Oscuros</p>
        <p style="font-size:18px; font-weight:700; color:#1e40af; margin:0;"><?php echo e($estCuartos); ?></p>
    </div>
    <div style="text-align:center;">
        <p style="font-size:11px; color:#6b7280; margin:0 0 2px;">Urnas</p>
        <p style="font-size:18px; font-weight:700; color:#1e40af; margin:0;"><?php echo e($estUrnas); ?></p>
    </div>
    <div style="text-align:center;">
        <p style="font-size:11px; color:#6b7280; margin:0 0 2px;">Tintas</p>
        <p style="font-size:18px; font-weight:700; color:#1e40af; margin:0;"><?php echo e($estTintas); ?></p>
    </div>
</div>
    </div>
</div>
<?php endif; ?>
            
            <?php if($conNota->detalleTecnico?->tec_realizado): ?>
            <?php $mTec = $conNota->detalleTecnico; ?>
            <div style="background:#f0fdf4; border-radius:12px; border:1px solid #bbf7d0; padding:20px; margin-top:14px; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
                <div style="display:flex; align-items:center; gap:8px; margin-bottom:16px; padding-bottom:10px; border-bottom:1px solid #bbf7d0;">
                    <h3 style="font-size:13px; font-weight:600; color:#166534; text-transform:uppercase; letter-spacing:0.5px; margin:0;">✓ Trabajo Técnico Realizado</h3>
                    <span style="font-size:11px; color:#16a34a;"><?php echo e($mTec->tec_realizado_at ? \Carbon\Carbon::parse($mTec->tec_realizado_at)->format('d/m/Y H:i') : ''); ?></span>
                </div>

                <p style="font-size:11px; font-weight:700; color:#166534; text-transform:uppercase; margin:0 0 10px;">Materiales Entregados</p>
                <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:10px; margin-bottom:16px;">
                   <?php $__currentLoopData = [
    ['mat_mesas', 'Mesa/s', false, 'cantidad_mesas', null],
    ['mat_actas_electorales', 'Actas Electorales', 'mat_actas_electorales_formato', 'mat_final_actas', 'mat_final_actas_formato'],
    ['mat_padron', 'Padrón Electoral', 'mat_padron_formato', 'mat_final_padrones', 'mat_final_padrones_formato'],
    ['mat_matriz_boletin', 'Matriz de Boletín', 'mat_matriz_boletin_formato', 'mat_final_papeletas', 'mat_final_papeletas_formato'],
    ['mat_actas_proclamacion', 'Actas de Proclamación', false, null, null],
    ['mat_certificados', 'Certificados de Resultados', false, null, null],
    ['mat_cuenta_votos', 'Cuenta Votos', false, null, null],
]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$field, $label, $formatoField, $campoAsesor, $formatoAsesor]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div style="background:#fff; border:1px solid #d1fae5; border-radius:8px; padding:10px;">
    <label style="display:block; font-size:11px; font-weight:600; color:#16a34a; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px;"><?php echo e($label); ?></label>
    <p style="font-size:14px; font-weight:600; color:#111827; margin:0;"><?php echo e(($campoAsesor ? $mTec->$campoAsesor : null) ?? $mTec->$field ?? '—'); ?></p>
    <?php if($formatoField): ?>
    <?php $fmt = ($formatoAsesor ? $mTec->$formatoAsesor : null) ?? ($formatoField ? $mTec->$formatoField : null); ?>
    <?php if($fmt): ?>
    <p style="font-size:11px; color:#6b7280; margin:2px 0 0;"><?php echo e(ucfirst($fmt)); ?></p>
    <?php endif; ?>
    <?php endif; ?>
</div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <p style="font-size:11px; font-weight:700; color:#166534; text-transform:uppercase; margin:0 0 10px;">Padrón</p>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-bottom:10px;">
                    <div style="background:#fff; border:1px solid #d1fae5; border-radius:8px; padding:10px;">
                        <p style="font-size:13px; font-weight:600; color:#111827; margin:0;"><?php echo e($mTec->padron_definitivo ? '✓ Padrón Definitivo' : '✗ Sin Padrón Definitivo'); ?></p>
                    </div>
                    <div style="background:#fff; border:1px solid #d1fae5; border-radius:8px; padding:10px;">
                        <p style="font-size:13px; font-weight:600; color:#111827; margin:0;"><?php echo e($mTec->padron_con_cedula ? '✓ Padrón con Cédula' : '✗ Sin Padrón con Cédula'); ?></p>
                    </div>
                </div>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-bottom:16px;">
                    <div>
                        <label style="display:block; font-size:11px; font-weight:600; color:#16a34a; margin-bottom:4px; text-transform:uppercase;">Cantidad de Electores</label>
                        <p style="font-size:14px; font-weight:600; color:#111827; margin:0;"><?php echo e($mTec->cantidad_electores ?? '—'); ?></p>
                    </div>
                    <div>
                        <label style="display:block; font-size:11px; font-weight:600; color:#16a34a; margin-bottom:4px; text-transform:uppercase;">Electores sin C.I.</label>
                        <p style="font-size:14px; font-weight:600; color:#111827; margin:0;"><?php echo e($mTec->cantidad_electores_sin_ci ?? '—'); ?></p>
                    </div>
                </div>

                <p style="font-size:11px; font-weight:700; color:#166534; text-transform:uppercase; margin:0 0 10px;">Responsables</p>
                <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:10px;">
                    <?php $__currentLoopData = [
                        ['resp_actas_electorales', 'Actas Electorales'],
                        ['resp_papeletas', 'Papeletas / Boletín'],
                        ['resp_padron_electoral', 'Padrón Electoral'],
                    ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$field, $label]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div>
                        <label style="display:block; font-size:11px; font-weight:600; color:#16a34a; margin-bottom:4px; text-transform:uppercase;"><?php echo e($label); ?></label>
                        <p style="font-size:14px; font-weight:600; color:#111827; margin:0;"><?php echo e($mTec->$field ?? '—'); ?></p>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php endif; ?>
            
<?php if($conNota->asunto_char && $conNota->charlas->count() > 0): ?>
<?php $__currentLoopData = $conNota->charlas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $ch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php
    $dotColor = match($ch->estado) {
        'realizada'  => '#16a34a',
        'cancelada'  => '#dc2626',
        'suspendida' => '#f97316',
        'vencida'    => '#dc2626',
        default      => '#eab308',
    };
    $tipoLabel = match($ch->char_tipo ?? '') {
        'proceso_electoral' => 'Charla sobre Proceso Electoral',
        'mmrv'              => 'Charla para MMRV',
        'ambos'             => 'Charla sobre Proceso - Charla MMRV',
        default             => '—',
    };
?>
<div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:20px; margin-top:14px; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
    <h3 style="font-size:13px; font-weight:600; color:#374151; margin-bottom:16px; padding-bottom:10px; border-bottom:1px solid #f3f4f6; text-transform:uppercase; letter-spacing:0.5px; display:flex; align-items:center; gap:8px;">
        Charla <?php echo e($i+1); ?>

        <span style="display:inline-flex; align-items:center; gap:4px; font-size:11px; font-weight:500; color:#6b7280; text-transform:none;">
            <span style="width:9px; height:9px; border-radius:50%; background:<?php echo e($dotColor); ?>; display:inline-block;"></span>
            <?php echo e(ucfirst($ch->estado)); ?>

        </span>
    </h3>
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
        <div>
            <p style="font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px;">Modalidad</p>
            <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">
                <?php echo e($ch->modalidad == 'virtual' ? 'Virtual' : ($ch->modalidad == 'presencial_oficina' ? 'Presencial — Oficina' : 'Presencial — Externa')); ?>

            </p>
        </div>
        <?php if($ch->char_tipo): ?>
        <div>
            <p style="font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px;">Tipo de charla</p>
            <p style="font-size:14px; font-weight:600; color:#111827; margin:0;"><?php echo e($tipoLabel); ?></p>
        </div>
        <?php endif; ?>
        <div>
            <p style="font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px;">Fecha y hora</p>
            <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">
                <?php echo e($ch->fecha_hora?->format('d/m/Y H:i') ?? '—'); ?>

            </p>
        </div>
        <?php if($ch->direccion): ?>
        <div style="grid-column:span 2;">
            <p style="font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px;">Dirección</p>
            <p style="font-size:14px; font-weight:600; color:#111827; margin:0;"><?php echo e($ch->direccion); ?></p>
        </div>
        <?php endif; ?>
        <?php if($ch->descripcion): ?>
        <div style="grid-column:span 2;">
            <p style="font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px;">Descripción</p>
            <p style="font-size:14px; color:#111827; margin:0;"><?php echo e($ch->descripcion); ?></p>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>

            
            <?php if($conNota->asunto_obs && $conNota->observador): ?>
            <?php
                $obsDot = match($conNota->observador->estado) {
                    'realizada'  => '#16a34a',
                    'cancelada'  => '#dc2626',
                    'suspendida' => '#f97316',
                    default      => '#eab308',
                };
            ?>
            <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:20px; margin-top:14px; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
                <h3 style="font-size:13px; font-weight:600; color:#374151; margin-bottom:16px; padding-bottom:10px; border-bottom:1px solid #f3f4f6; text-transform:uppercase; letter-spacing:0.5px; display:flex; align-items:center; gap:8px;">
                    Observadores
                    <span style="display:inline-flex; align-items:center; gap:4px; font-size:11px; font-weight:500; color:#6b7280; text-transform:none;">
                        <span style="width:9px; height:9px; border-radius:50%; background:<?php echo e($obsDot); ?>; display:inline-block;"></span>
                        <?php echo e(ucfirst($conNota->observador->estado)); ?>

                    </span>
                </h3>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                    <div>
                        <p style="font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px;">Fecha y hora</p>
                        <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">
                            <?php echo e($conNota->observador->fecha_hora?->format('d/m/Y H:i') ?? '—'); ?>

                        </p>
                    </div>
                    <?php if($conNota->observador->observadores): ?>
                    <div>
                        <p style="font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px;">Observadores asistentes</p>
                        <p style="font-size:14px; color:#111827; margin:0;"><?php echo e($conNota->observador->observadores); ?></p>
                    </div>
                    <?php endif; ?>
                    <?php if($conNota->observador->descripcion): ?>
                    <div style="grid-column:span 2;">
                        <p style="font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px;">Descripción</p>
                        <p style="font-size:14px; color:#111827; margin:0;"><?php echo e($conNota->observador->descripcion); ?></p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>

        </div>

    </div>
</div>

<script>
async function toggleTicker() {
    try {
        const response = await fetch('<?php echo e(route('secretaria.con-nota.toggle-ticker', $conNota)); ?>', {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            }
        });

        const data = await response.json();

        const box = document.getElementById('ticker-box');
        const check = document.getElementById('ticker-check');
        const label = document.getElementById('ticker-label');

        if (data.mostrar_en_ticker) {
            box.style.borderColor = '#16a34a';
            check.style.display = 'block';
            label.textContent = 'Mostrar en ticker';
        } else {
            box.style.borderColor = '#d1d5db';
            check.style.display = 'none';
            label.textContent = 'Oculto del ticker';
        }

        window.location.reload();

    } catch (err) {
        console.error('Error toggle ticker:', err);
    }
}
</script>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald3474b09374f7a1c6aabd4f89d6847dc)): ?>
<?php $attributes = $__attributesOriginald3474b09374f7a1c6aabd4f89d6847dc; ?>
<?php unset($__attributesOriginald3474b09374f7a1c6aabd4f89d6847dc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald3474b09374f7a1c6aabd4f89d6847dc)): ?>
<?php $component = $__componentOriginald3474b09374f7a1c6aabd4f89d6847dc; ?>
<?php unset($__componentOriginald3474b09374f7a1c6aabd4f89d6847dc); ?>
<?php endif; ?>
<?php /**PATH /var/www/html/resources/views/secretaria/con_nota/show.blade.php ENDPATH**/ ?>