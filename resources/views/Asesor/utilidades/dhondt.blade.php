<x-panel-layout title="Calculadora D'Hondt" :charlasPendientes="$charlasPendientes">

<style>
@import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;600&family=IBM+Plex+Sans:wght@400;500;600;700&display=swap');

.dhondt-wrap {
    font-family: 'IBM Plex Sans', sans-serif;
    max-width: 900px;
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
.dhondt-header h1 {
    font-size: 22px;
    font-weight: 700;
    color: #fff;
    margin: 0 0 6px;
    letter-spacing: -0.3px;
}
.dhondt-header p {
    font-size: 13px;
    color: rgba(255,255,255,0.6);
    margin: 0;
}

.config-card {
    background: #fff;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
    padding: 20px 24px;
    margin-bottom: 16px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.05);
}
.config-card h2 {
    font-size: 12px;
    font-weight: 700;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    margin: 0 0 16px;
}

.config-row {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 14px;
    margin-bottom: 16px;
}

.field-label {
    display: block;
    font-size: 11px;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 6px;
}
.field-input {
    width: 100%;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 8px 12px;
    font-size: 13px;
    color: #111827;
    outline: none;
    box-sizing: border-box;
    font-family: 'IBM Plex Sans', sans-serif;
    transition: border-color 0.15s;
}
.field-input:focus { border-color: #1e3a5f; }

.partidos-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 10px;
}

