<?php if (isset($component)) { $__componentOriginald3474b09374f7a1c6aabd4f89d6847dc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald3474b09374f7a1c6aabd4f89d6847dc = $attributes; } ?>
<?php $component = App\View\Components\PanelLayout::resolve(['title' => 'Gestión de Log'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('panel-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\PanelLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<div class="px-2 py-2">
    <div style="max-width:1000px; margin:0 auto;">

        <?php if(session('success')): ?>
        <div style="background:#d1fae5; color:#065f46; padding:10px 14px; border-radius:8px; margin-bottom:14px; font-size:13px;">
            <?php echo e(session('success')); ?>

        </div>
        <?php endif; ?>

        
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
            <div>
                <h2 style="font-size:16px; font-weight:700; color:#1e293b; margin:0;">Gestión de Log</h2>
                <p style="font-size:12px; color:#94a3b8; margin:2px 0 0;">Control de materiales prestados y devueltos</p>
            </div>
            <a href="<?php echo e(route('panel.dashboard')); ?>"
               style="font-size:12px; color:#94a3b8; text-decoration:none;">← Volver al panel</a>
        </div>

<div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:12px 16px; margin-bottom:14px; box-shadow:0 1px 4px rgba(0,0,0,0.04); display:flex; align-items:center; gap:10px;">
    <svg width="14" height="14" fill="none" stroke="#9ca3af" stroke-width="2" viewBox="0 0 24 24">
        <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
    </svg>
    <input type="text" id="filtro-org" placeholder="Buscar organización..."
           oninput="filtrarTablas(this.value)"
           style="border:none; outline:none; font-size:13px; color:#374151; width:100%;">
</div>
        
        <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; overflow:hidden; box-shadow:0 1px 4px rgba(0,0,0,0.04); margin-bottom:14px;">
            <div style="padding:12px 16px; border-bottom:1px solid #f3f4f6; background:#fffbeb;">
                <span style="font-size:13px; font-weight:600; color:#92400e;">⏳ Pendientes de entrega (<?php echo e($pendientes->count()); ?>)</span>
            </div>
            <table style="width:100%; border-collapse:collapse; font-size:12px;">
                <thead>
                    <tr style="background:#f8fafc;">
                        <th style="padding:8px 16px; text-align:left; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Código</th>
                        <th style="padding:8px 16px; text-align:left; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Organización</th>
                        <th style="padding:8px 16px; text-align:center; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Urnas</th>
                        <th style="padding:8px 16px; text-align:center; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Cuartos</th>
                        <th style="padding:8px 16px; text-align:center; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Tintas</th>
                        <th style="padding:8px 16px; text-align:left; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $pendientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entrada): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr style="border-bottom:1px solid #f3f4f6;" data-org="<?php echo e($entrada->nombre_organizacion); ?>">
                        <td style="padding:10px 16px; color:#185FA5; font-weight:600; font-family:monospace;"><?php echo e($entrada->codigo_org); ?></td>
                        <td style="padding:10px 16px; color:#1e293b; font-weight:500;"><?php echo e($entrada->nombre_organizacion); ?></td>
                        <td style="padding:10px 16px; text-align:center; color:#374151;"><?php echo e($entrada->log_urnas); ?></td>
                        <td style="padding:10px 16px; text-align:center; color:#374151;"><?php echo e($entrada->log_cuartos); ?></td>
                        <td style="padding:10px 16px; text-align:center; color:#374151;"><?php echo e($entrada->log_tintas); ?></td>
                        <td style="padding:10px 16px;">
    <span style="font-size:11px; color:#94a3b8;">Sin entregar aún</span>
</td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" style="padding:30px; text-align:center; color:#94a3b8; font-size:13px;">
                            ✅ No hay log pendientes.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        
        <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; overflow:hidden; box-shadow:0 1px 4px rgba(0,0,0,0.04); margin-bottom:14px;">
            <div style="padding:12px 16px; border-bottom:1px solid #f3f4f6; background:#eff6ff;">
                <span style="font-size:13px; font-weight:600; color:#1d4ed8;">📦 Entregados — esperando devolución (<?php echo e($entregados->count()); ?>)</span>
            </div>
            <table style="width:100%; border-collapse:collapse; font-size:12px;">
                <thead>
                    <tr style="background:#f8fafc;">
                        <th style="padding:8px 16px; text-align:left; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Código</th>
                        <th style="padding:8px 16px; text-align:left; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Organización</th>
                        <th style="padding:8px 16px; text-align:center; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Urnas</th>
                        <th style="padding:8px 16px; text-align:center; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Cuartos</th>
                        <th style="padding:8px 16px; text-align:center; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Tintas</th>
                        <th style="padding:8px 16px; text-align:left; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $entregados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entrada): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr style="border-bottom:1px solid #f3f4f6;" data-org="<?php echo e($entrada->nombre_organizacion); ?>">
                        <td style="padding:10px 16px; color:#185FA5; font-weight:600; font-family:monospace;"><?php echo e($entrada->codigo_org); ?></td>
                        <td style="padding:10px 16px; color:#1e293b; font-weight:500;"><?php echo e($entrada->nombre_organizacion); ?></td>
                        <td style="padding:10px 16px; text-align:center; color:#374151;"><?php echo e($entrada->log_urnas); ?></td>
                        <td style="padding:10px 16px; text-align:center; color:#374151;"><?php echo e($entrada->log_cuartos); ?></td>
                        <td style="padding:10px 16px; text-align:center; color:#374151;"><?php echo e($entrada->log_tintas); ?></td>
                        <td style="padding:10px 16px;">
                            <button onclick="abrirModal(<?php echo e($entrada->id); ?>, '<?php echo e(addslashes($entrada->nombre_organizacion)); ?>', <?php echo e($entrada->log_urnas); ?>, <?php echo e($entrada->log_cuartos); ?>, <?php echo e($entrada->log_tintas); ?>)"
                                    style="background:#2563eb; color:white; border:none; padding:5px 12px; border-radius:6px; font-size:11px; cursor:pointer; font-weight:500;">
                                Registrar devolución
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" style="padding:30px; text-align:center; color:#94a3b8; font-size:13px;">
                            Sin materiales entregados pendientes de devolución.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        
        <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; overflow:hidden; box-shadow:0 1px 4px rgba(0,0,0,0.04);">
            <div style="padding:12px 16px; border-bottom:1px solid #f3f4f6; background:#f0fdf4;">
                <span style="font-size:13px; font-weight:600; color:#15803d;">✅ Devueltos (<?php echo e($devueltos->count()); ?>)</span>
            </div>
            <table style="width:100%; border-collapse:collapse; font-size:12px;">
                <thead>
                    <tr style="background:#f8fafc;">
                        <th style="padding:8px 16px; text-align:left; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Código</th>
                        <th style="padding:8px 16px; text-align:left; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Organización</th>
                        <th style="padding:8px 16px; text-align:left; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Devuelto por</th>
                        <th style="padding:8px 16px; text-align:center; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Urnas</th>
                        <th style="padding:8px 16px; text-align:center; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Cuartos</th>
                        <th style="padding:8px 16px; text-align:center; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Tintas</th>
                        <th style="padding:8px 16px; text-align:left; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $devueltos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entrada): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr style="border-bottom:1px solid #f3f4f6;" data-org="<?php echo e($entrada->nombre_organizacion); ?>">
                        <td style="padding:10px 16px; color:#185FA5; font-weight:600; font-family:monospace;"><?php echo e($entrada->codigo_org); ?></td>
                        <td style="padding:10px 16px; color:#1e293b; font-weight:500;"><?php echo e($entrada->nombre_organizacion); ?></td>
                        <td style="padding:10px 16px; color:#374151;"><?php echo e($entrada->logDevolucion?->devuelto_por ?? '—'); ?></td>
                        <td style="padding:10px 16px; text-align:center; color:#374151;"><?php echo e($entrada->logDevolucion?->urnas_devueltas ?? '—'); ?></td>
                        <td style="padding:10px 16px; text-align:center; color:#374151;"><?php echo e($entrada->logDevolucion?->cuartos_devueltos ?? '—'); ?></td>
                        <td style="padding:10px 16px; text-align:center; color:#374151;"><?php echo e($entrada->logDevolucion?->tintas_devueltas ?? '—'); ?></td>
                        <td style="padding:10px 16px; color:#94a3b8;"><?php echo e($entrada->logDevolucion?->created_at?->format('d/m/Y') ?? '—'); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" style="padding:30px; text-align:center; color:#94a3b8; font-size:13px;">
                            Sin devoluciones registradas todavía.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>


<div id="modal-devolucion" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.4); z-index:50; align-items:center; justify-content:center;">
    <div style="background:white; border-radius:12px; padding:28px; max-width:480px; width:90%; box-shadow:0 20px 60px rgba(0,0,0,0.3);">
        <h3 style="font-size:15px; font-weight:700; color:#1e293b; margin-bottom:4px;">Registrar devolución</h3>
        <p id="modal-org" style="font-size:12px; color:#94a3b8; margin-bottom:18px;"></p>

        <form id="form-devolucion" method="POST">
            <?php echo csrf_field(); ?>
            <div style="margin-bottom:12px;">
                <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Nombre de quien devuelve *</label>
                <input type="text" name="devuelto_por" required
                       style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:12px; margin-bottom:12px;">
                <div>
                    <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Urnas</label>
                    <input type="number" name="urnas_devueltas" id="modal-urnas" min="0"
                           style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
                </div>
                <div>
                    <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Cuartos</label>
                    <input type="number" name="cuartos_devueltos" id="modal-cuartos" min="0"
                           style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
                </div>
                <div>
                    <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Tintas</label>
                    <input type="number" name="tintas_devueltas" id="modal-tintas" min="0"
                           style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
                </div>
            </div>
            <div style="margin-bottom:18px;">
                <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Observaciones</label>
                <textarea name="observaciones" rows="2" placeholder="Opcional..."
                          style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box; resize:vertical;"></textarea>
            </div>
            <div style="display:flex; gap:10px; justify-content:flex-end;">
                <button type="button" onclick="document.getElementById('modal-devolucion').style.display='none'"
                        style="padding:8px 18px; border-radius:8px; border:1px solid #e5e7eb; background:white; color:#374151; font-size:13px; cursor:pointer;">
                    Cancelar
                </button>
                <button type="submit"
                        style="padding:8px 18px; border-radius:8px; border:none; background:#2563eb; color:white; font-size:13px; cursor:pointer; font-weight:500;">
                    Confirmar devolución
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function abrirModal(id, org, urnas, cuartos, tintas) {
    document.getElementById('modal-org').textContent = org;
    document.getElementById('modal-urnas').value = urnas;
    document.getElementById('modal-cuartos').value = cuartos;
    document.getElementById('modal-tintas').value = tintas;
    document.getElementById('form-devolucion').action = '/secretaria/sin-nota/log/' + id + '/devolucion';
    document.getElementById('modal-devolucion').style.display = 'flex';
}

function filtrarTablas(valor) {
    valor = valor.toLowerCase();
    document.querySelectorAll('tbody tr[data-org]').forEach(function(tr) {
        tr.style.display = tr.dataset.org.toLowerCase().includes(valor) ? '' : 'none';
    });
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
<?php /**PATH /var/www/html/resources/views/secretaria/sin_nota/log.blade.php ENDPATH**/ ?>