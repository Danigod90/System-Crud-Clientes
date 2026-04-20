<x-panel-layout title="Panel General" :elecciones="$elecciones" :charlasPendientes="$charlasPendientes">
<div style="display:none">CHARLAS_COUNT:{{ $charlasPendientes->count() }}</div>
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
<div style="position:relative; top:0; z-index:10; margin:-18px -18px 0 -18px; padding:18px 18px 0 18px; background:linear-gradient(135deg, #e8f0f5 0%, #dde8f0 25%, #e5edf5 50%, #dde8f0 75%, #e8f0f5 100%); box-shadow:0 8px 20px rgba(180,180,190,0.3);">
<div style="max-width:1000px; margin:0 auto;">

    {{-- CARDS --}}
    <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:14px; margin-bottom:14px;">

        {{-- 1. Organizaciones activas --}}
        <div class="card-stat" style="background:linear-gradient(135deg,#E8834A,#F5A623); border-radius:14px; padding:18px 20px; position:relative; overflow:hidden; box-shadow:0 4px 12px rgba(232,131,74,0.35);">
            <div style="position:absolute;top:14px;right:16px;opacity:0.55;">
                <svg width="36" height="36" fill="none" stroke="#fff" stroke-width="1.5" viewBox="0 0 24 24">
                    <path d="M3 21h18M3 10h18M5 6l7-3 7 3M4 10v11M20 10v11M8 14v3M12 14v3M16 14v3"/>
                </svg>
            </div>
            <div style="font-size:11px; color:rgba(255,255,255,0.85); margin-bottom:6px; font-weight:500;">Mis organizaciones</div>
            <div style="font-size:36px; font-weight:700; color:#fff; line-height:1;">{{ $stats['organizaciones'] }}</div>
            <span style="display:inline-flex; background:rgba(255,255,255,0.22); border-radius:20px; padding:3px 10px; font-size:10px; color:#fff; margin-top:10px;">asignadas</span>
        </div>

        {{-- 2. Observadores pendientes --}}
        <div class="card-stat" style="background:linear-gradient(135deg,#4A7C59,#6BAF7A); border-radius:14px; padding:18px 20px; position:relative; overflow:hidden; box-shadow:0 4px 12px rgba(74,124,89,0.35);">
            <div style="position:absolute;top:14px;right:16px;opacity:0.55;">
                <svg width="36" height="36" fill="none" stroke="#fff" stroke-width="1.5" viewBox="0 0 24 24">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
            </div>
            <div style="font-size:11px; color:rgba(255,255,255,0.85); margin-bottom:6px; font-weight:500;">Observadores pendientes</div>
            <div style="font-size:36px; font-weight:700; color:#fff; line-height:1;">{{ $stats['obs_pendientes'] }}</div>
            <span style="display:inline-flex; background:rgba(255,255,255,0.22); border-radius:20px; padding:3px 10px; font-size:10px; color:#fff; margin-top:10px;">sin realizar</span>
        </div>

        {{-- 3. Charlas pendientes --}}
        <div class="card-stat" style="background:linear-gradient(135deg,#5B9EC9,#7BBDE0); border-radius:14px; padding:18px 20px; position:relative; overflow:hidden; box-shadow:0 4px 12px rgba(196,112,74,0.35);">
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

        {{-- 4. Borrador privado --}}
        <div class="card-stat" style="background:linear-gradient(135deg,#7A8A95,#9BAAB5); border-radius:14px; padding:18px 20px; position:relative; overflow:hidden; box-shadow:0 4px 12px rgba(46,107,138,0.35);">
            <div style="position:absolute;top:14px;right:16px;opacity:0.55;">
                <svg width="36" height="36" fill="none" stroke="#fff" stroke-width="1.5" viewBox="0 0 24 24">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/>
                    <line x1="16" y1="17" x2="8" y2="17"/>
                    <polyline points="10 9 9 9 8 9"/>
                </svg>
            </div>
            <div style="font-size:11px; color:rgba(255,255,255,0.85); margin-bottom:6px; font-weight:500;">Borrador privado</div>
            <div style="font-size:36px; font-weight:700; color:#fff; line-height:1;">{{ $stats['borradores'] }}</div>
            <span style="display:inline-flex; background:rgba(255,255,255,0.22); border-radius:20px; padding:3px 10px; font-size:10px; color:#fff; margin-top:10px;">mis borradores</span>
        </div>

        {{-- 5. Sin fecha de eleccion --}}
        <div class="card-stat" style="background:linear-gradient(135deg,#1A3A5C,#2E5F8A); border-radius:14px; padding:18px 20px; position:relative; overflow:hidden; box-shadow:0 4px 12px rgba(138,107,46,0.35);">
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
        <div class="card-stat" style="background:linear-gradient(135deg,#8B1A2A,#B5263A); border-radius:14px; padding:18px 20px; position:relative; overflow:hidden; box-shadow:0 4px 12px rgba(122,74,46,0.35);">
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
            Mis organizaciones
            <a href="{{ route('asesor.mis-organizaciones') }}" style="font-size:12px; color:#1f0566; text-decoration:none;">Ver todas</a>
        </div>
        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="background:rgba(100,150,200,0.2);">
                    <th style="padding:5px 10px; text-align:left; color:#374151; font-weight:500; font-size:12px; width:120px;">Codigo</th>
                    <th style="padding:5px 10px; text-align:left; color:#374151; font-weight:500; font-size:12px;">Organizacion</th>
                    <th style="padding:2px 10px; text-align:left; color:#374151; font-weight:500; font-size:12px; width:80px; white-space:nowrap;">Fecha Elección</th>
                    <th style="padding:5px 1px; text-align:left; color:#374151; font-weight:500; font-size:12px; width:100px;">Asunto</th>
                    <th style="padding:5px 4px; text-align:left; color:#374151; font-weight:500; font-size:12px; width:120px;">Estado</th>
                </tr>
            </thead>
        </table>
    </div>

