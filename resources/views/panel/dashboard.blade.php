<x-panel-layout title="Dashboard — Vista general" :elecciones="$elecciones">

{{-- CARDS + HEADER TABLA FIJOS --}}
<div style="position:sticky; top:0; z-index:10; margin:-18px -18px 0 -18px; padding:18px 18px 0 18px; background:linear-gradient(135deg, #e8eaf6 0%, #d4d8f0 25%, #e8d5f0 50%, #d4e8f0 75%, #e8eaf6 100%); box-shadow:0 8px 20px rgba(200,200,220,0.5);">

    {{-- CARDS --}}
    <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:14px; margin-bottom:14px;">

        {{-- 1. Organizaciones activas --}}
        <div style="background:linear-gradient(135deg,#7C6FC4,#D088C0); border-radius:14px; padding:18px 20px; position:relative; overflow:hidden; box-shadow:0 4px 12px rgba(124,111,196,0.35);">
            <div style="position:absolute;top:12px;right:16px;font-size:40px;opacity:0.6;line-height:1;">🏢</div>
            <div style="font-size:11px; color:rgba(255,255,255,0.8); margin-bottom:6px; font-weight:500; letter-spacing:0.3px;">Organizaciones activas</div>
            <div style="font-size:36px; font-weight:700; color:#fff; line-height:1;">{{ $stats['organizaciones'] }}</div>
            <span style="display:inline-flex; background:rgba(255,255,255,0.22); border-radius:20px; padding:3px 10px; font-size:10px; color:#fff; margin-top:10px;">total registradas</span>
        </div>

        {{-- 2. Charlas realizadas --}}
        <div style="background:linear-gradient(135deg,#4ABFB0,#60A8E0); border-radius:14px; padding:18px 20px; position:relative; overflow:hidden; box-shadow:0 4px 12px rgba(74,191,176,0.35);">
            <div style="position:absolute;top:12px;right:16px;font-size:40px;opacity:0.6;line-height:1;">✅</div>
            <div style="font-size:11px; color:rgba(255,255,255,0.8); margin-bottom:6px; font-weight:500; letter-spacing:0.3px;">Charlas realizadas</div>
            <div style="font-size:36px; font-weight:700; color:#fff; line-height:1;">{{ $stats['charlas_realizadas'] }}</div>
            <span style="display:inline-flex; background:rgba(255,255,255,0.22); border-radius:20px; padding:3px 10px; font-size:10px; color:#fff; margin-top:10px;">este mes</span>
        </div>

        {{-- 3. Charlas pendientes --}}
        <div style="background:linear-gradient(135deg,#E87CA0,#F0B080); border-radius:14px; padding:18px 20px; position:relative; overflow:hidden; box-shadow:0 4px 12px rgba(232,124,160,0.35);">
            <div style="position:absolute;top:12px;right:16px;font-size:40px;opacity:0.6;line-height:1;">🕐</div>
            <div style="font-size:11px; color:rgba(255,255,255,0.8); margin-bottom:6px; font-weight:500; letter-spacing:0.3px;">Charlas pendientes</div>
            <div style="font-size:36px; font-weight:700; color:#fff; line-height:1;">{{ $stats['charlas_pendientes'] }}</div>
            <span style="display:inline-flex; background:rgba(255,255,255,0.22); border-radius:20px; padding:3px 10px; font-size:10px; color:#fff; margin-top:10px;">proximas 7 dias</span>
        </div>

        {{-- 4. Elecciones proximas --}}
        <div style="background:linear-gradient(135deg,#5BC8E8,#A090E0); border-radius:14px; padding:18px 20px; position:relative; overflow:hidden; box-shadow:0 4px 12px rgba(91,200,232,0.35);">
            <div style="position:absolute;top:12px;right:16px;font-size:40px;opacity:0.6;line-height:1;">🗳️</div>
            <div style="font-size:11px; color:rgba(255,255,255,0.8); margin-bottom:6px; font-weight:500; letter-spacing:0.3px;">Elecciones proximas</div>
            <div style="font-size:36px; font-weight:700; color:#fff; line-height:1;">{{ $stats['elecciones_proximas'] }}</div>
            <span style="display:inline-flex; background:rgba(255,255,255,0.22); border-radius:20px; padding:3px 10px; font-size:10px; color:#fff; margin-top:10px;">proximos 30 dias</span>
        </div>

        {{-- 5. Sin fecha de eleccion --}}
        <div style="background:linear-gradient(135deg,#9090D0,#D090C0); border-radius:14px; padding:18px 20px; position:relative; overflow:hidden; box-shadow:0 4px 12px rgba(144,144,208,0.35);">
            <div style="position:absolute;top:12px;right:16px;font-size:40px;opacity:0.6;line-height:1;">📅</div>
            <div style="font-size:11px; color:rgba(255,255,255,0.8); margin-bottom:6px; font-weight:500; letter-spacing:0.3px;">Sin fecha de elección</div>
            <div style="font-size:36px; font-weight:700; color:#fff; line-height:1;">{{ $stats['sin_fecha'] }}</div>
            <span style="display:inline-flex; background:rgba(255,255,255,0.22); border-radius:20px; padding:3px 10px; font-size:10px; color:#fff; margin-top:10px;">requieren fecha</span>
        </div>

        {{-- 6. Trabajo tecnico pendiente --}}
        <div style="background:linear-gradient(135deg,#F09060,#F0A0B0); border-radius:14px; padding:18px 20px; position:relative; overflow:hidden; box-shadow:0 4px 12px rgba(240,144,96,0.35);">
            <div style="position:absolute;top:12px;right:16px;font-size:40px;opacity:0.6;line-height:1;">🔧</div>
            <div style="font-size:11px; color:rgba(255,255,255,0.8); margin-bottom:6px; font-weight:500; letter-spacing:0.3px;">Trabajo técnico pendiente</div>
            <div style="font-size:36px; font-weight:700; color:#fff; line-height:1;">{{ $stats['tec_pendientes'] }}</div>
            <span style="display:inline-flex; background:rgba(255,255,255,0.22); border-radius:20px; padding:3px 10px; font-size:10px; color:#fff; margin-top:10px;">por resolver</span>
        </div>

    </div>

    {{-- HEADER TABLA FIJO --}}
    <div style="background:rgba(255,255,255,0.95); border-radius:16px 16px 0 0; border:1px solid rgba(255,255,255,0.9); border-bottom:none;">
        <div style="padding:6px 16px; border-bottom:1px solid #e5e7eb; font-size:13px; font-weight:500; color:#111827; display:flex; justify-content:space-between; align-items:center;">
            Ultimas organizaciones ingresadas
            <a href="{{ route('secretaria.con-nota.index') }}" style="font-size:12px; color:#185FA5; text-decoration:none;">Ver todas</a>
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

