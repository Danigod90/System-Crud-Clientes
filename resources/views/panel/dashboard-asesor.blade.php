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
.add-org-btn {
    position: relative;
    z-index: 1;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 44px;
    height: 44px;
    background: linear-gradient(135deg, #185FA5, #2B4EC8);
    text-decoration: none;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(24,95,165,0.35);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.add-org-btn:hover {
    z-index: 50;
    transform: translateY(-2px);
    box-shadow: 0 8px 18px rgba(24,95,165,0.45);
}
.add-org-btn::after {
    content: "Nueva Organización";
    position: absolute;
    left: 52px;
    top: 50%;
    transform: translateY(-50%);
    background: #111827;
    color: #fff;
    font-size: 11px;
    font-weight: 500;
    padding: 5px 10px;
    border-radius: 6px;
    white-space: nowrap;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.15s ease;
    z-index: 20;
}
.add-org-btn:hover::after {
    opacity: 1;
}
.notes-btn {
    position: relative;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 44px;
    height: 44px;
    background: linear-gradient(135deg, #E0A030, #E8C060);
    border: none;
    cursor: pointer;
    text-decoration: none;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(224,160,48,0.35);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.notes-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 18px rgba(224,160,48,0.45);
}
.notes-btn::after {
    content: "Recordatorios";
    position: absolute;
    left: 52px;
    top: 50%;
    transform: translateY(-50%);
    background: #111827;
    color: #fff;
    font-size: 11px;
    font-weight: 500;
    padding: 5px 10px;
    border-radius: 6px;
    white-space: nowrap;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.15s ease;
    z-index: 20;
}
.notes-btn:hover::after {
    opacity: 1;
}
.notes-wrap { position: relative; z-index: 1; }
.notes-wrap:hover { z-index: 50; }
#notes-panel {
    position: absolute;
    top: 52px;
    left: 0;
    width: 260px;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 12px 30px rgba(0,0,0,0.18);
    border: 1px solid #f0e0c0;
    padding: 12px;
    z-index: 30;
    display: none;
}
#notes-panel.open { display: block; }
#notes-panel textarea {
    width: 100%;
    resize: none;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 6px 8px;
    font-size: 12px;
    font-family: inherit;
    outline: none;
    box-sizing: border-box;
}
#notes-panel textarea:focus { border-color: #E0A030; }
#notes-list { max-height: 180px; overflow-y: auto; margin-top: 8px; display: flex; flex-direction: column; gap: 6px; }
.nota-item {
    background: #fdf6e8;
    border-radius: 8px;
    padding: 6px 8px;
    font-size: 11.5px;
    color: #4b3b0f;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 6px;
    word-break: break-word;
}
.nota-item button {
    background: none;
    border: none;
    color: #b45309;
    cursor: pointer;
    font-size: 12px;
    line-height: 1;
    flex-shrink: 0;
}
#notes-hover-preview {
    position: absolute;
    top: 52px;
    left: 0;
    width: 220px;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 12px 30px rgba(0,0,0,0.18);
    border: 1px solid #f0e0c0;
    padding: 10px;
    z-index: 25;
    display: none;
    max-height: 200px;
    overflow-y: auto;
}
.notes-wrap:hover #notes-hover-preview.has-notes { display: block; }
.notes-wrap.panel-open #notes-hover-preview { display: none !important; }
.nota-preview-item {
    background: #fdf6e8;
    border-radius: 8px;
    padding: 6px 8px;
    font-size: 11px;
    color: #4b3b0f;
    margin-bottom: 6px;
    word-break: break-word;
}
.nota-preview-item:last-child { margin-bottom: 0; }
</style>

