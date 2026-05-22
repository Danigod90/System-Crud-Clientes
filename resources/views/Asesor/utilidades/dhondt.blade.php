<x-panel-layout title="Calculadora D'Hondt" :charlasPendientes="$charlasPendientes">

<style>
@import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;600&family=IBM+Plex+Sans:wght@400;500;600;700&display=swap');

.dhondt-wrap {
    font-family: 'IBM Plex Sans', sans-serif;
    max-width: 960px;
    margin: 0 auto;
    padding: 0 8px 40px;
}

.dhondt-header {
    background: linear-gradient(135deg, #1e3a5f 0%, #0f2444 100%);
    border-radius: 16px;
    padding: 28px 32px;
    margin-bottom: 20px;
    position: relative;
    overflow: hidden;
}
.dhondt-header::before {
    content: '';
    position: absolute;
    top: -40px; right: -40px;
    width: 200px; height: 200px;
    border-radius: 50%;
    background: rgba(255,255,255,0.04);
}
.dhondt-header h1 { font-size: 22px; font-weight: 700; color: #fff; margin: 0 0 6px; letter-spacing: -0.3px; }
.dhondt-header p  { font-size: 13px; color: rgba(255,255,255,0.6); margin: 0; }

/* MODO SELECTOR */
.modo-selector {
    display: flex;
    gap: 10px;
    margin-bottom: 16px;
}
.modo-btn {
    flex: 1;
    padding: 12px 16px;
    border-radius: 10px;
    border: 2px solid #e5e7eb;
    background: #fff;
    font-family: 'IBM Plex Sans', sans-serif;
    font-size: 13px;
    font-weight: 600;
    color: #6b7280;
    cursor: pointer;
    text-align: center;
    transition: all 0.15s;
}
.modo-btn.activo {
    border-color: #1e3a5f;
    background: #1e3a5f;
    color: #fff;
}
.modo-btn:not(.activo):hover { border-color: #1e3a5f; color: #1e3a5f; }

.config-card {
    background: #fff;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
    padding: 20px 24px;
    margin-bottom: 16px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.05);
}
.config-card h2 {
    font-size: 12px; font-weight: 700; color: #6b7280;
    text-transform: uppercase; letter-spacing: 0.8px; margin: 0 0 16px;
}
.config-row {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr 1fr;
    gap: 14px;
    margin-bottom: 16px;
}
.config-row-3 {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 14px;
    margin-bottom: 16px;
}
.field-label {
    display: block; font-size: 11px; font-weight: 600; color: #6b7280;
    text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;
}
.field-input {
    width: 100%; border: 1px solid #e5e7eb; border-radius: 8px;
    padding: 8px 12px; font-size: 13px; color: #111827; outline: none;
    box-sizing: border-box; font-family: 'IBM Plex Sans', sans-serif; transition: border-color 0.15s;
}
.field-input:focus { border-color: #1e3a5f; }

/* ═══ MODO 1: POR LISTA ═══ */
.partidos-grid { display: grid; grid-template-columns: 1fr; gap: 10px; }
.partido-row {
    background: #f9fafb; border: 1px solid #e5e7eb;
    border-radius: 8px; padding: 10px 12px;
}
.partido-row-header {
    display: flex; align-items: center; gap: 10px; margin-bottom: 0;
}
.partido-row-header.expanded { margin-bottom: 10px; }
.partido-color { width: 14px; height: 14px; border-radius: 50%; flex-shrink: 0; }
.partido-nombre {
    flex: 1; border: none; background: transparent; font-size: 13px;
    color: #374151; outline: none; font-family: 'IBM Plex Sans', sans-serif; font-weight: 500;
}
.partido-nombre::placeholder { color: #d1d5db; }
.partido-votos {
    width: 110px; border: 1px solid #e5e7eb; border-radius: 6px; padding: 5px 8px;
    font-size: 13px; font-family: 'IBM Plex Mono', monospace; color: #1e3a5f;
    font-weight: 600; text-align: right; outline: none; background: #fff;
}
.partido-votos:focus { border-color: #1e3a5f; }

/* Proponentes modo 1 */
.proponentes-lista {
    display: grid; grid-template-columns: 1fr 1fr; gap: 6px;
    padding-top: 8px; border-top: 1px solid #e5e7eb;
}
.proponente-input {
    border: 1px solid #e5e7eb; border-radius: 6px; padding: 5px 8px;
    font-size: 12px; color: #374151; outline: none; background: #fff;
    font-family: 'IBM Plex Sans', sans-serif; width: 100%; box-sizing: border-box;
}
.proponente-input::placeholder { color: #d1d5db; }
.proponente-input:focus { border-color: #1e3a5f; }

/* ═══ MODO 2: POR CANDIDATO CON MESAS ═══ */
.lista-card {
    background: #fff; border: 1px solid #e5e7eb; border-radius: 10px;
    margin-bottom: 12px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.04);
}
.lista-card-header {
    display: flex; align-items: center; gap: 10px;
    padding: 12px 16px; background: #f9fafb; border-bottom: 1px solid #e5e7eb;
}
.lista-card-nombre {
    flex: 1; border: none; background: transparent; font-size: 14px;
    color: #1e3a5f; outline: none; font-family: 'IBM Plex Sans', sans-serif; font-weight: 700;
}
.lista-total-badge {
    background: #1e3a5f; color: #fff; font-family: 'IBM Plex Mono', monospace;
    font-size: 12px; font-weight: 700; padding: 4px 10px; border-radius: 6px;
}
.mesas-table-wrap { overflow-x: auto; padding: 12px 16px; }
.mesas-table {
    width: 100%; border-collapse: collapse;
    font-family: 'IBM Plex Sans', sans-serif; font-size: 12px; min-width: 400px;
}
.mesas-table th {
    background: #f3f4f6; color: #6b7280; padding: 6px 8px;
    text-align: center; font-size: 11px; font-weight: 600;
    text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap;
}
.mesas-table th:first-child { text-align: left; min-width: 140px; }
.mesas-table td {
    padding: 5px 6px; border-bottom: 1px solid #f3f4f6; text-align: center;
}
.mesas-table td:first-child { text-align: left; }
.mesa-input {
    width: 70px; border: 1px solid #e5e7eb; border-radius: 5px;
    padding: 4px 5px; font-size: 12px; font-family: 'IBM Plex Mono', monospace;
    color: #1e3a5f; font-weight: 600; text-align: right; outline: none; background: #fff;
}
.mesa-input:focus { border-color: #1e3a5f; }
.candidato-nombre-input {
    border: none; background: transparent; font-size: 12px; color: #374151;
    outline: none; font-family: 'IBM Plex Sans', sans-serif; font-weight: 500; width: 100%;
}
.candidato-nombre-input::placeholder { color: #d1d5db; }
.total-candidato {
    font-family: 'IBM Plex Mono', monospace; font-size: 12px;
    font-weight: 700; color: #1e3a5f; min-width: 70px; text-align: right;
    padding: 4px 5px; background: #eff6ff; border-radius: 5px;
}
.total-lista-row td {
    background: #f0f9ff; font-weight: 700; border-top: 2px solid #bfdbfe;
}

/* BOTONES */
.btn-calcular {
    display: inline-flex; align-items: center; gap: 8px;
    background: #1e3a5f; color: white; padding: 10px 24px;
    border-radius: 10px; font-size: 14px; font-weight: 600;
    border: none; cursor: pointer; font-family: 'IBM Plex Sans', sans-serif;
    transition: background 0.15s;
}
.btn-calcular:hover { background: #162d4a; }
.btn-limpiar {
    display: inline-flex; align-items: center; gap: 8px;
    background: #f3f4f6; color: #374151; padding: 10px 20px;
    border-radius: 10px; font-size: 14px; font-weight: 500;
    border: none; cursor: pointer; font-family: 'IBM Plex Sans', sans-serif;
}

/* TABLA RESULTADO */
.resultado-card {
    background: #fff; border-radius: 12px; border: 1px solid #e5e7eb;
    padding: 20px 24px; margin-bottom: 16px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.05); display: none;
}
.resultado-card.visible { display: block; }
.tabla-dhondt {
    width: 100%; border-collapse: collapse;
    font-family: 'IBM Plex Mono', monospace; font-size: 12px; margin-bottom: 20px;
}
.tabla-dhondt th {
    background: #1e3a5f; color: #fff; padding: 8px 10px;
    text-align: center; font-weight: 600; font-size: 11px; letter-spacing: 0.5px;
}
.tabla-dhondt th:first-child { text-align: left; border-radius: 6px 0 0 0; }
.tabla-dhondt th:last-child { border-radius: 0 6px 0 0; }
.tabla-dhondt td {
    padding: 7px 10px; text-align: center;
    border-bottom: 1px solid #f3f4f6; color: #374151;
}
.tabla-dhondt td:first-child { text-align: left; font-family: 'IBM Plex Sans', sans-serif; font-weight: 600; }
.tabla-dhondt tr:hover td { background: #f9fafb; }
.celda-ganadora {
    font-weight: 700; border-radius: 4px; position: relative;
}
.celda-ganadora::after { content: '✓'; font-size: 9px; margin-left: 3px; color: #16a34a; }

/* REPARTO */
.reparto-grid { display: flex; flex-wrap: wrap; gap: 10px; }
.reparto-partido {
    display: flex; align-items: center; gap: 8px;
    background: #f9fafb; border: 1px solid #e5e7eb;
    border-radius: 10px; padding: 10px 16px; min-width: 160px;
}
.reparto-dot { width: 12px; height: 12px; border-radius: 50%; flex-shrink: 0; }
.reparto-info { flex: 1; }
.reparto-nombre { font-size: 12px; font-weight: 600; color: #374151; }
.reparto-cargos { font-size: 20px; font-weight: 700; font-family: 'IBM Plex Mono', monospace; }
.reparto-label { font-size: 10px; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.5px; }

/* CANDIDATOS ELECTOS */
.electos-table {
    width: 100%; border-collapse: collapse;
    font-family: 'IBM Plex Sans', sans-serif; font-size: 12px;
}
.electos-table th {
    background: #f3f4f6; color: #6b7280; padding: 7px 10px;
    text-align: left; font-size: 11px; font-weight: 600;
    text-transform: uppercase; letter-spacing: 0.5px;
}
.electos-table td { padding: 8px 10px; border-bottom: 1px solid #f3f4f6; }
.electos-table tr:hover td { background: #f9fafb; }

.info-box {
    background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 10px;
    padding: 12px 16px; margin-bottom: 16px; font-size: 12px;
    color: #1e40af; line-height: 1.6;
}
</style>

<div class="dhondt-wrap">

    <div class="dhondt-header">
        <h1>⚖️ Calculadora D'Hondt</h1>
        <p>Sistema de representación proporcional para distribución de cargos electivos</p>
    </div>

    <div class="info-box">
        <strong>¿Cómo funciona?</strong> Ingresá la cantidad de cargos a repartir, los nombres y votos de cada lista/partido. El sistema D'Hondt divide los votos de cada partido por 1, 2, 3... hasta el número de cargos, y asigna los cargos a los cocientes más altos.
    </div>

    {{-- SELECTOR DE MODO --}}
    <div class="modo-selector">
        <button class="modo-btn activo" id="btn-modo1" onclick="setModo(1)">
            📋 Por Lista (total directo)
        </button>
        <button class="modo-btn" id="btn-modo2" onclick="setModo(2)">
            🗳️ Por Candidato con Mesas
        </button>
    </div>

    {{-- CONFIGURACIÓN --}}
    <div class="config-card">
        <h2>Configuración</h2>
        <div id="config-modo1" class="config-row">
            <div>
                <label class="field-label">Cargos a elegir</label>
                <input type="number" id="num-cargos" class="field-input" min="1" max="20" value="6">
            </div>
            <div>
                <label class="field-label">Cantidad de listas</label>
                <input type="number" id="num-partidos" class="field-input" min="2" max="20" value="5">
            </div>
            <div>
                <label class="field-label">Umbral mínimo (%)</label>
                <input type="number" id="umbral" class="field-input" min="0" max="50" value="0" step="0.1">
                <span style="font-size:10px; color:#9ca3af; margin-top:3px; display:block;">0 = sin umbral</span>
            </div>
            <div>
                <label class="field-label">Proponentes por lista</label>
                <input type="number" id="num-proponentes" class="field-input" min="0" max="20" value="0" placeholder="0 = sin nombres">
                <span style="font-size:10px; color:#9ca3af; margin-top:3px; display:block;">0 = solo total</span>
            </div>
        </div>
        <div id="config-modo2" class="config-row" style="display:none;">
            <div>
                <label class="field-label">Cargos a elegir</label>
                <input type="number" id="num-cargos-m2" class="field-input" min="1" max="20" value="6">
            </div>
            <div>
                <label class="field-label">Cantidad de listas</label>
                <input type="number" id="num-listas-m2" class="field-input" min="2" max="20" value="3">
            </div>
            <div>
                <label class="field-label">Proponentes por lista</label>
                <input type="number" id="num-candidatos-m2" class="field-input" min="1" max="20" value="4">
            </div>
            <div>
                <label class="field-label">Cantidad de mesas</label>
                <input type="number" id="num-mesas-m2" class="field-input" min="1" max="100" value="3">
            </div>
        </div>
        <div style="display:flex; gap:8px; flex-wrap:wrap;">
            <button class="btn-limpiar" onclick="actualizarFormulario()">Actualizar formulario</button>
        </div>
    </div>

    {{-- MODO 1: POR LISTA --}}
    <div id="panel-modo1">
        <div class="config-card">
            <h2>Listas / Partidos / Movimientos</h2>
            <div class="partidos-grid" id="partidos-container"></div>
        </div>
    </div>

    {{-- MODO 2: POR CANDIDATO CON MESAS --}}
    <div id="panel-modo2" style="display:none;">
        <div id="listas-container"></div>
    </div>

    {{-- BOTONES --}}
    <div style="display:flex; gap:10px; margin-bottom:20px;">
        <button class="btn-calcular" onclick="calcular()">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
            </svg>
            Calcular D'Hondt
        </button>
        <button class="btn-limpiar" onclick="limpiarTodo()">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-4"/>
            </svg>
            Limpiar votos
        </button>
    </div>

    {{-- TABLA D'HONDT --}}
    <div class="resultado-card" id="resultado-tabla">
        <h2 style="font-size:12px; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:0.8px; margin:0 0 16px;">Tabla de cocientes</h2>
        <div style="overflow-x:auto;">
            <table class="tabla-dhondt" id="tabla-cocientes"></table>
        </div>
    </div>

    {{-- REPARTO FINAL --}}
    <div class="resultado-card" id="resultado-reparto">
        <div style="margin-bottom:20px;">
            <p style="font-size:12px; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:0.8px; margin:0 0 14px;">Reparto final de cargos</p>
            <div class="reparto-grid" id="reparto-grid"></div>
        </div>
        <div id="electos-section" style="display:none;">
            <div style="height:1px; background:#f3f4f6; margin:20px 0;"></div>
            <p style="font-size:12px; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:0.8px; margin:0 0 12px;">Candidatos electos — ordenados por votos</p>
            <div style="overflow-x:auto;">
                <table class="electos-table" id="electos-tabla"></table>
            </div>
        </div>
    </div>

</div>

<script>
const COLORES = [
    '#dc2626','#2563eb','#16a34a','#f59e0b','#7c3aed',
    '#0891b2','#db2777','#65a30d','#ea580c','#0284c7',
    '#9333ea','#059669','#d97706','#be185d','#0f766e',
    '#b45309','#4f46e5','#15803d','#b91c1c','#1d4ed8'
];

let modoActual = 1;

function setModo(m) {
    modoActual = m;
    document.getElementById('btn-modo1').classList.toggle('activo', m === 1);
    document.getElementById('btn-modo2').classList.toggle('activo', m === 2);
    document.getElementById('panel-modo1').style.display = m === 1 ? 'block' : 'none';
    document.getElementById('panel-modo2').style.display = m === 2 ? 'block' : 'none';
    document.getElementById('config-modo1').style.display = m === 1 ? 'grid' : 'none';
    document.getElementById('config-modo2').style.display = m === 2 ? 'grid' : 'none';
    document.getElementById('resultado-tabla').classList.remove('visible');
    document.getElementById('resultado-reparto').classList.remove('visible');
    actualizarFormulario();
}

function actualizarFormulario() {
    if (modoActual === 1) generarPartidos();
    else generarListasConMesas();
}

/* ═══════════════════════════════
   MODO 1 — POR LISTA
═══════════════════════════════ */
function generarPartidos() {
    const n = Math.min(Math.max(parseInt(document.getElementById('num-partidos').value) || 5, 2), 20);
    const nProp = Math.min(Math.max(parseInt(document.getElementById('num-proponentes').value) || 0, 0), 20);
    const container = document.getElementById('partidos-container');

    const existentes = {};
    container.querySelectorAll('.partido-row').forEach((row, i) => {
        existentes[i] = {
            nombre: row.querySelector('.partido-nombre').value,
            votos: row.querySelector('.partido-votos').value,
            proponentes: []
        };
        row.querySelectorAll('.proponente-input').forEach(inp => {
            existentes[i].proponentes.push(inp.value);
        });
    });

    container.innerHTML = '';
    for (let i = 0; i < n; i++) {
        const color = COLORES[i % COLORES.length];
        const nombre = existentes[i]?.nombre || `Lista ${i + 1}`;
        const votos = existentes[i]?.votos || '';

        let propHtml = '';
        if (nProp > 0) {
            propHtml = `<div class="proponentes-lista">`;
            for (let p = 0; p < nProp; p++) {
                const pNombre = existentes[i]?.proponentes[p] || '';
                propHtml += `<input type="text" class="proponente-input" value="${pNombre}" placeholder="Proponente ${p + 1}">`;
            }
            propHtml += `</div>`;
        }

        container.innerHTML += `
        <div class="partido-row">
            <div class="partido-row-header${nProp > 0 ? ' expanded' : ''}">
                <div class="partido-color" style="background:${color};"></div>
                <input type="text" class="partido-nombre" value="${nombre}" placeholder="Nombre lista ${i+1}">
                <input type="number" class="partido-votos" value="${votos}" placeholder="Total votos" min="0">
            </div>
            ${propHtml}
        </div>`;
    }
}

/* ═══════════════════════════════
   MODO 2 — POR CANDIDATO CON MESAS
═══════════════════════════════ */
function generarListasConMesas() {
    const nListas = Math.min(Math.max(parseInt(document.getElementById('num-listas-m2').value) || 3, 2), 20);
    const nCand = Math.min(Math.max(parseInt(document.getElementById('num-candidatos-m2').value) || 4, 1), 20);
    const nMesas = Math.min(Math.max(parseInt(document.getElementById('num-mesas-m2').value) || 3, 1), 100);
    const container = document.getElementById('listas-container');

    // Guardar valores existentes
    const existentes = {};
    container.querySelectorAll('.lista-card').forEach((card, li) => {
        existentes[li] = {
            nombre: card.querySelector('.lista-card-nombre').value,
            candidatos: []
        };
        card.querySelectorAll('tbody tr:not(.total-lista-row)').forEach((row, ci) => {
            const nombre = row.querySelector('.candidato-nombre-input')?.value || '';
            const votos = [];
            row.querySelectorAll('.mesa-input').forEach(inp => votos.push(inp.value));
            existentes[li].candidatos.push({ nombre, votos });
        });
    });

    container.innerHTML = '';
    for (let li = 0; li < nListas; li++) {
        const color = COLORES[li % COLORES.length];
        const listaNombre = existentes[li]?.nombre || `Lista ${li + 1}`;

        // Encabezados mesas
        let thMesas = '';
        for (let m = 1; m <= nMesas; m++) thMesas += `<th>Mesa ${m}</th>`;

        // Filas candidatos
        let rows = '';
        for (let ci = 0; ci < nCand; ci++) {
            const cNombre = existentes[li]?.candidatos[ci]?.nombre || '';
            let inputsMesas = '';
            for (let m = 0; m < nMesas; m++) {
                const v = existentes[li]?.candidatos[ci]?.votos[m] || '';
                inputsMesas += `<td><input type="number" class="mesa-input" value="${v}" min="0"
                    oninput="recalcularTotales(${li})"></td>`;
            }
            rows += `<tr>
                <td><input type="text" class="candidato-nombre-input" value="${cNombre}" placeholder="Candidato ${ci + 1}"></td>
                ${inputsMesas}
                <td><div class="total-candidato" id="total-c-${li}-${ci}">0</div></td>
            </tr>`;
        }

        container.innerHTML += `
        <div class="lista-card" data-lista="${li}">
            <div class="lista-card-header">
                <div class="partido-color" style="background:${color}; width:16px; height:16px;"></div>
                <input type="text" class="lista-card-nombre" value="${listaNombre}" style="font-size:14px; font-weight:700; color:#1e3a5f; border:none; background:transparent; outline:none; font-family:'IBM Plex Sans',sans-serif; flex:1;">
                <span style="font-size:11px; color:#6b7280; margin-right:6px;">Total votos:</span>
                <span class="lista-total-badge" id="total-lista-${li}">0</span>
            </div>
            <div class="mesas-table-wrap">
                <table class="mesas-table">
                    <thead>
                        <tr>
                            <th>Candidato</th>
                            ${thMesas}
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-lista-${li}">
                        ${rows}
                    </tbody>
                </table>
            </div>
        </div>`;
    }

    // Recalcular todos los totales
    for (let li = 0; li < nListas; li++) recalcularTotales(li);
}

function recalcularTotales(li) {
    const tbody = document.getElementById(`tbody-lista-${li}`);
    if (!tbody) return;
    let totalLista = 0;
    const nCand = parseInt(document.getElementById('num-candidatos-m2').value) || 4;

    tbody.querySelectorAll('tr:not(.total-lista-row)').forEach((row, ci) => {
        let totalCand = 0;
        row.querySelectorAll('.mesa-input').forEach(inp => {
            totalCand += parseInt(inp.value) || 0;
        });
        totalLista += totalCand;
        const el = document.getElementById(`total-c-${li}-${ci}`);
        if (el) el.textContent = totalCand.toLocaleString('es-PY');
    });

    const elTotal = document.getElementById(`total-lista-${li}`);
    if (elTotal) elTotal.textContent = totalLista.toLocaleString('es-PY');
}

/* ═══════════════════════════════
   CALCULAR D'HONDT (ambos modos)
═══════════════════════════════ */
function calcular() {
    if (modoActual === 1) calcularModo1();
    else calcularModo2();
}

function calcularModo1() {
    const cargos = Math.min(Math.max(parseInt(document.getElementById('num-cargos').value) || 6, 1), 20);
    const umbral = parseFloat(document.getElementById('umbral').value) || 0;
    const nProp = parseInt(document.getElementById('num-proponentes').value) || 0;
    const rows = document.querySelectorAll('#partidos-container .partido-row');

    let partidos = [];
    let totalVotos = 0;
    rows.forEach((row, i) => {
        const nombre = row.querySelector('.partido-nombre').value.trim() || `Lista ${i+1}`;
        const votos = parseInt(row.querySelector('.partido-votos').value) || 0;
        const proponentes = [];
        row.querySelectorAll('.proponente-input').forEach(inp => proponentes.push(inp.value.trim()));
        totalVotos += votos;
        partidos.push({ nombre, votos, color: COLORES[i % COLORES.length], idx: i, proponentes });
    });

    partidos = partidos.map(p => ({
        ...p,
        habilitado: umbral === 0 || (totalVotos > 0 && (p.votos / totalVotos * 100) >= umbral)
    }));

    ejecutarDhondt(partidos, cargos, false);
}

function calcularModo2() {
    const cargos = Math.min(Math.max(parseInt(document.getElementById('num-cargos-m2').value) || 6, 1), 20);
    const nListas = parseInt(document.getElementById('num-listas-m2').value) || 3;
    const nCand = parseInt(document.getElementById('num-candidatos-m2').value) || 4;
    const nMesas = parseInt(document.getElementById('num-mesas-m2').value) || 3;

    let partidos = [];
    let totalVotos = 0;

    for (let li = 0; li < nListas; li++) {
        const card = document.querySelector(`.lista-card[data-lista="${li}"]`);
        if (!card) continue;
        const nombre = card.querySelector('.lista-card-nombre').value.trim() || `Lista ${li + 1}`;
        const tbody = document.getElementById(`tbody-lista-${li}`);
        let totalLista = 0;
        const candidatos = [];

        tbody.querySelectorAll('tr').forEach((row, ci) => {
            if (ci >= nCand) return;
            const cNombre = row.querySelector('.candidato-nombre-input')?.value.trim() || `Candidato ${ci + 1}`;
            let totalCand = 0;
            row.querySelectorAll('.mesa-input').forEach(inp => totalCand += parseInt(inp.value) || 0);
            totalLista += totalCand;
            candidatos.push({ nombre: cNombre, votos: totalCand });
        });

        // Ordenar candidatos por votos desc
        candidatos.sort((a, b) => b.votos - a.votos);

        totalVotos += totalLista;
        partidos.push({ nombre, votos: totalLista, color: COLORES[li % COLORES.length], idx: li, candidatos, habilitado: true });
    }

    partidos = partidos.map(p => ({ ...p, habilitado: p.votos > 0 }));
    ejecutarDhondt(partidos, cargos, true);
}

function ejecutarDhondt(partidos, cargos, esModo2) {
    // Calcular cocientes
    const cocientes = [];
    partidos.forEach(p => {
        if (!p.habilitado) return;
        for (let d = 1; d <= cargos; d++) {
            cocientes.push({ partido: p, divisor: d, valor: p.votos / d });
        }
    });
    cocientes.sort((a, b) => b.valor - a.valor);
    const ganadores = cocientes.slice(0, cargos);
    const ganadoresSet = new Set(ganadores.map(g => `${g.partido.idx}-${g.divisor}`));

    const cargosPartido = {};
    partidos.forEach(p => cargosPartido[p.idx] = 0);
    ganadores.forEach(g => cargosPartido[g.partido.idx]++);

    // Tabla cocientes
    const tabla = document.getElementById('tabla-cocientes');
    let thead = '<thead><tr><th>Lista / Partido</th>';
    for (let d = 1; d <= cargos; d++) thead += `<th>÷ ${d}</th>`;
    thead += '</tr></thead>';

    let tbody = '<tbody>';
    partidos.forEach(p => {
        tbody += `<tr><td><span style="display:inline-flex;align-items:center;gap:6px;">
            <span style="width:10px;height:10px;border-radius:50%;background:${p.color};display:inline-block;"></span>
            ${p.nombre}${!p.habilitado ? ' <span style="font-size:9px;color:#dc2626;font-weight:700;">✗ bajo umbral</span>' : ''}
        </span></td>`;
        for (let d = 1; d <= cargos; d++) {
            const val = p.habilitado ? (p.votos / d) : null;
            const clave = `${p.idx}-${d}`;
            const esG = ganadoresSet.has(clave);
            const fmt = val !== null ? val.toLocaleString('es-PY', {maximumFractionDigits:3}) : '—';
            tbody += esG
                ? `<td class="celda-ganadora" style="background:${p.color}22!important;color:${p.color}!important;">${fmt}</td>`
                : `<td>${fmt}</td>`;
        }
        tbody += '</tr>';
    });
    tbody += '</tbody>';
    tabla.innerHTML = thead + tbody;

    // Reparto final
    const repartoGrid = document.getElementById('reparto-grid');
    repartoGrid.innerHTML = '';
    partidos.forEach(p => {
        const cant = cargosPartido[p.idx] || 0;
        repartoGrid.innerHTML += `
        <div class="reparto-partido">
            <div class="reparto-dot" style="background:${p.color};"></div>
            <div class="reparto-info">
                <div class="reparto-nombre">${p.nombre}</div>
                <div class="reparto-label">${p.votos.toLocaleString('es-PY')} votos${!p.habilitado ? ' · excluido' : ''}</div>
            </div>
            <div>
                <div class="reparto-cargos" style="color:${p.color};">${cant}</div>
                <div class="reparto-label" style="text-align:center;">cargo${cant !== 1 ? 's' : ''}</div>
            </div>
        </div>`;
    });

    // Candidatos electos
    const electosTabla = document.getElementById('electos-tabla');
    let hayElectos = false;

    if (esModo2) {
        // Modo 2: ordenar todos los candidatos electos por votos desc
        let todosElectos = [];
        partidos.forEach(p => {
            const cant = cargosPartido[p.idx] || 0;
            if (cant > 0 && p.candidatos) {
                p.candidatos.slice(0, cant).forEach((c, ci) => {
                    todosElectos.push({ lista: p.nombre, color: p.color, nombre: c.nombre, votos: c.votos, pos: ci + 1 });
                });
            }
        });
        todosElectos.sort((a, b) => b.votos - a.votos);

        if (todosElectos.length > 0) {
            hayElectos = true;
            let html = `<thead><tr>
                <th>#</th><th>Candidato</th><th>Lista</th><th style="text-align:right;">Votos</th>
            </tr></thead><tbody>`;
            todosElectos.forEach((e, i) => {
                html += `<tr>
                    <td style="font-family:'IBM Plex Mono',monospace;font-weight:700;color:#6b7280;">${i+1}</td>
                    <td style="font-weight:600;color:#111827;">${e.nombre || '—'}</td>
                    <td><span style="display:inline-flex;align-items:center;gap:5px;">
                        <span style="width:8px;height:8px;border-radius:50%;background:${e.color};display:inline-block;"></span>
                        ${e.lista}
                    </span></td>
                    <td style="text-align:right;font-family:'IBM Plex Mono',monospace;font-weight:700;color:#1e3a5f;">
                        ${e.votos.toLocaleString('es-PY')}
                    </td>
                </tr>`;
            });
            html += '</tbody>';
            electosTabla.innerHTML = html;
        }
    } else {
        // Modo 1: mostrar proponentes si los hay
        let todosElectos = [];
        partidos.forEach(p => {
            const cant = cargosPartido[p.idx] || 0;
            if (cant > 0 && p.proponentes && p.proponentes.length > 0) {
                p.proponentes.slice(0, cant).forEach((nombre, ci) => {
                    if (nombre) todosElectos.push({ lista: p.nombre, color: p.color, nombre, pos: ci + 1 });
                });
            }
        });

        if (todosElectos.length > 0) {
            hayElectos = true;
            let html = `<thead><tr><th>#</th><th>Candidato</th><th>Lista</th></tr></thead><tbody>`;
            todosElectos.forEach((e, i) => {
                html += `<tr>
                    <td style="font-family:'IBM Plex Mono',monospace;font-weight:700;color:#6b7280;">${i+1}</td>
                    <td style="font-weight:600;color:#111827;">${e.nombre}</td>
                    <td><span style="display:inline-flex;align-items:center;gap:5px;">
                        <span style="width:8px;height:8px;border-radius:50%;background:${e.color};display:inline-block;"></span>
                        ${e.lista}
                    </span></td>
                </tr>`;
            });
            html += '</tbody>';
            electosTabla.innerHTML = html;
        }
    }

    document.getElementById('electos-section').style.display = hayElectos ? 'block' : 'none';
    document.getElementById('resultado-tabla').classList.add('visible');
    document.getElementById('resultado-reparto').classList.add('visible');
    document.getElementById('resultado-tabla').scrollIntoView({ behavior: 'smooth', block: 'start' });
}

function limpiarTodo() {
    document.getElementById('resultado-tabla').classList.remove('visible');
    document.getElementById('resultado-reparto').classList.remove('visible');
    if (modoActual === 1) {
        document.querySelectorAll('.partido-votos').forEach(v => v.value = '');
    } else {
        document.querySelectorAll('.mesa-input').forEach(v => {
            v.value = '';
            const li = v.closest('.lista-card')?.dataset?.lista;
            if (li !== undefined) recalcularTotales(parseInt(li));
        });
    }
}

// Inicializar
document.getElementById('num-partidos').addEventListener('change', generarPartidos);
document.getElementById('num-proponentes').addEventListener('change', generarPartidos);
generarPartidos();
</script>

</x-panel-layout>
