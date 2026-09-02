<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Sistema de Gestion') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
   <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
    @keyframes humo {
        0%   { background-position: 0% 50%; }
        50%  { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    * { scrollbar-width: none; -ms-overflow-style: none; }
    *::-webkit-scrollbar { display: none; }
    #ticker-nombre, #ticker-dias, #ticker-charla-nombre { transition: opacity 0.3s ease; }
    @keyframes vaiven {
        0%, 15% { transform: translateX(0); }
        50% { transform: translateX(var(--scroll-x, 0)); }
        85%, 100% { transform: translateX(0); }
    }
    .tabla-scroll { scrollbar-width: thin; scrollbar-color: #cbd5e1 transparent; -ms-overflow-style: auto; }
.tabla-scroll::-webkit-scrollbar { display: block; width: 5px; }
.tabla-scroll::-webkit-scrollbar-track { background: transparent; }
.tabla-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
.tabla-scroll::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    @keyframes zumbido-shake {
        0%, 100% { transform: translateX(0); }
        10% { transform: translateX(-10px) rotate(-1deg); }
        20% { transform: translateX(9px) rotate(1deg); }
        30% { transform: translateX(-8px) rotate(-1deg); }
        40% { transform: translateX(7px) rotate(1deg); }
        50% { transform: translateX(-6px); }
        60% { transform: translateX(5px); }
        70% { transform: translateX(-4px); }
        80% { transform: translateX(3px); }
        90% { transform: translateX(-2px); }
    }
    .zumbido-anim { animation: zumbido-shake 0.5s ease-in-out; }
    </style>
</head>

<body class="font-sans antialiased" style="min-height:100vh; overflow:hidden; height:100vh;">

{{-- FONDO ANIMADO --}}
<div style="position:fixed; top:0; left:0; width:100%; height:100%; z-index:-1;
    background: linear-gradient(135deg, #f0f2f5 0%, #e2e8f8 35%, #ede8f5 65%, #f0f2f5 100%);
    background-size: 400% 400%;
    animation: humo 10s ease infinite;">
</div>

<div style="display:flex; height:100vh; background:transparent; overflow:hidden;">

    {{-- SIDEBAR --}}
    <div style="width:220px; min-width:220px; background:linear-gradient(180deg, rgba(30,50,160,0.75) 0%, rgba(20,35,120,0.85) 50%, rgba(30,50,160,0.75) 100%); display:flex; flex-direction:column; backdrop-filter:blur(16px); -webkit-backdrop-filter:blur(16px); border-right:1px solid rgba(255,255,255,0.12); box-shadow:2px 0 16px rgba(43,78,200,0.15);">

        {{-- LOGO --}}
        <div style="padding:20px 16px 16px; border-bottom:1px solid rgba(255,255,255,0.07);">
            <div style="font-size:14px; font-weight:600; color:#fff; letter-spacing:0.3px;">Dir. Org. Intermedias</div>
            <div style="font-size:11px; color:rgba(255,255,255,0.35); margin-top:2px;">Sistema de Gestion</div>
        </div>

        {{-- ROL ACTIVO --}}
        <div style="margin:14px 12px 6px; padding:9px 12px; background:rgba(255,255,255,0.06); border-radius:8px; border:1px solid rgba(255,255,255,0.08);">
            <div style="font-size:10px; color:rgba(255,255,255,0.35); margin-bottom:2px;">Rol activo</div>
            <div style="font-size:13px; font-weight:500; color:#fff;">{{ auth()->user()->getRoleNames()->first() }}</div>
        </div>

        {{-- NAV PRINCIPAL --}}
        <div style="padding:14px 14px 4px; font-size:10px; color:rgba(255,255,255,0.25); letter-spacing:1px; text-transform:uppercase;">Principal</div>
        @if(auth()->user()->hasRole('Supervisor'))
        <a href="{{ route('supervisor.dashboard') }}"
            style="display:flex; align-items:center; gap:10px; padding:9px 14px; margin:1px 8px; border-radius:8px; font-size:13px; color:{{ request()->routeIs('supervisor.dashboard') ? '#fff' : 'rgba(255,255,255,0.55)' }}; background:{{ request()->routeIs('supervisor.dashboard') ? 'rgba(99,130,255,0.2)' : 'transparent' }}; text-decoration:none; border:{{ request()->routeIs('supervisor.dashboard') ? '1px solid rgba(99,130,255,0.3)' : '1px solid transparent' }}; transition:all 0.2s;"
            onmouseover="this.style.background='rgba(255,255,255,0.12)'"
            onmouseout="this.style.background='{{ request()->routeIs('supervisor.dashboard') ? 'rgba(99,130,255,0.2)' : 'transparent' }}'">
            <span style="width:7px; height:7px; border-radius:50%; background:#60a5fa; flex-shrink:0;"></span>
            Panel General
        </a>
        @else
        <a href="{{ route('panel.dashboard') }}"
            style="display:flex; align-items:center; gap:10px; padding:9px 14px; margin:1px 8px; border-radius:8px; font-size:13px; color:{{ request()->routeIs('panel.dashboard') ? '#fff' : 'rgba(255,255,255,0.55)' }}; background:{{ request()->routeIs('panel.dashboard') ? 'rgba(99,130,255,0.2)' : 'transparent' }}; text-decoration:none; border:{{ request()->routeIs('panel.dashboard') ? '1px solid rgba(99,130,255,0.3)' : '1px solid transparent' }}; transition:all 0.2s;"
            onmouseover="this.style.background='rgba(255,255,255,0.12)'"
            onmouseout="this.style.background='{{ request()->routeIs('panel.dashboard') ? 'rgba(99,130,255,0.2)' : 'transparent' }}'">
            <span style="width:7px; height:7px; border-radius:50%; background:#60a5fa; flex-shrink:0;"></span>
            Panel General
        </a>
        @endif

        {{-- NAV ENTRADAS --}}
        @if(auth()->user()->hasAnyRole(['Admin', 'Asesor', 'Secretaria Con Nota', 'Secretaria Sin Nota']))
        <div style="padding:14px 14px 4px; font-size:10px; color:rgba(255,255,255,0.25); letter-spacing:1px; text-transform:uppercase;">Entradas</div>
        @endif

        @if(auth()->user()->hasAnyRole(['Admin', 'Asesor', 'Secretaria Con Nota']))
        <a href="{{ route('secretaria.con-nota.index') }}"
            style="display:flex; align-items:center; gap:10px; padding:9px 14px; margin:1px 8px; border-radius:8px; font-size:13px; color:{{ request()->routeIs('secretaria.con-nota.*') ? '#fff' : 'rgba(255,255,255,0.55)' }}; background:{{ request()->routeIs('secretaria.con-nota.*') ? 'rgba(52,211,153,0.15)' : 'transparent' }}; text-decoration:none; border:{{ request()->routeIs('secretaria.con-nota.*') ? '1px solid rgba(52,211,153,0.25)' : '1px solid transparent' }}; transition:all 0.2s;"
            onmouseover="this.style.background='rgba(255,255,255,0.12)'"
            onmouseout="this.style.background='{{ request()->routeIs('secretaria.con-nota.*') ? 'rgba(52,211,153,0.15)' : 'transparent' }}'">
            <span style="width:7px; height:7px; border-radius:50%; background:#34d399; flex-shrink:0;"></span>
            Mesa de Entrada
        </a>
        @endif

        @if(auth()->user()->roles->first()?->name === 'Asesor')
        <a href="{{ route('asesor.mis-organizaciones') }}"
            style="display:flex; align-items:center; gap:10px; padding:9px 14px; margin:1px 8px; border-radius:8px; font-size:13px; color:{{ request()->routeIs('asesor.*') ? '#fff' : 'rgba(255,255,255,0.55)' }}; background:{{ request()->routeIs('asesor.*') ? 'rgba(52,211,153,0.15)' : 'transparent' }}; text-decoration:none; border:{{ request()->routeIs('asesor.*') ? '1px solid rgba(52,211,153,0.25)' : '1px solid transparent' }}; transition:all 0.2s;"
            onmouseover="this.style.background='rgba(255,255,255,0.12)'"
            onmouseout="this.style.background='{{ request()->routeIs('asesor.*') ? 'rgba(52,211,153,0.15)' : 'transparent' }}'">
            <span style="width:7px; height:7px; border-radius:50%; background:{{ request()->routeIs('asesor.*') ? '#34d399' : 'rgba(255,255,255,0.28)' }}; flex-shrink:0;"></span>
            Mis organizaciones
        </a>

        @elseif(auth()->user()->hasAnyRole(['Secretaria Sin Nota', 'Secretaria Con Nota']))
        {{-- Entradas sin nota — excluye la ruta del log para no marcar ambos activos --}}
        @php $sinNotaActivo = request()->routeIs('secretaria.sin-nota.*') && !request()->routeIs('secretaria.sin-nota.log'); @endphp
        <a href="{{ route('secretaria.sin-nota.index') }}"
            style="display:flex; align-items:center; gap:10px; padding:9px 14px; margin:1px 8px; border-radius:8px; font-size:13px; color:{{ $sinNotaActivo ? '#fff' : 'rgba(255,255,255,0.55)' }}; background:{{ $sinNotaActivo ? 'rgba(255,255,255,0.1)' : 'transparent' }}; text-decoration:none; border:{{ $sinNotaActivo ? '1px solid rgba(255,255,255,0.15)' : '1px solid transparent' }}; transition:all 0.2s;"
            onmouseover="this.style.background='rgba(255,255,255,0.12)'"
            onmouseout="this.style.background='{{ $sinNotaActivo ? 'rgba(255,255,255,0.1)' : 'transparent' }}'">
            <span style="width:7px; height:7px; border-radius:50%; background:rgba(255,255,255,0.28); flex-shrink:0;"></span>
            Entradas sin nota
        </a>

        {{-- Gestión Logística — solo Secretaria Sin Nota y Admin --}}
        @if(auth()->user()->hasAnyRole(['Secretaria Sin Nota', 'Admin']))
        @php $logActivo = request()->routeIs('secretaria.sin-nota.log'); @endphp
        <a href="{{ route('secretaria.sin-nota.log') }}"
            style="display:flex; align-items:center; gap:10px; padding:9px 14px; margin:1px 8px; border-radius:8px; font-size:13px; color:{{ $logActivo ? '#fff' : 'rgba(255,255,255,0.55)' }}; background:{{ $logActivo ? 'rgba(52,211,153,0.15)' : 'transparent' }}; text-decoration:none; border:{{ $logActivo ? '1px solid rgba(52,211,153,0.25)' : '1px solid transparent' }}; transition:all 0.2s;"
            onmouseover="this.style.background='rgba(255,255,255,0.12)'"
            onmouseout="this.style.background='{{ $logActivo ? 'rgba(52,211,153,0.15)' : 'transparent' }}'">
            <span style="width:7px; height:7px; border-radius:50%; background:{{ $logActivo ? '#34d399' : 'rgba(255,255,255,0.28)' }}; flex-shrink:0;"></span>
            Gestión Logística
        </a>
        @endif
        @endif

        @if(auth()->user()->hasRole('Supervisor'))
        <div style="padding:14px 14px 4px; font-size:10px; color:rgba(255,255,255,0.25); letter-spacing:1px; text-transform:uppercase;">Mis Organizaciones</div>
        <a href="{{ route('supervisor.index') }}"
            style="display:flex; align-items:center; gap:10px; padding:9px 14px; margin:1px 8px; border-radius:8px; font-size:13px; color:{{ request()->routeIs('supervisor.index') ? '#fff' : 'rgba(255,255,255,0.55)' }}; background:{{ request()->routeIs('supervisor.index') ? 'rgba(52,211,153,0.15)' : 'transparent' }}; text-decoration:none; border:{{ request()->routeIs('supervisor.index') ? '1px solid rgba(52,211,153,0.25)' : '1px solid transparent' }}; transition:all 0.2s;"
            onmouseover="this.style.background='rgba(255,255,255,0.12)'"
            onmouseout="this.style.background='{{ request()->routeIs('supervisor.index') ? 'rgba(52,211,153,0.15)' : 'transparent' }}'">
            <span style="width:7px; height:7px; border-radius:50%; background:#34d399; flex-shrink:0;"></span>
            Organizaciones
        </a>
        @endif

        {{-- NAV TRABAJO --}}
        @if(auth()->user()->hasAnyRole(['Tecnico', 'Asesor']))
        <div style="padding:14px 14px 4px; font-size:10px; color:rgba(255,255,255,0.25); letter-spacing:1px; text-transform:uppercase;">Trabajo</div>
        @endif
        @if(auth()->user()->hasRole('Tecnico'))
        <a href="{{ route('tecnico.organizaciones') }}"
            style="display:flex; align-items:center; gap:10px; padding:9px 14px; margin:1px 8px; border-radius:8px; font-size:13px; color:rgba(255,255,255,0.55); text-decoration:none; border:1px solid transparent; transition:all 0.2s;"
            onmouseover="this.style.background='rgba(255,255,255,0.12)'"
            onmouseout="this.style.background='transparent'">
            <span style="width:7px; height:7px; border-radius:50%; background:#fbbf24; flex-shrink:0;"></span>
            Panel tecnico
        </a>
        @endif
        @if(auth()->user()->hasRole('Asesor'))
        <a href="#"
            style="display:flex; align-items:center; gap:10px; padding:9px 14px; margin:1px 8px; border-radius:8px; font-size:13px; color:rgba(255,255,255,0.55); text-decoration:none; border:1px solid transparent; transition:all 0.2s;"
            onmouseover="this.style.background='rgba(255,255,255,0.12)'"
            onmouseout="this.style.background='transparent'">
            <span style="width:7px; height:7px; border-radius:50%; background:#a78bfa; flex-shrink:0;"></span>
            Charlas
        </a>
        <a href="{{ route('asesor.borrador.index') }}"
            style="display:flex; align-items:center; gap:10px; padding:9px 14px; margin:1px 8px; border-radius:8px; font-size:13px; color:{{ request()->routeIs('asesor.borrador.*') ? '#fff' : 'rgba(255,255,255,0.55)' }}; background:{{ request()->routeIs('asesor.borrador.*') ? 'rgba(244,114,182,0.2)' : 'transparent' }}; text-decoration:none; border:{{ request()->routeIs('asesor.borrador.*') ? '1px solid rgba(244,114,182,0.3)' : '1px solid transparent' }}; transition:all 0.2s;"
            onmouseover="this.style.background='rgba(255,255,255,0.12)'"
            onmouseout="this.style.background='{{ request()->routeIs('asesor.borrador.*') ? 'rgba(244,114,182,0.2)' : 'transparent' }}'">
            <span style="width:7px; height:7px; border-radius:50%; background:#f472b6; flex-shrink:0;"></span>
            Borrador privado
        </a>
        @endif

        {{-- NAV UTILIDADES --}}
        <div style="padding:14px 14px 4px; font-size:10px; color:rgba(255,255,255,0.25); letter-spacing:1px; text-transform:uppercase;">Utilidades</div>
        @if(auth()->user()->hasRole('Tecnico'))
        <a href="{{ route('tecnico.manuales.index') }}"
            style="display:flex; align-items:center; gap:10px; padding:9px 14px; margin:1px 8px; border-radius:8px; font-size:13px; color:{{ request()->routeIs('tecnico.manuales.*') ? '#fff' : 'rgba(255,255,255,0.55)' }}; background:{{ request()->routeIs('tecnico.manuales.*') ? 'rgba(255,255,255,0.1)' : 'transparent' }}; text-decoration:none; border:{{ request()->routeIs('tecnico.manuales.*') ? '1px solid rgba(255,255,255,0.15)' : '1px solid transparent' }}; transition:all 0.2s;"
            onmouseover="this.style.background='rgba(255,255,255,0.12)'"
            onmouseout="this.style.background='{{ request()->routeIs('tecnico.manuales.*') ? 'rgba(255,255,255,0.1)' : 'transparent' }}'">
            <span style="width:7px; height:7px; border-radius:50%; background:rgba(255,255,255,0.28); flex-shrink:0;"></span>
            Manuales Técnicos
        </a>
        @else
        <a href="{{ route('asesor.manuales.index') }}"
            style="display:flex; align-items:center; gap:10px; padding:9px 14px; margin:1px 8px; border-radius:8px; font-size:13px; color:{{ request()->routeIs('asesor.manuales.*') ? '#fff' : 'rgba(255,255,255,0.55)' }}; background:{{ request()->routeIs('asesor.manuales.*') ? 'rgba(255,255,255,0.1)' : 'transparent' }}; text-decoration:none; border:{{ request()->routeIs('asesor.manuales.*') ? '1px solid rgba(255,255,255,0.15)' : '1px solid transparent' }}; transition:all 0.2s;"
            onmouseover="this.style.background='rgba(255,255,255,0.12)'"
            onmouseout="this.style.background='{{ request()->routeIs('asesor.manuales.*') ? 'rgba(255,255,255,0.1)' : 'transparent' }}'">
            <span style="width:7px; height:7px; border-radius:50%; background:rgba(255,255,255,0.28); flex-shrink:0;"></span>
            Manuales
        </a>
        @endif
        @if(auth()->user()->hasRole('Asesor'))
        <a href="{{ route('asesor.calculadora.dhondt') }}"
            style="display:flex; align-items:center; gap:10px; padding:9px 14px; margin:1px 8px; border-radius:8px; font-size:13px; color:{{ request()->routeIs('asesor.calculadora.dhondt') ? '#fff' : 'rgba(255,255,255,0.55)' }}; background:{{ request()->routeIs('asesor.calculadora.dhondt') ? 'rgba(251,191,36,0.2)' : 'transparent' }}; text-decoration:none; border:{{ request()->routeIs('asesor.calculadora.dhondt') ? '1px solid rgba(251,191,36,0.3)' : '1px solid transparent' }}; transition:all 0.2s;"
            onmouseover="this.style.background='rgba(255,255,255,0.12)'"
            onmouseout="this.style.background='{{ request()->routeIs('asesor.calculadora.dhondt') ? 'rgba(251,191,36,0.2)' : 'transparent' }}'">
            <span style="width:7px; height:7px; border-radius:50%; background:#fbbf24; flex-shrink:0;"></span>
            Calculadora D'Hondt
        </a>
        @endif

    </div>
    {{-- FIN SIDEBAR --}}

    {{-- CONTENIDO PRINCIPAL --}}
    <div style="flex:1; display:flex; flex-direction:column; overflow:hidden; background:transparent;">

        {{-- TOPBAR --}}
        <div style="background:rgba(255,255,255,0.4); backdrop-filter:blur(8px); border-bottom:1px solid #e5e7eb; padding:13px 22px; display:flex; align-items:center; justify-content:space-between;">

            {{-- TITULO --}}
            <div style="display:flex; align-items:center; gap:8px;">
                <svg width="16" height="16" fill="none" stroke="#6b7280" stroke-width="1.8" viewBox="0 0 24 24">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                </svg>
                <span style="font-size:15px; font-weight:500; color:#111827;">{{ $title ?? 'Dashboard' }}</span>
            </div>

            {{-- DERECHA --}}
            <div style="display:flex; align-items:center; gap:14px;">

                {{-- TICKER ELECCIONES --}}
                @isset($elecciones)
                @if($elecciones->count() > 0)
                @php $primera = $elecciones->first(); $diasPrimera = (int) now()->startOfDay()->diffInDays($primera->fecha_eleccion->startOfDay(), false); @endphp
                <div onclick="toggleElecciones()" id="ticker-box"
                     style="display:flex; align-items:center; gap:8px; background:#f0f9ff; border:1px solid #bae6fd; border-radius:8px; padding:5px 12px; cursor:pointer; min-width:180px; max-width:260px;">
                    <svg width="13" height="13" fill="none" stroke="#0369a1" stroke-width="1.8" viewBox="0 0 24 24" style="flex-shrink:0;">
                        <rect x="3" y="4" width="18" height="18" rx="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                    <span style="font-size:11px; color:#0369a1; font-weight:600; white-space:nowrap; flex-shrink:0;">Próxima:</span>
                    <span id="ticker-nombre" style="font-size:12px; color:#0c4a6e; font-weight:500; overflow:hidden; white-space:nowrap; flex:1; position:relative;"><span id="ticker-nombre-inner" style="display:inline-block; white-space:nowrap;">{{ $primera->nombre_organizacion }}</span></span>
                    <span id="ticker-dias" style="font-size:10px; font-weight:600; padding:2px 7px; border-radius:20px; flex-shrink:0;
                        background:{{ $diasPrimera <= 7 ? '#fee2e2' : ($diasPrimera <= 15 ? '#fef3c7' : '#d1fae5') }};
                        color:{{ $diasPrimera <= 7 ? '#991b1b' : ($diasPrimera <= 15 ? '#92400e' : '#065f46') }};">
                        {{ $diasPrimera }} días
                    </span>
                </div>
                @endif
                @endisset

                {{-- TICKER CHARLAS --}}
                @php $cp = $charlasPendientes ?? null; @endphp
                @if($cp && $cp->count() > 0)
                @php $primeraCharla = $cp->first(); $diasCharla = (int) now()->startOfDay()->diffInDays($primeraCharla->fecha_hora->startOfDay(), false); @endphp
                <div onclick="toggleCharlas()" id="ticker-box-charla"
                     style="display:flex; align-items:center; gap:8px; background:#fefce8; border:1px solid #fde68a; border-radius:8px; padding:5px 12px; cursor:pointer; min-width:180px; max-width:260px;">
                    <svg width="13" height="13" fill="none" stroke="#854d0e" stroke-width="1.8" viewBox="0 0 24 24" style="flex-shrink:0;">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                    </svg>
                    <span style="font-size:11px; color:#854d0e; font-weight:600; white-space:nowrap; flex-shrink:0;">Charla:</span>
                    <span id="ticker-charla-nombre" style="font-size:12px; color:#713f12; font-weight:500; overflow:hidden; white-space:nowrap; flex:1; position:relative;"><span id="ticker-charla-nombre-inner" style="display:inline-block; white-space:nowrap;">{{ $primeraCharla->entrada->nombre_organizacion ?? '—' }}</span></span>
                    <span style="font-size:10px; font-weight:600; padding:2px 7px; border-radius:20px; flex-shrink:0; background:#fef9c3; color:#854d0e;">
                        {{ $diasCharla }} días
                    </span>
                </div>
                @endif

                {{-- CAMPANITA --}}
                <div style="position:relative; cursor:pointer;" onclick="toggleNotif()">
                    <svg width="20" height="20" fill="none" stroke="#6b7280" stroke-width="1.5" viewBox="0 0 24 24">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                    </svg>
                    @php $unread = auth()->user()->unreadNotifications->count(); @endphp
                    @if($unread > 0)
                    <span style="position:absolute; top:-5px; right:-5px; background:#e24b4a; color:#fff; font-size:9px; font-weight:600; width:15px; height:15px; border-radius:50%; display:flex; align-items:center; justify-content:center;">
                        {{ $unread }}
                    </span>
                    @endif
                </div>

                {{-- AVATAR --}}
                <div onclick="toggleMenu()" style="width:32px; height:32px; border-radius:50%; background:#185FA5; display:flex; align-items:center; justify-content:center; font-size:11px; font-weight:600; color:#fff; cursor:pointer; user-select:none;">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>

            </div>
        </div>
        {{-- FIN TOPBAR --}}

        {{-- SLOT PRINCIPAL --}}
        <div style="flex:1; padding:10px 8px 60px 8px; overflow-y:auto; overflow-x:hidden; background:linear-gradient(135deg, #e8eaf6 0%, #d4d8f0 25%, #e8d5f0 50%, #d4e8f0 75%, #e8eaf6 100%);">
            {{ $slot }}
        </div>

    </div>
    {{-- FIN CONTENIDO PRINCIPAL --}}

</div>

{{-- DROPDOWN ELECCIONES --}}
<div id="eleccionesMenu" style="display:none; position:fixed; top:52px; right:80px; background:#fff; border:1px solid #e5e7eb; border-radius:12px; box-shadow:0 8px 24px rgba(0,0,0,0.12); width:290px; z-index:99999; overflow:hidden;">
    <div style="padding:10px 14px; border-bottom:1px solid #f3f4f6;">
        <span style="font-size:11px; font-weight:600; color:#374151; text-transform:uppercase; letter-spacing:0.5px;">Elecciones próximas</span>
    </div>
    @isset($elecciones)
    @forelse($elecciones as $e)
    @php $dias = (int) now()->startOfDay()->diffInDays($e->fecha_eleccion->startOfDay(), false); @endphp
    <div style="display:flex; justify-content:space-between; align-items:center; padding:9px 14px; border-bottom:1px solid #f9fafb;">
        <div>
            <div style="font-size:12px; font-weight:500; color:#111827;">{{ $e->nombre_organizacion }}</div>
            <div style="font-size:10.5px; color:#6b7280;">{{ $e->fecha_eleccion->format('d M Y') }} — {{ $e->asesor_asignado }}</div>
        </div>
        <span style="font-size:10.5px; font-weight:500; padding:3px 9px; border-radius:20px; flex-shrink:0;
            background:{{ $dias <= 7 ? '#fee2e2' : ($dias <= 15 ? '#fef3c7' : '#d1fae5') }};
            color:{{ $dias <= 7 ? '#991b1b' : ($dias <= 15 ? '#92400e' : '#065f46') }};">
            {{ $dias }} días
        </span>
    </div>
    @empty
    <div style="padding:16px; text-align:center; font-size:12px; color:#9ca3af;">Sin elecciones próximas.</div>
    @endforelse
    @endisset
</div>

{{-- DROPDOWN CHARLAS --}}
@php $cp = $charlasPendientes ?? null; @endphp
@if($cp && $cp->count() > 0)
<div id="charlasMenu" style="display:none; position:fixed; top:52px; right:80px; background:#fff; border:1px solid #e5e7eb; border-radius:12px; box-shadow:0 8px 24px rgba(0,0,0,0.12); width:290px; z-index:99999; overflow:hidden;">
    <div style="padding:10px 14px; border-bottom:1px solid #f3f4f6;">
        <span style="font-size:11px; font-weight:600; color:#374151; text-transform:uppercase; letter-spacing:0.5px;">Charlas Pendientes</span>
    </div>
    @forelse($cp as $c)
    @php $dc = (int) now()->startOfDay()->diffInDays($c->fecha_hora->startOfDay(), false); @endphp
    <div style="display:flex; justify-content:space-between; align-items:center; padding:9px 14px; border-bottom:1px solid #f9fafb;">
        <div>
            <div style="font-size:12px; font-weight:500; color:#111827;">{{ $c->entrada->nombre_organizacion ?? '—' }}</div>
            <div style="font-size:10.5px; color:#6b7280;">{{ $c->fecha_hora->format('d M Y H:i') }} — {{ $c->entrada->asesor_asignado ?? '—' }}</div>
        </div>
        <span style="font-size:10.5px; font-weight:500; padding:3px 9px; border-radius:20px; flex-shrink:0; background:#fef9c3; color:#854d0e;">
            {{ $dc }} días
        </span>
    </div>
    @empty
    <div style="padding:16px; text-align:center; font-size:12px; color:#9ca3af;">Sin charlas pendientes.</div>
    @endforelse
</div>
@endif

{{-- DROPDOWN NOTIFICACIONES --}}
<div id="notifMenu" style="display:none; position:fixed; top:52px; right:60px; background:#fff; border:1px solid #e5e7eb; border-radius:12px; box-shadow:0 8px 24px rgba(0,0,0,0.12); width:300px; z-index:99999; overflow:hidden;">
    <div style="padding:12px 16px; border-bottom:1px solid #f3f4f6; display:flex; justify-content:space-between; align-items:center;">
        <span style="font-size:12px; font-weight:600; color:#374151; text-transform:uppercase; letter-spacing:0.5px;">Notificaciones</span>
        @if($unread > 0)
        <span style="background:#e24b4a; color:#fff; font-size:10px; font-weight:600; padding:2px 7px; border-radius:20px;">{{ $unread }}</span>
        @endif
    </div>
   <div id="notif-contenido" style="max-height:320px; overflow:auto;">
    @forelse(auth()->user()->notifications->take(8) as $notif)
    @php
    $esNuevaEntrada = $loop->first && (str_contains($notif->data['mensaje'] ?? '', 'Nueva entrada') || str_contains($notif->data['mensaje'] ?? '', 'Nuevo trabajo')) && is_null($notif->read_at);
    $esCorreccion = $loop->first && str_contains($notif->data['mensaje'] ?? '', 'editó nuevamente') && is_null($notif->read_at);
    $bgColor = $esNuevaEntrada ? 'background:#f6fefa;' : ($esCorreccion ? 'background:#fefdf5;' : '');
@endphp
    <div style="padding:11px 16px; border-bottom:1px solid #f9fafb; display:flex; align-items:flex-start; gap:8px; {{ $bgColor }}">
        <span style="width:7px; height:7px; border-radius:50%; flex-shrink:0; margin-top:4px; background:{{ $notif->read_at ? '#d1d5db' : '#185FA5' }};"></span>
        <div style="flex:1;">
            <div style="font-size:12px; color:#111827; line-height:1.4;">{{ $notif->data['mensaje'] ?? '' }}</div>
            @if(isset($notif->data['seccion']))
            <div style="font-size:10.5px; color:#6b7280; margin-top:2px;">{{ $notif->data['seccion'] }}</div>
            @endif
            <div style="font-size:10px; color:#9ca3af; margin-top:3px;">{{ $notif->created_at->diffForHumans() }}</div>
        </div>
    </div>
        @empty
        <div style="padding:20px 16px; text-align:center; font-size:12px; color:#9ca3af;">Sin notificaciones.</div>
        @endforelse
    </div>
</div>

{{-- DROPDOWN USUARIO --}}
<div id="userMenu" style="display:none; position:fixed; top:52px; right:16px; background:#fff; border:1px solid #e5e7eb; border-radius:10px; box-shadow:0 8px 24px rgba(0,0,0,0.15); min-width:160px; z-index:99999; overflow:hidden;">
    <div style="padding:10px 14px; border-bottom:1px solid #f3f4f6;">
        <div style="font-size:12px; font-weight:500; color:#111827;">{{ auth()->user()->name }}</div>
        <div style="font-size:11px; color:#9ca3af; margin-top:1px;">{{ auth()->user()->getRoleNames()->first() }}</div>
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
    <form method="POST" action="{{ route('logout') }}">
        @csrf
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
function updateMarquee(outerId, innerId) {
    const outer = document.getElementById(outerId);
    const inner = document.getElementById(innerId);
    if (!outer || !inner) return 0;
    inner.style.animation = 'none';
    inner.style.transform = 'translateX(0)';
    void inner.offsetWidth; // forzar reflow
    const overflow = inner.scrollWidth - outer.clientWidth;
    if (overflow > 4) {
        const duration = Math.max(4, overflow / 25);
        inner.style.setProperty('--scroll-x', (-overflow - 6) + 'px');
        inner.style.animation = `vaiven ${duration}s ease-in-out infinite`;
        return duration * 1000;
    } else {
        inner.style.removeProperty('--scroll-x');
        return 0;
    }
}

@isset($elecciones)
@if($elecciones->count() > 0)
updateMarquee('ticker-nombre', 'ticker-nombre-inner');
@endif
@if($elecciones->count() > 1)
@php
    $tickerData = $elecciones->map(function($e) {
        $dias = (int) now()->startOfDay()->diffInDays($e->fecha_eleccion->startOfDay(), false);
        $bg = $dias <= 7 ? '#fee2e2' : ($dias <= 15 ? '#fef3c7' : '#d1fae5');
        $color = $dias <= 7 ? '#991b1b' : ($dias <= 15 ? '#92400e' : '#065f46');
        return ['nombre' => $e->nombre_organizacion, 'dias' => $dias, 'bg' => $bg, 'color' => $color];
    });
@endphp
const tickerItems = @json($tickerData);
let tickerIdx = 0;
const tickerNombre = document.getElementById('ticker-nombre');
const tickerNombreInner = document.getElementById('ticker-nombre-inner');
const tickerDias = document.getElementById('ticker-dias');
if (tickerNombre && tickerItems.length > 1) {
    setInterval(() => {
        tickerNombre.style.opacity = '0';
        tickerDias.style.opacity = '0';
        setTimeout(() => {
            tickerIdx = (tickerIdx + 1) % tickerItems.length;
            const item = tickerItems[tickerIdx];
            tickerNombreInner.textContent = item.nombre;
            tickerDias.textContent = item.dias + ' días';
            tickerDias.style.background = item.bg;
            tickerDias.style.color = item.color;
            tickerNombre.style.opacity = '1';
            tickerDias.style.opacity = '1';
            updateMarquee('ticker-nombre', 'ticker-nombre-inner');
        }, 300);
    }, 8000);
}
@endif
@endisset

@if($cp && $cp->count() > 0)
updateMarquee('ticker-charla-nombre', 'ticker-charla-nombre-inner');
@endif
@if($cp && $cp->count() > 1)
@php
    $charlasData = $cp->map(function($c) {
        return ['nombre' => $c->entrada->nombre_organizacion ?? '—'];
    });
@endphp
const charlasItems = @json($charlasData);
let charlasIdx = 0;
const tickerCharlaNombre = document.getElementById('ticker-charla-nombre');
const tickerCharlaNombreInner = document.getElementById('ticker-charla-nombre-inner');
if (tickerCharlaNombre && charlasItems.length > 1) {
    setInterval(() => {
        tickerCharlaNombre.style.opacity = '0';
        setTimeout(() => {
            charlasIdx = (charlasIdx + 1) % charlasItems.length;
            tickerCharlaNombreInner.textContent = charlasItems[charlasIdx].nombre;
            tickerCharlaNombre.style.opacity = '1';
            updateMarquee('ticker-charla-nombre', 'ticker-charla-nombre-inner');
        }, 300);
    }, 8000);
}
@endif

function closeAll() {
    document.getElementById('notifMenu').style.display = 'none';
    document.getElementById('userMenu').style.display = 'none';
    const el = document.getElementById('eleccionesMenu');
    if (el) el.style.display = 'none';
    const ch = document.getElementById('charlasMenu');
    if (ch) ch.style.display = 'none';
}

function posicionarMenuBajoBoton(menu, boton) {
    if (!menu || !boton) return;
    const rect = boton.getBoundingClientRect();
    menu.style.top = (rect.bottom + 6) + 'px';
    menu.style.left = rect.left + 'px';
    menu.style.right = 'auto';
}

function toggleCharlas() {
    const ch = document.getElementById('charlasMenu');
    const visible = ch.style.display === 'block';
    closeAll();
    if (!visible) {
        posicionarMenuBajoBoton(ch, document.getElementById('ticker-box-charla'));
        ch.style.display = 'block';
    }
}

function toggleElecciones() {
    const el = document.getElementById('eleccionesMenu');
    const visible = el.style.display === 'block';
    closeAll();
    if (!visible) {
        posicionarMenuBajoBoton(el, document.getElementById('ticker-box'));
        el.style.display = 'block';
    }
}

function toggleNotif() {
    const notif = document.getElementById('notifMenu');
    const visible = notif.style.display === 'block';
    closeAll();
    if (!visible) {
        notif.style.display = 'block';
        fetch('/notificaciones/lista')
            .then(r => r.json())
            .then(d => {
                const contenido = document.getElementById('notif-contenido');
                if (!contenido) return;
                if (d.notificaciones.length === 0) {
                    contenido.innerHTML = '<div style="padding:20px 16px; text-align:center; font-size:12px; color:#9ca3af;">Sin notificaciones.</div>';
                } else {
                    contenido.innerHTML = d.notificaciones.map((n, idx) => `
<div style="padding:11px 16px; border-bottom:1px solid #f9fafb; display:flex; align-items:flex-start; gap:8px; ${(idx === 0 && !n.leida && (n.mensaje.includes('Nueva entrada') || n.mensaje.includes('Nuevo trabajo'))) ? 'background:#f6fefa;' : (idx === 0 && !n.leida && n.mensaje.includes('editó nuevamente')) ? 'background:#fefdf5;' : ''}">                            <span style="width:7px; height:7px; border-radius:50%; flex-shrink:0; margin-top:4px; background:${n.leida ? '#d1d5db' : '#185FA5'};"></span>
                            <div style="flex:1;">
                                <div style="font-size:12px; color:#111827; line-height:1.4;">${n.mensaje}</div>
                                ${n.seccion ? `<div style="font-size:10.5px; color:#6b7280; margin-top:2px;">${n.seccion}</div>` : ''}
                                <div style="font-size:10px; color:#9ca3af; margin-top:3px;">${n.hace}</div>
                            </div>
                        </div>
                    `).join('');
                    contenido.scrollTop = 0;
                }
            });
        fetch('/notificaciones/leer', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            }
        }).then(() => {
            const campanita = document.querySelector('[onclick="toggleNotif()"]');
            const badge = campanita?.querySelector('span');
            if (badge) badge.remove();
        });
    }
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

async function actualizarNotificaciones() {
    try {
        const r = await fetch('/notificaciones/count');
        const d = await r.json();
        const campanita = document.querySelector('[onclick="toggleNotif()"]');
        const badge = campanita?.querySelector('span');
        if (d.count > 0) {
            if (!badge) {
                const span = document.createElement('span');
                span.style.cssText = 'position:absolute; top:-5px; right:-5px; background:#e24b4a; color:#fff; font-size:9px; font-weight:600; width:15px; height:15px; border-radius:50%; display:flex; align-items:center; justify-content:center;';
                span.textContent = d.count;
                campanita.appendChild(span);
            } else {
                badge.textContent = d.count;
            }
        } else {
            if (badge) badge.remove();
        }
    } catch(e) {}
}
let notifInterval = setInterval(actualizarNotificaciones, 30000);

</script>
{{-- CHAT WIDGET --}}
<div id="chat-btn" onclick="toggleChat()" style="position:fixed; bottom:24px; right:24px; width:50px; height:50px; border-radius:50%; background:#1e3a5f; border:none; cursor:pointer; display:flex; align-items:center; justify-content:center; box-shadow:0 4px 12px rgba(0,0,0,0.25); z-index:8000;">
    <svg width="22" height="22" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24">
        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
    </svg>
    <span id="chat-badge" style="display:none; position:absolute; top:-3px; right:-3px; background:#e24b4a; color:#fff; font-size:9px; font-weight:600; width:16px; height:16px; border-radius:50%; align-items:center; justify-content:center;">0</span>
</div>

{{-- VISTA PREVIA DEL ÚLTIMO MENSAJE --}}
<div id="chat-preview" onclick="abrirPreviewChat()" style="display:none; position:fixed; bottom:84px; right:24px; max-width:260px; background:#fff; border-radius:12px; box-shadow:0 8px 24px rgba(0,0,0,0.18); border:1px solid #e5e7eb; padding:10px 12px; z-index:7999; cursor:pointer;">
    <div style="display:flex; align-items:flex-start; gap:8px;">
        <span style="font-size:15px; flex-shrink:0; margin-top:1px;">💬</span>
        <div style="min-width:0;">
            <div id="chat-preview-nombre" style="font-size:11px; font-weight:700; color:#1e3a5f; margin-bottom:2px;"></div>
            <div id="chat-preview-texto" style="font-size:12px; color:#374151; overflow:hidden; text-overflow:ellipsis; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical;"></div>
            <div id="chat-preview-extra" style="display:none; font-size:10px; color:#2563eb; font-weight:600; margin-top:4px;"></div>
        </div>
    </div>
</div>

<div id="chat-panel" style="display:none; position:fixed; bottom:84px; right:24px; width:392px; height:440px; background:#fff; border-radius:12px; box-shadow:0 8px 32px rgba(0,0,0,0.18); z-index:8000; display:none; flex-direction:column; overflow:hidden; border:1px solid #e5e7eb;">

    {{-- Header --}}
    <div style="background:#1e3a5f; padding:10px 14px; display:flex; align-items:center; justify-content:space-between; flex-shrink:0; position:relative;">
        <span style="font-size:13px; font-weight:600; color:#fff; display:flex; align-items:center; gap:6px;">
            <svg width="14" height="14" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            Chat interno
        </span>
        <div style="display:flex; gap:6px; align-items:center;">
            <button type="button" id="btn-notif-permiso" onclick="activarNotificacionesEscritorio()" title="Avisarte con el chat minimizado" style="display:none; background:rgba(255,255,255,0.15); border:none; border-radius:20px; width:24px; height:24px; cursor:pointer; color:#fff; font-size:12px; align-items:center; justify-content:center;">🔔</button>
            <button type="button" id="btn-en-linea" onclick="toggleEnLinea()" style="display:flex; background:rgba(255,255,255,0.15); border:none; border-radius:20px; padding:3px 9px; cursor:pointer; color:#fff; font-size:10px; font-weight:600; align-items:center; gap:4px;">
                <span style="width:6px; height:6px; border-radius:50%; background:#16a34a; display:inline-block;"></span>
                <span id="en-linea-texto">0 en línea</span>
            </button>
            <button onclick="toggleChat()" style="background:rgba(255,255,255,0.15); border:none; border-radius:6px; width:24px; height:24px; cursor:pointer; color:#fff; font-size:14px; display:flex; align-items:center; justify-content:center;">—</button>
        </div>
        <div id="en-linea-panel" style="display:none; position:absolute; top:38px; right:34px; min-width:140px; max-width:220px; max-height:180px; overflow-y:auto; background:#fff; border:1px solid #e5e7eb; border-radius:8px; box-shadow:0 6px 20px rgba(0,0,0,0.15); padding:6px; z-index:30;"></div>
    </div>

    {{-- Body --}}
    <div style="display:flex; flex:1; overflow:hidden;">

        {{-- Lista conversaciones --}}
        <div id="chat-convs" style="width:115px; border-right:1px solid #e5e7eb; overflow-y:auto; background:#f8fafc; flex-shrink:0;"></div>

        {{-- Mensajes --}}
        <div style="flex:1; display:flex; flex-direction:column; overflow:hidden; position:relative;">
            <div id="chat-conv-header" style="padding:7px 10px; border-bottom:1px solid #e5e7eb; font-size:11px; font-weight:600; color:#374151; background:#fff; flex-shrink:0; display:flex; align-items:center; gap:6px;">
                Seleccioná una conversación
            </div>
            <div id="chat-msgs" style="flex:1; overflow-y:auto; padding:8px; display:flex; flex-direction:column; gap:5px; background:#f9fafb;"></div>
            <div id="chat-sticker-picker" style="display:none; position:absolute; bottom:46px; left:7px; right:7px; max-height:170px; overflow-y:auto; background:#fff; border:1px solid #e5e7eb; border-radius:10px; box-shadow:0 4px 16px rgba(0,0,0,0.12); padding:8px; z-index:20; grid-template-columns:repeat(6, 1fr); gap:6px;"></div>
            <div id="chat-input-wrap" style="padding:7px; border-top:1px solid #e5e7eb; display:flex; gap:5px; align-items:center; background:#fff; flex-shrink:0; position:relative;">
                <button type="button" onclick="toggleStickerPicker()" style="cursor:pointer; color:#9ca3af; background:none; border:none; padding:0; display:flex; align-items:center; font-size:16px; line-height:1;">🙂</button>
                <button type="button" id="btn-zumbido" onclick="enviarZumbido()" title="Mandar un zumbido" style="cursor:pointer; color:#9ca3af; background:none; border:none; padding:0; display:none; align-items:center; font-size:16px; line-height:1;">👋</button>
                <label for="chat-file" style="cursor:pointer; color:#9ca3af; display:flex; align-items:center;">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"/></svg>
                </label>
                <input type="file" id="chat-file" style="display:none;" onchange="chatArchivoSeleccionado(this)">
                <input type="text" id="chat-input" placeholder="Escribí un mensaje..." onkeydown="if(event.key==='Enter')enviarMensaje()"
                    style="flex:1; border:1px solid #e5e7eb; border-radius:8px; padding:5px 8px; font-size:11px; outline:none; background:#f9fafb;">
                <button onclick="enviarMensaje()" style="background:#1e3a5f; border:none; border-radius:8px; width:28px; height:28px; cursor:pointer; display:flex; align-items:center; justify-content:center;">
                    <svg width="13" height="13" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Lista usuarios (para nuevo directo) --}}
    <div id="chat-usuarios-panel" style="display:none; position:absolute; inset:40px 0 0 0; background:#fff; z-index:10; overflow-y:auto; padding:8px;">
        <div style="display:flex; align-items:center; gap:6px; padding:6px 8px; border-bottom:1px solid #e5e7eb; margin-bottom:6px;">
            <button onclick="cerrarUsuarios()" style="background:none; border:none; cursor:pointer; color:#6b7280; font-size:18px; line-height:1;">←</button>
            <span style="font-size:12px; font-weight:600; color:#374151;">Nueva conversación</span>
        </div>
        <div id="chat-usuarios-lista"></div>
    </div>
</div>

<script>

let chatAbierto = false;
let convActualId = null;
let pollingInterval = null;
let chatArchivoFile = null;
let pingInterval = null;
let badgeInterval = null;
let enLineaInterval = null;
let enLineaAbierto = false;
let cargandoEnLinea = false;

async function actualizarEnLinea() {
    if (cargandoEnLinea) return;
    cargandoEnLinea = true;
    try {
        const res = await fetch('/chat/en-linea');
        const usuarios = await res.json();
        document.getElementById('en-linea-texto').textContent = usuarios.length + ' en línea';

        const panel = document.getElementById('en-linea-panel');
        if (usuarios.length === 0) {
            panel.innerHTML = `<div style="font-size:11px; color:#9ca3af; padding:4px 6px;">Nadie más conectado</div>`;
        } else {
            panel.innerHTML = usuarios.map(u => `
                <div onclick="abrirDirectoDesdeEnLinea(${u.id})"
                    style="display:flex; align-items:center; gap:6px; padding:5px 6px; font-size:11px; color:#374151; cursor:pointer; border-radius:6px;"
                    onmouseover="this.style.background='#f3f4f6'" onmouseout="this.style.background='transparent'">
                    <span style="width:7px; height:7px; border-radius:50%; background:#16a34a; flex-shrink:0;"></span>
                    ${u.nombre}
                </div>
            `).join('');
        }
    } catch (e) {
    } finally {
        cargandoEnLinea = false;
    }
}

function toggleEnLinea() {
    enLineaAbierto = !enLineaAbierto;
    document.getElementById('en-linea-panel').style.display = enLineaAbierto ? 'block' : 'none';
    if (enLineaAbierto) actualizarEnLinea();
}

function abrirDirectoDesdeEnLinea(userId) {
    document.getElementById('en-linea-panel').style.display = 'none';
    enLineaAbierto = false;
    iniciarDirecto(userId);
}

function toggleChat() {
    iniciarAudio();
    chatAbierto = !chatAbierto;
    const panel = document.getElementById('chat-panel');
    panel.style.display = chatAbierto ? 'flex' : 'none';
    if (chatAbierto) {
        ocultarPreviewChat();
        cargarConversaciones();
        actualizarBotonZumbido();
        if (!pollingInterval) pollingInterval = setInterval(chatPolling, 3000);
    } else {
        clearInterval(pollingInterval);
        pollingInterval = null;
        document.getElementById('chat-sticker-picker').style.display = 'none';
        document.getElementById('en-linea-panel').style.display = 'none';
        enLineaAbierto = false;
    }
}

let cargandoMensajes = false; // mismo seguro, para no pisar consultas de /chat/mensajes

function chatPolling() {
    if (convActualId && !cargandoMensajes) cargarMensajes(convActualId, false);
    actualizarBadge();
    actualizarBotonZumbido();
}

async function cargarConversaciones() {
    const res = await fetch('/chat/conversaciones');
    const convs = await res.json();
    const cont = document.getElementById('chat-convs');
    cont.innerHTML = convs.map(c => `
        <div onclick="seleccionarConv(${c.id}, '${c.nombre}', '${c.tipo}')"
            style="position:relative; padding:8px 24px 8px 10px; cursor:pointer; border-bottom:1px solid #f3f4f6; ${convActualId === c.id ? 'background:#eff6ff;' : ''}">
            ${c.tipo === 'directo' ? `
            <button onclick="event.stopPropagation(); cerrarConversacion(${c.id})" title="Cerrar chat"
                style="position:absolute; top:6px; right:4px; width:16px; height:16px; border:none; background:transparent; color:#9ca3af; cursor:pointer; font-size:12px; line-height:1; border-radius:4px; display:flex; align-items:center; justify-content:center;"
                onmouseover="this.style.background='#f3f4f6'; this.style.color='#dc2626';"
                onmouseout="this.style.background='transparent'; this.style.color='#9ca3af';">✕</button>
            ` : ''}
            <div style="font-size:11px; font-weight:600; color:#374151; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                ${c.tipo === 'general' ? '👥 ' : c.tipo === 'rol' ? '🔧 ' : '💬 '}${c.nombre}
            </div>
            ${c.ultimo ? `<div style="font-size:10px; color:#9ca3af; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; margin-top:1px;">${c.ultimo_user ? c.ultimo_user.split(' ')[0]+': ' : ''}${c.ultimo}</div>` : ''}
            ${c.no_leidos > 0 ? `<span style="background:#e24b4a; color:#fff; font-size:9px; border-radius:20px; padding:1px 5px; font-weight:600;">${c.no_leidos}</span>` : ''}
        </div>
    `).join('') + `
        <div onclick="abrirUsuarios()" style="padding:8px 10px; cursor:pointer; border-top:1px solid #e5e7eb; margin-top:4px; display:flex; align-items:center; gap:4px;">
            <span style="font-size:14px;">+</span>
            <span style="font-size:10px; color:#6b7280;">Nuevo chat</span>
        </div>
    `;
}

async function cerrarConversacion(id) {
    if (!confirm('¿Cerrar este chat? No se borra nada, solo desaparece de tu lista hasta que llegue un mensaje nuevo.')) return;
    await fetch('/chat/ocultar/' + id, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
    });
    if (convActualId === id) {
        convActualId = null;
        document.getElementById('chat-msgs').innerHTML = '';
        document.getElementById('chat-conv-header').textContent = 'Seleccioná una conversación';
    }
    cargarConversaciones();
}