.partido-row {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 10px 12px;
}
.partido-color {
    width: 14px;
    height: 14px;
    border-radius: 50%;
    flex-shrink: 0;
}
.partido-nombre {
    flex: 1;
    border: none;
    background: transparent;
    font-size: 13px;
    color: #374151;
    outline: none;
    font-family: 'IBM Plex Sans', sans-serif;
    font-weight: 500;
}
.partido-nombre::placeholder { color: #d1d5db; }
.partido-votos {
    width: 100px;
    border: 1px solid #e5e7eb;
    border-radius: 6px;
    padding: 5px 8px;
    font-size: 13px;
    font-family: 'IBM Plex Mono', monospace;
    color: #1e3a5f;
    font-weight: 600;
    text-align: right;
    outline: none;
    background: #fff;
}
.partido-votos:focus { border-color: #1e3a5f; }

.btn-calcular {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #1e3a5f;
    color: white;
    padding: 10px 24px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    font-family: 'IBM Plex Sans', sans-serif;
    transition: background 0.15s;
}
.btn-calcular:hover { background: #162d4a; }

.btn-limpiar {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #f3f4f6;
    color: #374151;
    padding: 10px 20px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 500;
    border: none;
    cursor: pointer;
    font-family: 'IBM Plex Sans', sans-serif;
}

/* TABLA RESULTADO */
.resultado-card {
    background: #fff;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
    padding: 20px 24px;
    margin-bottom: 16px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.05);
    display: none;
}
.resultado-card.visible { display: block; }

.tabla-dhondt {
    width: 100%;
    border-collapse: collapse;
    font-family: 'IBM Plex Mono', monospace;
    font-size: 12px;
    margin-bottom: 20px;
}
.tabla-dhondt th {
    background: #1e3a5f;
    color: #fff;
    padding: 8px 10px;
    text-align: center;
    font-weight: 600;
    font-size: 11px;
    letter-spacing: 0.5px;
}
.tabla-dhondt th:first-child { text-align: left; border-radius: 6px 0 0 0; }
.tabla-dhondt th:last-child { border-radius: 0 6px 0 0; }
.tabla-dhondt td {
    padding: 7px 10px;
    text-align: center;
    border-bottom: 1px solid #f3f4f6;
    color: #374151;
}
.tabla-dhondt td:first-child { text-align: left; font-family: 'IBM Plex Sans', sans-serif; font-weight: 600; }
.tabla-dhondt tr:hover td { background: #f9fafb; }

.celda-ganadora {
    background: #fef9c3 !important;
    font-weight: 700;
    color: #92400e !important;
    border-radius: 4px;
    position: relative;
}
.celda-ganadora::after {
    content: '✓';
    font-size: 9px;
    margin-left: 3px;
    color: #16a34a;
}

/* REPARTO FINAL */
.reparto-section h3 {
    font-size: 12px;
    font-weight: 700;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    margin: 0 0 14px;
}
.reparto-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}
.reparto-partido {
    display: flex;
    align-items: center;
    gap: 8px;
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    padding: 10px 16px;
    min-width: 160px;
}
.reparto-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    flex-shrink: 0;
}
.reparto-info { flex: 1; }
.reparto-nombre {
    font-size: 12px;
    font-weight: 600;
    color: #374151;
}
.reparto-cargos {
    font-size: 20px;
    font-weight: 700;
    font-family: 'IBM Plex Mono', monospace;
}
.reparto-label {
    font-size: 10px;
    color: #9ca3af;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.candidatos-row {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    margin-top: 16px;
    padding-top: 16px;
    border-top: 1px solid #f3f4f6;
}
.candidato-chip {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    color: #fff;
}
.candidato-num {
    background: rgba(0,0,0,0.2);
    border-radius: 50%;
    width: 16px;
    height: 16px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 9px;
    font-weight: 700;
}

.info-box {
    background: #eff6ff;
    border: 1px solid #bfdbfe;
    border-radius: 10px;
    padding: 12px 16px;
    margin-bottom: 16px;
    font-size: 12px;
    color: #1e40af;
    line-height: 1.6;
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

    {{-- CONFIGURACIÓN --}}
    <div class="config-card">
        <h2>Configuración</h2>
        <div class="config-row">
            <div>
                <label class="field-label">Cargos a elegir</label>
                <input type="number" id="num-cargos" class="field-input" min="1" max="20" value="6" placeholder="Ej: 6">
            </div>
            <div>
                <label class="field-label">Cantidad de listas/partidos</label>
                <input type="number" id="num-partidos" class="field-input" min="2" max="20" value="5" placeholder="Ej: 5">
            </div>
            <div>
                <label class="field-label">Umbral mínimo (%)</label>
                <input type="number" id="umbral" class="field-input" min="0" max="50" value="0" step="0.1" placeholder="Ej: 3">
                <span style="font-size:10px; color:#9ca3af; margin-top:3px; display:block;">0 = sin umbral</span>
            </div>
        </div>
        <button class="btn-limpiar" onclick="generarPartidos()" style="margin-bottom:0;">
            Actualizar formulario
        </button>
    </div>

    {{-- PARTIDOS --}}
    <div class="config-card">
        <h2>Listas / Partidos / Movimientos</h2>
        <div class="partidos-grid" id="partidos-container"></div>
    </div>

    {{-- BOTONES --}}
    <div style="display:flex; gap:10px; margin-bottom:20px;">
        <button class="btn-calcular" onclick="calcularDhondt()">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
            </svg>
            Calcular D'Hondt
        </button>
        <button class="btn-limpiar" onclick="limpiarTodo()">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-4"/>
            </svg>
            Limpiar
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
        <div class="reparto-section">
            <h3>Reparto final de cargos</h3>
            <div class="reparto-grid" id="reparto-grid"></div>
        </div>
        <div id="candidatos-section" style="display:none;">
            <div style="height:1px; background:#f3f4f6; margin:20px 0;"></div>
            <p style="font-size:12px; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:0.8px; margin:0 0 12px;">Candidatos electos por lista</p>
            <div class="candidatos-row" id="candidatos-grid"></div>
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

function generarPartidos() {
    const n = Math.min(Math.max(parseInt(document.getElementById('num-partidos').value) || 5, 2), 20);
    const container = document.getElementById('partidos-container');
    const existentes = {};
    container.querySelectorAll('.partido-row').forEach((row, i) => {
        existentes[i] = {
            nombre: row.querySelector('.partido-nombre').value,
            votos:  row.querySelector('.partido-votos').value
        };
    });
    container.innerHTML = '';
    for (let i = 0; i < n; i++) {
        const color = COLORES[i % COLORES.length];
        const nombre = existentes[i]?.nombre || `Lista ${i + 1}`;
        const votos  = existentes[i]?.votos  || '';
        container.innerHTML += `
        <div class="partido-row">
            <div class="partido-color" style="background:${color};"></div>
            <input type="text" class="partido-nombre" value="${nombre}" placeholder="Nombre lista ${i+1}">
            <input type="number" class="partido-votos" value="${votos}" placeholder="Votos" min="0">
        </div>`;
    }
}

function calcularDhondt() {
    const cargos  = Math.min(Math.max(parseInt(document.getElementById('num-cargos').value) || 6, 1), 20);
    const umbral  = parseFloat(document.getElementById('umbral').value) || 0;
    const rows    = document.querySelectorAll('.partido-row');

    // Recopilar datos
    let partidos = [];
    let totalVotos = 0;
    rows.forEach((row, i) => {
        const nombre = row.querySelector('.partido-nombre').value.trim() || `Lista ${i+1}`;
        const votos  = parseInt(row.querySelector('.partido-votos').value) || 0;
        totalVotos += votos;
        partidos.push({ nombre, votos, color: COLORES[i % COLORES.length], idx: i });
    });

    // Aplicar umbral
    partidos = partidos.map(p => ({
        ...p,
        habilitado: umbral === 0 || (totalVotos > 0 && (p.votos / totalVotos * 100) >= umbral)
    }));

    // Calcular cocientes
    const cocientes = [];
    partidos.forEach(p => {
        if (!p.habilitado) return;
        for (let d = 1; d <= cargos; d++) {
            cocientes.push({ partido: p, divisor: d, valor: p.votos / d });
        }
    });

    // Ordenar y asignar cargos
    cocientes.sort((a, b) => b.valor - a.valor);
    const ganadores = cocientes.slice(0, cargos);
    const ganadoresSet = new Set(ganadores.map(g => `${g.partido.idx}-${g.divisor}`));

    const cargosPartido = {};
    partidos.forEach(p => cargosPartido[p.idx] = 0);
    ganadores.forEach(g => cargosPartido[g.partido.idx]++);

    // Construir tabla
    const tabla = document.getElementById('tabla-cocientes');
    let thead = '<thead><tr><th>Lista / Partido</th>';
    for (let d = 1; d <= cargos; d++) thead += `<th>÷ ${d}</th>`;
    thead += '</tr></thead>';

    let tbody = '<tbody>';
    partidos.forEach(p => {
        tbody += `<tr>`;
        tbody += `<td><span style="display:inline-flex;align-items:center;gap:6px;">
            <span style="width:10px;height:10px;border-radius:50%;background:${p.color};display:inline-block;flex-shrink:0;"></span>
            ${p.nombre}${!p.habilitado ? ' <span style="font-size:9px;color:#dc2626;font-weight:700;">✗ bajo umbral</span>' : ''}
        </span></td>`;
        for (let d = 1; d <= cargos; d++) {
            const val   = p.habilitado ? (p.votos / d) : '—';
            const clave = `${p.idx}-${d}`;
            const esGanador = ganadoresSet.has(clave);
            const valFmt = p.habilitado ? val.toLocaleString('es-PY', {maximumFractionDigits:3}) : '—';
            tbody += esGanador
                ? `<td class="celda-ganadora" style="background:${p.color}22!important;color:${p.color}!important;">${valFmt}</td>`
                : `<td>${valFmt}</td>`;
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

    // Chips candidatos
    const candidatosGrid = document.getElementById('candidatos-grid');
    candidatosGrid.innerHTML = '';
    let hayCandidatos = false;
    partidos.forEach(p => {
        const cant = cargosPartido[p.idx] || 0;
        if (cant > 0) {
            hayCandidatos = true;
            for (let c = 1; c <= cant; c++) {
                candidatosGrid.innerHTML += `
                <span class="candidato-chip" style="background:${p.color};">
                    <span class="candidato-num">${c}</span>
                    ${p.nombre}
                </span>`;
            }
        }
    });
    document.getElementById('candidatos-section').style.display = hayCandidatos ? 'block' : 'none';

    // Mostrar resultados
    document.getElementById('resultado-tabla').classList.add('visible');
    document.getElementById('resultado-reparto').classList.add('visible');
    document.getElementById('resultado-tabla').scrollIntoView({ behavior: 'smooth', block: 'start' });
}

function limpiarTodo() {
    document.getElementById('resultado-tabla').classList.remove('visible');
    document.getElementById('resultado-reparto').classList.remove('visible');
    document.querySelectorAll('.partido-votos').forEach(v => v.value = '');
}

// Inicializar
document.getElementById('num-partidos').addEventListener('change', generarPartidos);
generarPartidos();
</script>

</x-panel-layout>
