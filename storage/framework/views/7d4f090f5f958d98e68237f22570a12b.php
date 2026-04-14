<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(config('app.name', 'Sistema de Gestion')); ?></title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="icon" type="image/x-icon" href="/favicon-tsje.ico">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <style>
    @keyframes humo {
        0%   { background-position: 0% 50%; }
        50%  { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    * { scrollbar-width: none; -ms-overflow-style: none; }
    *::-webkit-scrollbar { display: none; }
    #ticker-nombre, #ticker-dias { transition: opacity 0.3s ease; }
    </style>
</head>

<body class="font-sans antialiased" style="min-height:100vh; overflow:hidden; height:100vh;">


<div style="position:fixed; top:0; left:0; width:100%; height:100%; z-index:-1;
    background: linear-gradient(135deg, #f0f2f5 0%, #e2e8f8 35%, #ede8f5 65%, #f0f2f5 100%);
    background-size: 400% 400%;
    animation: humo 10s ease infinite;">
</div>

<div style="display:flex; height:100vh; background:transparent; overflow:hidden;">

    
    <div style="width:220px; min-width:220px; background:linear-gradient(180deg, rgba(30,50,160,0.75) 0%, rgba(20,35,120,0.85) 50%, rgba(30,50,160,0.75) 100%); display:flex; flex-direction:column; backdrop-filter:blur(16px); -webkit-backdrop-filter:blur(16px); border-right:1px solid rgba(255,255,255,0.12); box-shadow:2px 0 16px rgba(43,78,200,0.15);">

        
        <div style="padding:20px 16px 16px; border-bottom:1px solid rgba(255,255,255,0.07);">
            <div style="font-size:14px; font-weight:600; color:#fff; letter-spacing:0.3px;">Dir. Org. Intermedias</div>
            <div style="font-size:11px; color:rgba(255,255,255,0.35); margin-top:2px;">Sistema de Gestion</div>
        </div>

        
        <div style="margin:14px 12px 6px; padding:9px 12px; background:rgba(255,255,255,0.06); border-radius:8px; border:1px solid rgba(255,255,255,0.08);">
            <div style="font-size:10px; color:rgba(255,255,255,0.35); margin-bottom:2px;">Rol activo</div>
            <div style="font-size:13px; font-weight:500; color:#fff;"><?php echo e(auth()->user()->getRoleNames()->first()); ?></div>
        </div>

        
        <div style="padding:14px 14px 4px; font-size:10px; color:rgba(255,255,255,0.25); letter-spacing:1px; text-transform:uppercase;">Principal</div>
        <a href="<?php echo e(route('panel.dashboard')); ?>"
            style="display:flex; align-items:center; gap:10px; padding:9px 14px; margin:1px 8px; border-radius:8px; font-size:13px; color:<?php echo e(request()->routeIs('panel.dashboard') ? '#fff' : 'rgba(255,255,255,0.55)'); ?>; background:<?php echo e(request()->routeIs('panel.dashboard') ? 'rgba(99,130,255,0.2)' : 'transparent'); ?>; text-decoration:none; border:<?php echo e(request()->routeIs('panel.dashboard') ? '1px solid rgba(99,130,255,0.3)' : '1px solid transparent'); ?>; transition:all 0.2s;"
            onmouseover="this.style.background='rgba(255,255,255,0.12)'"
            onmouseout="this.style.background='<?php echo e(request()->routeIs('panel.dashboard') ? 'rgba(99,130,255,0.2)' : 'transparent'); ?>'">
            <span style="width:7px; height:7px; border-radius:50%; background:#60a5fa; flex-shrink:0;"></span>
            Panel General
        </a>

        
        <div style="padding:14px 14px 4px; font-size:10px; color:rgba(255,255,255,0.25); letter-spacing:1px; text-transform:uppercase;">Entradas</div>
        <a href="<?php echo e(route('secretaria.con-nota.index')); ?>"
            style="display:flex; align-items:center; gap:10px; padding:9px 14px; margin:1px 8px; border-radius:8px; font-size:13px; color:<?php echo e(request()->routeIs('secretaria.con-nota.*') ? '#fff' : 'rgba(255,255,255,0.55)'); ?>; background:<?php echo e(request()->routeIs('secretaria.con-nota.*') ? 'rgba(52,211,153,0.15)' : 'transparent'); ?>; text-decoration:none; border:<?php echo e(request()->routeIs('secretaria.con-nota.*') ? '1px solid rgba(52,211,153,0.25)' : '1px solid transparent'); ?>; transition:all 0.2s;"
            onmouseover="this.style.background='rgba(255,255,255,0.12)'"
            onmouseout="this.style.background='<?php echo e(request()->routeIs('secretaria.con-nota.*') ? 'rgba(52,211,153,0.15)' : 'transparent'); ?>'">
            <span style="width:7px; height:7px; border-radius:50%; background:#34d399; flex-shrink:0;"></span>
            Mesa de Entrada
        </a>
        <?php if(auth()->user()->roles->first()?->name === 'Asesor'): ?>
<a href="<?php echo e(route('asesor.mis-organizaciones')); ?>"
    style="display:flex; align-items:center; gap:10px; padding:9px 14px; margin:1px 8px; border-radius:8px; font-size:13px; color:<?php echo e(request()->routeIs('asesor.*') ? '#fff' : 'rgba(255,255,255,0.55)'); ?>; background:<?php echo e(request()->routeIs('asesor.*') ? 'rgba(52,211,153,0.15)' : 'transparent'); ?>; text-decoration:none; border:<?php echo e(request()->routeIs('asesor.*') ? '1px solid rgba(52,211,153,0.25)' : '1px solid transparent'); ?>; transition:all 0.2s;"
    onmouseover="this.style.background='rgba(255,255,255,0.12)'"
    onmouseout="this.style.background='<?php echo e(request()->routeIs('asesor.*') ? 'rgba(52,211,153,0.15)' : 'transparent'); ?>'">
    <span style="width:7px; height:7px; border-radius:50%; background:<?php echo e(request()->routeIs('asesor.*') ? '#34d399' : 'rgba(255,255,255,0.28)'); ?>; flex-shrink:0;"></span>
    Mis organizaciones
</a>
<?php else: ?>
<a href="<?php echo e(route('secretaria.sin-nota.index')); ?>"
    style="display:flex; align-items:center; gap:10px; padding:9px 14px; margin:1px 8px; border-radius:8px; font-size:13px; color:<?php echo e(request()->routeIs('secretaria.sin-nota.*') ? '#fff' : 'rgba(255,255,255,0.55)'); ?>; background:<?php echo e(request()->routeIs('secretaria.sin-nota.*') ? 'rgba(255,255,255,0.1)' : 'transparent'); ?>; text-decoration:none; border:<?php echo e(request()->routeIs('secretaria.sin-nota.*') ? '1px solid rgba(255,255,255,0.15)' : '1px solid transparent'); ?>; transition:all 0.2s;"
    onmouseover="this.style.background='rgba(255,255,255,0.12)'"
    onmouseout="this.style.background='<?php echo e(request()->routeIs('secretaria.sin-nota.*') ? 'rgba(255,255,255,0.1)' : 'transparent'); ?>'">
    <span style="width:7px; height:7px; border-radius:50%; background:rgba(255,255,255,0.28); flex-shrink:0;"></span>
    Entradas sin nota
</a>
<?php endif; ?>
        </a>

        
        <div style="padding:14px 14px 4px; font-size:10px; color:rgba(255,255,255,0.25); letter-spacing:1px; text-transform:uppercase;">Trabajo</div>
        <a href="#"
            style="display:flex; align-items:center; gap:10px; padding:9px 14px; margin:1px 8px; border-radius:8px; font-size:13px; color:rgba(255,255,255,0.55); text-decoration:none; border:1px solid transparent; transition:all 0.2s;"
            onmouseover="this.style.background='rgba(255,255,255,0.12)'"
            onmouseout="this.style.background='transparent'">
            <span style="width:7px; height:7px; border-radius:50%; background:#fbbf24; flex-shrink:0;"></span>
            Panel tecnico
        </a>
        <a href="#"
            style="display:flex; align-items:center; gap:10px; padding:9px 14px; margin:1px 8px; border-radius:8px; font-size:13px; color:rgba(255,255,255,0.55); text-decoration:none; border:1px solid transparent; transition:all 0.2s;"
            onmouseover="this.style.background='rgba(255,255,255,0.12)'"
            onmouseout="this.style.background='transparent'">
            <span style="width:7px; height:7px; border-radius:50%; background:#a78bfa; flex-shrink:0;"></span>
            Charlas
        </a>
        <a href="#"
            style="display:flex; align-items:center; gap:10px; padding:9px 14px; margin:1px 8px; border-radius:8px; font-size:13px; color:rgba(255,255,255,0.55); text-decoration:none; border:1px solid transparent; transition:all 0.2s;"
            onmouseover="this.style.background='rgba(255,255,255,0.12)'"
            onmouseout="this.style.background='transparent'">
            <span style="width:7px; height:7px; border-radius:50%; background:#f472b6; flex-shrink:0;"></span>
            Borrador privado
        </a>

        
        <div style="padding:14px 14px 4px; font-size:10px; color:rgba(255,255,255,0.25); letter-spacing:1px; text-transform:uppercase;">Utilidades</div>
        <a href="#"
            style="display:flex; align-items:center; gap:10px; padding:9px 14px; margin:1px 8px; border-radius:8px; font-size:13px; color:rgba(255,255,255,0.55); text-decoration:none; border:1px solid transparent; transition:all 0.2s;"
            onmouseover="this.style.background='rgba(255,255,255,0.12)'"
            onmouseout="this.style.background='transparent'">
            <span style="width:7px; height:7px; border-radius:50%; background:rgba(255,255,255,0.28); flex-shrink:0;"></span>
            Manuales
        </a>

    </div>
    

    
    <div style="flex:1; display:flex; flex-direction:column; overflow:hidden; background:transparent;">

        
        <div style="background:rgba(255,255,255,0.4); backdrop-filter:blur(8px); border-bottom:1px solid #e5e7eb; padding:13px 22px; display:flex; align-items:center; justify-content:space-between;">

            
            <div style="display:flex; align-items:center; gap:8px;">
                <svg width="16" height="16" fill="none" stroke="#6b7280" stroke-width="1.8" viewBox="0 0 24 24">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                </svg>
                <span style="font-size:15px; font-weight:500; color:#111827;"><?php echo e($title ?? 'Dashboard'); ?></span>
            </div>

            
            <div style="display:flex; align-items:center; gap:14px;">

               
                <?php if(isset($elecciones)): ?>
                <?php if($elecciones->count() > 0): ?>
                <?php $primera = $elecciones->first(); $diasPrimera = (int) now()->startOfDay()->diffInDays($primera->fecha_eleccion->startOfDay(), false); ?>
                <div onclick="toggleElecciones()" id="ticker-box"
                     style="display:flex; align-items:center; gap:8px; background:#f0f9ff; border:1px solid #bae6fd; border-radius:8px; padding:5px 12px; cursor:pointer; min-width:180px; max-width:260px;">
                    <svg width="13" height="13" fill="none" stroke="#0369a1" stroke-width="1.8" viewBox="0 0 24 24" style="flex-shrink:0;">
                        <rect x="3" y="4" width="18" height="18" rx="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                    <span style="font-size:11px; color:#0369a1; font-weight:600; white-space:nowrap; flex-shrink:0;">Próxima:</span>
                    <span id="ticker-nombre" style="font-size:12px; color:#0c4a6e; font-weight:500; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; flex:1;"><?php echo e($primera->nombre_organizacion); ?></span>
                    <span id="ticker-dias" style="font-size:10px; font-weight:600; padding:2px 7px; border-radius:20px; flex-shrink:0;
                        background:<?php echo e($diasPrimera <= 7 ? '#fee2e2' : ($diasPrimera <= 15 ? '#fef3c7' : '#d1fae5')); ?>;
                        color:<?php echo e($diasPrimera <= 7 ? '#991b1b' : ($diasPrimera <= 15 ? '#92400e' : '#065f46')); ?>;">
                        <?php echo e($diasPrimera); ?> días
                    </span>
                </div>
                <?php endif; ?>
                <?php endif; ?>

                
<?php $cp = $charlasPendientes ?? null; ?>
<?php if($cp && $cp->count() > 0): ?>
<?php $primeraCharla = $cp->first(); $diasCharla = (int) now()->startOfDay()->diffInDays($primeraCharla->fecha_hora->startOfDay(), false); ?>
                <div onclick="toggleCharlas()" id="ticker-box-charla"
                     style="display:flex; align-items:center; gap:8px; background:#fefce8; border:1px solid #fde68a; border-radius:8px; padding:5px 12px; cursor:pointer; min-width:180px; max-width:260px;">
                    <svg width="13" height="13" fill="none" stroke="#854d0e" stroke-width="1.8" viewBox="0 0 24 24" style="flex-shrink:0;">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                    </svg>
                    <span style="font-size:11px; color:#854d0e; font-weight:600; white-space:nowrap; flex-shrink:0;">Charla:</span>
                    <span id="ticker-charla-nombre" style="font-size:12px; color:#713f12; font-weight:500; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; flex:1;"><?php echo e($primeraCharla->entrada->nombre_organizacion ?? '—'); ?></span>
                    <span style="font-size:10px; font-weight:600; padding:2px 7px; border-radius:20px; flex-shrink:0; background:#fef9c3; color:#854d0e;">
                        <?php echo e($diasCharla); ?> días
                    </span>
                </div>
                <?php endif; ?>

                
                <div style="position:relative; cursor:pointer;" onclick="toggleNotif()">
                    <svg width="20" height="20" fill="none" stroke="#6b7280" stroke-width="1.5" viewBox="0 0 24 24">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                    </svg>
                    <?php $unread = auth()->user()->unreadNotifications->count(); ?>
                    <?php if($unread > 0): ?>
                    <span style="position:absolute; top:-5px; right:-5px; background:#e24b4a; color:#fff; font-size:9px; font-weight:600; width:15px; height:15px; border-radius:50%; display:flex; align-items:center; justify-content:center;">
                        <?php echo e($unread); ?>

                    </span>
                    <?php endif; ?>
                </div>

                
                <div onclick="toggleMenu()" style="width:32px; height:32px; border-radius:50%; background:#185FA5; display:flex; align-items:center; justify-content:center; font-size:11px; font-weight:600; color:#fff; cursor:pointer; user-select:none;">
                    <?php echo e(strtoupper(substr(auth()->user()->name, 0, 2))); ?>

                </div>

            </div>
        </div>
        

        
       <div style="flex:1; padding:10px 8px 60px 8px; overflow-y:auto; overflow-x:hidden; background:transparent;">
    <?php echo e($slot); ?>

</div>

    </div>
    

</div>


<div id="eleccionesMenu" style="display:none; position:fixed; top:52px; right:80px; background:#fff; border:1px solid #e5e7eb; border-radius:12px; box-shadow:0 8px 24px rgba(0,0,0,0.12); width:290px; z-index:99999; overflow:hidden;">
    <div style="padding:10px 14px; border-bottom:1px solid #f3f4f6;">
    <span style="font-size:11px; font-weight:600; color:#374151; text-transform:uppercase; letter-spacing:0.5px;">Elecciones próximas</span>
</div>
<?php if(isset($elecciones)): ?>
<?php $__empty_1 = true; $__currentLoopData = $elecciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
<?php $dias = (int) now()->startOfDay()->diffInDays($e->fecha_eleccion->startOfDay(), false); ?>
<div style="display:flex; justify-content:space-between; align-items:center; padding:9px 14px; border-bottom:1px solid #f9fafb;">
    <div>
        <div style="font-size:12px; font-weight:500; color:#111827;"><?php echo e($e->nombre_organizacion); ?></div>
        <div style="font-size:10.5px; color:#6b7280;"><?php echo e($e->fecha_eleccion->format('d M Y')); ?> — <?php echo e($e->asesor_asignado); ?></div>
    </div>
    <span style="font-size:10.5px; font-weight:500; padding:3px 9px; border-radius:20px; flex-shrink:0;
        background:<?php echo e($dias <= 7 ? '#fee2e2' : ($dias <= 15 ? '#fef3c7' : '#d1fae5')); ?>;
        color:<?php echo e($dias <= 7 ? '#991b1b' : ($dias <= 15 ? '#92400e' : '#065f46')); ?>;">
        <?php echo e($dias); ?> días
    </span>
</div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div style="padding:16px; text-align:center; font-size:12px; color:#9ca3af;">Sin elecciones próximas.</div>
    <?php endif; ?>
    <?php endif; ?>
</div>


<?php $cp = $charlasPendientes ?? null; ?>
<?php if($cp && $cp->count() > 0): ?>
<div id="charlasMenu" style="display:none; position:fixed; top:52px; right:80px; background:#fff; border:1px solid #e5e7eb; border-radius:12px; box-shadow:0 8px 24px rgba(0,0,0,0.12); width:290px; z-index:99999; overflow:hidden;">
    <div style="padding:10px 14px; border-bottom:1px solid #f3f4f6;">
        <span style="font-size:11px; font-weight:600; color:#374151; text-transform:uppercase; letter-spacing:0.5px;">Charlas Pendientes</span>
    </div>
    <?php $__empty_1 = true; $__currentLoopData = $cp; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <?php $dc = (int) now()->startOfDay()->diffInDays($c->fecha_hora->startOfDay(), false); ?>
    <div style="display:flex; justify-content:space-between; align-items:center; padding:9px 14px; border-bottom:1px solid #f9fafb;">
        <div>
            <div style="font-size:12px; font-weight:500; color:#111827;"><?php echo e($c->entrada->nombre_organizacion ?? '—'); ?></div>
            <div style="font-size:10.5px; color:#6b7280;"><?php echo e($c->fecha_hora->format('d M Y H:i')); ?> — <?php echo e($c->entrada->asesor_asignado ?? '—'); ?></div>
        </div>
        <span style="font-size:10.5px; font-weight:500; padding:3px 9px; border-radius:20px; flex-shrink:0; background:#fef9c3; color:#854d0e;">
            <?php echo e($dc); ?> días
        </span>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div style="padding:16px; text-align:center; font-size:12px; color:#9ca3af;">Sin charlas pendientes.</div>
    <?php endif; ?>
</div>
<?php endif; ?>


<div id="notifMenu" style="display:none; position:fixed; top:52px; right:60px; background:#fff; border:1px solid #e5e7eb; border-radius:12px; box-shadow:0 8px 24px rgba(0,0,0,0.12); width:300px; z-index:99999; overflow:hidden;">
    <div style="padding:12px 16px; border-bottom:1px solid #f3f4f6; display:flex; justify-content:space-between; align-items:center;">
        <span style="font-size:12px; font-weight:600; color:#374151; text-transform:uppercase; letter-spacing:0.5px;">Notificaciones</span>
        <?php if($unread > 0): ?>
        <span style="background:#e24b4a; color:#fff; font-size:10px; font-weight:600; padding:2px 7px; border-radius:20px;"><?php echo e($unread); ?></span>
        <?php endif; ?>
    </div>
    <div style="max-height:320px; overflow:auto;">
        <?php $__empty_1 = true; $__currentLoopData = auth()->user()->notifications->take(8); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div style="padding:11px 16px; border-bottom:1px solid #f9fafb; display:flex; align-items:flex-start; gap:8px;">
            <span style="width:7px; height:7px; border-radius:50%; flex-shrink:0; margin-top:4px; background:<?php echo e($notif->read_at ? '#d1d5db' : '#185FA5'); ?>;"></span>
            <div style="flex:1;">
                <div style="font-size:12px; color:#111827; line-height:1.4;"><?php echo e($notif->data['mensaje'] ?? ''); ?></div>
                <?php if(isset($notif->data['seccion'])): ?>
                <div style="font-size:10.5px; color:#6b7280; margin-top:2px;"><?php echo e($notif->data['seccion']); ?></div>
                <?php endif; ?>
                <div style="font-size:10px; color:#9ca3af; margin-top:3px;"><?php echo e($notif->created_at->diffForHumans()); ?></div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div style="padding:20px 16px; text-align:center; font-size:12px; color:#9ca3af;">Sin notificaciones.</div>
        <?php endif; ?>
    </div>
</div>


<div id="userMenu" style="display:none; position:fixed; top:52px; right:16px; background:#fff; border:1px solid #e5e7eb; border-radius:10px; box-shadow:0 8px 24px rgba(0,0,0,0.15); min-width:160px; z-index:99999; overflow:hidden;">
    <div style="padding:10px 14px; border-bottom:1px solid #f3f4f6;">
        <div style="font-size:12px; font-weight:500; color:#111827;"><?php echo e(auth()->user()->name); ?></div>
        <div style="font-size:11px; color:#9ca3af; margin-top:1px;"><?php echo e(auth()->user()->getRoleNames()->first()); ?></div>
    </div>
    <a href="#" style="display:flex; align-items:center; gap:8px; padding:9px 14px; font-size:13px; color:#374151; text-decoration:none;"
        onmouseover="this.style.background='#f9fafb'"
        onmouseout="this.style.background='transparent'">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
            <circle cx="12" cy="7" r="4"/>
        </svg>
        Perfil
    </a>
    <form method="POST" action="<?php echo e(route('logout')); ?>">
        <?php echo csrf_field(); ?>
        <button type="submit" style="width:100%; display:flex; align-items:center; gap:8px; padding:9px 14px; font-size:13px; color:#e24b4a; background:transparent; border:none; cursor:pointer; text-align:left;"
            onmouseover="this.style.background='#fff5f5'"
            onmouseout="this.style.background='transparent'">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                <polyline points="16 17 21 12 16 7"/>
                <line x1="21" y1="12" x2="9" y2="12"/>
            </svg>
            Cerrar sesión
        </button>
    </form>
</div>

<script>
<?php if(isset($elecciones)): ?>
<?php if($elecciones->count() > 1): ?>
<?php
    $tickerData = $elecciones->map(function($e) {
        $dias = (int) now()->startOfDay()->diffInDays($e->fecha_eleccion->startOfDay(), false);
        $bg = $dias <= 7 ? '#fee2e2' : ($dias <= 15 ? '#fef3c7' : '#d1fae5');
        $color = $dias <= 7 ? '#991b1b' : ($dias <= 15 ? '#92400e' : '#065f46');
        return ['nombre' => $e->nombre_organizacion, 'dias' => $dias, 'bg' => $bg, 'color' => $color];
    });
?>
const tickerItems = <?php echo json_encode($tickerData, 15, 512) ?>;
let tickerIdx = 0;
const tickerNombre = document.getElementById('ticker-nombre');
const tickerDias = document.getElementById('ticker-dias');
if (tickerNombre && tickerItems.length > 1) {
    setInterval(() => {
        tickerNombre.style.opacity = '0';
        tickerDias.style.opacity = '0';
        setTimeout(() => {
            tickerIdx = (tickerIdx + 1) % tickerItems.length;
            const item = tickerItems[tickerIdx];
            tickerNombre.textContent = item.nombre;
            tickerDias.textContent = item.dias + ' días';
            tickerDias.style.background = item.bg;
            tickerDias.style.color = item.color;
            tickerNombre.style.opacity = '1';
            tickerDias.style.opacity = '1';
        }, 300);
    }, 3000);
}
<?php endif; ?>
<?php endif; ?>

<?php if($cp && $cp->count() > 1): ?>
<?php
    $charlasData = $cp->map(function($c) {
        return ['nombre' => $c->entrada->nombre_organizacion ?? '—'];
    });
?>
const charlasItems = <?php echo json_encode($charlasData, 15, 512) ?>;
let charlasIdx = 0;
const tickerCharlaNombre = document.getElementById('ticker-charla-nombre');
if (tickerCharlaNombre && charlasItems.length > 1) {
    setInterval(() => {
        tickerCharlaNombre.style.opacity = '0';
        setTimeout(() => {
            charlasIdx = (charlasIdx + 1) % charlasItems.length;
            tickerCharlaNombre.textContent = charlasItems[charlasIdx].nombre;
            tickerCharlaNombre.style.opacity = '1';
        }, 300);
    }, 3000);
}
<?php endif; ?>
function closeAll() {
    document.getElementById('notifMenu').style.display = 'none';
    document.getElementById('userMenu').style.display = 'none';
    const el = document.getElementById('eleccionesMenu');
    if (el) el.style.display = 'none';
    const ch = document.getElementById('charlasMenu');
    if (ch) ch.style.display = 'none';
}

function toggleCharlas() {
    const ch = document.getElementById('charlasMenu');
    const visible = ch.style.display === 'block';
    closeAll();
    if (!visible) ch.style.display = 'block';
}

function toggleElecciones() {
    const el = document.getElementById('eleccionesMenu');
    const visible = el.style.display === 'block';
    closeAll();
    if (!visible) el.style.display = 'block';
}

function toggleNotif() {
    const notif = document.getElementById('notifMenu');
    const visible = notif.style.display === 'block';
    closeAll();
    if (!visible) notif.style.display = 'block';
}

function toggleMenu() {
    const menu = document.getElementById('userMenu');
    const visible = menu.style.display === 'block';
    closeAll();
    if (!visible) menu.style.display = 'block';
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('#eleccionesMenu') && !e.target.closest('#ticker-box') &&
        !e.target.closest('#charlasMenu') && !e.target.closest('#ticker-box-charla') &&
        !e.target.closest('#notifMenu') && !e.target.closest('[onclick="toggleNotif()"]') &&
        !e.target.closest('#userMenu') && !e.target.closest('[onclick="toggleMenu()"]')) {
        closeAll();
    }
});
</script>
</body>
</html>
<?php /**PATH /var/www/html/resources/views/layouts/panel.blade.php ENDPATH**/ ?>