async function seleccionarConv(id, nombre, tipo) {
    document.getElementById('chat-sticker-picker').style.display = 'none';
    convActualId = id;
    document.getElementById('chat-conv-header').textContent = (tipo === 'general' ? '👥 ' : tipo === 'rol' ? '🔧 ' : '💬 ') + nombre;
    document.getElementById('btn-zumbido').style.display = tipo === 'directo' ? 'flex' : 'none';
    actualizarBotonZumbido();
    await cargarMensajes(id, true);
    cargarConversaciones();
}

let cantidadMensajesPorConv = {};

async function cargarMensajes(id, scroll) {
    cargandoMensajes = true;
    const res = await fetch(`/chat/mensajes/${id}`).finally(() => { cargandoMensajes = false; });
    const msgs = await res.json();
    const cont = document.getElementById('chat-msgs');
    const cantAnterior = cantidadMensajesPorConv[id] ?? null;

    // Si ya estaba viendo el final de la conversación, lo mantenemos ahí
    // después de refrescar (si no, cada actualización de fondo te tira el scroll arriba)
    const estabaAbajo = (cont.scrollTop + cont.clientHeight) >= (cont.scrollHeight - 30);

    cont.innerHTML = msgs.map(m => {
        if (m.archivo_tipo === 'zumbido') {
            return `
                <div style="text-align:center; margin:4px 0;">
                    <span style="font-size:10px; color:#9ca3af; font-style:italic; background:#f3f4f6; padding:3px 10px; border-radius:20px;">
                        👋 ${m.es_mio ? 'Le mandaste un zumbido' : (m.nombre + ' te mandó un zumbido')}
                    </span>
                </div>
            `;
        }
        return `
        <div style="display:flex; flex-direction:column; align-items:${m.es_mio ? 'flex-end' : 'flex-start'};">
            ${!m.es_mio ? `<div style="font-size:9px; color:#9ca3af; margin-bottom:2px;">${m.nombre}</div>` : ''}
            ${m.mensaje ? `<div style="background:${m.es_mio ? '#dbeafe' : '#fff'}; border:1px solid #e5e7eb; border-radius:8px; padding:5px 8px; font-size:11px; color:#374151; max-width:85%; line-height:1.5;">${m.mensaje}</div>` : ''}
            ${m.archivo && m.archivo_tipo === 'sticker' ? `<img src="${m.archivo}" style="width:56px; height:56px; margin-top:2px;">` : ''}
            ${m.archivo && m.archivo_tipo !== 'sticker' ? `<a href="${m.archivo}" target="_blank" style="display:flex; align-items:center; gap:4px; background:#f3f4f6; border:1px solid #e5e7eb; border-radius:6px; padding:4px 8px; font-size:10px; color:#374151; text-decoration:none; margin-top:2px;">📎 ${m.archivo_nombre}</a>` : ''}
            <div style="font-size:9px; color:#d1d5db; margin-top:2px;">${m.hora}</div>
        </div>
        `;
    }).join('');

    // Sonido solo si esta MISMA conversación tiene mensajes nuevos de otra persona
    if (cantAnterior !== null && msgs.length > cantAnterior) {
        const mensajesNuevos = msgs.slice(cantAnterior);
        const nuevosDeOtros = mensajesNuevos.filter(m => !m.es_mio);
        const zumbidoRecibido = nuevosDeOtros.find(m => m.archivo_tipo === 'zumbido');
        if (zumbidoRecibido) {
            sacudirChat();
            reproducirZumbido();
        } else if (nuevosDeOtros.length > 0) {
            reproducirSonido();
        }
        if (nuevosDeOtros.length > 0) {
            const ultimo = nuevosDeOtros[nuevosDeOtros.length - 1];
            mostrarNotificacionEscritorio(ultimo.nombre, ultimo.archivo_tipo === 'zumbido' ? '👋 Zumbido' : (ultimo.mensaje || (ultimo.archivo_tipo === 'sticker' ? '🙂 Sticker' : '📎 Archivo')));
        }
    }

    cantidadMensajesPorConv[id] = msgs.length;

    if (scroll || estabaAbajo) cont.scrollTop = cont.scrollHeight;
}

