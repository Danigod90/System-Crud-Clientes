<?php if (isset($component)) { $__componentOriginald3474b09374f7a1c6aabd4f89d6847dc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald3474b09374f7a1c6aabd4f89d6847dc = $attributes; } ?>
<?php $component = App\View\Components\PanelLayout::resolve(['title' => 'Ver Entrada — '.e($conNota->codigo_org).''] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
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

            <?php if($conNota->asunto_log): ?>
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
            
            <?php if($conNota->asunto_char && $conNota->charla): ?>
            <?php
                $dotColor = match($conNota->charla->estado) {
                    'realizada'  => '#16a34a',
                    'cancelada'  => '#dc2626',
                    'suspendida' => '#f97316',
                    'vencida'    => '#dc2626',
                    default      => '#eab308',
                };
            ?>
            <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:20px; margin-top:14px; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
                <h3 style="font-size:13px; font-weight:600; color:#374151; margin-bottom:16px; padding-bottom:10px; border-bottom:1px solid #f3f4f6; text-transform:uppercase; letter-spacing:0.5px; display:flex; align-items:center; gap:8px;">
                    Detalle de Charla
                    <span style="display:inline-flex; align-items:center; gap:4px; font-size:11px; font-weight:500; color:#6b7280; text-transform:none;">
                        <span style="width:9px; height:9px; border-radius:50%; background:<?php echo e($dotColor); ?>; display:inline-block;"></span>
                        <?php echo e(ucfirst($conNota->charla->estado)); ?>

                    </span>
                </h3>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                    <div>
                        <p style="font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px;">Modalidad</p>
                        <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">
                            <?php echo e($conNota->charla->modalidad == 'virtual' ? 'Virtual' : ($conNota->charla->modalidad == 'presencial_oficina' ? 'Presencial — Oficina' : 'Presencial — Externa')); ?>

                        </p>
                    </div>
                    <?php if($conNota->charla->char_tipo): ?>
                    <div>
                        <p style="font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px;">Tipo de charla</p>
                        <?php
                            $tipoLabel = match($conNota->charla->char_tipo) {
                                'proceso_electoral' => 'Charla sobre Proceso Electoral',
                                'mmrv'              => 'Charla para MMRV',
                                'ambos'             => 'Charla sobre Proceso - Charla MMRV',
                                default             => '—',
                            };
                        ?>
                        <p style="font-size:14px; font-weight:600; color:#111827; margin:0;"><?php echo e($tipoLabel); ?></p>
                    </div>
                    <?php endif; ?>
                    <div>
                        <p style="font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px;">Fecha y hora</p>
                        <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">
                            <?php echo e($conNota->charla->fecha_hora?->format('d/m/Y H:i') ?? '—'); ?>

                        </p>
                    </div>
                    <?php if($conNota->charla->direccion): ?>
                    <div style="grid-column:span 2;">
                        <p style="font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px;">Dirección</p>
                        <p style="font-size:14px; font-weight:600; color:#111827; margin:0;"><?php echo e($conNota->charla->direccion); ?></p>
                    </div>
                    <?php endif; ?>
                    <?php if($conNota->charla->descripcion): ?>
                    <div style="grid-column:span 2;">
                        <p style="font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px;">Descripción</p>
                        <p style="font-size:14px; color:#111827; margin:0;"><?php echo e($conNota->charla->descripcion); ?></p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
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