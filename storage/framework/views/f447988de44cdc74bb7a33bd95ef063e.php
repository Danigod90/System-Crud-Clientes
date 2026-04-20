<?php if (isset($component)) { $__componentOriginald3474b09374f7a1c6aabd4f89d6847dc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald3474b09374f7a1c6aabd4f89d6847dc = $attributes; } ?>
<?php $component = App\View\Components\PanelLayout::resolve(['title' => 'Editar Mesa de Entrada — '.e($conNota->codigo_org).''] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
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

        <form method="POST" action="<?php echo e(route('secretaria.con-nota.update', $conNota)); ?>">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
<input type="hidden" name="from" value="<?php echo e(request('from')); ?>">
<input type="hidden" name="entrada_id" value="<?php echo e(request('entrada_id', $conNota->id)); ?>">
            
            <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:20px; margin-bottom:14px; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
                <h3 style="font-size:13px; font-weight:600; color:#374151; margin-bottom:16px; padding-bottom:10px; border-bottom:1px solid #f3f4f6; text-transform:uppercase; letter-spacing:0.5px;">Datos de la organización</h3>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:12px;">
                    <div>
                        <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Nombre de la organización *</label>
                        <input type="text" name="nombre_organizacion"
                               value="<?php echo e(old('nombre_organizacion', $conNota->nombre_organizacion)); ?>"
                               style="width:100%; border:1px solid <?php echo e($errors->has('nombre_organizacion') ? '#f87171' : '#e5e7eb'); ?>; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
                        <?php $__errorArgs = ['nombre_organizacion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p style="color:#ef4444; font-size:11px; margin-top:3px;"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div>
                        <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Tipo de organización *</label>
                        <select name="tipo_organizacion"
                                style="width:100%; border:1px solid <?php echo e($errors->has('tipo_organizacion') ? '#f87171' : '#e5e7eb'); ?>; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; background:#fff; box-sizing:border-box;">
                            <option value="">Seleccionar tipo...</option>
                            <?php $__currentLoopData = $tipos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($tipo->nombre); ?>" <?php echo e(old('tipo_organizacion', $conNota->tipo_organizacion) == $tipo->nombre ? 'selected' : ''); ?>><?php echo e($tipo->nombre); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['tipo_organizacion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p style="color:#ef4444; font-size:11px; margin-top:3px;"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:12px;">
                    <div>
                        <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Nombre del representante *</label>
                        <input type="text" name="nombre_representante"
                               value="<?php echo e(old('nombre_representante', $conNota->nombre_representante)); ?>"
                               style="width:100%; border:1px solid <?php echo e($errors->has('nombre_representante') ? '#f87171' : '#e5e7eb'); ?>; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
                        <?php $__errorArgs = ['nombre_representante'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p style="color:#ef4444; font-size:11px; margin-top:3px;"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div>
                        <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Teléfono del representante</label>
                        <input type="text" name="telefono_representante"
                               value="<?php echo e(old('telefono_representante', $conNota->telefono_representante)); ?>"
                               placeholder="Opcional"
                               style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
                    </div>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:12px;">
                    <div>
                        <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Fecha de elección</label>
                        <input type="date" name="fecha_eleccion"
                               value="<?php echo e(old('fecha_eleccion', $conNota->fecha_eleccion?->format('Y-m-d'))); ?>"
                               style="width:100%; border:1px solid <?php echo e($errors->has('fecha_eleccion') ? '#f87171' : '#e5e7eb'); ?>; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
                        <?php $__errorArgs = ['fecha_eleccion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p style="color:#ef4444; font-size:11px; margin-top:3px;"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div>
                        <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Vía de ingreso *</label>
                        <select name="via_ingreso"
                                style="width:100%; border:1px solid <?php echo e($errors->has('via_ingreso') ? '#f87171' : '#e5e7eb'); ?>; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; background:#fff; box-sizing:border-box;">
                            <option value="">Seleccionar...</option>
                            <option value="presencial" <?php echo e(old('via_ingreso', $conNota->via_ingreso) == 'presencial' ? 'selected' : ''); ?>>Presencial</option>
                            <option value="correo" <?php echo e(old('via_ingreso', $conNota->via_ingreso) == 'correo' ? 'selected' : ''); ?>>Correo</option>
                        </select>
                        <?php $__errorArgs = ['via_ingreso'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p style="color:#ef4444; font-size:11px; margin-top:3px;"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div>
                        <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Asesor asignado *</label>
                        <select name="asesor_asignado"
                                style="width:100%; border:1px solid <?php echo e($errors->has('asesor_asignado') ? '#f87171' : '#e5e7eb'); ?>; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; background:#fff; box-sizing:border-box;">
                            <option value="">Seleccionar asesor...</option>
                            <?php $__currentLoopData = $asesores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $asesor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($asesor->nombre); ?> <?php echo e($asesor->apellido); ?>"
                                    <?php echo e(old('asesor_asignado', $conNota->asesor_asignado) == $asesor->nombre . ' ' . $asesor->apellido ? 'selected' : ''); ?>>
                                    <?php echo e($asesor->nombre); ?> <?php echo e($asesor->apellido); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['asesor_asignado'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p style="color:#ef4444; font-size:11px; margin-top:3px;"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>

            
<div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:20px; margin-bottom:14px; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
    <h3 style="font-size:13px; font-weight:600; color:#374151; margin-bottom:6px; padding-bottom:10px; border-bottom:1px solid #f3f4f6; text-transform:uppercase; letter-spacing:0.5px;">Asunto solicitado *</h3>
    <p style="font-size:11px; color:#9ca3af; margin-bottom:14px;">Podés agregar o quitar servicios en cualquier momento.</p>

    <?php $__errorArgs = ['asunto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p style="color:#ef4444; font-size:11px; margin-bottom:10px;"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

    <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:10px;">
        <label style="display:flex; align-items:center; gap:10px; border:1px solid #e5e7eb; border-radius:10px; padding:12px 14px; cursor:pointer;">
            <input type="checkbox" name="asunto[]" value="char"
                   <?php echo e(old('asunto') ? (in_array('char', old('asunto')) ? 'checked' : '') : ($conNota->asunto_char ? 'checked' : '')); ?>

                   style="width:15px; height:15px; accent-color:#2563eb;">
            <div>
                <span style="font-size:13px; font-weight:600; color:#1f2937;">Char</span>
                <p style="font-size:11px; color:#9ca3af; margin:0;">Charla</p>
            </div>
        </label>
        <label style="display:flex; align-items:center; gap:10px; border:1px solid #e5e7eb; border-radius:10px; padding:12px 14px; cursor:pointer;">
            <input type="checkbox" name="asunto[]" value="log" id="check-log"
                   <?php echo e(old('asunto') ? (in_array('log', old('asunto')) ? 'checked' : '') : ($conNota->asunto_log ? 'checked' : '')); ?>

                   style="width:15px; height:15px; accent-color:#2563eb;">
            <div>
                <span style="font-size:13px; font-weight:600; color:#1f2937;">Log</span>
                <p style="font-size:11px; color:#9ca3af; margin:0;">Logística</p>
            </div>
        </label>
        <label style="display:flex; align-items:center; gap:10px; border:1px solid #e5e7eb; border-radius:10px; padding:12px 14px; cursor:pointer;">
            <input type="checkbox" name="asunto[]" value="tec"
                   <?php echo e(old('asunto') ? (in_array('tec', old('asunto')) ? 'checked' : '') : ($conNota->asunto_tec ? 'checked' : '')); ?>

                   style="width:15px; height:15px; accent-color:#2563eb;">
            <div>
                <span style="font-size:13px; font-weight:600; color:#1f2937;">Tec</span>
                <p style="font-size:11px; color:#9ca3af; margin:0;">Técnica</p>
            </div>
        </label>
        <label style="display:flex; align-items:center; gap:10px; border:1px solid #e5e7eb; border-radius:10px; padding:12px 14px; cursor:pointer;">
            <input type="checkbox" name="asunto[]" value="obs"
                   <?php echo e(old('asunto') ? (in_array('obs', old('asunto')) ? 'checked' : '') : ($conNota->asunto_obs ? 'checked' : '')); ?>

                   style="width:15px; height:15px; accent-color:#2563eb;">
            <div>
                <span style="font-size:13px; font-weight:600; color:#1f2937;">Obs</span>
                <p style="font-size:11px; color:#9ca3af; margin:0;">Observadores</p>
            </div>
        </label>
    </div>
</div>

            
            <div id="seccion-logistica" style="display:<?php echo e(($conNota->asunto_log && !$conNota->asunto_tec) ? 'block' : 'none'); ?>; background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:20px; margin-bottom:14px; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
                <h3 style="font-size:13px; font-weight:600; color:#374151; margin-bottom:6px; padding-bottom:10px; border-bottom:1px solid #f3f4f6; text-transform:uppercase; letter-spacing:0.5px;">Detalle Logístico</h3>
                <p style="font-size:11px; color:#9ca3af; margin-bottom:14px;">Cargá las cantidades según la nota. Dejá en 0 si no aplica.</p>
                <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:12px;">
                    <div>
                        <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Urnas</label>
                        <input type="number" name="log_urnas" min="0"
                               value="<?php echo e(old('log_urnas', $conNota->log_urnas)); ?>"
                               style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
                    </div>
                    <div>
                        <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Cuartos oscuros</label>
                        <input type="number" name="log_cuartos" min="0"
                               value="<?php echo e(old('log_cuartos', $conNota->log_cuartos)); ?>"
                               style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
                    </div>
                    <div>
                        <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Tintas</label>
                        <input type="number" name="log_tintas" min="0"
                               value="<?php echo e(old('log_tintas', $conNota->log_tintas)); ?>"
                               style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
                    </div>
                </div>
            </div>

            
            <div style="display:flex; justify-content:flex-end; gap:10px;">
<a href="<?php echo e(request('from') == 'asesor' ? route('asesor.organizacion.edit', $conNota->id) : route('secretaria.con-nota.show', $conNota)); ?>"   style="display:inline-flex; align-items:center; gap:6px; background:#f3f4f6; color:#374151; padding:8px 18px; border-radius:8px; font-size:13px; text-decoration:none;">
    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
    </svg>
    Cancelar
</a>
                <button type="submit"
                        style="display:inline-flex; align-items:center; gap:6px; background:#2563eb; color:white; padding:8px 18px; border-radius:8px; font-size:13px; border:none; cursor:pointer; font-weight:500;">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    Guardar cambios
                </button>
            </div>

        </form>
    </div>
</div>

<script>
    const checkLog = document.getElementById('check-log');
    const seccionLog = document.getElementById('seccion-logistica');
   function toggleLogistica() {
    const tieneTec = document.querySelector('input[name="asunto[]"][value="tec"]')?.checked ?? false;
    seccionLog.style.display = (checkLog.checked && !tieneTec) ? 'block' : 'none';
}
    checkLog.addEventListener('change', toggleLogistica);
document.querySelector('input[name="asunto[]"][value="tec"]')?.addEventListener('change', toggleLogistica);
toggleLogistica();
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
<?php /**PATH /var/www/html/resources/views/secretaria/con_nota/edit.blade.php ENDPATH**/ ?>