let audioCtx = null;

function iniciarAudio() {
    if (!audioCtx) {
        audioCtx = new (window.AudioContext || window.webkitAudioContext)();
    }
}

function reproducirSonido() {
    try {
        if (!audioCtx) audioCtx = new (window.AudioContext || window.webkitAudioContext)();
        if (audioCtx.state === 'suspended') audioCtx.resume();
        const osc = audioCtx.createOscillator();
        const gain = audioCtx.createGain();
        osc.connect(gain);
        gain.connect(audioCtx.destination);
        osc.frequency.value = 880;
        osc.type = 'sine';
        gain.gain.setValueAtTime(0.3, audioCtx.currentTime);
        gain.gain.exponentialRampToValueAtTime(0.001, audioCtx.currentTime + 0.3);
        osc.start(audioCtx.currentTime);
        osc.stop(audioCtx.currentTime + 0.3);
    } catch(e) {
        console.error('Audio error:', e);
    }
}

const audioZumbido = new Audio('/sounds/zumbido.mp3');

function reproducirZumbido() {
    try {
        audioZumbido.currentTime = 0;
        audioZumbido.play();
    } catch(e) {}
}

function sacudirChat() {
    const panel = document.getElementById('chat-panel');
    panel.classList.remove('zumbido-anim');
    void panel.offsetWidth; // fuerza reflow para poder reiniciar la animación
    panel.classList.add('zumbido-anim');
    // La saco al terminar: si no, queda "pegada" y al cerrar/abrir el panel
    // (display:none → flex) el navegador la vuelve a disparar sola.
    setTimeout(() => panel.classList.remove('zumbido-anim'), 550);
}

