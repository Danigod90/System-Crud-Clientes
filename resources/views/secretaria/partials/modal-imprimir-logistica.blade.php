{{-- Modal reutilizable: "Imprimir Logística" (solo asunto Log).
     Pide Funcionario, Fecha, Persona que retira y Teléfono, guarda el registro
     y muestra una vista previa del recibo para imprimir.
     Para usarlo: incluir este partial una vez en la página y llamar a
     abrirModalImprimirLog(id, nombreOrganizacion) desde un botón. --}}

<div id="modal-imprimir-log" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.4); z-index:50; align-items:center; justify-content:center;">
    <div style="background:white; border-radius:12px; padding:28px; max-width:440px; width:90%; box-shadow:0 20px 60px rgba(0,0,0,0.3);">
        <div style="font-size:32px; text-align:center; margin-bottom:10px;">🖨️</div>
        <h3 style="font-size:15px; font-weight:700; color:#1e293b; margin-bottom:4px; text-align:center;">Imprimir logística</h3>
        <p id="modal-log-org" style="font-size:12px; color:#64748b; margin-bottom:18px; text-align:center;"></p>
        <div style="margin-bottom:14px;">
            <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Fecha y hora *</label>
            <input type="datetime-local" id="log-fecha" required
                   style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:8px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
        </div>
        <div style="margin-bottom:14px;">
            <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Persona que retira *</label>
            <input type="text" id="log-persona-retira" required placeholder="Nombre completo..."
                   style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:8px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
        </div>
        <div style="margin-bottom:20px;">
            <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Teléfono de quien retira *</label>
            <input type="text" id="log-telefono-retira" required placeholder="Ej: 0981 123 456"
                   style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:8px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
        </div>
        <p style="font-size:11px; color:#94a3b8; margin-bottom:16px; text-align:center;">Al confirmar se guarda el registro y se muestra la vista previa.</p>
        <div style="display:flex; gap:10px; justify-content:center;">
            <button onclick="document.getElementById('modal-imprimir-log').style.display='none'"
                    style="padding:8px 18px; border-radius:8px; border:1px solid #e5e7eb; background:white; color:#374151; font-size:13px; cursor:pointer;">Cancelar</button>
            <button id="btn-confirmar-imprimir-log" onclick="confirmarImprimirLog()"
                    style="padding:8px 18px; border-radius:8px; border:none; background:#0369a1; color:white; font-size:13px; cursor:pointer; font-weight:500;">Confirmar e imprimir</button>
        </div>
    </div>
</div>

<div id="modal-recibo-log" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.6); z-index:9999; align-items:center; justify-content:center;">
    <div style="background:#fff; border-radius:12px; width:90%; max-width:860px; max-height:90vh; display:flex; flex-direction:column; box-shadow:0 8px 32px rgba(0,0,0,0.3);">
        <div style="display:flex; align-items:center; justify-content:space-between; padding:14px 20px; border-bottom:1px solid #e5e7eb; flex-shrink:0;">
            <span style="font-size:14px; font-weight:600; color:#111827;">Vista previa — Recibo de Logística</span>
            <div style="display:flex; gap:8px;">
                <button onclick="imprimirReciboLog()"
                    style="display:inline-flex; align-items:center; gap:6px; background:#1e3a5f; color:white; padding:8px 18px; border-radius:8px; font-size:13px; border:none; cursor:pointer; font-weight:500;">
                    🖨️ Imprimir
                </button>
                <button onclick="cerrarModalReciboLog()"
                    style="display:inline-flex; align-items:center; gap:6px; background:#f3f4f6; color:#374151; padding:8px 18px; border-radius:8px; font-size:13px; border:none; cursor:pointer; font-weight:500;">
                    ✕ Cerrar
                </button>
            </div>
        </div>
        <div style="flex:1; overflow-y:auto; padding:20px; background:#f9fafb;">
            <div id="recibo-log-html" style="background:#fff; border-radius:8px; padding:16px; box-shadow:0 1px 4px rgba(0,0,0,0.08);"></div>
        </div>
    </div>
</div>

