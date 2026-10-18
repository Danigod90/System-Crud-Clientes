{{-- Modal "Log de Urgencia": buscar cualquier organización con asunto log
     (tenga o no también tec) que todavía no fue entregada, cargarle rápido
     urnas/cuartos/tintas + datos de quien retira, y pasar directo al
     recibo listo para imprimir. Pensado para cuando alguien viene a
     retirar materiales y el asesor todavía no cargó nada en el sistema. --}}

<div id="modal-urgencia-buscar" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.4); z-index:9998; align-items:center; justify-content:center;">
    <div style="background:white; border-radius:12px; padding:24px; max-width:620px; width:92%; max-height:85vh; display:flex; flex-direction:column; box-shadow:0 20px 60px rgba(0,0,0,0.3);">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:4px;">
            <h3 style="font-size:15px; font-weight:700; color:#1e293b; margin:0;">📦 Entrega de Log</h3>
            <button type="button" onclick="cerrarUrgencia()" style="background:none; border:none; font-size:18px; color:#9ca3af; cursor:pointer; line-height:1;">✕</button>
        </div>
        <p style="font-size:12px; color:#64748b; margin:2px 0 14px;">Buscá la organización para cargar rápido los materiales logísticos e imprimir el recibo. Funciona exclusivamente para asunto log "pendientes".</p>

        <div style="display:flex; gap:8px; margin-bottom:12px;">
            <input type="text" id="urgencia-buscar-input" placeholder="Buscar por nombre o código de organización..." autocomplete="off"
                   style="flex:1; border:1px solid #e5e7eb; border-radius:8px; padding:9px 12px; font-size:13px; outline:none; box-sizing:border-box;">
            <select id="urgencia-filtro-asesor" style="border:1px solid #e5e7eb; border-radius:8px; padding:9px 10px; font-size:13px; color:#374151; outline:none; background:#fff; max-width:180px;">
                <option value="">Todos los asesores</option>
                @isset($asesores)
                @foreach($asesores as $a)
                <option value="{{ $a->nombre }} {{ $a->apellido }}">{{ $a->nombre }} {{ $a->apellido }}</option>
                @endforeach
                @endisset
            </select>
        </div>

        <div id="urgencia-resultados" style="overflow-y:auto; flex:1; min-height:100px;">
            <p style="font-size:12px; color:#9ca3af; text-align:center; padding:20px 0;">Escribí para buscar, o dejá vacío para ver las organizaciones pendientes.</p>
        </div>
    </div>
</div>