function sacudirBotonChat() {
    const btn = document.getElementById('chat-btn');
    btn.classList.remove('zumbido-anim');
    void btn.offsetWidth;
    btn.classList.add('zumbido-anim');
    setTimeout(() => btn.classList.remove('zumbido-anim'), 550);
}

// Notificaciones nativas del sistema (Windows/Mac), avisan aunque tengas
// la ventana minimizada o estés en otra pestaña. Requieren permiso del navegador.
function actualizarBotonNotifPermiso() {
    const btn = document.getElementById('btn-notif-permiso');
    if (!('Notification' in window)) { btn.style.display = 'none'; return; }
    btn.style.display = Notification.permission === 'default' ? 'flex' : 'none';
}

function activarNotificacionesEscritorio() {
    if (!('Notification' in window)) return;
    Notification.requestPermission().then(() => actualizarBotonNotifPermiso());
}

function mostrarNotificacionEscritorio(titulo, cuerpo) {
    if (!('Notification' in window)) return;
    if (Notification.permission !== 'granted') return;
    // Solo si de verdad no estás mirando la pestaña — si la tenés activa, ya te avisa el cartelito de adentro del chat.
    if (!document.hidden && document.hasFocus()) return;
    try {
        const notif = new Notification(titulo, { body: cuerpo, icon: '/favicon.ico' });
        notif.onclick = () => { window.focus(); notif.close(); };
    } catch (e) {}
}

