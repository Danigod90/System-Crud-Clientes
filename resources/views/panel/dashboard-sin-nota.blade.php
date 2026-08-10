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
    content: "Nueva Entrada";
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

<div style="max-width:1000px; margin:0 auto; padding:0;">

    {{-- BOTON NUEVA ENTRADA + RECORDATORIOS --}}
    <div style="display:flex; gap:10px; margin-bottom:8px; position:relative;">
        <a href="{{ route('secretaria.sin-nota.create') }}" class="add-org-btn">
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

    {{-- CARDS --}}
    <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:14px; margin-bottom:20px;">

        {{-- 1. Entradas del mes --}}
        <div class="card-stat" style="background:linear-gradient(135deg,#7C6FC4,#D088C0); border-radius:14px; padding:18px 20px; position:relative; overflow:hidden; box-shadow:0 4px 12px rgba(124,111,196,0.35);">
            <div style="position:absolute;top:14px;right:16px;opacity:0.55;">
                <svg width="36" height="36" fill="none" stroke="#fff" stroke-width="1.5" viewBox="0 0 24 24">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/>
                    <line x1="16" y1="17" x2="8" y2="17"/>
                    <polyline points="10 9 9 9 8 9"/>
                </svg>
            </div>
            <div style="font-size:11px; color:rgba(255,255,255,0.85); margin-bottom:6px; font-weight:500;">Entradas del mes</div>
            <div style="font-size:36px; font-weight:700; color:#fff; line-height:1;">{{ $stats['entradas_mes'] }}</div>
            <span style="display:inline-flex; background:rgba(255,255,255,0.22); border-radius:20px; padding:3px 10px; font-size:10px; color:#fff; margin-top:10px;">{{ now()->translatedFormat('F Y') }}</span>
        </div>

        {{-- 2. Log pendientes --}}
        <div class="card-stat" style="background:linear-gradient(135deg,#F09060,#F0C040); border-radius:14px; padding:18px 20px; position:relative; overflow:hidden; box-shadow:0 4px 12px rgba(240,144,96,0.35);">
            <div style="position:absolute;top:14px;right:16px;opacity:0.55;">
                <svg width="36" height="36" fill="none" stroke="#fff" stroke-width="1.5" viewBox="0 0 24 24">
                    <path d="M21 10H3M21 6H3M21 14H3M21 18H3"/>
                </svg>
            </div>
            <div style="font-size:11px; color:rgba(255,255,255,0.85); margin-bottom:6px; font-weight:500;">Log pendientes</div>
            <div style="font-size:36px; font-weight:700; color:#fff; line-height:1;">{{ $stats['log_pendientes'] }}</div>
            <span style="display:inline-flex; background:rgba(255,255,255,0.22); border-radius:20px; padding:3px 10px; font-size:10px; color:#fff; margin-top:10px;">sin entregar</span>
        </div>

        {{-- 3. Log devueltos --}}
        <div class="card-stat" style="background:linear-gradient(135deg,#4ABFB0,#60A8E0); border-radius:14px; padding:18px 20px; position:relative; overflow:hidden; box-shadow:0 4px 12px rgba(74,191,176,0.35);">
            <div style="position:absolute;top:14px;right:16px;opacity:0.55;">
                <svg width="36" height="36" fill="none" stroke="#fff" stroke-width="1.5" viewBox="0 0 24 24">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
            </div>
            <div style="font-size:11px; color:rgba(255,255,255,0.85); margin-bottom:6px; font-weight:500;">Log devueltos</div>
            <div style="font-size:36px; font-weight:700; color:#fff; line-height:1;">{{ $stats['log_devueltos'] }}</div>
            <span style="display:inline-flex; background:rgba(255,255,255,0.22); border-radius:20px; padding:3px 10px; font-size:10px; color:#fff; margin-top:10px;">materiales recuperados</span>
        </div>

    </div>

    {{-- LOG PENDIENTES TABLA --}}
    <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; overflow:hidden; box-shadow:0 1px 4px rgba(0,0,0,0.04); margin-bottom:14px;">
        <div style="padding:12px 16px; border-bottom:1px solid #f3f4f6; display:flex; justify-content:space-between; align-items:center;">
            <span style="font-size:13px; font-weight:600; color:#374151;">Log pendientes de devolución</span>
            <a href="{{ route('secretaria.sin-nota.log') }}" style="font-size:12px; color:#2563eb; text-decoration:none;">Ver todos →</a>
        </div>
        <table style="width:100%; border-collapse:collapse; font-size:12px;">
            <thead>
                <tr style="background:#f8fafc;">
                    <th style="padding:8px 16px; text-align:left; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Código</th>
                    <th style="padding:8px 16px; text-align:left; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Organización</th>
                    <th style="padding:8px 16px; text-align:left; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Urnas</th>
                    <th style="padding:8px 16px; text-align:left; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Cuartos</th>
                    <th style="padding:8px 16px; text-align:left; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Tintas</th>
                    <th style="padding:8px 16px; text-align:left; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;"></th>
                </tr>
            </thead>
            <tbody>
                @php
                    $logPendientes = \App\Models\EntradaConNota::where('asunto_log', true)
    ->where('log_estado', 'entregada')
    ->latest()->take(5)->get();
                @endphp
                @forelse($logPendientes as $entrada)
                <tr style="border-bottom:1px solid #f3f4f6;">
                    <td style="padding:10px 16px; color:#185FA5; font-weight:600; font-family:monospace;">{{ $entrada->codigo_org }}</td>
                    <td style="padding:10px 16px; color:#1e293b;">{{ $entrada->nombre_organizacion }}</td>
                    <td style="padding:10px 16px; color:#374151;">{{ $entrada->log_urnas }}</td>
                    <td style="padding:10px 16px; color:#374151;">{{ $entrada->log_cuartos }}</td>
                    <td style="padding:10px 16px; color:#374151;">{{ $entrada->log_tintas }}</td>
                    <td style="padding:10px 16px;">
                        <a href="{{ route('secretaria.sin-nota.log') }}"
                           style="font-size:12px; color:#2563eb; text-decoration:none; font-weight:500;">Ver →</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding:30px; text-align:center; color:#94a3b8; font-size:13px;">
                        ✅ No hay log pendientes de devolución.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ENTRADAS SIN NOTA RECIENTES --}}
    <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; overflow:hidden; box-shadow:0 1px 4px rgba(0,0,0,0.04);">
        <div style="padding:12px 16px; border-bottom:1px solid #f3f4f6; display:flex; justify-content:space-between; align-items:center;">
            <span style="font-size:13px; font-weight:600; color:#374151;">Últimas entradas sin nota</span>
            <a href="{{ route('secretaria.sin-nota.index') }}" style="font-size:12px; color:#2563eb; text-decoration:none;">Ver todas →</a>
        </div>
        <table style="width:100%; border-collapse:collapse; font-size:12px;">
            <thead>
                <tr style="background:#f8fafc;">
                    <th style="padding:8px 16px; text-align:left; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">N° Entrada</th>
                    <th style="padding:8px 16px; text-align:left; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Nombre</th>
                    <th style="padding:8px 16px; text-align:left; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Apellido</th>
                    <th style="padding:8px 16px; text-align:left; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Asesor</th>
                    <th style="padding:8px 16px; text-align:left; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Fecha</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $ultimasEntradas = \App\Models\EntradaSinNota::with('asesor')->latest()->take(5)->get();
                @endphp
                @forelse($ultimasEntradas as $entrada)
                <tr style="border-bottom:1px solid #f3f4f6;">
                    <td style="padding:10px 16px; color:#6b7280; font-weight:600; font-family:monospace;">{{ $entrada->numero_entrada }}</td>
                    <td style="padding:10px 16px; color:#1e293b; font-weight:500;">{{ $entrada->nombre }}</td>
                    <td style="padding:10px 16px; color:#374151;">{{ $entrada->apellido }}</td>
                    <td style="padding:10px 16px; color:#374151;">{{ $entrada->asesor ? $entrada->asesor->nombre . ' ' . $entrada->asesor->apellido : '—' }}</td>
                    <td style="padding:10px 16px; color:#94a3b8;">{{ $entrada->created_at->format('d/m/Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding:30px; text-align:center; color:#94a3b8; font-size:13px;">
                        No hay entradas registradas.
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