<div id="modal-urgencia-form" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.4); z-index:9998; align-items:center; justify-content:center;">
    <div style="background:white; border-radius:12px; padding:28px; max-width:440px; width:92%; box-shadow:0 20px 60px rgba(0,0,0,0.3);">
        <div style="font-size:32px; text-align:center; margin-bottom:6px;">📦</div>
        <h3 style="font-size:15px; font-weight:700; color:#1e293b; margin-bottom:2px; text-align:center;">Entrega de Log</h3>
        <p id="urgencia-org-nombre" style="font-size:12px; color:#64748b; margin-bottom:16px; text-align:center; font-weight:600;"></p>

        <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:8px; margin-bottom:14px;">
            <div>
                <label style="display:block; font-size:10.5px; font-weight:600; color:#6b7280; margin-bottom:4px; text-transform:uppercase;">Urnas</label>
                <input type="number" id="urgencia-urnas" min="0" value="0" style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 8px; font-size:13px; outline:none; box-sizing:border-box;">
            </div>
            <div>
                <label style="display:block; font-size:10.5px; font-weight:600; color:#6b7280; margin-bottom:4px; text-transform:uppercase;">Cuartos</label>
                <input type="number" id="urgencia-cuartos" min="0" value="0" style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 8px; font-size:13px; outline:none; box-sizing:border-box;">
            </div>
            <div>
                <label style="display:block; font-size:10.5px; font-weight:600; color:#6b7280; margin-bottom:4px; text-transform:uppercase;">Tintas</label>
                <input type="number" id="urgencia-tintas" min="0" value="0" style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 8px; font-size:13px; outline:none; box-sizing:border-box;">
            </div>
        </div>
        <p id="urgencia-aviso-precargado" style="display:none; font-size:11px; color:#065f46; background:#ecfdf5; border:1px solid #a7f3d0; border-radius:6px; padding:5px 8px; margin:-4px 0 12px;">
            ✓ Cantidades ya cargadas previamente — puedes editarlas.
        </p>
        <div style="margin-bottom:12px;">
            <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Funcionario que entrega *</label>
            <input type="text" id="urgencia-funcionario" required list="funcionarios-log-datalist" placeholder="Nombre completo..." style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:8px 10px; font-size:13px; outline:none; box-sizing:border-box;">
        </div>
        <div style="margin-bottom:12px;">
            <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Fecha y hora *</label>
            <input type="datetime-local" id="urgencia-fecha" required style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:8px 10px; font-size:13px; outline:none; box-sizing:border-box;">
        </div>
        <div style="margin-bottom:12px;">
            <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Persona que retira *</label>
            <input type="text" id="urgencia-persona" required placeholder="Nombre completo..." style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:8px 10px; font-size:13px; outline:none; box-sizing:border-box;">
        </div>
        <div style="margin-bottom:18px;">
            <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Teléfono de quien retira *</label>
            <input type="text" id="urgencia-telefono" required placeholder="Ej: 0981 123 456" style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:8px 10px; font-size:13px; outline:none; box-sizing:border-box;">
        </div>
        <div style="display:flex; gap:10px; justify-content:center;">
            <button type="button" onclick="volverABuscarUrgencia()" style="padding:8px 16px; border-radius:8px; border:1px solid #e5e7eb; background:white; color:#374151; font-size:13px; cursor:pointer;">← Volver</button>
            <button type="button" onclick="irAConfirmarUrgencia()" style="padding:8px 18px; border-radius:8px; border:none; background:#16a34a; color:white; font-size:13px; cursor:pointer; font-weight:500;">Siguiente →</button>
        </div>
    </div>
</div>

<div id="modal-urgencia-confirmar" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.4); z-index:9998; align-items:center; justify-content:center;">
    <div style="background:white; border-radius:12px; padding:28px; max-width:400px; width:92%; box-shadow:0 20px 60px rgba(0,0,0,0.3);">
        <div style="font-size:32px; text-align:center; margin-bottom:6px;">✅</div>
        <h3 style="font-size:15px; font-weight:700; color:#1e293b; margin-bottom:14px; text-align:center;">¿Están bien estos datos?</h3>
        <div id="urgencia-resumen" style="background:#f9fafb; border-radius:10px; padding:14px; font-size:12.5px; color:#374151; line-height:1.9; margin-bottom:18px;"></div>
        <p style="font-size:11px; color:#94a3b8; margin-bottom:16px; text-align:center;">Al confirmar se guarda y se marca como entregado.</p>
        <div style="display:flex; gap:10px; justify-content:center;">
            <button type="button" onclick="volverAFormUrgencia()" style="padding:8px 16px; border-radius:8px; border:1px solid #e5e7eb; background:white; color:#374151; font-size:13px; cursor:pointer;">← Editar</button>
            <button id="btn-confirmar-urgencia" type="button" onclick="confirmarUrgencia()" style="padding:8px 18px; border-radius:8px; border:none; background:#16a34a; color:white; font-size:13px; cursor:pointer; font-weight:500;">Confirmar e imprimir</button>
        </div>
    </div>
</div>

{{-- Reimprimir: solo cantidades (en gris, con botón Editar). No muestra ni modifica
     fecha, funcionario ni datos de quien retiró. --}}
