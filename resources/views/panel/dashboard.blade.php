<x-panel-layout title="Panel General" :elecciones="$elecciones" :charlasPendientes="$charlasPendientes">
<style>
.card-stat {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    cursor: default;
}
.card-stat:hover {
    transform: translateY(-4px) scale(1.02);
    box-shadow: 0 16px 32px rgba(0,0,0,0.2) !important;
}
</style>
{{-- CARDS + HEADER TABLA FIJOS --}}
<div style="position:sticky; top:0; z-index:10; margin:-18px -18px 0 -18px; padding:18px 18px 0 18px; background:linear-gradient(135deg, #e8eaf6 0%, #d4d8f0 25%, #e8d5f0 50%, #d4e8f0 75%, #e8eaf6 100%); box-shadow:0 8px 20px rgba(200,200,220,0.5);">
<div style="max-width:1000px; margin:0 auto;">

    {{-- CARDS --}}
    <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:14px; margin-bottom:14px;">

        {{-- 1. Organizaciones activas --}}
        <div class="card-stat"style="background:linear-gradient(135deg,#7C6FC4,#D088C0); border-radius:14px; padding:18px 20px; position:relative; overflow:visible; box-shadow:0 4px 12px rgba(124,111,196,0.35);">
            <div style="position:absolute;top:14px;right:16px;opacity:0.55;">
                <svg width="36" height="36" fill="none" stroke="#fff" stroke-width="1.5" viewBox="0 0 24 24">
                    <path d="M3 21h18M3 10h18M5 6l7-3 7 3M4 10v11M20 10v11M8 14v3M12 14v3M16 14v3"/>
                </svg>
            </div>
            <div style="font-size:11px; color:rgba(255,255,255,0.85); margin-bottom:6px; font-weight:500;">Organizaciones activas</div>
            <div style="font-size:36px; font-weight:700; color:#fff; line-height:1;">{{ $stats['organizaciones'] }}</div>
            <span style="display:inline-flex; background:rgba(255,255,255,0.22); border-radius:20px; padding:3px 10px; font-size:10px; color:#fff; margin-top:10px;">total registradas</span>
        </div>

        {{-- 2. Charlas realizadas --}}
        <div class="card-stat" style="background:linear-gradient(135deg,#4ABFB0,#60A8E0); border-radius:14px; padding:18px 20px; position:relative; overflow:visible; box-shadow:0 4px 12px rgba(74,191,176,0.35);">
            <div style="position:absolute;top:14px;right:16px;opacity:0.55;">
                <svg width="36" height="36" fill="none" stroke="#fff" stroke-width="1.5" viewBox="0 0 24 24">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
            </div>
            <div style="font-size:11px; color:rgba(255,255,255,0.85); margin-bottom:6px; font-weight:500;">Charlas realizadas</div>
            <div style="font-size:36px; font-weight:700; color:#fff; line-height:1;">{{ $stats['charlas_realizadas'] }}</div>
            <span style="display:inline-flex; background:rgba(255,255,255,0.22); border-radius:20px; padding:3px 10px; font-size:10px; color:#fff; margin-top:10px;">este mes</span>
        </div>

        {{-- 3. Charlas pendientes --}}
        <div class="card-stat" style="background:linear-gradient(135deg,#E87CA0,#F0B080); border-radius:14px; padding:18px 20px; position:relative; overflow:visible; box-shadow:0 4px 12px rgba(232,124,160,0.35);">
            <div style="position:absolute;top:14px;right:16px;opacity:0.55;">
                <svg width="36" height="36" fill="none" stroke="#fff" stroke-width="1.5" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/>
                    <polyline points="12 6 12 12 16 14"/>
                </svg>
            </div>
            <div style="font-size:11px; color:rgba(255,255,255,0.85); margin-bottom:6px; font-weight:500;">Charlas pendientes</div>
            <div style="font-size:36px; font-weight:700; color:#fff; line-height:1;">{{ $stats['charlas_pendientes'] }}</div>
            <span style="display:inline-flex; background:rgba(255,255,255,0.22); border-radius:20px; padding:3px 10px; font-size:10px; color:#fff; margin-top:10px;">sin realizar</span>
        </div>

        {{-- 4. Elecciones proximas --}}
        <div class="card-stat" style="background:linear-gradient(135deg,#5BC8E8,#A090E0); border-radius:14px; padding:18px 20px; position:relative; overflow:visible; box-shadow:0 4px 12px rgba(91,200,232,0.35);">
            <div style="position:absolute;top:14px;right:16px;opacity:0.55;">
                <svg width="36" height="36" fill="none" stroke="#fff" stroke-width="1.5" viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/>
                    <line x1="8" y1="2" x2="8" y2="6"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                    <circle cx="12" cy="16" r="1" fill="#fff"/>
                </svg>
            </div>
            <div style="font-size:11px; color:rgba(255,255,255,0.85); margin-bottom:6px; font-weight:500;">Elecciones próximas</div>
            <div style="font-size:36px; font-weight:700; color:#fff; line-height:1;">{{ $stats['elecciones_proximas'] }}</div>
            <span style="display:inline-flex; background:rgba(255,255,255,0.22); border-radius:20px; padding:3px 10px; font-size:10px; color:#fff; margin-top:10px;">próximos 30 días</span>
        </div>

        {{-- 5. Sin fecha de eleccion --}}
        <div class="card-stat" style="background:linear-gradient(135deg,#9090D0,#D090C0); border-radius:14px; padding:18px 20px; position:relative; overflow:visible; box-shadow:0 4px 12px rgba(144,144,208,0.35);">
            <div style="position:absolute;top:14px;right:16px;opacity:0.55;">
                <svg width="36" height="36" fill="none" stroke="#fff" stroke-width="1.5" viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/>
                    <line x1="8" y1="2" x2="8" y2="6"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                    <line x1="9" y1="15" x2="15" y2="15"/>
                </svg>
            </div>
            <div style="font-size:11px; color:rgba(255,255,255,0.85); margin-bottom:6px; font-weight:500;">Sin fecha de elección</div>
            <div style="font-size:36px; font-weight:700; color:#fff; line-height:1;">{{ $stats['sin_fecha'] }}</div>
            <span style="display:inline-flex; background:rgba(255,255,255,0.22); border-radius:20px; padding:3px 10px; font-size:10px; color:#fff; margin-top:10px;">requieren fecha</span>
        </div>

        {{-- 6. Trabajo tecnico pendiente --}}
        <div class="card-stat" style="background:linear-gradient(135deg,#F09060,#F0A0B0); border-radius:14px; padding:18px 20px; position:relative; overflow:visible; box-shadow:0 4px 12px rgba(240,144,96,0.35);">
            <div style="position:absolute;top:14px;right:16px;opacity:0.55;">
                <svg width="36" height="36" fill="none" stroke="#fff" stroke-width="1.5" viewBox="0 0 24 24">
                    <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>
                </svg>
            </div>
            <div style="font-size:11px; color:rgba(255,255,255,0.85); margin-bottom:6px; font-weight:500;">Trabajo técnico pendiente</div>
            <div style="font-size:36px; font-weight:700; color:#fff; line-height:1;">{{ $stats['tec_pendientes'] }}</div>
            <span style="display:inline-flex; background:rgba(255,255,255,0.22); border-radius:20px; padding:3px 10px; font-size:10px; color:#fff; margin-top:10px;">por resolver</span>
        </div>

    </div>

    {{-- HEADER TABLA FIJO --}}
    <div style="background:rgba(255,255,255,0.95); border-radius:16px 16px 0 0; border:1px solid rgba(255,255,255,0.9); border-bottom:none;">
        <div style="padding:6px 16px; border-bottom:1px solid #e5e7eb; font-size:13px; font-weight:500; color:#111827; display:flex; justify-content:space-between; align-items:center;">
    Ultimas organizaciones ingresadas
    <div style="display:flex; align-items:center; gap:8px;">
        <form method="GET" action="{{ route('panel.dashboard') }}" style="display:flex; align-items:center; gap:6px;">
           <select name="asesor" onchange="this.form.submit()" style="border:1px solid #e5e7eb; border-radius:8px; padding:4px 10px; font-size:12px; color:#374151; outline:none; background:#fff; cursor:pointer; transition: box-shadow 0.2s ease;"
    onmouseover="this.style.boxShadow='0 4px 10px rgba(0,0,0,0.12)'"
    onmouseout="this.style.boxShadow='none'">
                <option value="">Todos los asesores</option>
                @foreach($asesores as $asesor)
                    @php $nombreCompleto = $asesor->nombre . ' ' . $asesor->apellido; @endphp
                    <option value="{{ $nombreCompleto }}" {{ request('asesor') == $nombreCompleto ? 'selected' : '' }}>
                        {{ $nombreCompleto }}
                    </option>
                @endforeach
            </select>
            @if(request('asesor'))
                <a href="{{ route('panel.dashboard') }}" style="font-size:12px; color:#6b7280; text-decoration:none;">✕</a>
            @endif
        </form>
        <a href="{{ route('secretaria.con-nota.index') }}" style="font-size:12px; color:#185FA5; text-decoration:none;">Ver todas</a>
    </div>