{{-- CARDS + HEADER TABLA FIJOS --}}
<div style="position:relative; top:0; z-index:10; margin:-18px -18px 0 -18px; padding:18px 18px 0 18px; background:linear-gradient(135deg, #e8f0f5 0%, #dde8f0 25%, #e5edf5 50%, #dde8f0 75%, #e8f0f5 100%); box-shadow:0 8px 20px rgba(180,180,190,0.3);">

    {{-- BOTON NUEVA ORGANIZACION + RECORDATORIOS (flotando en el margen izquierdo) --}}
    <div style="position:absolute; left:24px; top:18px; z-index:15; display:flex; flex-direction:column; gap:10px;">
        <a href="{{ route('secretaria.con-nota.create') }}" class="add-org-btn">
            <svg width="19" height="19" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                <polyline points="14 2 14 8 20 8"/>
                <line x1="12" y1="18" x2="12" y2="12"/>
                <line x1="9" y1="15" x2="15" y2="15"/>
            </svg>
        </a>

        <div class="notes-wrap">
            <button type="button" class="notes-btn" onclick="toggleNotesPanel()">
                <svg width="19" height="19" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 2h6a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2H9a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2z"/>
                    <line x1="9" y1="7" x2="15" y2="7"/>
                    <line x1="9" y1="11" x2="15" y2="11"/>
                    <line x1="9" y1="15" x2="12" y2="15"/>
                </svg>
            </button>
            <div id="notes-hover-preview">
                <div id="notes-hover-list"></div>
            </div>
        </div>

        <div id="notes-panel">
            <textarea id="nota-input" rows="2" maxlength="1000" placeholder="Escribe un recordatorio..."></textarea>
            <button type="button" onclick="agregarNota()" style="margin-top:6px; width:100%; background:#E0A030; color:#fff; border:none; border-radius:8px; padding:6px 0; font-size:11.5px; font-weight:600; cursor:pointer;">Agregar</button>
            <div id="notes-list"></div>
        </div>
    </div>

<div style="max-width:1000px; margin:0 auto;">

    {{-- WIDGET PRIORIDADES TÉCNICA --}}
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
            <div style="background:#fff8f8; border:1px solid rgba(220,38,38,0.15); border-radius:10px; padding:10px 12px;">
                <div style="display:flex; align-items:center; gap:6px; margin-bottom:6px;">
                    <span style="font-size:10px; font-weight:700; background:#dc2626; color:#fff; width:18px; height:18px; border-radius:50%; display:inline-flex; align-items:center; justify-content:center;">{{ $i+1 }}</span>
                    <span style="font-size:10px; font-weight:600; color:#dc2626; font-family:monospace;">{{ $ent->codigo_org }}</span>
                </div>
                <p style="font-size:11px; font-weight:600; color:#111827; margin:0 0 4px; line-height:1.3; overflow:hidden; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical;">{{ $ent->nombre_organizacion }}</p>
                <p style="font-size:10px; color:#6b7280; margin:0 0 4px;">{{ $ent->asesor_asignado ?? '—' }}</p>
                <p style="font-size:10px; color:#6b7280; margin:0 0 6px;">📅 {{ $ent->fecha_eleccion?->format('d/m/Y') ?? 'Sin fecha' }}</p>
                <div style="display:flex; gap:6px; flex-wrap:wrap;">
                    <span style="font-size:10px; background:#eff6ff; color:#1d4ed8; padding:2px 6px; border-radius:4px;">Pap: {{ $pap }}</span>
                    <span style="font-size:10px; background:#f0fdf4; color:#15803d; padding:2px 6px; border-radius:4px;">Act: {{ $act }}</span>
                    <span style="font-size:10px; background:#fefce8; color:#854d0e; padding:2px 6px; border-radius:4px;">Pad: {{ $pad }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- CARDS --}}
   <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:16px; margin-bottom:24px;">

    <a href="{{ route('asesor.mis-organizaciones') }}" style="text-decoration:none;">