<div id="modal-reimprimir" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.4); z-index:9998; align-items:center; justify-content:center;">
    <div style="background:white; border-radius:12px; padding:28px; max-width:400px; width:92%; box-shadow:0 20px 60px rgba(0,0,0,0.3);">
        <div style="font-size:32px; text-align:center; margin-bottom:6px;">🖨️</div>
        <h3 style="font-size:15px; font-weight:700; color:#1e293b; margin-bottom:2px; text-align:center;">Reimprimir recibo</h3>
        <p id="reimprimir-org-nombre" style="font-size:12px; color:#64748b; margin-bottom:16px; text-align:center; font-weight:600;"></p>
        <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:8px; margin-bottom:10px;">
            <div>
                <label style="display:block; font-size:10.5px; font-weight:600; color:#6b7280; margin-bottom:4px; text-transform:uppercase;">Urnas</label>
                <input type="number" id="reimprimir-urnas" min="0" readonly style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 8px; font-size:13px; outline:none; box-sizing:border-box; background:#f3f4f6; color:#6b7280;">
            </div>
            <div>
                <label style="display:block; font-size:10.5px; font-weight:600; color:#6b7280; margin-bottom:4px; text-transform:uppercase;">Cuartos</label>
                <input type="number" id="reimprimir-cuartos" min="0" readonly style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 8px; font-size:13px; outline:none; box-sizing:border-box; background:#f3f4f6; color:#6b7280;">
            </div>
            <div>
                <label style="display:block; font-size:10.5px; font-weight:600; color:#6b7280; margin-bottom:4px; text-transform:uppercase;">Tintas</label>
                <input type="number" id="reimprimir-tintas" min="0" readonly style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 8px; font-size:13px; outline:none; box-sizing:border-box; background:#f3f4f6; color:#6b7280;">
            </div>
        </div>
        <div style="text-align:center; margin-bottom:16px;">
            <button type="button" id="btn-editar-reimprimir" onclick="activarEdicionReimprimir()" style="background:#f3f4f6; color:#374151; padding:5px 12px; border-radius:8px; font-size:11px; border:none; cursor:pointer; font-weight:500;">✏️ Editar cantidades</button>
        </div>
        <div style="display:flex; gap:10px; justify-content:center;">
            <button type="button" onclick="document.getElementById('modal-reimprimir').style.display='none'" style="padding:8px 16px; border-radius:8px; border:1px solid #e5e7eb; background:white; color:#374151; font-size:13px; cursor:pointer;">Cancelar</button>
            <button type="button" id="btn-confirmar-reimprimir" onclick="confirmarReimprimir()" style="padding:8px 18px; border-radius:8px; border:none; background:#065f46; color:white; font-size:13px; cursor:pointer; font-weight:500;">Ver recibo</button>
        </div>
    </div>
</div>

<div id="modal-urgencia-recibo" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.6); z-index:9999; align-items:center; justify-content:center;">
    <div style="background:#fff; border-radius:12px; width:90%; max-width:860px; max-height:90vh; display:flex; flex-direction:column; box-shadow:0 8px 32px rgba(0,0,0,0.3);">
        <div style="display:flex; align-items:center; justify-content:space-between; padding:14px 20px; border-bottom:1px solid #e5e7eb; flex-shrink:0;">
            <span style="font-size:14px; font-weight:600; color:#111827;">Vista previa — Recibo de Logística</span>
            <div style="display:flex; gap:8px;">
                <button onclick="imprimirReciboUrgencia()" style="display:inline-flex; align-items:center; gap:6px; background:#1e3a5f; color:white; padding:8px 18px; border-radius:8px; font-size:13px; border:none; cursor:pointer; font-weight:500;">🖨️ Imprimir</button>
                <button onclick="cerrarReciboUrgencia()" style="display:inline-flex; align-items:center; gap:6px; background:#f3f4f6; color:#374151; padding:8px 18px; border-radius:8px; font-size:13px; border:none; cursor:pointer; font-weight:500;">✕ Cerrar</button>
            </div>
        </div>
        <div style="flex:1; overflow-y:auto; padding:20px; background:#f9fafb;">
            <div id="urgencia-recibo-html" style="background:#fff; border-radius:8px; padding:16px; box-shadow:0 1px 4px rgba(0,0,0,0.08);"></div>
        </div>
    </div>