// Guardo el enfriamiento en localStorage (no en una variable JS) para que
// sobreviva si navegás a otra pantalla del sistema mientras espera los 3 min.
function obtenerZumbidoHasta(convId) {
    const v = localStorage.getItem('zumbidoHasta_' + convId);
    return v ? parseInt(v, 10) : 0;
}
function guardarZumbidoHasta(convId, timestamp) {
    localStorage.setItem('zumbidoHasta_' + convId, String(timestamp));
}

function actualizarBotonZumbido() {
    const btn = document.getElementById('btn-zumbido');
    if (!btn || btn.style.display === 'none' || !convActualId) return;
    const hasta = obtenerZumbidoHasta(convActualId);
    if (Date.now() < hasta) {
        btn.disabled = true;
        btn.style.opacity = '0.35';
    } else {
        btn.disabled = false;
        btn.style.opacity = '1';
    }
}

async function enviarZumbido() {
    if (!convActualId) return;
    if (Date.now() < obtenerZumbidoHasta(convActualId)) return;

    const res = await fetch(`/chat/zumbido/${convActualId}`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
    });
    const data = await res.json();

    if (!data.ok) {
        if (data.restante) guardarZumbidoHasta(convActualId, Date.now() + data.restante * 1000);
        actualizarBotonZumbido();
        return;
    }

    guardarZumbidoHasta(convActualId, Date.now() + 180000);
    actualizarBotonZumbido();
    sacudirChat();
    reproducirZumbido();
    await cargarMensajes(convActualId, true);
    cargarConversaciones();
}