<div class="card-stat" style="background:#eab308; border-radius:12px; padding:20px; color:white; cursor:pointer; transition:opacity 0.2s;" onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">
    <div style="display:flex; justify-content:space-between; align-items:flex-start;">
            <div>
                <div style="font-size:13px; font-weight:500; margin-bottom:8px;">Mis organizaciones</div>
                <div style="font-size:36px; font-weight:700; line-height:1;">{{ $stats['organizaciones']}}</div>
            </div>
            <svg width="32" height="32" fill="none" stroke="rgba(255,255,255,0.7)" stroke-width="1.5" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
        </div>
        <span style="display:inline-block; background:rgba(0,0,0,0.15); font-size:11px; padding:2px 10px; border-radius:20px; margin-top:10px;">asignadas</span>
    </div>
    </a>

    <a href="{{ route('asesor.mis-organizaciones') }}?asunto=obs" style="text-decoration:none;">
    <div class="card-stat" style="background:#16a34a; border-radius:12px; padding:20px; color:white; cursor:pointer; transition:opacity 0.2s;" onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">
        <div style="display:flex; justify-content:space-between; align-items:flex-start;">
            <div>
                <div style="font-size:13px; font-weight:500; margin-bottom:8px;">Observadores pendientes</div>
                <div style="font-size:36px; font-weight:700; line-height:1;">{{ $stats['obs_pendientes'] }}</div>
            </div>
            <svg width="32" height="32" fill="none" stroke="rgba(255,255,255,0.7)" stroke-width="1.5" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        </div>
        <span style="display:inline-block; background:rgba(0,0,0,0.15); font-size:11px; padding:2px 10px; border-radius:20px; margin-top:10px;">sin realizar</span>
    </div>
    </a>

    <a href="{{ route('asesor.mis-organizaciones') }}?asunto=char_pendiente" style="text-decoration:none;">
    <div class="card-stat" style="background:#60a5fa; border-radius:12px; padding:20px; color:white; cursor:pointer;" onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">
        <div style="display:flex; justify-content:space-between; align-items:flex-start;">
            <div>
                <div style="font-size:13px; font-weight:500; margin-bottom:8px;">Charlas pendientes</div>
                <div style="font-size:36px; font-weight:700; line-height:1;">{{ $stats['charlas_pendientes'] }}</div>
            </div>
            <svg width="32" height="32" fill="none" stroke="rgba(255,255,255,0.7)" stroke-width="1.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        </div>
        <span style="display:inline-block; background:rgba(0,0,0,0.15); font-size:11px; padding:2px 10px; border-radius:20px; margin-top:10px;">sin realizar</span>
    </div>
    </a>

    <a href="{{ route('asesor.mis-organizaciones') }}?asunto=tec_sin_enviar" style="text-decoration:none;">
<div class="card-stat" style="background:#d97706; border-radius:12px; padding:20px; color:white; cursor:pointer;" onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">
    <div style="display:flex; justify-content:space-between; align-items:flex-start;">
        <div>
            <div style="font-size:13px; font-weight:500; margin-bottom:8px;">Sin enviar a técnica</div>
            <div style="font-size:36px; font-weight:700; line-height:1;">{{ $stats['sin_enviar_tec'] }}</div>
        </div>
        <svg width="32" height="32" fill="none" stroke="rgba(255,255,255,0.7)" stroke-width="1.5" viewBox="0 0 24 24"><path d="M22 2L11 13"/><path d="M22 2l-7 20-4-9-9-4 20-7z"/></svg>
    </div>
    <span style="display:inline-block; background:rgba(0,0,0,0.15); font-size:11px; padding:2px 10px; border-radius:20px; margin-top:10px;">se olvidaron de enviar</span>
</div>
</a>

    <a href="{{ route('asesor.mis-organizaciones') }}?sin_fecha=1" style="text-decoration:none;">
    <div class="card-stat" style="background:#1e3a5f; border-radius:12px; padding:20px; color:white; cursor:pointer;" onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">
        <div style="display:flex; justify-content:space-between; align-items:flex-start;">
            <div>
                <div style="font-size:13px; font-weight:500; margin-bottom:8px;">Sin fecha de elección</div>
                <div style="font-size:36px; font-weight:700; line-height:1;">{{ $stats['sin_fecha'] }}</div>
            </div>
            <svg width="32" height="32" fill="none" stroke="rgba(255,255,255,0.7)" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        </div>
        <span style="display:inline-block; background:rgba(0,0,0,0.15); font-size:11px; padding:2px 10px; border-radius:20px; margin-top:10px;">requieren fecha</span>
    </div>
    </a>

<a href="{{ route('asesor.mis-organizaciones') }}?asunto=tec_pendiente" style="text-decoration:none;">
        <div class="card-stat" style="background:#dc2626; border-radius:12px; padding:20px; color:white; cursor:pointer;" onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">
        <div style="display:flex; justify-content:space-between; align-items:flex-start;">
            <div>
                <div style="font-size:13px; font-weight:500; margin-bottom:8px;">Trabajo técnico pendiente</div>
                <div style="font-size:36px; font-weight:700; line-height:1;">{{ $stats['tec_pendientes'] }}</div>
            </div>
            <svg width="32" height="32" fill="none" stroke="rgba(255,255,255,0.7)" stroke-width="1.5" viewBox="0 0 24 24"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
        </div>
        <span style="display:inline-block; background:rgba(0,0,0,0.15); font-size:11px; padding:2px 10px; border-radius:20px; margin-top:10px;">por resolver</span>
    </div>
    </a>

