<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gestión de Asesores
        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <?php if(session('success')): ?>
                    <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                        <?php echo e(session('success')); ?>

                    </div>
                <?php endif; ?>

                <div class="flex justify-between items-center mb-4">
    <h3 class="text-lg font-semibold">Listado de Asesores</h3>
    <div class="flex gap-2">
        <a href="<?php echo e(route('admin.users.index')); ?>"
           class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
            ← Volver
        </a>
        <a href="<?php echo e(route('admin.asesores.create')); ?>"
           class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            + Nuevo Asesor
        </a>
    </div>
</div>

                <table class="w-full table-auto border-collapse">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border px-4 py-2 text-left">Nombre</th>
                            <th class="border px-4 py-2 text-left">Apellido</th>
                            <th class="border px-4 py-2 text-left">Cargo</th>
                            <th class="border px-4 py-2 text-left">Estado</th>
                            <th class="border px-4 py-2 text-left">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $asesores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $asesor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-gray-50">
                                <td class="border px-4 py-2"><?php echo e($asesor->nombre); ?></td>
                                <td class="border px-4 py-2"><?php echo e($asesor->apellido); ?></td>
                                <td class="border px-4 py-2"><?php echo e($asesor->cargo ?? '-'); ?></td>
                                <td class="border px-4 py-2">
                                    <?php if($asesor->activo): ?>
                                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm">Activo</span>
                                    <?php else: ?>
                                        <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-sm">Inactivo</span>
                                    <?php endif; ?>
                                </td>
                                <td class="border px-4 py-2 flex gap-2">
                                    <a href="<?php echo e(route('admin.asesores.edit', $asesor)); ?>"
                                       class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 text-sm">
                                        Editar
                                    </a>
                                    <form method="POST" action="<?php echo e(route('admin.asesores.destroy', $asesor)); ?>"
                                          onsubmit="return confirm('¿Eliminar este asesor?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit"
                                                class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-sm">
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="border px-4 py-4 text-center text-gray-500">
                                    No hay asesores registrados aún.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <div class="mt-4">
                    <?php echo e($asesores->links()); ?>

                </div>

            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH /var/www/html/resources/views/admin/asesores/index.blade.php ENDPATH**/ ?>