</div>
</div>
{{-- FIN STICKY --}}

{{-- BODY SCROLLEABLE --}}
<div style="max-width:1000px; margin:0 auto;">
<div style="background:rgba(255,255,255,0.75); backdrop-filter:blur(12px); -webkit-backdrop-filter:blur(12px); border:1px solid rgba(255,255,255,0.9); border-top:none; border-radius:0 0 16px 16px; box-shadow:0 20px 60px rgba(240,240,241,0.15), 0 8px 20px rgba(234,234,241,0.1); margin-bottom:40px;">
    <table style="width:100%; border-collapse:collapse; font-size:11px;">
        <tbody>
            @forelse($entradas as $entrada)
            <tr style="border-bottom:1px solid #f3f4f6;" onmouseover="this.style.background='rgba(232,131,74,0.06)'" onmouseout="this.style.background='transparent'">
                <td style="padding:5px 10px; color:#E8834A; font-weight:600; font-family:monospace; width:120px;">{{ $entrada->codigo_org }}</td>
                <td style="padding:5px 10px; color:#111827;">{{ $entrada->nombre_organizacion }}</td>
                <td style="padding:5px 10px; color:#6b7280; width:100px; font-size:11px;">
                    {{ $entrada->fecha_eleccion?->format('d/m/Y') ?? '—' }}
                </td>
                <td style="padding:5px 1px; color:#111827; font-weight:600; width:100px;">{{ $entrada->asunto_texto }}</td>
                <td style="padding:5px 2px; width:120px;">
                    @if($entrada->asunto_char)
                        <span style="display:inline-flex; align-items:center; gap:3px; margin-right:6px;">
                            <span style="font-size:11px; color:#6b7280;">Char</span>
                            @foreach($entrada->charlas as $i => $ch)
                                @php $charDot = match($ch->estado) { 'realizada' => '#16a34a', 'cancelada' => '#dc2626', 'suspendida' => '#f97316', 'vencida' => '#dc2626', default => '#eab308' }; @endphp
                                <span style="width:9px; height:9px; border-radius:50%; background:{{ $charDot }}; display:inline-block;"></span>
                                <sup style="font-size:8px; color:#6b7280;">{{ $i+1 }}</sup>
                            @endforeach
                            @if($entrada->charlas->isEmpty())
                                <span style="width:9px; height:9px; border-radius:50%; background:#eab308; display:inline-block;"></span>
                            @endif
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
                    No tenés organizaciones asignadas aún.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
</div>

</x-panel-layout>