</div>

<datalist id="funcionarios-log-datalist">
    @isset($funcionariosLog)
    @foreach($funcionariosLog as $nombreFunc)
    <option value="{{ $nombreFunc }}"></option>
    @endforeach
    @endisset
</datalist>

<style>
    @keyframes girarUrgencia { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
    .spinner-urgencia { animation: girarUrgencia 0.7s linear infinite; }
</style>
<script>
let _urgenciaOrgId = null;
let _urgenciaOrgNombre = '';
let _urgenciaBuscarTimeout = null;
let _urgenciaModoReimpresion = false;
let _urgenciaResultados = {};

function escapeHtmlUrgencia(texto) {
    if (texto === null || texto === undefined) return '';
    const div = document.createElement('div');
    div.textContent = String(texto);
    return div.innerHTML;
}

function fechaLocalAhoraUrgencia() {
    const now = new Date();
    const pad = n => String(n).padStart(2, '0');
    return now.getFullYear() + '-' + pad(now.getMonth()+1) + '-' + pad(now.getDate())
        + 'T' + pad(now.getHours()) + ':' + pad(now.getMinutes());
}

function abrirUrgencia() {
    document.getElementById('urgencia-buscar-input').value = '';
    document.getElementById('urgencia-filtro-asesor').value = '';
    document.getElementById('modal-urgencia-buscar').style.display = 'flex';
    buscarUrgencia();
    setTimeout(() => document.getElementById('urgencia-buscar-input').focus(), 100);
}

function cerrarUrgencia() {
    document.getElementById('modal-urgencia-buscar').style.display = 'none';
}

document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('urgencia-buscar-input');
    const selectAsesor = document.getElementById('urgencia-filtro-asesor');
    if (!input) return;
    input.addEventListener('input', function() {
        clearTimeout(_urgenciaBuscarTimeout);
        _urgenciaBuscarTimeout = setTimeout(() => buscarUrgencia(), 350);
    });
    selectAsesor?.addEventListener('change', () => buscarUrgencia());
});

async function buscarUrgencia() {
    const q      = document.getElementById('urgencia-buscar-input').value;
    const asesor = document.getElementById('urgencia-filtro-asesor').value;
    const cont = document.getElementById('urgencia-resultados');
    cont.innerHTML = '<p style="font-size:12px; color:#9ca3af; text-align:center; padding:20px 0;">Buscando...</p>';
    try {
        const res = await fetch('{{ route('secretaria.con-nota.buscar-log-urgencia') }}?q=' + encodeURIComponent(q) + '&asesor=' + encodeURIComponent(asesor));
        const data = await res.json();
        if (!data.length) {
            cont.innerHTML = '<p style="font-size:12px; color:#9ca3af; text-align:center; padding:20px 0;">Sin resultados.</p>';
            return;
        }
        cont.innerHTML = data.map(org => `
            <div class="urgencia-resultado-item" data-id="${org.id}" data-nombre="${escapeHtmlUrgencia(org.nombre_organizacion)}"
                 style="padding:10px 12px; border:1px solid #f3f4f6; border-radius:8px; margin-bottom:6px; cursor:pointer; transition:background 0.15s;"
                 onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='white'">
                <div style="font-size:13px; font-weight:600; color:#111827;">${escapeHtmlUrgencia(org.nombre_organizacion)}</div>
                <div style="font-size:11px; color:#6b7280; margin-top:2px;">
                    ${escapeHtmlUrgencia(org.codigo_org)} — Asesor: ${escapeHtmlUrgencia(org.asesor_asignado)} — Elección: ${escapeHtmlUrgencia(org.fecha_eleccion)} — Ingresó: ${escapeHtmlUrgencia(org.fecha_entrada)}
                </div>
                <div style="display:flex; gap:10px; align-items:center; font-size:10.5px; color:#6b7280; margin-top:4px;">
                    <span style="display:inline-flex; align-items:center; gap:4px;"><span style="width:8px; height:8px; border-radius:50%; background:#eab308; display:inline-block;"></span>Log pendiente</span>
                    ${org.tiene_tec ? `<span style="display:inline-flex; align-items:center; gap:4px;"><span style="width:8px; height:8px; border-radius:50%; background:${org.tec_realizado ? '#16a34a' : '#eab308'}; display:inline-block;"></span>Tec ${org.tec_realizado ? 'realizado' : 'pendiente'}</span>` : ''}
                </div>
            </div>
        `).join('');
        _urgenciaResultados = {};
        data.forEach(org => { _urgenciaResultados[org.id] = org; });
        cont.querySelectorAll('.urgencia-resultado-item').forEach(el => {
            el.addEventListener('click', function() {
                const id = parseInt(this.dataset.id, 10);
                seleccionarUrgencia(id, this.dataset.nombre, _urgenciaResultados[id]);
            });
        });
    } catch (e) {
        cont.innerHTML = '<p style="font-size:12px; color:#dc2626; text-align:center; padding:20px 0;">Error al buscar. Intentá de nuevo.</p>';
        console.error(e);
    }
}