</div>

    {{-- HEADER TABLA FIJO --}}
    <div style="background:rgba(255,255,255,0.95); border-radius:16px 16px 0 0; border:1px solid rgba(255,255,255,0.9); border-bottom:none;">
        <div style="padding:6px 16px; border-bottom:1px solid #e5e7eb; font-size:13px; font-weight:500; color:#111827; display:flex; justify-content:space-between; align-items:center;">
            Mis organizaciones
<a href="{{ route('asesor.mis-organizaciones') }}" style="font-size:12px; color:#1f0566; text-decoration:none;">Ver todas</a>        </div>
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
{{-- Total entradas: {{ count($entradas) }} --}}
<div style="background:rgba(255,255,255,0.75); backdrop-filter:blur(12px); -webkit-backdrop-filter:blur(12px); border:1px solid rgba(255,255,255,0.9); border-top:none; border-radius:0 0 16px 16px; box-shadow:0 20px 60px rgba(240, 240, 241, 0.15), 0 8px 20px rgba(234, 234, 241, 0.1); margin-bottom:40px;">
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
                <td colspan="4" style="padding:20px 16px; text-align:center; color:#9ca3af; font-size:12px;">
                    No tenés organizaciones asignadas aún.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
</div>

<script>
function escapeHtml(str) {
    const div = document.createElement('div');
    div.textContent = str;
    return div.innerHTML;
}

let notasCache = null;

function toggleNotesPanel() {
    const panel = document.getElementById('notes-panel');
    const wrap = document.querySelector('.notes-wrap');
    const abrir = !panel.classList.contains('open');
    panel.classList.toggle('open');
    wrap.classList.toggle('panel-open', abrir);
    if (abrir) cargarNotas();
}

document.addEventListener('click', function(e) {
    const panel = document.getElementById('notes-panel');
    const wrap = document.querySelector('.notes-wrap');
    const btn = document.querySelector('.notes-btn');
    if (panel.classList.contains('open') && !panel.contains(e.target) && e.target !== btn && !btn.contains(e.target)) {
        panel.classList.remove('open');
        wrap.classList.remove('panel-open');
    }
});

function renderNotasEnLista(elId, notas, conBoton) {
    const el = document.getElementById(elId);
    if (!notas || notas.length === 0) {
        el.innerHTML = '<div style="font-size:11px; color:#9ca3af; text-align:center; padding:6px 0;">Sin recordatorios.</div>';
        return;
    }
    el.innerHTML = notas.map(n => conBoton ? `
        <div class="nota-item">
            <span>${escapeHtml(n.contenido)}</span>
            <button onclick="eliminarNota(${n.id})" title="Eliminar">✕</button>
        </div>
    ` : `
        <div class="nota-preview-item">${escapeHtml(n.contenido)}</div>
    `).join('');
}

function cargarNotas() {
    fetch('/notas')
        .then(r => {
            if (!r.ok) throw new Error('HTTP ' + r.status);
            return r.json();
        })
        .then(data => {
            notasCache = data.notas || [];
            renderNotasEnLista('notes-list', notasCache, true);
            renderNotasEnLista('notes-hover-list', notasCache, false);
            const preview = document.getElementById('notes-hover-preview');
            preview.classList.toggle('has-notes', notasCache.length > 0);
        })
        .catch(err => {
            console.error('Error cargando notas:', err);
            document.getElementById('notes-list').innerHTML = '<div style="font-size:11px; color:#dc2626; text-align:center; padding:6px 0;">Error al cargar (' + err.message + ')</div>';
        });
}

document.querySelector('.notes-wrap').addEventListener('mouseenter', function() {
    if (notasCache === null) cargarNotas();
});

document.addEventListener('DOMContentLoaded', cargarNotas);

function agregarNota() {
    const input = document.getElementById('nota-input');
    const contenido = input.value.trim();
    if (!contenido) return;
    fetch('/notas', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ contenido })
    })
    .then(async r => {
        const data = await r.json().catch(() => ({}));
        if (!r.ok) throw new Error(data.error || ('HTTP ' + r.status));
        return data;
    })
    .then(() => {
        input.value = '';
        cargarNotas();
    })
    .catch(err => {
        console.error('Error guardando nota:', err);
        alert(err.message);
    });
}

function eliminarNota(id) {
    fetch('/notas/' + id, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(r => {
        if (!r.ok) throw new Error('HTTP ' + r.status);
        return r.json();
    })
    .then(() => cargarNotas())
    .catch(err => {
        console.error('Error eliminando nota:', err);
        alert('No se pudo eliminar (' + err.message + ').');
    });
}
</script>

</x-panel-layout>