// Se re-evalúa solo, sin depender de que el chat esté abierto ni de recargar (F5)
setInterval(actualizarBotonZumbido, 5000);

async function enviarMensaje() {
    const input = document.getElementById('chat-input');
    const mensaje = input.value.trim();
    if (!mensaje && !chatArchivoFile) return;
    if (!convActualId) return;

    const formData = new FormData();
    if (mensaje) formData.append('mensaje', mensaje);
    if (chatArchivoFile) formData.append('archivo', chatArchivoFile);

    input.value = '';
    chatArchivoFile = null;
    document.getElementById('chat-file').value = '';

    await fetch(`/chat/enviar/${convActualId}`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
        body: formData
    });

    await cargarMensajes(convActualId, true);
    cargarConversaciones();
}

function chatArchivoSeleccionado(input) {
    chatArchivoFile = input.files[0];
    if (chatArchivoFile) {
        document.getElementById('chat-input').placeholder = '📎 ' + chatArchivoFile.name;
    }
}

let listaStickers = null;

async function toggleStickerPicker() {
    const picker = document.getElementById('chat-sticker-picker');
    const abrir = picker.style.display === 'none' || !picker.style.display;
    if (!abrir) {
        picker.style.display = 'none';
        return;
    }
    if (!listaStickers) {
        const res = await fetch('/chat/stickers');
        listaStickers = await res.json();
    }
    picker.innerHTML = listaStickers.map(s => `
        <img src="${s.url}" onclick="enviarSticker('${s.archivo}')"
            style="width:100%; aspect-ratio:1; cursor:pointer; border-radius:6px; transition:transform 0.1s;"
            onmouseover="this.style.transform='scale(1.12)'" onmouseout="this.style.transform='scale(1)'">
    `).join('');
    picker.style.display = 'grid';
}

