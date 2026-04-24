<x-panel-layout title="Panel Técnico" :elecciones="$elecciones">
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
<div style="position:relative; top:0; z-index:10; margin:-18px -18px 0 -18px; padding:18px 18px 0 18px; background:linear-gradient(135deg, #e8f0f5 0%, #dde8f0 25%, #e5edf5 50%, #dde8f0 75%, #e8f0f5 100%); box-shadow:0 8px 20px rgba(180,180,190,0.3);">
<div style="max-width:1000px; margin:0 auto;">

    {{-- WIDGET PRIORIDADES --}}
    @if($prioridades->count() > 0)
    <div style="background:rgba(255,255,255,0.95); border-radius:14px; border:1px solid rgba(220,38,38,0.2); padding:14px 16px; margin-bottom:14px; box-shadow:0 4px 12px rgba(220,38,38,0.1);">
        <div style="display:flex; align-items:center; gap:8px; margin-bottom:10px;">
            <span style="width:8px; height:8px; border-radius:50%; background:#dc2626; display:inline-block;"></span>
            <span style="font-size:12px; font-weight:600; color:#dc2626; text-transform:uppercase; letter-spacing:0.5px;">Prioridad Área Técnica</span>
            <span style="font-size:11px; color:#9ca3af; margin-left:auto;">{{ $prioridades->count() }}/5 activas</span>
        </div>
        <div style="display:grid; grid-template-columns:repeat({{ min($prioridades->count(), 5) }},1fr); gap:10px;">
            @foreach($prioridades as $i => $p)
            @php
                $ent = $p->entrada;
                $pap = $ent->detalleTecnico?->mat_final_papeletas ?? $ent->detalleTecnico?->cantidad_papeletas ?? '—';