</div>
        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="background:rgba(43,78,200,0.25);">
                    <th style="padding:5px 10px; text-align:left; color:#fff; font-weight:500; font-size:12px; width:120px;">Codigo</th>
                    <th style="padding:5px 10px; text-align:left; color:#fff; font-weight:500; font-size:12px;">Organizacion</th>
                    <th style="padding:5px 10px; text-align:left; color:#fff; font-weight:500; font-size:12px; width:120px;">Asesor</th>
                    <th style="padding:5px 1px; text-align:left; color:#fff; font-weight:500; font-size:12px; width:100px;">Asunto</th>
                    <th style="padding:5px 4px; text-align:left; color:#fff; font-weight:500; font-size:12px; width:120px;">Estado</th>
                </tr>
            </thead>
        </table>
    </div>

</div>
</div>
{{-- FIN STICKY --}}

{{-- BODY SCROLLEABLE --}}
<div style="max-width:1000px; margin:0 auto;">
<div style="background:rgba(255,255,255,0.75); backdrop-filter:blur(12px); -webkit-backdrop-filter:blur(12px); border:1px solid rgba(255,255,255,0.9); border-top:none; border-radius:0 0 16px 16px; box-shadow:0 20px 60px rgba(100,100,180,0.15), 0 8px 20px rgba(100,100,180,0.1); margin-bottom:18px;">
    <table style="width:100%; border-collapse:collapse; font-size:11px;">
        <tbody>
            @forelse($entradas as $entrada)
            <tr style="border-bottom:1px solid #f3f4f6;" onmouseover="this.style.background='rgba(100,100,180,0.06)'" onmouseout="this.style.background='transparent'">
                <td style="padding:5px 10px; color:#185FA5; font-weight:600; font-family:monospace; width:120px;">{{ $entrada->codigo_org }}</td>
                <td style="padding:5px 10px; color:#111827;">{{ $entrada->nombre_organizacion }}</td>
                <td style="padding:5px 10px; color:#6b7280; width:120px; font-size:11.5px;">{{ $entrada->asesor_asignado ?? '-' }}</td>
                <td style="padding:5px 1px; color:#111827; font-weight:600; width:100px;">{{ $entrada->asunto_texto }}</td>
                <td style="padding:5px 2px; width:120px;">
                    @if($entrada->asunto_char)
                        @php $charDot = match($entrada->charla?->estado ?? 'pendiente') { 'realizada' => '#16a34a', 'cancelada' => '#dc2626', 'suspendida' => '#f97316', 'vencida' => '#dc2626', default => '#eab308' }; @endphp
                        <span style="display:inline-flex; align-items:center; gap:3px; margin-right:6px;">
                            <span style="font-size:11px; color:#6b7280;">Char</span>
                            <span style="width:9px; height:9px; border-radius:50%; background:{{ $charDot }}; display:inline-block;"></span>
                        </span>
                    @endif
                    @if($entrada->asunto_log)
                        @php $logDot = in_array($entrada->log_estado ?? 'pendiente', ['entregada', 'realizado']) ? '#16a34a' : '#eab308'; @endphp
                        <span style="display:inline-flex; align-items:center; gap:3px; margin-right:6px;">
                            <span style="font-size:11px; color:#6b7280;">Log</span>
                            <span style="width:9px; height:9px; border-radius:50%; background:{{ $logDot }}; display:inline-block;"></span>
                        </span>
                    @endif
                    @if($entrada->asunto_tec)
                        @php $tecDot = $entrada->detalleTecnico?->tec_realizado ? '#16a34a' : '#eab308'; @endphp
                        <span style="display:inline-flex; align-items:center; gap:3px;">
                            <span style="font-size:11px; color:#6b7280;">Tec</span>
                            <span style="width:9px; height:9px; border-radius:50%; background:{{ $tecDot }}; display:inline-block;"></span>
                        </span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="padding:20px 16px; text-align:center; color:#9ca3af; font-size:12px;">
                    Sin organizaciones registradas aun.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
</div>
{{-- FIN BODY --}}

</x-panel-layout>