{{-- BODY SCROLLEABLE --}}
<div style="background:rgba(255,255,255,0.75); backdrop-filter:blur(12px); -webkit-backdrop-filter:blur(12px); border:1px solid rgba(255,255,255,0.9); border-top:none; border-radius:0 0 16px 16px; box-shadow:0 20px 60px rgba(100,100,180,0.15), 0 8px 20px rgba(100,100,180,0.1); margin-bottom:18px;">
    <table style="width:100%; border-collapse:collapse; font-size:11px;">
        <tbody>
            @forelse($entradas as $entrada)
            <tr style="border-bottom:1px solid #f3f4f6;" onmouseover="this.style.background='rgba(100,100,180,0.06)'" onmouseout="this.style.background='transparent'">
                <td style="padding:5px 10px; color:#185FA5; font-weight:600; font-family:monospace; width:120px;">{{ $entrada->codigo_org }}</td>
                <td style="padding:5px 10px; color:#111827;">{{ $entrada->nombre_organizacion }}</td>
                <td style="padding:5px 10px; color:#6b7280; width:120px;font-size:11.5px;">{{ $entrada->asesor_asignado ?? '-' }}</td>
                <td style="padding:5px 1px; color:#111827; font-weight:600; width:100px;">{{ $entrada->asunto_texto }}</td>
                <td style="padding:5px 2px; width:120px;">
                    @if($entrada->asunto_char)
                        @php $charDot = match($entrada->char_estado ?? 'pendiente') { 'realizada' => '#16a34a', 'cancelada' => '#ea580c', 'vencida' => '#dc2626', default => '#ca8a04' }; @endphp
                        <span style="display:inline-flex; align-items:center; gap:3px; margin-right:6px;">
                            <span style="font-size:11px; color:#6b7280;">Char</span>
                            <span style="width:9px; height:9px; border-radius:50%; background:{{ $charDot }}; display:inline-block;"></span>
                        </span>
                    @endif
                    @if($entrada->asunto_log)
                        @php $logDot = ($entrada->log_estado ?? 'pendiente') === 'entregada' ? '#16a34a' : '#ca8a04'; @endphp
                        <span style="display:inline-flex; align-items:center; gap:3px; margin-right:6px;">
                            <span style="font-size:11px; color:#6b7280;">Log</span>
                            <span style="width:9px; height:9px; border-radius:50%; background:{{ $logDot }}; display:inline-block;"></span>
                        </span>
                    @endif
                    @if($entrada->asunto_tec)
                        @php $tecDot = ($entrada->tec_estado ?? 'pendiente') === 'entregada' ? '#16a34a' : '#ca8a04'; @endphp
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

</x-panel-layout>