$mesas = $ent->detalleTecnico?->cantidad_mesas ?? 0;
$act = $ent->detalleTecnico?->mat_final_actas ?? ($mesas > 0 ? $mesas * 3 : '—');
$pad = $ent->detalleTecnico?->mat_final_padrones ?? ($mesas > 0 ? $mesas * 3 : '—');
            @endphp
            <a href="{{ route('tecnico.organizacion.edit', $ent->id) }}" style="text-decoration:none;">
            <div style="background:#fff8f8; border:1px solid rgba(220,38,38,0.15); border-radius:10px; padding:10px 12px; transition:box-shadow 0.2s;"
                 onmouseover="this.style.boxShadow='0 4px 12px rgba(220,38,38,0.15)'"
                 onmouseout="this.style.boxShadow='none'">
                <div style="display:flex; align-items:center; gap:6px; margin-bottom:6px;">
                    <span style="font-size:10px; font-weight:700; background:#dc2626; color:#fff; width:18px; height:18px; border-radius:50%; display:inline-flex; align-items:center; justify-content:center;">{{ $i+1 }}</span>
                    <span style="font-size:10px; font-weight:600; color:#dc2626; font-family:monospace;">{{ $ent->codigo_org }}</span>
                </div>
                <p style="font-size:11px; font-weight:600; color:#111827; margin:0 0 4px; line-height:1.3; overflow:hidden; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical;">{{ $ent->nombre_organizacion }}</p>
                <p style="font-size:10px; color:#6b7280; margin:0 0 6px;">{{ $ent->asesor_asignado ?? '—' }}</p>
                <p style="font-size:10px; color:#6b7280; margin:0 0 6px;">📅 {{ $ent->fecha_eleccion?->format('d/m/Y') ?? 'Sin fecha' }}</p>
                <div style="display:flex; gap:6px; flex-wrap:wrap;">
                    <span style="font-size:10px; background:#eff6ff; color:#1d4ed8; padding:2px 6px; border-radius:4px;">Pap: {{ $pap }}</span>
                    <span style="font-size:10px; background:#f0fdf4; color:#15803d; padding:2px 6px; border-radius:4px;">Act: {{ $act }}</span>
                    <span style="font-size:10px; background:#fefce8; color:#854d0e; padding:2px 6px; border-radius:4px;">Pad: {{ $pad }}</span>
                </div>
            </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

    {{-- CARDS --}}
    <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:14px; margin-bottom:14px;">

        {{-- 1. Total técnica --}}
        <div class="card-stat" style="background:linear-gradient(135deg,#E8834A,#F5A623); border-radius:14px; padding:18px 20px; position:relative; overflow:hidden; box-shadow:0 4px 12px rgba(232,131,74,0.35);">
            <div style="position:absolute;top:14px;right:16px;opacity:0.55;">
                <svg width="36" height="36" fill="none" stroke="#fff" stroke-width="1.5" viewBox="0 0 24 24">
                    <path d="M3 21h18M3 10h18M5 6l7-3 7 3M4 10v11M20 10v11M8 14v3M12 14v3M16 14v3"/>
                </svg>
            </div>
            <div style="font-size:11px; color:rgba(255,255,255,0.85); margin-bottom:6px; font-weight:500;">Organizaciones con Técnica</div>
            <div style="font-size:36px; font-weight:700; color:#fff; line-height:1;">{{ $stats['total_tec'] }}</div>
            <span style="display:inline-flex; background:rgba(255,255,255,0.22); border-radius:20px; padding:3px 10px; font-size:10px; color:#fff; margin-top:10px;">en total</span>
        </div>

        {{-- 2. Enviados --}}
        <div class="card-stat" style="background:linear-gradient(135deg,#4A7C59,#6BAF7A); border-radius:14px; padding:18px 20px; position:relative; overflow:hidden; box-shadow:0 4px 12px rgba(74,124,89,0.35);">
            <div style="position:absolute;top:14px;right:16px;opacity:0.55;">
                <svg width="36" height="36" fill="none" stroke="#fff" stroke-width="1.5" viewBox="0 0 24 24">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
            </div>
            <div style="font-size:11px; color:rgba(255,255,255,0.85); margin-bottom:6px; font-weight:500;">Enviados a Técnica</div>
            <div style="font-size:36px; font-weight:700; color:#fff; line-height:1;">{{ $stats['enviados'] }}</div>
            <span style="display:inline-flex; background:rgba(255,255,255,0.22); border-radius:20px; padding:3px 10px; font-size:10px; color:#fff; margin-top:10px;">por el asesor</span>
        </div>

        {{-- 3. Por imprimir --}}
        <div class="card-stat" style="background:linear-gradient(135deg,#5B9EC9,#7BBDE0); border-radius:14px; padding:18px 20px; position:relative; overflow:hidden; box-shadow:0 4px 12px rgba(91,158,201,0.35);">
            <div style="position:absolute;top:14px;right:16px;opacity:0.55;">
                <svg width="36" height="36" fill="none" stroke="#fff" stroke-width="1.5" viewBox="0 0 24 24">
                    <polyline points="6 9 6 2 18 2 18 9"/>
                    <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                    <rect x="6" y="14" width="12" height="8"/>
                </svg>
            </div>
            <div style="font-size:11px; color:rgba(255,255,255,0.85); margin-bottom:6px; font-weight:500;">Por imprimir</div>
            <div style="font-size:36px; font-weight:700; color:#fff; line-height:1;">{{ $stats['por_imprimir'] }}</div>
            <span style="display:inline-flex; background:rgba(255,255,255,0.22); border-radius:20px; padding:3px 10px; font-size:10px; color:#fff; margin-top:10px;">listos para imprimir</span>
        </div>

        {{-- 4. Impresos --}}
        <div class="card-stat" style="background:linear-gradient(135deg,#7A8A95,#9BAAB5); border-radius:14px; padding:18px 20px; position:relative; overflow:hidden; box-shadow:0 4px 12px rgba(46,107,138,0.35);">
            <div style="position:absolute;top:14px;right:16px;opacity:0.55;">
                <svg width="36" height="36" fill="none" stroke="#fff" stroke-width="1.5" viewBox="0 0 24 24">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <polyline points="9 15 12 18 15 15"/>
                </svg>
            </div>
            <div style="font-size:11px; color:rgba(255,255,255,0.85); margin-bottom:6px; font-weight:500;">Impresos</div>
            <div style="font-size:36px; font-weight:700; color:#fff; line-height:1;">{{ $stats['impresos'] }}</div>
            <span style="display:inline-flex; background:rgba(255,255,255,0.22); border-radius:20px; padding:3px 10px; font-size:10px; color:#fff; margin-top:10px;">completados</span>
        </div>

        {{-- 5. Sin fecha --}}
        <div class="card-stat" style="background:linear-gradient(135deg,#8A6B2E,#B59040); border-radius:14px; padding:18px 20px; position:relative; overflow:hidden; box-shadow:0 4px 12px rgba(138,107,46,0.35);">
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

        {{-- 6. Pendientes --}}
        <div class="card-stat" style="background:linear-gradient(135deg,#C8A020,#E0BC40); border-radius:14px; padding:18px 20px; position:relative; overflow:hidden; box-shadow:0 4px 12px rgba(200,160,32,0.35);">
            <div style="position:absolute;top:14px;right:16px;opacity:0.55;">
                <svg width="36" height="36" fill="none" stroke="#fff" stroke-width="1.5" viewBox="0 0 24 24">
                    <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>
                </svg>
            </div>
            <div style="font-size:11px; color:rgba(255,255,255,0.85); margin-bottom:6px; font-weight:500;">Trabajo pendiente</div>
            <div style="font-size:36px; font-weight:700; color:#fff; line-height:1;">{{ $stats['pendientes'] }}</div>
            <span style="display:inline-flex; background:rgba(255,255,255,0.22); border-radius:20px; padding:3px 10px; font-size:10px; color:#fff; margin-top:10px;">por resolver</span>
        </div>

    </div>

    {{-- HEADER TABLA --}}