function seleccionarUrgencia(id, nombre, datos) {
    _urgenciaModoReimpresion = false;
    _urgenciaOrgId = id;
    _urgenciaOrgNombre = nombre;
    document.getElementById('urgencia-org-nombre').textContent = nombre;
    // Si la organización ya trae cantidades cargadas (ej. las cargó el
    // asesor), se precargan para poder revisarlas/editarlas.
    document.getElementById('urgencia-urnas').value   = datos?.log_urnas   ?? 0;
    document.getElementById('urgencia-cuartos').value = datos?.log_cuartos ?? 0;
    document.getElementById('urgencia-tintas').value  = datos?.log_tintas  ?? 0;
    const hayPrecargado = ((datos?.log_urnas ?? 0) + (datos?.log_cuartos ?? 0) + (datos?.log_tintas ?? 0)) > 0;
    document.getElementById('urgencia-aviso-precargado').style.display = hayPrecargado ? 'block' : 'none';
    document.getElementById('urgencia-funcionario').value = {!! json_encode(auth()->user()->name ?? '') !!};
    document.getElementById('urgencia-fecha').value = fechaLocalAhoraUrgencia();
    document.getElementById('urgencia-persona').value = '';
    document.getElementById('urgencia-telefono').value = '';
    document.getElementById('modal-urgencia-buscar').style.display = 'none';
    document.getElementById('modal-urgencia-form').style.display = 'flex';
}

// Modo "Reimprimir": popup mínimo con solo las cantidades (en gris) y un
// botón Editar. Si no se edita nada, solo se vuelve a mostrar el recibo con
// los datos originales; si se editan, se guardan únicamente las 3 cantidades.
let _reimprimirId = null;
let _reimprimirOriginal = null;

async function abrirReimprimirUrgencia(id) {
    try {
        const res = await fetch('/secretaria/con-nota/' + id + '/datos-log-urgencia', { headers: { 'Accept': 'application/json' } });
        if (!res.ok) throw new Error('HTTP ' + res.status);
        const d = await res.json();
        _reimprimirId = d.id;
        _reimprimirOriginal = { urnas: d.log_urnas, cuartos: d.log_cuartos, tintas: d.log_tintas };
        document.getElementById('reimprimir-org-nombre').textContent = d.nombre;
        ['urnas', 'cuartos', 'tintas'].forEach(k => {
            const el = document.getElementById('reimprimir-' + k);
            el.value = _reimprimirOriginal[k];
            el.readOnly = true;
            el.style.background = '#f3f4f6';
            el.style.color = '#6b7280';
        });
        document.getElementById('btn-editar-reimprimir').style.display = 'inline-block';
        const btn = document.getElementById('btn-confirmar-reimprimir');
        btn.disabled = false; btn.style.opacity = '1'; btn.innerHTML = 'Ver recibo';
        document.getElementById('modal-reimprimir').style.display = 'flex';
    } catch (e) {
        alert('No se pudieron cargar los datos. Intentá de nuevo.');
        console.error(e);
    }
}

