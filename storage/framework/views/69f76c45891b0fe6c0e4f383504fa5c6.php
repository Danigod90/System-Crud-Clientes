<?php if (isset($component)) { $__componentOriginald3474b09374f7a1c6aabd4f89d6847dc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald3474b09374f7a1c6aabd4f89d6847dc = $attributes; } ?>
<?php $component = App\View\Components\PanelLayout::resolve(['title' => 'Editar Organización — '.e($entrada->codigo_org).''] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
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
            <h3 style="font-size:13px; font-weight:600; color:#374151; margin-bottom:16px; padding-bottom:10px; border-bottom:1px solid #f3f4f6; text-transform:uppercase; letter-spacing:0.5px;">Datos de la organización</h3>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:12px;">
                <div>
                    <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Organización</label>
                    <p style="font-size:14px; font-weight:600; color:#111827; margin:0;"><?php echo e($entrada->nombre_organizacion); ?></p>
                    <p style="font-size:12px; color:#6b7280; margin:2px 0 0;"><?php echo e($entrada->tipo_organizacion); ?></p>
                </div>
                <div>
                    <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Representante</label>
                    <p style="font-size:14px; font-weight:600; color:#111827; margin:0;"><?php echo e($entrada->nombre_representante); ?></p>
                    <?php if($entrada->telefono_representante): ?>
                    <p style="font-size:12px; color:#6b7280; margin:2px 0 0;"><?php echo e($entrada->telefono_representante); ?></p>
                    <?php endif; ?>
                </div>
                <div>
                    <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Fecha de elección</label>
                    <p style="font-size:14px; font-weight:600; color:#111827; margin:0;"><?php echo e($entrada->fecha_eleccion?->format('d/m/Y') ?? '—'); ?></p>
                </div>
                <div>
                    <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Asunto</label>
                    <p style="font-size:14px; font-weight:700; color:#111827; font-family:monospace; margin:0;"><?php echo e($entrada->asunto_texto); ?></p>
                </div>
            </div>
        </div>

        
        <?php if($entrada->asunto_char): ?>
        <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:20px; margin-bottom:14px; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
            <h3 style="font-size:13px; font-weight:600; color:#374151; margin-bottom:16px; padding-bottom:10px; border-bottom:1px solid #f3f4f6; text-transform:uppercase; letter-spacing:0.5px;">
                Detalle de Charla
                <?php if($entrada->charla): ?>
                    <?php
                        $dotColor = match($entrada->charla->estado) {
                            'realizada'  => '#16a34a',
                            'cancelada'  => '#dc2626',
                            'suspendida' => '#f97316',
                            'vencida'    => '#dc2626',
                            default      => '#eab308',
                        };
                    ?>
                    <span style="display:inline-flex; align-items:center; gap:4px; margin-left:8px; font-size:11px; font-weight:500; color:#6b7280; text-transform:none;">
                        <span style="width:9px; height:9px; border-radius:50%; background:<?php echo e($dotColor); ?>; display:inline-block;"></span>
                        <?php echo e(ucfirst($entrada->charla->estado)); ?>

                    </span>
                <?php endif; ?>
            </h3>

            <form method="POST" action="<?php echo e(route('asesor.charla.store', $entrada)); ?>">
                <?php echo csrf_field(); ?>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:12px;">
                    <div>
                        <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Modalidad *</label>
                        <select name="modalidad" id="modalidad-select"
                                style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; background:#fff; box-sizing:border-box;">
                            <option value="">Seleccionar...</option>
                            <option value="virtual" <?php echo e($entrada->charla?->modalidad == 'virtual' ? 'selected' : ''); ?>>Virtual</option>
                            <option value="presencial_oficina" <?php echo e($entrada->charla?->modalidad == 'presencial_oficina' ? 'selected' : ''); ?>>Presencial — Oficina</option>
                            <option value="presencial_externa" <?php echo e($entrada->charla?->modalidad == 'presencial_externa' ? 'selected' : ''); ?>>Presencial — Externa</option>
                        </select>
                    </div>
                    <div>
                        <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Fecha y hora *</label>
                        <input type="datetime-local" name="fecha_hora"
                               value="<?php echo e($entrada->charla?->fecha_hora?->format('Y-m-d\TH:i')); ?>"
                               style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
                    </div>
                </div>

                <div id="seccion-direccion" style="display:<?php echo e($entrada->charla?->modalidad == 'presencial_externa' ? 'block' : 'none'); ?>; margin-bottom:12px;">
                    <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Dirección *</label>
                    <input type="text" name="direccion"
                           value="<?php echo e($entrada->charla?->direccion); ?>"
                           placeholder="Dirección del local donde se realizará la charla..."
                           style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
                </div>

                <div style="display:flex; justify-content:flex-end;">
                    <button type="submit"
                            style="display:inline-flex; align-items:center; gap:6px; background:#2563eb; color:white; padding:8px 18px; border-radius:8px; font-size:13px; border:none; cursor:pointer; font-weight:500;">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                        Guardar charla
                    </button>
                </div>
            </form>

            
            <?php if($entrada->charla): ?>
            <div style="border-top:1px solid #f3f4f6; margin-top:16px; padding-top:16px;">
                <p style="font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:10px;">Cambiar estado</p>
                <div style="display:flex; gap:8px; flex-wrap:wrap;">

                    <form method="POST" action="<?php echo e(route('asesor.charla.estado', $entrada->charla)); ?>">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PATCH'); ?>
                        <input type="hidden" name="estado" value="realizada">
                        <button type="submit"
                                onclick="return confirm('¿Marcar la charla como realizada?')"
                                style="display:inline-flex; align-items:center; gap:6px; background:#16a34a; color:white; padding:8px 16px; border-radius:8px; font-size:13px; border:none; cursor:pointer; font-weight:500;">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                            Realizada
                        </button>
                    </form>

                    <form method="POST" action="<?php echo e(route('asesor.charla.estado', $entrada->charla)); ?>">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PATCH'); ?>
                        <input type="hidden" name="estado" value="suspendida">
                        <button type="submit"
                                onclick="return confirm('¿Marcar la charla como suspendida?')"
                                style="display:inline-flex; align-items:center; gap:6px; background:#f97316; color:white; padding:8px 16px; border-radius:8px; font-size:13px; border:none; cursor:pointer; font-weight:500;">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10"/>
                                <line x1="10" y1="15" x2="10" y2="9"/>
                                <line x1="14" y1="15" x2="14" y2="9"/>
                            </svg>
                            Suspendida
                        </button>
                    </form>

                    <form method="POST" action="<?php echo e(route('asesor.charla.estado', $entrada->charla)); ?>">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PATCH'); ?>
                        <input type="hidden" name="estado" value="cancelada">
                        <button type="submit"
                                onclick="return confirm('¿Confirmar cancelación de la charla?')"
                                style="display:inline-flex; align-items:center; gap:6px; background:#dc2626; color:white; padding:8px 16px; border-radius:8px; font-size:13px; border:none; cursor:pointer; font-weight:500;">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <line x1="18" y1="6" x2="6" y2="18"/>
                                <line x1="6" y1="6" x2="18" y2="18"/>
                            </svg>
                            Cancelada
                        </button>
                    </form>

                </div>
            </div>
            <?php endif; ?>

        </div>
        <?php endif; ?>

        
        <div style="display:flex; justify-content:flex-end; gap:10px;">
            <a href="<?php echo e(route('asesor.mis-organizaciones')); ?>"
               style="display:inline-flex; align-items:center; gap:6px; background:#1e3a5f; color:white; padding:10px 20px; border-radius:8px; font-size:14px; text-decoration:none; font-weight:500;">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="15 18 9 12 15 6"/>
                </svg>
                Volver a mis organizaciones
            </a>
        </div>

    </div>
</div>

<script>
const modalidadSelect = document.getElementById('modalidad-select');
const seccionDireccion = document.getElementById('seccion-direccion');
modalidadSelect.addEventListener('change', function() {
    seccionDireccion.style.display = this.value === 'presencial_externa' ? 'block' : 'none';
});
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
<?php /**PATH /var/www/html/resources/views/asesor/edit.blade.php ENDPATH**/ ?>