<style>
    @keyframes girar { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
    .spinner-guardar { animation: girar 0.7s linear infinite; }
</style>
<script>
function fechaLocalAhora() {
    const now = new Date();
    const pad = n => String(n).padStart(2, '0');
    return now.getFullYear() + '-' + pad(now.getMonth()+1) + '-' + pad(now.getDate())
        + 'T' + pad(now.getHours()) + ':' + pad(now.getMinutes());
}

let _logEntradaId = null;
function abrirModalImprimirLog(id, org) {
    _logEntradaId = id;
    document.getElementById('modal-log-org').textContent = org;
    document.getElementById('log-fecha').value = fechaLocalAhora();
    document.getElementById('log-persona-retira').value = '';
    document.getElementById('log-telefono-retira').value = '';
    const btnImprimirLog = document.getElementById('btn-confirmar-imprimir-log');
    btnImprimirLog.disabled = false;
    btnImprimirLog.style.opacity = '1';
    btnImprimirLog.style.cursor = 'pointer';
    btnImprimirLog.innerHTML = 'Confirmar e imprimir';
    document.getElementById('modal-imprimir-log').style.display = 'flex';
    setTimeout(() => document.getElementById('log-persona-retira').focus(), 100);
}

async function confirmarImprimirLog() {
    const btnImprimirLog = document.getElementById('btn-confirmar-imprimir-log');
    if (btnImprimirLog.disabled) return;

    const fecha           = document.getElementById('log-fecha').value;
    const personaRetira   = document.getElementById('log-persona-retira').value.trim();
    const telefonoRetira  = document.getElementById('log-telefono-retira').value.trim();
    if (!fecha)          { alert('Por favor ingresá la fecha.'); return; }
    if (!personaRetira)  { alert('Por favor ingresá el nombre de quien retira.'); return; }
    if (!telefonoRetira) { alert('Por favor ingresá el teléfono de quien retira.'); return; }

    btnImprimirLog.disabled = true;
    btnImprimirLog.style.opacity = '0.7';
    btnImprimirLog.style.cursor = 'not-allowed';
    btnImprimirLog.innerHTML = '<svg class="spinner-guardar" width="13" height="13" fill="none" viewBox="0 0 24 24" style="vertical-align:middle; margin-right:5px;">'
        + '<circle cx="12" cy="12" r="9" stroke="rgba(255,255,255,0.35)" stroke-width="3"/>'
        + '<path d="M21 12a9 9 0 0 0-9-9" stroke="#fff" stroke-width="3" stroke-linecap="round"/>'
        + '</svg>Guardando...';

    const url = '/secretaria/sin-nota/log/' + _logEntradaId + '/imprimir-logistica'
        + '?fecha_entrega=' + encodeURIComponent(fecha)
        + '&persona_retira=' + encodeURIComponent(personaRetira)
        + '&telefono_retira=' + encodeURIComponent(telefonoRetira);

    document.getElementById('modal-imprimir-log').style.display = 'none';

    try {
        const response = await fetch(url, {
            headers: { 'Accept': 'application/json' }
        });
        const data = await response.json();
        document.getElementById('recibo-log-html').innerHTML = data.html;
        document.getElementById('modal-recibo-log').style.display = 'flex';
    } catch(e) {
        alert('Error al cargar el recibo. Intentá de nuevo.');
        console.error(e);
    }
}

function imprimirReciboLog() {
    const contenido = document.getElementById('recibo-log-html').innerHTML;
    const tituloOriginal = document.title;
    const bodyOriginal = document.body.innerHTML;
    document.title = 'Recibo Logística';
    document.body.innerHTML = contenido;
    window.print();
    document.body.innerHTML = bodyOriginal;
    document.title = tituloOriginal;
    window.location.reload();
}

function cerrarModalReciboLog() {
    document.getElementById('modal-recibo-log').style.display = 'none';
    document.getElementById('recibo-log-html').innerHTML = '';
    window.location.reload();
}

['modal-imprimir-log', 'modal-recibo-log'].forEach(id => {
    document.getElementById(id).addEventListener('click', function(e) {
        if (e.target === this) this.style.display = 'none';
    });
});
</script>