async function enviarSticker(archivo) {
    if (!convActualId) return;
    document.getElementById('chat-sticker-picker').style.display = 'none';

    const formData = new FormData();
    formData.append('sticker', archivo);

    await fetch(`/chat/enviar/${convActualId}`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
        body: formData
    });

    await cargarMensajes(convActualId, true);
    cargarConversaciones();
}

async function abrirUsuarios() {
    document.getElementById('chat-usuarios-panel').style.display = 'block';
    const res = await fetch('/chat/usuarios');
    const usuarios = await res.json();
    document.getElementById('chat-usuarios-lista').innerHTML = usuarios.map(u => `
        <div onclick="iniciarDirecto(${u.id})" style="padding:8px 10px; cursor:pointer; border-bottom:1px solid #f3f4f6; display:flex; align-items:center; gap:8px;">
            <span style="width:8px; height:8px; border-radius:50%; background:${u.online ? '#16a34a' : '#d1d5db'}; flex-shrink:0;"></span>
            <div>
                <div style="font-size:11px; font-weight:600; color:#374151;">${u.nombre}</div>
                <div style="font-size:10px; color:#9ca3af;">${u.rol}</div>
            </div>
        </div>
    `).join('');
}

function cerrarUsuarios() {
    document.getElementById('chat-usuarios-panel').style.display = 'none';
}