<div style="background:rgba(255,255,255,0.95); border-radius:16px 16px 0 0; border:1px solid rgba(255,255,255,0.9); border-bottom:none;">
    <div style="padding:6px 16px; border-bottom:1px solid #e5e7eb; font-size:13px; font-weight:500; color:#111827; display:flex; justify-content:space-between; align-items:center;">
        Organizaciones recientes
        <div style="display:flex; align-items:center; gap:8px;">
            <form method="GET" action="{{ route('tecnico.dashboard') }}" style="display:flex; align-items:center; gap:6px;">
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
                    <a href="{{ route('tecnico.dashboard') }}" style="font-size:12px; color:#6b7280; text-decoration:none;">✕</a>
                @endif
            </form>
            <a href="{{ route('tecnico.organizaciones') }}" style="font-size:12px; color:#1f0566; text-decoration:none;">Ver todas</a>
        </div>
    </div>
    <table style="width:100%; border-collapse:collapse;">
        <thead>
            <tr style="background:rgba(100,150,200,0.2);">
    <th style="padding:5px 10px; text-align:left; color:#374151; font-weight:500; font-size:12px; width:120px;">Codigo</th>
    <th style="padding:5px 10px; text-align:left; color:#374151; font-weight:500; font-size:12px;">Organizacion</th>
    <th style="padding:5px 10px; text-align:left; color:#374151; font-weight:500; font-size:12px; width:120px;">Asesor</th>
    <th style="padding:5px 1px; text-align:left; color:#374151; font-weight:500; font-size:12px; width:100px;">Asunto</th>
    <th style="padding:5px 4px; text-align:left; color:#374151; font-weight:500; font-size:12px; width:120px;">Estado</th>
</tr>
        </thead>
    </table>
</div>

</div>
</div>

{{-- BODY --}}
<div style="max-width:1000px; margin:0 auto;">
<div style="background:rgba(255,255,255,0.75); backdrop-filter:blur(12px); border:1px solid rgba(255,255,255,0.9); border-top:none; border-radius:0 0 16px 16px; box-shadow:0 20px 60px rgba(240,240,241,0.15); margin-bottom:40px;">
    <table style="width:100%; border-collapse:collapse; font-size:11px;">
        <tbody>
            @forelse($entradas as $entrada)
            <tr style="border-bottom:1px solid #f3f4f6;" onmouseover="this.style.background='rgba(232,131,74,0.06)'" onmouseout="this.style.background='transparent'">
                <td style="padding:5px 10px; color:#E8834A; font-weight:600; font-family:monospace; width:120px;">
                    <a href="{{ route('tecnico.organizacion.edit', $entrada->id) }}" style="color:#E8834A; text-decoration:none;">{{ $entrada->codigo_org }}</a>
                </td>
                <td style="padding:5px 10px; color:#111827;">{{ $entrada->nombre_organizacion }}</td>
                <td style="padding:5px 10px; color:#6b7280; width:120px; font-size:11px;">{{ $entrada->asesor_asignado ?? '-' }}</td>
                <td style="padding:5px 1px; color:#111827; font-weight:600; width:100px;">{{ $entrada->asunto_texto }}</td>
                <td style="padding:5px 2px; width:120px;">
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
                <td colspan="4" style="padding:20px 16px; text-align:center; color:#9ca3af; font-size:12px;">
                    No hay organizaciones con técnica aún.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
</div>

</x-panel-layout>
