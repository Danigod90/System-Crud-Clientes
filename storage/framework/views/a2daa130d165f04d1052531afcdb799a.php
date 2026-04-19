<?php if (isset($component)) { $__componentOriginald3474b09374f7a1c6aabd4f89d6847dc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald3474b09374f7a1c6aabd4f89d6847dc = $attributes; } ?>
<?php $component = App\View\Components\PanelLayout::resolve(['title' => 'Borrador Privado'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('panel-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\PanelLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<div class="px-2 py-2">
    <div style="max-width:860px; margin:0 auto;">

        <?php if(session('success')): ?>
        <div style="background:#d1fae5; color:#065f46; padding:10px 14px; border-radius:8px; margin-bottom:14px; font-size:13px;">
            <?php echo e(session('success')); ?>

        </div>
        <?php endif; ?>

        
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
            <div>
                <h2 style="font-size:16px; font-weight:700; color:#1e293b; margin:0;">Borrador Privado</h2>
                <p style="font-size:12px; color:#94a3b8; margin:2px 0 0;">Solo vos podés ver estos registros</p>
            </div>
            <a href="<?php echo e(route('asesor.borrador.create')); ?>"
               style="display:inline-flex; align-items:center; gap:6px; background:#2563eb; color:white; padding:8px 16px; border-radius:8px; font-size:13px; text-decoration:none; font-weight:500;">
                + Nueva organización
            </a>
        </div>

        
        <?php $__empty_1 = true; $__currentLoopData = $borradores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $borrador): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:16px 20px; margin-bottom:10px; box-shadow:0 1px 4px rgba(0,0,0,0.04); display:flex; justify-content:space-between; align-items:center;">
            <div>
                <div style="display:flex; align-items:center; gap:8px; margin-bottom:4px;">
                    <span style="font-size:14px; font-weight:600; color:#1e293b;"><?php echo e($borrador->nombre_organizacion); ?></span>
                    <?php if($borrador->estado === 'enviado'): ?>
                        <span style="background:#dbeafe; color:#1d4ed8; font-size:10px; font-weight:600; padding:2px 8px; border-radius:20px;">Enviado a Mesa</span>
                    <?php elseif($borrador->estado === 'archivado'): ?>
                        <span style="background:#f3f4f6; color:#6b7280; font-size:10px; font-weight:600; padding:2px 8px; border-radius:20px;">Archivado</span>
                    <?php else: ?>
                        <span style="background:#dcfce7; color:#16a34a; font-size:10px; font-weight:600; padding:2px 8px; border-radius:20px;">Activo</span>
                    <?php endif; ?>
                </div>
                <p style="font-size:12px; color:#94a3b8; margin:0;">
                    <?php echo e($borrador->tipo_organizacion ?? 'Sin tipo'); ?>

                    <?php if($borrador->nombre_representante): ?> · <?php echo e($borrador->nombre_representante); ?> <?php endif; ?>
                    · <?php echo e($borrador->tareas->count() ?? 0); ?> tarea(s)
                </p>
            </div>
            <a href="<?php echo e(route('asesor.borrador.show', $borrador->id)); ?>"
               style="font-size:12px; color:#2563eb; text-decoration:none; font-weight:500;">Ver →</a>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div style="text-align:center; padding:60px 20px; color:#94a3b8;">
            <div style="font-size:36px; margin-bottom:12px;">📋</div>
            <p style="font-size:14px; font-weight:500;">No tenés borradores todavía</p>
            <p style="font-size:12px;">Creá tu primer registro privado</p>
        </div>
        <?php endif; ?>

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
<?php /**PATH /var/www/html/resources/views/panel/asesor/borrador/index.blade.php ENDPATH**/ ?>