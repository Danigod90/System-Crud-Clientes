<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Sistema de Gestion') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
    @keyframes humo {
        0%   { background-position: 0% 50%; }
        50%  { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
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
    <a href="{{ route('panel.dashboard') }}"
        style="display:flex; align-items:center; gap:10px; padding:9px 14px; margin:1px 8px; border-radius:8px; font-size:13px; color:{{ request()->routeIs('panel.dashboard') ? '#fff' : 'rgba(255,255,255,0.55)' }}; background:{{ request()->routeIs('panel.dashboard') ? 'rgba(99,130,255,0.2)' : 'transparent' }}; text-decoration:none; border:{{ request()->routeIs('panel.dashboard') ? '1px solid rgba(99,130,255,0.3)' : '1px solid transparent' }}; transition:all 0.2s;"
        onmouseover="this.style.background='rgba(255,255,255,0.12)'"
        onmouseout="this.style.background='{{ request()->routeIs('panel.dashboard') ? 'rgba(99,130,255,0.2)' : 'transparent' }}'">
        <span style="width:7px; height:7px; border-radius:50%; background:#60a5fa; flex-shrink:0;"></span>
        Dashboard
    </a>

    {{-- NAV ENTRADAS --}}
    <div style="padding:14px 14px 4px; font-size:10px; color:rgba(255,255,255,0.25); letter-spacing:1px; text-transform:uppercase;">Entradas</div>
    <a href="{{ route('secretaria.con-nota.index') }}"
        style="display:flex; align-items:center; gap:10px; padding:9px 14px; margin:1px 8px; border-radius:8px; font-size:13px; color:{{ request()->routeIs('secretaria.con-nota.*') ? '#fff' : 'rgba(255,255,255,0.55)' }}; background:{{ request()->routeIs('secretaria.con-nota.*') ? 'rgba(52,211,153,0.15)' : 'transparent' }}; text-decoration:none; border:{{ request()->routeIs('secretaria.con-nota.*') ? '1px solid rgba(52,211,153,0.25)' : '1px solid transparent' }}; transition:all 0.2s;"
        onmouseover="this.style.background='rgba(255,255,255,0.12)'"
        onmouseout="this.style.background='{{ request()->routeIs('secretaria.con-nota.*') ? 'rgba(52,211,153,0.15)' : 'transparent' }}'">
        <span style="width:7px; height:7px; border-radius:50%; background:#34d399; flex-shrink:0;"></span>
        Entradas con nota
    </a>
    <a href="{{ route('secretaria.sin-nota.index') }}"
        style="display:flex; align-items:center; gap:10px; padding:9px 14px; margin:1px 8px; border-radius:8px; font-size:13px; color:{{ request()->routeIs('secretaria.sin-nota.*') ? '#fff' : 'rgba(255,255,255,0.55)' }}; background:{{ request()->routeIs('secretaria.sin-nota.*') ? 'rgba(255,255,255,0.1)' : 'transparent' }}; text-decoration:none; border:{{ request()->routeIs('secretaria.sin-nota.*') ? '1px solid rgba(255,255,255,0.15)' : '1px solid transparent' }}; transition:all 0.2s;"
        onmouseover="this.style.background='rgba(255,255,255,0.12)'"
        onmouseout="this.style.background='{{ request()->routeIs('secretaria.sin-nota.*') ? 'rgba(255,255,255,0.1)' : 'transparent' }}'">
        <span style="width:7px; height:7px; border-radius:50%; background:rgba(255,255,255,0.28); flex-shrink:0;"></span>
        Entradas sin nota
    </a>

    {{-- NAV TRABAJO --}}
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

    {{-- NAV SISTEMA --}}
    <div style="padding:14px 14px 4px; font-size:10px; color:rgba(255,255,255,0.25); letter-spacing:1px; text-transform:uppercase;">Sistema</div>
    <a href="#"
        style="display:flex; align-items:center; gap:10px; padding:9px 14px; margin:1px 8px; border-radius:8px; font-size:13px; color:rgba(255,255,255,0.55); text-decoration:none; border:1px solid transparent; transition:all 0.2s;"
        onmouseover="this.style.background='rgba(255,255,255,0.12)'"
        onmouseout="this.style.background='transparent'">
        <span style="width:7px; height:7px; border-radius:50%; background:rgba(255,255,255,0.28); flex-shrink:0;"></span>
        Notificaciones
    </a>

    {{-- LOGOUT --}}
    <div style="margin-top:auto; padding:16px;">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                style="width:100%; padding:9px; background:rgba(255,255,255,0.06); color:rgba(255,255,255,0.5); border:1px solid rgba(255,255,255,0.08); border-radius:8px; font-size:12px; cursor:pointer; text-align:left; transition:all 0.2s;"
                onmouseover="this.style.background='rgba(255,255,255,0.15)'"
                onmouseout="this.style.background='rgba(255,255,255,0.06)'">
                Cerrar sesion
            </button>
        </form>
    </div>

</div>
{{-- FIN SIDEBAR --}}
    {{-- CONTENIDO PRINCIPAL --}}
    <div style="flex:1; display:flex; flex-direction:column; overflow:hidden; background:transparent;">

        {{-- TOPBAR --}}
<div style="background:rgba(255,255,255,0.4); backdrop-filter:blur(8px); border-bottom:1px solid #e5e7eb; padding:13px 22px; display:flex; align-items:center; justify-content:space-between;">            <span style="font-size:15px; font-weight:500; color:#111827;">{{ $title ?? 'Dashboard' }}</span>
            <div style="display:flex; align-items:center; gap:14px;">
                {{-- campanita --}}
                <div style="position:relative; cursor:pointer;">
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
                {{-- avatar --}}
                <div style="width:30px; height:30px; border-radius:50%; background:#185FA5; display:flex; align-items:center; justify-content:center; font-size:11px; font-weight:600; color:#fff;">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
            </div>
        </div>

        {{-- AREA DE CONTENIDO + PANEL DERECHO --}}
       <div style="display:flex; flex:1; overflow:hidden; background:transparent;">

           {{-- SLOT PRINCIPAL --}}
<div style="flex:1; padding:18px; overflow:auto; background:transparent;">
    {{ $slot }}
</div>

            {{-- PANEL DERECHO — NOTIFICACIONES --}}
<div style="width:240px; min-width:240px; background:rgba(255,255,255,0.4); backdrop-filter:blur(8px); border-left:1px solid #e5e7eb; padding:16px; overflow:auto; display:flex; flex-direction:column;">
                <div style="font-size:11px; font-weight:500; color:#9ca3af; margin-bottom:12px; text-transform:uppercase; letter-spacing:0.7px;">Notificaciones</div>

                @forelse(auth()->user()->notifications->take(5) as $notif)
                <div style="padding:11px 0; border-bottom:1px solid #f3f4f6;">
                    <div style="display:flex; align-items:flex-start; gap:7px;">
                        <span style="width:7px; height:7px; border-radius:50%; flex-shrink:0; margin-top:4px; background:{{ $notif->read_at ? '#d1d5db' : '#185FA5' }};"></span>
                        <span style="font-size:12px; color:#111827; line-height:1.4; flex:1;">{{ $notif->data['mensaje'] ?? '' }}</span>
                        <span style="font-size:10px; color:#9ca3af; white-space:nowrap;">{{ $notif->created_at->diffForHumans() }}</span>
                    </div>
                    @if(isset($notif->data['seccion']))
                    <div style="font-size:10.5px; color:#6b7280; margin-top:3px; padding-left:14px;">{{ $notif->data['seccion'] }}</div>
                    @endif
                </div>
                @empty
                <p style="font-size:12px; color:#9ca3af;">Sin notificaciones.</p>
                @endforelse

                {{-- ELECCIONES PROXIMAS --}}
                @isset($elecciones)
                <div style="margin-top:auto; padding-top:16px;">
                    <div style="font-size:11px; font-weight:500; color:#9ca3af; margin-bottom:12px; text-transform:uppercase; letter-spacing:0.7px;">Elecciones proximas</div>
                    @forelse($elecciones as $e)
                    <div style="display:flex; justify-content:space-between; align-items:center; padding:9px 0; border-bottom:1px solid #f3f4f6;">
                        <div>
                            <div style="font-size:12px; color:#111827; font-weight:500;">{{ $e->nombre_organizacion }}</div>
                            <div style="font-size:10.5px; color:#6b7280; margin-top:1px;">{{ $e->fecha_eleccion->format('d M Y') }}</div>
                        </div>
                        @php $dias = (int) now()->startOfDay()->diffInDays($e->fecha_eleccion->startOfDay(), false); @endphp
                        <span style="font-size:10.5px; font-weight:500; padding:3px 9px; border-radius:20px;
                            background:{{ $dias <= 7 ? '#fee2e2' : ($dias <= 15 ? '#fef3c7' : '#d1fae5') }};
                            color:{{ $dias <= 7 ? '#991b1b' : ($dias <= 15 ? '#92400e' : '#065f46') }};">
                            {{ $dias }} dias
                        </span>
                    </div>
                    @empty
                    <p style="font-size:12px; color:#9ca3af;">Sin elecciones proximas.</p>
                    @endforelse
                </div>
                @endisset

            </div>
            {{-- FIN PANEL DERECHO --}}

        </div>
    </div>
    {{-- FIN CONTENIDO PRINCIPAL --}}

</div>
</body>
</html>
