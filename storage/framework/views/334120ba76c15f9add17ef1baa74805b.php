<?php if (isset($component)) { $__componentOriginald3474b09374f7a1c6aabd4f89d6847dc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald3474b09374f7a1c6aabd4f89d6847dc = $attributes; } ?>
<?php $component = App\View\Components\PanelLayout::resolve(['title' => 'Nueva Entrada Sin Nota'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('panel-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\PanelLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<div class="px-2 py-2">
    <div style="max-width:560px; margin:0 auto;">

        <?php if($errors->any()): ?>
        <div style="background:#fee2e2; color:#991b1b; padding:10px 14px; border-radius:8px; margin-bottom:14px; font-size:13px;">
            <ul style="margin:0; padding-left:16px;">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
        <?php endif; ?>

        <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:24px; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
            <div style="margin-bottom:20px; padding-bottom:12px; border-bottom:1px solid #f3f4f6;">
                <h3 style="font-size:14px; font-weight:700; color:#1e293b; margin:0;">Nueva Entrada Sin Nota</h3>
                <p style="font-size:12px; color:#94a3b8; margin:4px 0 0;">Registrar atención sin expediente</p>
            </div>

            <form method="POST" action="<?php echo e(route('secretaria.sin-nota.store')); ?>">
                <?php echo csrf_field(); ?>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:12px;">
                    <div>
                        <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Nombre *</label>
                        <input type="text" name="nombre" value="<?php echo e(old('nombre')); ?>" required
                               style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
                    </div>
                    <div>
                        <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Apellido *</label>
                        <input type="text" name="apellido" value="<?php echo e(old('apellido')); ?>" required
                               style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
                    </div>
                </div>

                <div style="margin-bottom:12px;">
                    <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Teléfono <span style="font-weight:400; text-transform:none;">(opcional)</span></label>
                    <input type="text" name="telefono" value="<?php echo e(old('telefono')); ?>" placeholder="Ej: 0981 123 456"
                           style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
                </div>

                <div style="margin-bottom:12px;">
                    <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Tipo de Servicio *</label>
                    <select name="tipo_charla" required
                            style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; background:#fff; box-sizing:border-box;">
                        <option value="">Seleccionar...</option>
                        <option value="Asesoramiento Electoral" <?php echo e(old('tipo_charla') == 'Asesoramiento Electoral' ? 'selected' : ''); ?>>Asesoramiento Electoral</option>
                        <option value="Charla para Miembros de Mesa" <?php echo e(old('tipo_charla') == 'Charla para Miembros de Mesa' ? 'selected' : ''); ?>>Charla para Miembros de Mesa</option>
                        <option value="Materiales Entregados" <?php echo e(old('tipo_charla') == 'Materiales Entregados' ? 'selected' : ''); ?>>Materiales Entregados</option>
                    </select>
                </div>

                <div style="margin-bottom:20px;">
                    <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Asesor que atendió <span style="font-weight:400; text-transform:none;">(opcional)</span></label>
                    <select name="asesor_id"
                            style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; background:#fff; box-sizing:border-box;">
                        <option value="">Sin asesor asignado</option>
                        <?php $__currentLoopData = $asesores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $asesor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($asesor->id); ?>" <?php echo e(old('asesor_id') == $asesor->id ? 'selected' : ''); ?>>
                                <?php echo e($asesor->nombre); ?> <?php echo e($asesor->apellido); ?>

                                <?php if($asesor->cargo): ?> — <?php echo e($asesor->cargo); ?> <?php endif; ?>
                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div style="display:flex; gap:10px; justify-content:flex-end;">
                    <a href="<?php echo e(route('secretaria.sin-nota.index')); ?>"
                       style="padding:8px 18px; border-radius:8px; border:1px solid #e5e7eb; background:white; color:#374151; font-size:13px; text-decoration:none; font-weight:500;">
                        Cancelar
                    </a>
                    <button type="submit"
                            style="padding:8px 18px; border-radius:8px; border:none; background:#2563eb; color:white; font-size:13px; cursor:pointer; font-weight:500;">
                        Registrar Entrada
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
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
<?php /**PATH /var/www/html/resources/views/secretaria/sin_nota/create.blade.php ENDPATH**/ ?>