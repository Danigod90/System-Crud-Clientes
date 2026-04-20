<?php if (isset($component)) { $__componentOriginald3474b09374f7a1c6aabd4f89d6847dc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald3474b09374f7a1c6aabd4f89d6847dc = $attributes; } ?>
<?php $component = App\View\Components\PanelLayout::resolve(['title' => 'Nueva Mesa de Entrada'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
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
        <?php if(session('error')): ?>
        <div style="background:#fee2e2; color:#991b1b; padding:10px 14px; border-radius:8px; margin-bottom:14px; font-size:13px;">
            <?php echo e(session('error')); ?>

        </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('secretaria.con-nota.store')); ?>" id="form-entrada">
            <?php echo csrf_field(); ?>

            
            <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:20px; margin-bottom:14px; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
                <h3 style="font-size:13px; font-weight:600; color:#374151; margin-bottom:16px; padding-bottom:10px; border-bottom:1px solid #f3f4f6; text-transform:uppercase; letter-spacing:0.5px;">Datos de la organización</h3>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:12px;">
                    <div>
                        <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Nombre de la organización *</label>
                        <input type="text" name="nombre_organizacion" value="<?php echo e(old('nombre_organizacion')); ?>"
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
    <option value="<?php echo e($tipo->nombre); ?>" <?php echo e(old('tipo_organizacion') == $tipo->nombre ? 'selected' : ''); ?>><?php echo e($tipo->nombre); ?></option>
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
                        <input type="text" name="nombre_representante" value="<?php echo e(old('nombre_representante')); ?>"
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
                        <input type="text" name="telefono_representante" value="<?php echo e(old('telefono_representante')); ?>"
                               placeholder="Opcional"
                               style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
                    </div>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:12px;">
                    <div>
                        <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Fecha de elección</label>
                        <input type="date" name="fecha_eleccion" id="fecha_eleccion" value="<?php echo e(old('fecha_eleccion')); ?>"
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
                            <option value="presencial" <?php echo e(old('via_ingreso') == 'presencial' ? 'selected' : ''); ?>>Presencial</option>
                            <option value="correo" <?php echo e(old('via_ingreso') == 'correo' ? 'selected' : ''); ?>>Correo</option>
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
                                    <?php echo e(old('asesor_asignado') == $asesor->nombre . ' ' . $asesor->apellido ? 'selected' : ''); ?>>
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
                <p style="font-size:11px; color:#9ca3af; margin-bottom:14px;">Seleccioná uno o más servicios que solicita la organización.</p>

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
                               <?php echo e(is_array(old('asunto')) && in_array('char', old('asunto')) ? 'checked' : ''); ?>

                               style="width:15px; height:15px; accent-color:#2563eb;">
                        <div>
                            <span style="font-size:13px; font-weight:600; color:#1f2937;">Char</span>
                            <p style="font-size:11px; color:#9ca3af; margin:0;">Charla</p>
                        </div>
                    </label>
                    <label style="display:flex; align-items:center; gap:10px; border:1px solid #e5e7eb; border-radius:10px; padding:12px 14px; cursor:pointer;">
                        <input type="checkbox" name="asunto[]" value="log" id="check-log"
                               <?php echo e(is_array(old('asunto')) && in_array('log', old('asunto')) ? 'checked' : ''); ?>

                               style="width:15px; height:15px; accent-color:#2563eb;">
                        <div>
                            <span style="font-size:13px; font-weight:600; color:#1f2937;">Log</span>
                            <p style="font-size:11px; color:#9ca3af; margin:0;">Logística</p>
                        </div>
                    </label>
                    <label style="display:flex; align-items:center; gap:10px; border:1px solid #e5e7eb; border-radius:10px; padding:12px 14px; cursor:pointer;">
                        <input type="checkbox" name="asunto[]" value="tec"
                               <?php echo e(is_array(old('asunto')) && in_array('tec', old('asunto')) ? 'checked' : ''); ?>

                               style="width:15px; height:15px; accent-color:#2563eb;">
                        <div>
                            <span style="font-size:13px; font-weight:600; color:#1f2937;">Tec</span>
                            <p style="font-size:11px; color:#9ca3af; margin:0;">Técnica</p>
                        </div>
                    </label>
                    <label style="display:flex; align-items:center; gap:10px; border:1px solid #e5e7eb; border-radius:10px; padding:12px 14px; cursor:pointer;">
                        <input type="checkbox" name="asunto[]" value="obs"
                               <?php echo e(is_array(old('asunto')) && in_array('obs', old('asunto')) ? 'checked' : ''); ?>

                               style="width:15px; height:15px; accent-color:#2563eb;">
                        <div>
                            <span style="font-size:13px; font-weight:600; color:#1f2937;">Obs</span>
                            <p style="font-size:11px; color:#9ca3af; margin:0;">Observadores</p>
                        </div>
                    </label>
                </div>
            </div>

            
            <div id="seccion-logistica" style="display:none; background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:20px; margin-bottom:14px; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
                <h3 style="font-size:13px; font-weight:600; color:#374151; margin-bottom:6px; padding-bottom:10px; border-bottom:1px solid #f3f4f6; text-transform:uppercase; letter-spacing:0.5px;">Detalle Logístico</h3>
                <p style="font-size:11px; color:#9ca3af; margin-bottom:14px;">Cargá las cantidades según la nota. Dejá en 0 si no aplica.</p>
                <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:12px;">
                    <div>
                        <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Urnas</label>
                        <input type="number" name="log_urnas" min="0" value="<?php echo e(old('log_urnas', 0)); ?>"
                               style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
                    </div>
                    <div>
                        <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Cuartos oscuros</label>
                        <input type="number" name="log_cuartos" min="0" value="<?php echo e(old('log_cuartos', 0)); ?>"
                               style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
                    </div>
                    <div>
                        <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Tintas</label>
                        <input type="number" name="log_tintas" min="0" value="<?php echo e(old('log_tintas', 0)); ?>"
                               style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
                    </div>
                </div>
            </div>

            
            <div style="display:flex; justify-content:flex-end; gap:10px;">
                <a href="<?php echo e(route('secretaria.con-nota.index')); ?>"
                   style="display:inline-flex; align-items:center; gap:6px; background:#f3f4f6; color:#374151; padding:8px 18px; border-radius:8px; font-size:13px; text-decoration:none;">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                    Cancelar
                </a>
                <button type="button" id="btn-guardar"
                        style="display:inline-flex; align-items:center; gap:6px; background:#2563eb; color:white; padding:8px 18px; border-radius:8px; font-size:13px; border:none; cursor:pointer; font-weight:500;">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    Registrar entrada
                </button>
            </div>

        </form>
    </div>
</div>


<div id="modal-sin-fecha" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.4); z-index:50; align-items:center; justify-content:center;">
    <div style="background:white; border-radius:12px; padding:32px; max-width:400px; width:90%; box-shadow:0 20px 60px rgba(0,0,0,0.3); text-align:center;">
        <div style="font-size:42px; margin-bottom:12px;">📅</div>
        <h3 style="font-size:16px; font-weight:700; color:#1e293b; margin-bottom:8px;">¿Guardar sin fecha de elección?</h3>
        <p style="font-size:13px; color:#64748b; margin-bottom:24px;">No ingresaste una fecha de elección. Podés guardar igual y completarla después.</p>
        <div style="display:flex; gap:12px; justify-content:center;">
            <button id="btn-modal-no"
                    style="padding:9px 20px; border-radius:8px; border:1px solid #e5e7eb; background:white; color:#374151; font-size:13px; cursor:pointer;">
                No, volver
            </button>
            <button id="btn-modal-si"
                    style="padding:9px 20px; border-radius:8px; border:none; background:#2563eb; color:white; font-size:13px; cursor:pointer; font-weight:500;">
                Sí, guardar igual
            </button>
        </div>
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

    const form = document.getElementById('form-entrada');
    const btnGuardar = document.getElementById('btn-guardar');
    const modal = document.getElementById('modal-sin-fecha');
    const btnSi = document.getElementById('btn-modal-si');
    const btnNo = document.getElementById('btn-modal-no');
    const inputFecha = document.getElementById('fecha_eleccion');
    let confirmado = false;

    btnGuardar.addEventListener('click', function() {
        if (!inputFecha.value && !confirmado) { modal.style.display = 'flex'; }
        else { form.submit(); }
    });
    btnSi.addEventListener('click', function() { confirmado = true; modal.style.display = 'none'; form.submit(); });
    btnNo.addEventListener('click', function() { modal.style.display = 'none'; });
    modal.addEventListener('click', function(e) { if (e.target === modal) modal.style.display = 'none'; });
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
<?php /**PATH /var/www/html/resources/views/secretaria/con_nota/create.blade.php ENDPATH**/ ?>