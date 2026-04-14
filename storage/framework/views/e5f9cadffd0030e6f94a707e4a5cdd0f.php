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
            Gestión de Usuarios
        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <?php if(session('success')): ?>
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between mb-4">
    <h2 class="text-xl font-semibold">Usuarios del Sistema</h2>
  <div class="flex gap-2">
    <a href="<?php echo e(route('admin.asesores.index')); ?>" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Gestión de Asesores</a>
    <a href="<?php echo e(route('admin.configuracion.index')); ?>" style="background-color:#7c3aed; color:white; padding:8px 16px; border-radius:6px; text-decoration:none; font-size:14px;">Configuración</a>
    <a href="/admin/tipo-organizaciones" style="background-color:#0891b2; color:white; padding:8px 16px; border-radius:6px; text-decoration:none; font-size:14px;">Tipos de Org.</a>
    <a href="<?php echo e(route('admin.users.create')); ?>" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Nuevo Usuario</a>
    <form method="POST" action="<?php echo e(route('logout')); ?>" style="display:inline;">
        <?php echo csrf_field(); ?>
        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Cerrar sesión</button>
    </form>
</div>
</div>
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="p-3 text-left">Nombre</th>
                                <th class="p-3 text-left">Email</th>
                                <th class="p-3 text-left">Rol</th>
                                <th class="p-3 text-left">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="border-b">
                                <td class="p-3"><?php echo e($user->name); ?></td>
                                <td class="p-3"><?php echo e($user->email); ?></td>
                                <td class="p-3"><?php echo e($user->roles->pluck('name')->join(', ')); ?></td>
                                <td class="p-3">
                                    <form action="<?php echo e(route('admin.users.destroy', $user)); ?>" method="POST" onsubmit="return confirm('¿Eliminar usuario?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
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
<?php /**PATH /var/www/html/resources/views/admin/users/index.blade.php ENDPATH**/ ?>