function activarEdicionReimprimir() {
    ['urnas', 'cuartos', 'tintas'].forEach(k => {
        const el = document.getElementById('reimprimir-' + k);
        el.readOnly = false;
        el.style.background = '#fff';
        el.style.color = '#111827';
    });
    document.getElementById('btn-editar-reimprimir').style.display = 'none';
    document.getElementById('reimprimir-urnas').focus();
}

async function confirmarReimprimir() {
    const btn = document.getElementById('btn-confirmar-reimprimir');
    if (btn.disabled) return;
    const actual = {
        urnas:   parseInt(document.getElementById('reimprimir-urnas').value, 10),
        cuartos: parseInt(document.getElementById('reimprimir-cuartos').value, 10),
        tintas:  parseInt(document.getElementById('reimprimir-tintas').value, 10),
    };
    if ([actual.urnas, actual.cuartos, actual.tintas].some(n => isNaN(n) || n < 0)) {
        alert('Ingresá cantidades válidas (0 o más).');
        return;
    }
    const cambio = actual.urnas !== _reimprimirOriginal.urnas
        || actual.cuartos !== _reimprimirOriginal.cuartos
        || actual.tintas  !== _reimprimirOriginal.tintas;

    btn.disabled = true; btn.style.opacity = '0.7'; btn.innerHTML = 'Cargando...';
    try {
        let response;
        if (cambio) {
            response = await fetch('/secretaria/con-nota/' + _reimprimirId + '/actualizar-cantidades-log', {
                method: 'POST',
                headers: { 'Accept': 'application/json', 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ log_urnas: actual.urnas, log_cuartos: actual.cuartos, log_tintas: actual.tintas }),
            });
        } else {
            response = await fetch('/secretaria/sin-nota/log/' + _reimprimirId + '/reimprimir', { headers: { 'Accept': 'application/json' } });
        }
        if (!response.ok) throw new Error('HTTP ' + response.status);
        const data = await response.json();
        document.getElementById('modal-reimprimir').style.display = 'none';
        document.getElementById('urgencia-recibo-html').innerHTML = data.html;
        document.getElementById('modal-urgencia-recibo').style.display = 'flex';
    } catch (e) {
        alert('No se pudo cargar el recibo. Intentá de nuevo.');
        console.error(e);
        btn.disabled = false; btn.style.opacity = '1'; btn.innerHTML = 'Ver recibo';
    }
}

function volverABuscarUrgencia() {
    document.getElementById('modal-urgencia-form').style.display = 'none';
    if (_urgenciaModoReimpresion) return;
    document.getElementById('modal-urgencia-buscar').style.display = 'flex';
}

function irAConfirmarUrgencia() {
    const funcionario = document.getElementById('urgencia-funcionario').value.trim();
    const fecha    = document.getElementById('urgencia-fecha').value;
    const persona  = document.getElementById('urgencia-persona').value.trim();
    const telefono = document.getElementById('urgencia-telefono').value.trim();
    if (!funcionario) { alert('Por favor ingresá el funcionario que entrega.'); return; }
    if (!fecha)    { alert('Por favor ingresá la fecha.'); return; }
    if (!persona)  { alert('Por favor ingresá el nombre de quien retira.'); return; }
    if (!telefono) { alert('Por favor ingresá el teléfono de quien retira.'); return; }

    const urnas   = document.getElementById('urgencia-urnas').value || 0;
    const cuartos = document.getElementById('urgencia-cuartos').value || 0;
    const tintas  = document.getElementById('urgencia-tintas').value || 0;

    document.getElementById('urgencia-resumen').innerHTML = `
        <strong>${escapeHtmlUrgencia(_urgenciaOrgNombre)}</strong><br>
        Urnas: ${urnas} — Cuartos: ${cuartos} — Tintas: ${tintas}<br>
        Entrega: ${escapeHtmlUrgencia(funcionario)}<br>
        Retira: ${escapeHtmlUrgencia(persona)} (${escapeHtmlUrgencia(telefono)})<br>
        Fecha: ${fecha.replace('T', ' ')}
    `;
    document.getElementById('modal-urgencia-form').style.display = 'none';
    document.getElementById('modal-urgencia-confirmar').style.display = 'flex';
}

