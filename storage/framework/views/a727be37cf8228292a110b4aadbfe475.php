<?php if (isset($component)) { $__componentOriginald3474b09374f7a1c6aabd4f89d6847dc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald3474b09374f7a1c6aabd4f89d6847dc = $attributes; } ?>
<?php $component = App\View\Components\PanelLayout::resolve(['title' => 'Panel Técnico — '.e($entrada->codigo_org).''] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('panel-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\PanelLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

<div class="px-2 py-2">
    <div style="max-width:760px; margin:0 auto;">

        
        <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:20px; margin-bottom:14px; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px; padding-bottom:10px; border-bottom:1px solid #f3f4f6;">
                <h3 style="font-size:13px; font-weight:600; color:#374151; text-transform:uppercase; letter-spacing:0.5px; margin:0;">Datos de la organización</h3>
                <a href="<?php echo e(route('tecnico.organizaciones')); ?>"
                   style="display:inline-flex; align-items:center; gap:6px; background:#f3f4f6; color:#374151; padding:6px 14px; border-radius:8px; font-size:12px; text-decoration:none; font-weight:500;">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <polyline points="15 18 9 12 15 6"/>
                    </svg>
                    Volver
                </a>
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
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


        
<?php if($entrada->detalleTecnico): ?>
<div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:20px; margin-bottom:14px; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px; padding-bottom:10px; border-bottom:1px solid #f3f4f6;">
        <h3 style="font-size:13px; font-weight:600; color:#374151; text-transform:uppercase; letter-spacing:0.5px; margin:0; display:flex; align-items:center; gap:8px;">
            Datos del Asesor
            <?php $tecDot = $entrada->detalleTecnico->enviado_tecnica ? '#16a34a' : '#eab308'; ?>
            <span style="display:inline-flex; align-items:center; gap:4px; font-size:11px; font-weight:500; color:#6b7280; text-transform:none;">
                <span style="width:9px; height:9px; border-radius:50%; background:<?php echo e($tecDot); ?>; display:inline-block;"></span>
                <?php echo e($entrada->detalleTecnico->enviado_tecnica ? 'Enviado a Técnica' : 'Pendiente'); ?>

            </span>
        </h3>
        <button id="btn-editar-asesor" onclick="activarEdicionAsesor()"
                style="display:inline-flex; align-items:center; gap:6px; background:#f3f4f6; color:#374151; padding:6px 14px; border-radius:8px; font-size:12px; border:none; cursor:pointer; font-weight:500;">
            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
            </svg>
            Editar
        </button>
    </div>

    
    <div id="asesor-readonly" style="display:block;">
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:12px;">
            <div>
                <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Órgano Electoral</label>
                <p style="font-size:14px; font-weight:600; color:#111827; margin:0;"><?php echo e($entrada->detalleTecnico->organo_electoral ?? '—'); ?></p>
            </div>
            <div>
                <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Cantidad de Listas</label>
                <p style="font-size:14px; font-weight:600; color:#111827; margin:0;"><?php echo e($entrada->detalleTecnico->cantidad_listas ?? '—'); ?></p>
            </div>
            <div>
                <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Cantidad de Papeletas</label>
                <p style="font-size:14px; font-weight:600; color:#111827; margin:0;"><?php echo e($entrada->detalleTecnico->cantidad_papeletas ?? '—'); ?></p>
            </div>
            <div>
                <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Cantidad de Mesas</label>
                <p style="font-size:14px; font-weight:600; color:#111827; margin:0;"><?php echo e($entrada->detalleTecnico->cantidad_mesas ?? '—'); ?></p>
            </div>
        </div>

        
        <?php
            $cantPapRO = $entrada->detalleTecnico->cantidad_papeletas ?? 0;
            $ordinalRO = ['Primera','Segunda','Tercera','Cuarta','Quinta','Sexta','Séptima','Octava','Novena','Décima'];
        ?>
        <?php if($cantPapRO > 0): ?>
        <div style="margin-bottom:12px;">
            <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:8px; text-transform:uppercase; letter-spacing:0.5px;">Papeletas</label>
            <?php for($p = 1; $p <= min($cantPapRO, 10); $p++): ?>
            <?php
                $candidaturaRO = $entrada->detalleTecnico->{"pap_{$p}_lista_1_candidatura"} ?? '—';
                $sistemaRO     = $entrada->detalleTecnico->{"pap_{$p}_sistema_eleccion"} ?? '—';
            ?>
            <div style="display:flex; align-items:center; gap:12px; padding:8px 12px; background:#f9fafb; border:1px solid #e5e7eb; border-radius:8px; margin-bottom:6px;">
                <span style="font-size:12px; font-weight:700; color:#374151; white-space:nowrap;"><?php echo e($ordinalRO[$p-1]); ?></span>
                <span style="font-size:13px; color:#111827; flex:1;"><?php echo e($candidaturaRO); ?></span>
                <span style="font-size:11px; color:#6b7280; white-space:nowrap;"><?php echo e($sistemaRO); ?></span>
            </div>
            <?php endfor; ?>
        </div>
        <?php endif; ?>

        
        <?php if($entrada->detalleTecnico->cantidad_mesas && $entrada->detalleTecnico->cantidad_papeletas): ?>
        <?php
            $mesasRO    = $entrada->detalleTecnico->cantidad_mesas;
            $papeletasRO = $entrada->detalleTecnico->cantidad_papeletas;
            $actasRO    = $mesasRO * 3;
            $padronesRO = $mesasRO * 3;
            $cuartosRO  = $mesasRO;
            $urnasRO    = $mesasRO * $papeletasRO;
        ?>
        <div style="background:#eff6ff; border:1px solid #bfdbfe; border-radius:8px; padding:12px 16px;">
            <p style="font-size:11px; font-weight:700; color:#1e40af; text-transform:uppercase; margin:0 0 10px;">Estimado de materiales</p>
            <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:8px;">
                <div style="text-align:center;">
                    <p style="font-size:11px; color:#6b7280; margin:0 0 2px;">Actas</p>
                    <p style="font-size:18px; font-weight:700; color:#1e40af; margin:0;"><?php echo e($actasRO); ?></p>
                </div>
                <div style="text-align:center;">
                    <p style="font-size:11px; color:#6b7280; margin:0 0 2px;">Padrones</p>
                    <p style="font-size:18px; font-weight:700; color:#1e40af; margin:0;"><?php echo e($padronesRO); ?></p>
                </div>
                <div style="text-align:center;">
                    <p style="font-size:11px; color:#6b7280; margin:0 0 2px;">Cuartos Oscuros</p>
                    <p style="font-size:18px; font-weight:700; color:#1e40af; margin:0;"><?php echo e($cuartosRO); ?></p>
                </div>
                <div style="text-align:center;">
                    <p style="font-size:11px; color:#6b7280; margin:0 0 2px;">Urnas</p>
                    <p style="font-size:18px; font-weight:700; color:#1e40af; margin:0;"><?php echo e($urnasRO); ?></p>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    
    <form id="asesor-form" method="POST" action="<?php echo e(route('tecnico.detalle_tecnico.saveAsesor', $entrada->id)); ?>"
          style="display:none;">
        <?php echo csrf_field(); ?>

        <div style="margin-bottom:14px;">
            <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:8px; text-transform:uppercase; letter-spacing:0.5px;">Órgano Electoral</label>
            <div style="display:flex; gap:10px; flex-wrap:wrap;">
                <?php $__currentLoopData = ['TEI' => 'T.E.I.', 'JEI' => 'J.E.I.', 'CEI' => 'C.E.I.']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <label style="display:flex; align-items:center; gap:8px; padding:8px 14px; border:1px solid #d1d5db; border-radius:8px; cursor:pointer; background:#fff;">
                    <input type="radio" name="organo_electoral" value="<?php echo e($value); ?>"
                        <?php echo e($entrada->detalleTecnico->organo_electoral == $value ? 'checked' : ''); ?>

                        style="width:15px; height:15px; accent-color:#2563eb;">
                    <span style="font-size:13px; font-weight:600; color:#374151;"><?php echo e($label); ?></span>
                </label>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:12px; margin-bottom:14px;">
            <div>
                <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Cantidad de Listas</label>
                <input type="number" name="cantidad_listas" min="1" max="10"
                    value="<?php echo e($entrada->detalleTecnico->cantidad_listas); ?>"
                    style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; background:#fff; box-sizing:border-box;">
            </div>
            <div>
                <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Cantidad de Papeletas</label>
                <input type="number" name="cantidad_papeletas" id="input_papeletas" min="1" max="10"
    value="<?php echo e($entrada->detalleTecnico->cantidad_papeletas); ?>"
                    style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; background:#fff; box-sizing:border-box;">
            </div>
            <div>
                <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Cantidad de Mesas</label>
                <input type="number" name="cantidad_mesas" id="input_mesas" min="1"
    value="<?php echo e($entrada->detalleTecnico->cantidad_mesas); ?>"
                    style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; background:#fff; box-sizing:border-box;">
            </div>
        </div>

        
        <?php
            $cantPapTec = $entrada->detalleTecnico->cantidad_papeletas ?? 1;
            $cantListasTec = $entrada->detalleTecnico->cantidad_listas ?? 1;
            $candidaturasTec = ['Presidente y Vicepresidentes','Presidente y Vicepresidente','Secretario General y Adjunto','Comisión Directiva','Miembros Titulares','Miembros Titulares y Suplentes','Vocales Titulares','Vocales Titulares y Suplentes','Tribunal Electoral Independiente','Junta Electoral','Colegio Electoral','Síndico','Comité Revisadora de Cuentas'];
            $sistemasTec = ['Lista Única','Lista Cerrada','Lista Desbloqueada','Lista Cerrada Bloqueada','Nominal'];
            $ordinalTec = ['Primera','Segunda','Tercera','Cuarta','Quinta','Sexta','Séptima','Octava','Novena','Décima'];
        ?>

        <div style="margin-bottom:14px;">
            <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:8px; text-transform:uppercase; letter-spacing:0.5px;">Papeletas</label>
            <?php for($p = 1; $p <= min($cantPapTec, 10); $p++): ?>
            <div style="background:#f9fafb; border:1px solid #e5e7eb; border-radius:10px; padding:14px; margin-bottom:10px;">
                <p style="font-size:12px; font-weight:700; color:#374151; margin:0 0 10px;"><?php echo e($ordinalTec[$p-1]); ?> Papeleta</p>
                <div style="display:flex; gap:8px; align-items:flex-start;">
                    <div style="flex:1; display:flex; flex-direction:column; gap:4px;">
                        <label style="font-size:11px; font-weight:600; color:#6b7280; text-transform:uppercase;">Lista</label>
                        <?php for($l = 1; $l <= min($cantListasTec, 5); $l++): ?>
                        <input type="text" name="pap_<?php echo e($p); ?>_lista_<?php echo e($l); ?>_nombre"
                            value="<?php echo e($entrada->detalleTecnico->{"pap_{$p}_lista_{$l}_nombre"}); ?>"
                            placeholder="<?php echo e($ordinalTec[$l-1]); ?> Lista"
                            style="width:100%; border:1px solid #d1d5db; border-radius:6px; padding:5px 7px; font-size:12px; color:#111827; background:#fff; box-sizing:border-box;">
                        <?php endfor; ?>
                    </div>
                    <div style="flex:1;">
                        <label style="font-size:11px; font-weight:600; color:#6b7280; text-transform:uppercase; display:block; margin-bottom:4px;">Candidatura</label>
                        <div style="display:flex; align-items:center; height:calc(100% - 20px);">
                            <input type="text" name="pap_<?php echo e($p); ?>_lista_1_candidatura"
                                value="<?php echo e($entrada->detalleTecnico->{"pap_{$p}_lista_1_candidatura"}); ?>"
                                list="candidaturas-tec-list"
                                placeholder="Candidatura..."
                                style="width:100%; border:1px solid #d1d5db; border-radius:6px; padding:5px 7px; font-size:12px; color:#111827; background:#fff; box-sizing:border-box; margin-top:<?php echo e($cantListasTec > 1 ? round(($cantListasTec-1) * 29 / 2) : 0); ?>px;">
                        </div>
                    </div>
                    <div style="flex:1;">
                        <label style="font-size:11px; font-weight:600; color:#6b7280; text-transform:uppercase; display:block; margin-bottom:4px;">Sistema de Elección</label>
                        <div style="display:flex; align-items:center; height:calc(100% - 20px);">
                            <input type="text" name="pap_<?php echo e($p); ?>_sistema_eleccion"
                                value="<?php echo e($entrada->detalleTecnico->{"pap_{$p}_sistema_eleccion"}); ?>"
                                list="sistemas-tec-list"
                                placeholder="Sistema..."
                                style="width:100%; border:1px solid #d1d5db; border-radius:6px; padding:5px 7px; font-size:12px; color:#111827; background:#fff; box-sizing:border-box; margin-top:<?php echo e($cantListasTec > 1 ? round(($cantListasTec-1) * 29 / 2) : 0); ?>px;">
                        </div>
                    </div>
                </div>
            </div>
            <?php endfor; ?>
            <datalist id="candidaturas-tec-list">
                <?php $__currentLoopData = $candidaturasTec; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($c); ?>">
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </datalist>
            <datalist id="sistemas-tec-list">
                <?php $__currentLoopData = $sistemasTec; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($s); ?>">
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </datalist>
        </div>

        <div style="display:flex; justify-content:flex-end; gap:8px;">
            <button type="button" onclick="cancelarEdicionAsesor()"
                    style="display:inline-flex; align-items:center; gap:6px; background:#f3f4f6; color:#374151; padding:8px 18px; border-radius:8px; font-size:13px; border:none; cursor:pointer; font-weight:500;">
                Cancelar
            </button>
            <button type="submit"
                    style="display:inline-flex; align-items:center; gap:6px; background:#2563eb; color:white; padding:8px 18px; border-radius:8px; font-size:13px; border:none; cursor:pointer; font-weight:500;">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
                Guardar
            </button>
        </div>
    </form>
</div>
<?php endif; ?>



        <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:20px; margin-bottom:14px; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px; padding-bottom:10px; border-bottom:1px solid #f3f4f6;">
                <h3 style="font-size:13px; font-weight:600; color:#374151; text-transform:uppercase; letter-spacing:0.5px; margin:0;">
                    Detalle Técnico
                </h3>
                <div style="display:flex; gap:8px; align-items:center;">
                    <?php if($entrada->detalleTecnico?->impreso): ?>
                    <span style="display:inline-flex; align-items:center; gap:6px; background:#d1fae5; color:#065f46; padding:6px 14px; border-radius:8px; font-size:12px; font-weight:500;">
                        ✓ Impreso <?php echo e($entrada->detalleTecnico->impreso_at?->format('d/m/Y H:i')); ?>

                    </span>
                    <?php endif; ?>
                    <button id="btn-editar-tec" onclick="activarEdicionTec()"
                            style="display:inline-flex; align-items:center; gap:6px; background:#f3f4f6; color:#374151; padding:6px 14px; border-radius:8px; font-size:12px; border:none; cursor:pointer; font-weight:500;">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                        </svg>
                        Editar
                    </button>
                </div>
            </div>

            <?php if(session('success')): ?>
            <div style="background:#d1fae5; border:1px solid #6ee7b7; border-radius:8px; padding:12px 16px; margin-bottom:16px; font-size:13px; color:#065f46;">
                <?php echo e(session('success')); ?>

            </div>
            <?php endif; ?>

            
<div id="tec-readonly" style="display:block;">

    
    <div style="margin-bottom:16px;">
        <p style="font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase; margin:0 0 10px;">Materiales Entregados</p>
        <?php
            $mesasRO = $entrada->detalleTecnico?->cantidad_mesas ?? 0;
            $defaultsRO = [
                'mat_mesas'              => $entrada->detalleTecnico?->mat_mesas ?? $mesasRO,
                'mat_actas_electorales'  => $entrada->detalleTecnico?->mat_actas_electorales ?? ($mesasRO * 3),
                'mat_padron'             => $entrada->detalleTecnico?->mat_padron ?? ($mesasRO * 3),
                'mat_matriz_boletin'     => $entrada->detalleTecnico?->mat_matriz_boletin ?? ($entrada->detalleTecnico?->cantidad_papeletas ?? 0),
                'mat_actas_proclamacion' => $entrada->detalleTecnico?->mat_actas_proclamacion ?? 3,
                'mat_certificados'       => $entrada->detalleTecnico?->mat_certificados,
                'mat_cuenta_votos'       => $entrada->detalleTecnico?->mat_cuenta_votos,
            ];
        ?>
        <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:10px;">
            <?php $__currentLoopData = [
                ['mat_mesas', 'Mesa/s', false],
                ['mat_actas_electorales', 'Actas Electorales', 'mat_actas_electorales_formato'],
                ['mat_padron', 'Padrón Electoral', 'mat_padron_formato'],
                ['mat_matriz_boletin', 'Matriz de Boletín', 'mat_matriz_boletin_formato'],
                ['mat_actas_proclamacion', 'Actas de Proclamación', false],
                ['mat_certificados', 'Certificados de Resultados', false],
                ['mat_cuenta_votos', 'Cuenta Votos', false],
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$field, $label, $formatoField]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div style="background:#f9fafb; border:1px solid #e5e7eb; border-radius:8px; padding:10px;">
                <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px;"><?php echo e($label); ?></label>
                <p style="font-size:14px; font-weight:600; color:#111827; margin:0;"><?php echo e($defaultsRO[$field] ?? '—'); ?></p>
                <?php if($formatoField): ?>
                <p style="font-size:11px; color:#6b7280; margin:2px 0 0;"><?php echo e(ucfirst($entrada->detalleTecnico?->$formatoField ?? '')); ?></p>
                <?php endif; ?>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    
    <div style="margin-bottom:16px;">
        <p style="font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase; margin:0 0 10px;">Padrón</p>
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-bottom:10px;">
            <div style="background:#f9fafb; border:1px solid #e5e7eb; border-radius:8px; padding:10px;">
                <p style="font-size:13px; font-weight:600; color:#111827; margin:0;">
                    <?php echo e($entrada->detalleTecnico?->padron_definitivo ? '✓ Padrón Definitivo' : '✗ Sin Padrón Definitivo'); ?>

                </p>
            </div>
            <div style="background:#f9fafb; border:1px solid #e5e7eb; border-radius:8px; padding:10px;">
                <p style="font-size:13px; font-weight:600; color:#111827; margin:0;">
                    <?php echo e($entrada->detalleTecnico?->padron_con_cedula ? '✓ Padrón con Cédula' : '✗ Sin Padrón con Cédula'); ?>

                </p>
            </div>
        </div>
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
            <div>
                <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase;">Cantidad de Electores</label>
                <p style="font-size:14px; font-weight:600; color:#111827; margin:0;"><?php echo e($entrada->detalleTecnico?->cantidad_electores ?? '—'); ?></p>
            </div>
            <div>
                <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase;">Electores sin C.I.</label>
                <p style="font-size:14px; font-weight:600; color:#111827; margin:0;"><?php echo e($entrada->detalleTecnico?->cantidad_electores_sin_ci ?? '—'); ?></p>
            </div>
        </div>
    </div>

    
    <div>
        <p style="font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase; margin:0 0 10px;">Responsables</p>
        <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:10px;">
            <?php $__currentLoopData = [
                ['resp_actas_electorales', 'Actas Electorales'],
                ['resp_papeletas', 'Papeletas / Boletín'],
                ['resp_padron_electoral', 'Padrón Electoral'],
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$field, $label]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div>
                <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase;"><?php echo e($label); ?></label>
                <p style="font-size:14px; font-weight:600; color:#111827; margin:0;"><?php echo e($entrada->detalleTecnico?->$field ?? '—'); ?></p>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>

            
<form id="tec-form" method="POST" action="<?php echo e(route('tecnico.detalle_tecnico.saveTecnico', $entrada->id)); ?>" style="display:none;">
    <?php echo csrf_field(); ?>

    <?php
        $mesas          = $entrada->detalleTecnico?->cantidad_mesas ?? 0;
        $defaultMesas   = $entrada->detalleTecnico?->mat_mesas ?? $mesas;
        $defaultActas   = $entrada->detalleTecnico?->mat_actas_electorales ?? ($mesas * 3);
        $defaultPadron  = $entrada->detalleTecnico?->mat_padron ?? ($mesas * 3);
        $defaultBoletin = $entrada->detalleTecnico?->mat_matriz_boletin ?? ($entrada->detalleTecnico?->cantidad_papeletas ?? 0);
    ?>

    
                <div style="margin-bottom:20px;">
                    <p style="font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase; margin:0 0 14px;">Materiales Entregados</p>
                    <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:12px;">
                       <?php $__currentLoopData = [
    ['mat_mesas', 'Mesa/s', false, $defaultMesas],
    ['mat_actas_electorales', 'Actas Electorales', true, $defaultActas],
    ['mat_padron', 'Padrón Electoral', true, $defaultPadron],
    ['mat_matriz_boletin', 'Matriz de Boletín', true, $defaultBoletin],
   ['mat_actas_proclamacion', 'Actas de Proclamación', false, $entrada->detalleTecnico?->mat_actas_proclamacion ?? 3],
    ['mat_certificados', 'Certificados de Resultados', false, null],
    ['mat_cuenta_votos', 'Cuenta Votos', false, null],
]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$field, $label, $hasFormato, $default]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div style="background:#f9fafb; border:1px solid #e5e7eb; border-radius:8px; padding:12px;">
                            <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:6px;"><?php echo e($label); ?></label>
                            <input type="number" name="<?php echo e($field); ?>" min="0"
                                value="<?php echo e(old($field, $entrada->detalleTecnico?->$field ?? $default)); ?>"
                                style="width:100%; border:1px solid #d1d5db; border-radius:6px; padding:6px 8px; font-size:13px; color:#111827; background:#fff; box-sizing:border-box; margin-bottom:<?php echo e($hasFormato ? '6px' : '0'); ?>;">
                            <?php if($hasFormato): ?>
                            <select name="<?php echo e($field); ?>_formato"
                                style="width:100%; border:1px solid #d1d5db; border-radius:6px; padding:6px 8px; font-size:12px; color:#374151; background:#fff; box-sizing:border-box;">
                                <option value="">Formato...</option>
                                <option value="impreso" <?php echo e(old("{$field}_formato", $entrada->detalleTecnico?->{"{$field}_formato"}) == 'impreso' ? 'selected' : ''); ?>>Impreso</option>
                                <option value="digital" <?php echo e(old("{$field}_formato", $entrada->detalleTecnico?->{"{$field}_formato"}) == 'digital' ? 'selected' : ''); ?>>Digital</option>
                            </select>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                
                <div style="margin-bottom:20px;">
                    <p style="font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase; margin:0 0 14px;">Padrón</p>
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:12px;">
                        <label style="display:flex; align-items:center; gap:10px; padding:10px 14px; border:1px solid #d1d5db; border-radius:8px; cursor:pointer; background:#fff;">
                            <input type="checkbox" name="padron_definitivo" value="1"
                                <?php echo e(old('padron_definitivo', $entrada->detalleTecnico?->padron_definitivo) ? 'checked' : ''); ?>

                                style="width:15px; height:15px; accent-color:#2563eb;">
                            <span style="font-size:13px; font-weight:600; color:#374151;">Padrón Definitivo</span>
                        </label>
                        <label style="display:flex; align-items:center; gap:10px; padding:10px 14px; border:1px solid #d1d5db; border-radius:8px; cursor:pointer; background:#fff;">
                            <input type="checkbox" name="padron_con_cedula" value="1"
                                <?php echo e(old('padron_con_cedula', $entrada->detalleTecnico?->padron_con_cedula) ? 'checked' : ''); ?>

                                style="width:15px; height:15px; accent-color:#2563eb;">
                            <span style="font-size:13px; font-weight:600; color:#374151;">Padrón con Cédula</span>
                        </label>
                    </div>
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                        <div>
                            <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:6px;">Cantidad de Electores</label>
                            <input type="number" name="cantidad_electores" min="0"
                                value="<?php echo e(old('cantidad_electores', $entrada->detalleTecnico?->cantidad_electores)); ?>"
                                style="width:100%; border:1px solid #d1d5db; border-radius:8px; padding:8px 10px; font-size:13px; color:#111827; background:#fff; box-sizing:border-box;">
                        </div>
                        <div>
                            <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:6px;">Electores sin C.I.</label>
                            <input type="number" name="cantidad_electores_sin_ci" min="0"
                                value="<?php echo e(old('cantidad_electores_sin_ci', $entrada->detalleTecnico?->cantidad_electores_sin_ci)); ?>"
                                style="width:100%; border:1px solid #d1d5db; border-radius:8px; padding:8px 10px; font-size:13px; color:#111827; background:#fff; box-sizing:border-box;">
                        </div>
                    </div>
                </div>

                
                <div style="margin-bottom:24px;">
                    <p style="font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase; margin:0 0 14px;">Responsables</p>
                    <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:12px;">
                        <?php $__currentLoopData = [
                            ['resp_actas_electorales', 'Actas Electorales'],
                            ['resp_papeletas', 'Papeletas / Boletín'],
                            ['resp_padron_electoral', 'Padrón Electoral'],
                        ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$field, $label]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div>
                            <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:6px;"><?php echo e($label); ?></label>
                            <input type="text" name="<?php echo e($field); ?>"
                                value="<?php echo e(old($field, $entrada->detalleTecnico?->$field)); ?>"
                                list="tecnicos-list"
                                placeholder="Nombre del responsable..."
                                style="width:100%; border:1px solid #d1d5db; border-radius:8px; padding:8px 10px; font-size:13px; color:#111827; background:#fff; box-sizing:border-box;">
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <datalist id="tecnicos-list">
    <option value="Selica Gamarra">
    <option value="Cristhian Maidana">
    <option value="Marcos Ramírez">
    <option value="Santiago Acuña">
    <option value="Liliana López">
    <option value="David Cousirat">
    <option value="Lilian Martinez">
</datalist>
                </div>

                
                <div style="display:flex; justify-content:flex-end; gap:8px;">
                    <button type="button" onclick="cancelarEdicionTec()"
                        style="display:inline-flex; align-items:center; gap:6px; background:#f3f4f6; color:#374151; padding:10px 20px; border-radius:8px; font-size:13px; border:none; cursor:pointer; font-weight:500;">
                        Cancelar
                    </button>
                    <button type="submit"
                        style="display:inline-flex; align-items:center; gap:6px; background:#2563eb; color:white; padding:10px 24px; border-radius:8px; font-size:13px; border:none; cursor:pointer; font-weight:500;">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                        Guardar
                    </button>
                </div>
            </form>

            
            <div style="display:flex; gap:10px; margin-top:16px; padding-top:16px; border-top:1px solid #f3f4f6;">
                <form method="POST" action="<?php echo e(route('tecnico.detalle_tecnico.imprimir', $entrada->id)); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit" onclick="return confirm('¿Marcar como impreso?')"
                        style="display:inline-flex; align-items:center; gap:6px; background:#1e3a5f; color:white; padding:10px 20px; border-radius:8px; font-size:13px; border:none; cursor:pointer; font-weight:500;">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <polyline points="6 9 6 2 18 2 18 9"/>
                            <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                            <rect x="6" y="14" width="12" height="8"/>
                        </svg>
                        Imprimir Logística
                    </button>
                </form>

                <?php if(!$entrada->detalleTecnico?->tec_realizado): ?>
                <form method="POST" action="<?php echo e(route('tecnico.detalle_tecnico.realizado', $entrada->id)); ?>">
                    <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                    <button type="submit" onclick="return confirm('¿Marcar trabajo técnico como realizado?')"
                        style="display:inline-flex; align-items:center; gap:6px; background:#16a34a; color:white; padding:10px 20px; border-radius:8px; font-size:13px; border:none; cursor:pointer; font-weight:500;">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                        Marcar como Realizado
                    </button>
                </form>
                <?php else: ?>
                <span style="display:inline-flex; align-items:center; gap:6px; background:#bbf7d0; color:#166534; padding:10px 20px; border-radius:8px; font-size:13px; font-weight:500;">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    Realizado
                </span>
                <?php endif; ?>
            </div>
        </div>

        
        <div style="display:flex; justify-content:flex-end;">
            <a href="<?php echo e(route('tecnico.organizaciones')); ?>"
               style="display:inline-flex; align-items:center; gap:6px; background:#1e3a5f; color:white; padding:10px 20px; border-radius:8px; font-size:14px; text-decoration:none; font-weight:500;">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="15 18 9 12 15 6"/>
                </svg>
                Volver a organizaciones
            </a>
        </div>

    </div>
</div>
<script>
function activarEdicionAsesor() {
    document.getElementById('asesor-readonly').style.display = 'none';
    document.getElementById('asesor-form').style.display = 'block';
    document.getElementById('btn-editar-asesor').style.display = 'none';
}

function cancelarEdicionAsesor() {
    document.getElementById('asesor-readonly').style.display = 'block';
    document.getElementById('asesor-form').style.display = 'none';
    document.getElementById('btn-editar-asesor').style.display = 'inline-flex';
}

function activarEdicionTec() {
    document.getElementById('tec-readonly').style.display = 'none';
    document.getElementById('tec-form').style.display = 'block';
    document.getElementById('btn-editar-tec').style.display = 'none';
}

function cancelarEdicionTec() {
    document.getElementById('tec-readonly').style.display = 'block';
    document.getElementById('tec-form').style.display = 'none';
    document.getElementById('btn-editar-tec').style.display = 'inline-flex';
}
</script>

<div id="banner-actualizacion" style="display:none; position:fixed; top:16px; left:50%; transform:translateX(-50%); z-index:9999; background:#fef3c7; border:1px solid #f59e0b; border-radius:10px; padding:12px 20px; font-size:13px; font-weight:500; color:#92400e; box-shadow:0 4px 12px rgba(0,0,0,0.15); align-items:center; gap:10px;">
    ⚠️ El asesor actualizó los datos —
    <a href="javascript:location.reload()" style="color:#92400e; font-weight:700; text-decoration:underline;">recargá la página</a>
</div>

<script>
const entradaId = <?php echo e($entrada->id); ?>;
const timestampInicial = "<?php echo e($entrada->detalleTecnico?->asesor_updated_at ?? ''); ?>";

if (timestampInicial) {
    setInterval(async function() {
        try {
            const r = await fetch('/tecnico/detalle/' + entradaId + '/check-update');
            const d = await r.json();
            if (d.asesor_updated_at && d.asesor_updated_at !== timestampInicial) {
                document.getElementById('banner-actualizacion').style.display = 'flex';
            }
        } catch(e) {}
    }, 30000);
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
<?php /**PATH /var/www/html/resources/views/tecnico/edit_tecnico.blade.php ENDPATH**/ ?>