async function iniciarDirecto(userId) {
    const res = await fetch(`/chat/directo/${userId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        }
    });
    const data = await res.json();
    cerrarUsuarios();
    await cargarConversaciones();
    const res2 = await fetch('/chat/conversaciones');
    const convs = await res2.json();
    const conv = convs.find(c => c.id === data.conversacion_id);
    if (conv) seleccionarConv(conv.id, conv.nombre, conv.tipo);
}

let actualizandoBadge = false; // evita que se pisen consultas si el servidor tarda en responder

async function actualizarBadge() {
    if (actualizandoBadge) return;
    actualizandoBadge = true;
    try {
        const res = await fetch('/chat/no-leidos');
        const data = await res.json();
        const badge = document.getElementById('chat-badge');
        if (data.total > 0) {
            badge.textContent = data.total;
            badge.style.display = 'flex';
        } else {
            badge.style.display = 'none';
        }
        await chequearPreviewChat();
    } finally {
        actualizandoBadge = false;
    }
}

let previewChatConv = null;

// Uso localStorage (no una variable JS) para recordar el último aviso visto,
// porque cada clic a otra pantalla del sistema recarga la página entera y
// borraría una variable normal — así el zumbido se detecta como "nuevo" bien,
// pase lo que pase con la navegación.
async function chequearPreviewChat() {
    if (chatAbierto) return;
    try {
        const res = await fetch('/chat/conversaciones');
        const convs = await res.json();
        const conNoLeidos = convs.filter(c => c.no_leidos > 0 && c.ultimo);
        const conNuevo = conNoLeidos.sort((a, b) => (b.ultimo_hora || '').localeCompare(a.ultimo_hora || ''))[0];

        if (!conNuevo) return;

        const fingerprint = conNuevo.id + '|' + conNuevo.ultimo + '|' + conNuevo.ultimo_hora;
        const otras = conNoLeidos.length - 1;

        mostrarPreviewChat(conNuevo, otras);

        const fingerprintGuardado = localStorage.getItem('chatPreviewFingerprint');
        if (fingerprint === fingerprintGuardado) return; // ya lo procesamos, aunque haya sido en otra página

        const esPrimeraVezEnEsteNavegador = fingerprintGuardado === null;
        localStorage.setItem('chatPreviewFingerprint', fingerprint);

        if (!esPrimeraVezEnEsteNavegador && conNuevo.ultimo_tipo === 'zumbido') {
            sacudirBotonChat();
            reproducirZumbido();
        }

        if (!esPrimeraVezEnEsteNavegador) {
            mostrarNotificacionEscritorio(conNuevo.ultimo_user || conNuevo.nombre, conNuevo.ultimo);
        }
    } catch (e) {}
}

function mostrarPreviewChat(conv, otras) {
    previewChatConv = conv;
    const prev = document.getElementById('chat-preview');
    document.getElementById('chat-preview-nombre').textContent = conv.ultimo_user || conv.nombre;
    document.getElementById('chat-preview-texto').textContent = conv.ultimo;
    const extra = document.getElementById('chat-preview-extra');
    if (otras > 0) {
        extra.textContent = '+ ' + otras + (otras === 1 ? ' chat más esperando' : ' chats más esperando');
        extra.style.display = 'block';
    } else {
        extra.style.display = 'none';
    }
    prev.style.display = 'block';
}

function ocultarPreviewChat() {
    document.getElementById('chat-preview').style.display = 'none';
}

function abrirPreviewChat() {
    const conv = previewChatConv;
    ocultarPreviewChat();
    toggleChat();
    if (conv) setTimeout(() => seleccionarConv(conv.id, conv.nombre, conv.tipo), 200);
}

function pingOnline() {
    fetch('/chat/ping', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
    });
}

// Cadencia normal (pestaña visible) vs. cadencia reducida (minimizada / en otra pestaña).
// Antes se frenaba todo por completo al minimizar, pero eso significaba no enterarte
// de mensajes ni zumbidos hasta volver a mirar la pantalla. Ahora sigue consultando,
// solo que más espaciado, para no sobrecargar el servidor sin dejar de avisar.
const CADENCIA_RAPIDA = { notif: 30000, ping: 30000, badge: 10000, enLinea: 15000, chat: 3000 };
const CADENCIA_LENTA  = { notif: 60000, ping: 45000, badge: 30000, enLinea: 45000, chat: 8000 };

actualizarBotonNotifPermiso();
actualizarBadge();
pingInterval = setInterval(pingOnline, CADENCIA_RAPIDA.ping);
badgeInterval = setInterval(actualizarBadge, CADENCIA_RAPIDA.badge);
actualizarEnLinea();
enLineaInterval = setInterval(actualizarEnLinea, CADENCIA_RAPIDA.enLinea);

// Al minimizar/cambiar de pestaña seguimos consultando, pero más lento;
// al volver, se retoma la cadencia normal y se refresca todo de una.
document.addEventListener('visibilitychange', function() {
    clearInterval(notifInterval);
    clearInterval(pingInterval);
    clearInterval(badgeInterval);
    clearInterval(enLineaInterval);
    if (pollingInterval) {
        clearInterval(pollingInterval);
        pollingInterval = null;
    }

    if (document.visibilityState === 'hidden') {
        const c = CADENCIA_LENTA;
        notifInterval = setInterval(actualizarNotificaciones, c.notif);
        pingInterval = setInterval(pingOnline, c.ping);
        badgeInterval = setInterval(actualizarBadge, c.badge);
        enLineaInterval = setInterval(actualizarEnLinea, c.enLinea);
        if (chatAbierto && convActualId) {
            pollingInterval = setInterval(chatPolling, c.chat);
        }
    } else {
        const c = CADENCIA_RAPIDA;
        actualizarNotificaciones();
        actualizarBadge();
        pingOnline();
        actualizarEnLinea();
        notifInterval = setInterval(actualizarNotificaciones, c.notif);
        pingInterval = setInterval(pingOnline, c.ping);
        badgeInterval = setInterval(actualizarBadge, c.badge);
        enLineaInterval = setInterval(actualizarEnLinea, c.enLinea);
        if (chatAbierto && convActualId) {
            pollingInterval = setInterval(chatPolling, c.chat);
            cargarMensajes(convActualId, false);
        }
    }
});

</script>
@livewireScripts

</body>

</html>