function volverAFormUrgencia() {
    document.getElementById('modal-urgencia-confirmar').style.display = 'none';
    document.getElementById('modal-urgencia-form').style.display = 'flex';
}

async function confirmarUrgencia() {
    const btn = document.getElementById('btn-confirmar-urgencia');
    if (btn.disabled) return;
    btn.disabled = true;
    btn.style.opacity = '0.7';
    btn.style.cursor = 'not-allowed';
    btn.innerHTML = '<svg class="spinner-urgencia" width="13" height="13" fill="none" viewBox="0 0 24 24" style="vertical-align:middle; margin-right:5px;">'
        + '<circle cx="12" cy="12" r="9" stroke="rgba(255,255,255,0.35)" stroke-width="3"/>'
        + '<path d="M21 12a9 9 0 0 0-9-9" stroke="#fff" stroke-width="3" stroke-linecap="round"/>'
        + '</svg>Guardando...';

    const params = new URLSearchParams({
        entregado_por:   document.getElementById('urgencia-funcionario').value.trim(),
        fecha_entrega:   document.getElementById('urgencia-fecha').value,
        persona_retira:  document.getElementById('urgencia-persona').value.trim(),
        telefono_retira: document.getElementById('urgencia-telefono').value.trim(),
        log_urnas:       document.getElementById('urgencia-urnas').value || 0,
        log_cuartos:     document.getElementById('urgencia-cuartos').value || 0,
        log_tintas:      document.getElementById('urgencia-tintas').value || 0,
    });

    const url = '/secretaria/sin-nota/log/' + _urgenciaOrgId + '/imprimir-logistica?' + params.toString();

    try {
        const response = await fetch(url, { headers: { 'Accept': 'application/json' } });
        const data = await response.json();
        document.getElementById('modal-urgencia-confirmar').style.display = 'none';
        document.getElementById('urgencia-recibo-html').innerHTML = data.html;
        document.getElementById('modal-urgencia-recibo').style.display = 'flex';
    } catch (e) {
        alert('Error al generar el recibo. Intentá de nuevo.');
        console.error(e);
        btn.disabled = false;
        btn.style.opacity = '1';
        btn.style.cursor = 'pointer';
        btn.innerHTML = 'Confirmar e imprimir';
    }
}

function imprimirReciboUrgencia() {
    const contenido = document.getElementById('urgencia-recibo-html').innerHTML;
    const tituloOriginal = document.title;
    const bodyOriginal = document.body.innerHTML;
    document.title = 'Recibo Logística';
    document.body.innerHTML = contenido;
    window.print();
    document.body.innerHTML = bodyOriginal;
    document.title = tituloOriginal;
    window.location.reload();
}

function cerrarReciboUrgencia() {
    window.location.reload();
}

['modal-urgencia-buscar', 'modal-urgencia-form', 'modal-urgencia-confirmar', 'modal-reimprimir', 'modal-urgencia-recibo'].forEach(id => {
    const el = document.getElementById(id);
    if (el) el.addEventListener('click', function(e) {
        if (e.target === this && id !== 'modal-urgencia-recibo') this.style.display = 'none';
    });
});
</script>
