<x-panel-layout title="Gestión de Log">
<div class="px-2 py-2">
    <div style="max-width:1000px; margin:0 auto;">

        @if(session('success'))
        <div style="background:#d1fae5; color:#065f46; padding:10px 14px; border-radius:8px; margin-bottom:14px; font-size:13px;">
            {{ session('success') }}
        </div>
        @endif

        {{-- HEADER --}}
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
            <div>
                <h2 style="font-size:16px; font-weight:700; color:#1e293b; margin:0;">Gestión de Log</h2>
                <p style="font-size:12px; color:#94a3b8; margin:2px 0 0;">Control de materiales prestados y devueltos</p>
            </div>
            <a href="{{ route('panel.dashboard') }}"
               style="font-size:12px; color:#94a3b8; text-decoration:none;">← Volver al panel</a>
        </div>
{{-- FILTRO --}}
<div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:12px 16px; margin-bottom:14px; box-shadow:0 1px 4px rgba(0,0,0,0.04); display:flex; align-items:center; gap:10px;">
    <svg width="14" height="14" fill="none" stroke="#9ca3af" stroke-width="2" viewBox="0 0 24 24">
        <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
    </svg>
    <input type="text" id="filtro-org" placeholder="Buscar organización..."
           oninput="filtrarTablas(this.value)"
           style="border:none; outline:none; font-size:13px; color:#374151; width:100%;">
</div>
        {{-- PENDIENTES --}}
        <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; overflow:hidden; box-shadow:0 1px 4px rgba(0,0,0,0.04); margin-bottom:14px;">
            <div style="padding:12px 16px; border-bottom:1px solid #f3f4f6; background:#fffbeb;">
                <span style="font-size:13px; font-weight:600; color:#92400e;">⏳ Pendientes de entrega ({{ $pendientes->count() }})</span>
            </div>
            <table style="width:100%; border-collapse:collapse; font-size:12px;">
                <thead>
                    <tr style="background:#f8fafc;">
                        <th style="padding:8px 16px; text-align:left; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Código</th>
                        <th style="padding:8px 16px; text-align:left; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Organización</th>
                        <th style="padding:8px 16px; text-align:left; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Asesor</th>
                        <th style="padding:8px 16px; text-align:center; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Urnas</th>
                        <th style="padding:8px 16px; text-align:center; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Cuartos</th>
                        <th style="padding:8px 16px; text-align:center; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Tintas</th>
                        <th style="padding:8px 16px; text-align:left; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendientes as $entrada)
                    <tr style="border-bottom:1px solid #f3f4f6;" data-org="{{ $entrada->nombre_organizacion }}">
                        <td style="padding:10px 16px; color:#185FA5; font-weight:600; font-family:monospace;">{{ $entrada->codigo_org }}</td>
                        <td style="padding:10px 16px; color:#1e293b; font-weight:500;">{{ $entrada->nombre_organizacion }}</td>
                        <td style="padding:6px 16px; color:#374151;">{{ $entrada->asesor_asignado ?? '—' }}</td>
                       @php
    $mTec = $entrada->detalleTecnico;
    $m = $mTec->cantidad_mesas ?? 0;
    $p = $mTec->cantidad_papeletas ?? 0;
    $gUrnas   = ($entrada->asunto_tec && $entrada->asunto_log) ? ($mTec->mat_final_urnas ?? ($m * $p)) : ($entrada->log_urnas ?? 0);
    $gCuartos = ($entrada->asunto_tec && $entrada->asunto_log) ? ($mTec->mat_final_cuartos ?? $m) : ($entrada->log_cuartos ?? 0);
    $gTintas  = ($entrada->asunto_tec && $entrada->asunto_log) ? ($mTec->mat_final_tintas ?? $m) : ($entrada->log_tintas ?? 0);
@endphp
<td style="padding:10px 16px; text-align:center; color:#374151;">{{ $gUrnas }}</td>
<td style="padding:10px 16px; text-align:center; color:#374151;">{{ $gCuartos }}</td>
<td style="padding:10px 16px; text-align:center; color:#374151;">{{ $gTintas }}</td>
                        <td style="padding:10px 16px;">
   @if($entrada->asunto_log && !$entrada->asunto_tec)
    <button onclick="abrirModalImprimir({{ $entrada->id }}, '{{ addslashes($entrada->nombre_organizacion) }}')"
            style="display:inline-flex; align-items:center; gap:5px; background:#f0f9ff; border:1px solid #bae6fd; color:#0369a1; padding:4px 10px; border-radius:6px; font-size:11px; cursor:pointer; font-weight:500;">
        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <polyline points="6 9 6 2 18 2 18 9"/>
            <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
            <rect x="6" y="14" width="12" height="8"/>
        </svg>
        Imprimir Log
    </button>
@elseif($entrada->asunto_tec && $entrada->detalleTecnico?->impreso)
    <form method="POST" action="{{ route('secretaria.con-nota.entregar-tec', $entrada) }}">
        @csrf @method('PATCH')
        <button type="submit" onclick="return confirm('¿Confirmar entrega a {{ addslashes($entrada->nombre_organizacion) }}?')"
                style="display:inline-flex; align-items:center; gap:5px; background:#dcfce7; border:1px solid #86efac; color:#166534; padding:4px 10px; border-radius:6px; font-size:11px; cursor:pointer; font-weight:500;">
            ✓ Entregar
        </button>
    </form>
@else
    <span style="font-size:11px; color:#94a3b8;">Sin imprimir Tec</span>
@endif
</td>
</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="padding:30px; text-align:center; color:#94a3b8; font-size:13px;">
                            ✅ No hay log pendientes.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ENTREGADOS (prestados, esperando devolución) --}}
        <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; overflow:hidden; box-shadow:0 1px 4px rgba(0,0,0,0.04); margin-bottom:14px;">
            <div style="padding:12px 16px; border-bottom:1px solid #f3f4f6; background:#eff6ff;">
                <span style="font-size:13px; font-weight:600; color:#1d4ed8;">📦 Entregados — esperando devolución ({{ $entregados->count() }})</span>
            </div>
            <table style="width:100%; border-collapse:collapse; font-size:12px;">
                <thead>
                    <tr style="background:#f8fafc;">
                        <th style="padding:8px 16px; text-align:left; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Código</th>
                        <th style="padding:8px 16px; text-align:left; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Organización</th>
<th style="padding:8px 16px; text-align:center; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; width:60px;">Urnas</th>
<th style="padding:8px 16px; text-align:center; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; width:60px;">Cuartos</th>
<th style="padding:8px 16px; text-align:center; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; width:60px;">Tintas</th>
                        <th style="padding:8px 16px; text-align:left; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($entregados as $entrada)
<tr style="border-bottom:1px solid #f3f4f6;" data-org="{{ $entrada->nombre_organizacion }}">
    <td style="padding:10px 16px; color:#185FA5; font-weight:600; font-family:monospace;">{{ $entrada->codigo_org }}</td>
    <td style="padding:10px 16px; color:#1e293b; font-weight:500;">{{ $entrada->nombre_organizacion }}</td>
    @php
        $urnas   = ($entrada->asunto_tec && $entrada->asunto_log) ? ($entrada->detalleTecnico->mat_final_urnas  ?? 0) : ($entrada->asunto_log ? $entrada->log_urnas : 0);
$cuartos = ($entrada->asunto_tec && $entrada->asunto_log) ? ($entrada->detalleTecnico->mat_final_cuartos ?? 0) : ($entrada->asunto_log ? $entrada->log_cuartos : 0);
$tintas  = ($entrada->asunto_tec && $entrada->asunto_log) ? ($entrada->detalleTecnico->mat_final_tintas  ?? 0) : ($entrada->asunto_log ? $entrada->log_tintas : 0);
    @endphp
    <td style="padding:10px 16px; text-align:center; color:#374151;">{{ $urnas }}</td>
    <td style="padding:10px 16px; text-align:center; color:#374151;">{{ $cuartos }}</td>
    <td style="padding:10px 16px; text-align:center; color:#374151;">{{ $tintas }}</td>
                        <td style="padding:10px 16px;">
                           @if($entrada->asunto_log)
<button onclick="abrirModal({{ $entrada->id }}, '{{ addslashes($entrada->nombre_organizacion) }}', {{ $urnas }}, {{ $cuartos }}, {{ $tintas }})"
    style="background:#2563eb; color:white; border:none; padding:4px 8px; border-radius:6px; font-size:11px; cursor:pointer; font-weight:500; white-space:nowrap;">
    Registrar devolución
</button>
@else
<span style="font-size:11px; color:#16a34a; font-weight:500;">✓ Entregado</span>
@endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="padding:30px; text-align:center; color:#94a3b8; font-size:13px;">
                            Sin materiales entregados pendientes de devolución.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- DEVUELTOS --}}
        <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; overflow:hidden; box-shadow:0 1px 4px rgba(0,0,0,0.04);">
            <div style="padding:12px 16px; border-bottom:1px solid #f3f4f6; background:#f0fdf4;">
                <span style="font-size:13px; font-weight:600; color:#15803d;">✅ Devueltos ({{ $devueltos->count() }})</span>
            </div>
            <table style="width:100%; border-collapse:collapse; font-size:12px;">
                <thead>
                    <tr style="background:#f8fafc;">
                        <th style="padding:8px 16px; text-align:left; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Código</th>
                        <th style="padding:8px 16px; text-align:left; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Organización</th>
                        <th style="padding:8px 16px; text-align:left; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Devuelto por</th>
                        <th style="padding:8px 16px; text-align:center; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Urnas</th>
                        <th style="padding:8px 16px; text-align:center; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Cuartos</th>
                        <th style="padding:8px 16px; text-align:center; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Tintas</th>
                        <th style="padding:8px 16px; text-align:left; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($devueltos as $entrada)
                    <tr style="border-bottom:1px solid #f3f4f6;" data-org="{{ $entrada->nombre_organizacion }}">
                        <td style="padding:10px 16px; color:#185FA5; font-weight:600; font-family:monospace;">{{ $entrada->codigo_org }}</td>
                        <td style="padding:10px 16px; color:#1e293b; font-weight:500;">{{ $entrada->nombre_organizacion }}</td>
                        <td style="padding:10px 16px; color:#374151;">{{ $entrada->logDevolucion?->devuelto_por ?? '—' }}</td>
                        <td style="padding:10px 16px; text-align:center; color:#374151;">{{ $entrada->logDevolucion?->urnas_devueltas ?? '—' }}</td>
                        <td style="padding:10px 16px; text-align:center; color:#374151;">{{ $entrada->logDevolucion?->cuartos_devueltos ?? '—' }}</td>
                        <td style="padding:10px 16px; text-align:center; color:#374151;">{{ $entrada->logDevolucion?->tintas_devueltas ?? '—' }}</td>
                        <td style="padding:10px 16px; color:#94a3b8;">{{ $entrada->logDevolucion?->created_at?->format('d/m/Y') ?? '—' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="padding:30px; text-align:center; color:#94a3b8; font-size:13px;">
                            Sin devoluciones registradas todavía.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

{{-- MODAL DEVOLUCIÓN --}}
<div id="modal-devolucion" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.4); z-index:50; align-items:center; justify-content:center;">
    <div style="background:white; border-radius:12px; padding:28px; max-width:480px; width:90%; box-shadow:0 20px 60px rgba(0,0,0,0.3);">
        <h3 style="font-size:15px; font-weight:700; color:#1e293b; margin-bottom:4px;">Registrar devolución</h3>
        <p id="modal-org" style="font-size:12px; color:#94a3b8; margin-bottom:18px;"></p>

        <form id="form-devolucion" method="POST">
            @csrf
            <div style="margin-bottom:12px;">
                <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Nombre de quien devuelve *</label>
                <input type="text" name="devuelto_por" required
                       style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:12px; margin-bottom:12px;">
                <div>
                    <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Urnas</label>
                    <input type="number" name="urnas_devueltas" id="modal-urnas" min="0"
                           style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
                </div>
                <div>
                    <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Cuartos</label>
                    <input type="number" name="cuartos_devueltos" id="modal-cuartos" min="0"
                           style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
                </div>
                <div>
                    <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Tintas</label>
                    <input type="number" name="tintas_devueltas" id="modal-tintas" min="0"
                           style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
                </div>
            </div>
            <div style="margin-bottom:18px;">
                <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Observaciones</label>
                <textarea name="observaciones" rows="2" placeholder="Opcional..."
                          style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box; resize:vertical;"></textarea>
            </div>
            <div style="display:flex; gap:10px; justify-content:flex-end;">
                <button type="button" onclick="document.getElementById('modal-devolucion').style.display='none'"
                        style="padding:8px 18px; border-radius:8px; border:1px solid #e5e7eb; background:white; color:#374151; font-size:13px; cursor:pointer;">
                    Cancelar
                </button>
                <button type="submit"
                        style="padding:8px 18px; border-radius:8px; border:none; background:#2563eb; color:white; font-size:13px; cursor:pointer; font-weight:500;">
                    Confirmar devolución
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function abrirModal(id, org, urnas, cuartos, tintas) {
    document.getElementById('modal-org').textContent = org;
    document.getElementById('modal-urnas').value = urnas;
    document.getElementById('modal-cuartos').value = cuartos;
    document.getElementById('modal-tintas').value = tintas;
    document.getElementById('form-devolucion').action = '/secretaria/sin-nota/log/' + id + '/devolucion';
    document.getElementById('modal-devolucion').style.display = 'flex';
}

function filtrarTablas(valor) {
    valor = valor.toLowerCase();
    document.querySelectorAll('tbody tr[data-org]').forEach(function(tr) {
        tr.style.display = tr.dataset.org.toLowerCase().includes(valor) ? '' : 'none';
    });
}

function abrirModalImprimir(id, org) {
    document.getElementById('modal-imprimir-org').textContent = org;
    document.getElementById('btn-confirmar-imprimir').href = '/secretaria/con-nota/' + id + '/recibo-logistica';
    document.getElementById('modal-imprimir').style.display = 'flex';
}
</script>

{{-- MODAL CONFIRMAR IMPRESION --}}
<div id="modal-imprimir" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.4); z-index:50; align-items:center; justify-content:center;">
    <div style="background:white; border-radius:12px; padding:28px; max-width:420px; width:90%; box-shadow:0 20px 60px rgba(0,0,0,0.3); text-align:center;">
        <div style="font-size:36px; margin-bottom:12px;">🖨️</div>
        <h3 style="font-size:15px; font-weight:700; color:#1e293b; margin-bottom:6px;">Confirmar entrega de materiales</h3>
        <p id="modal-imprimir-org" style="font-size:13px; color:#64748b; margin-bottom:20px;"></p>
        <p style="font-size:12px; color:#94a3b8; margin-bottom:20px;">Al confirmar se imprimirá el recibo y los materiales quedarán registrados como entregados.</p>
        <div style="display:flex; gap:10px; justify-content:center;">
            <button onclick="document.getElementById('modal-imprimir').style.display='none'"
                    style="padding:8px 18px; border-radius:8px; border:1px solid #e5e7eb; background:white; color:#374151; font-size:13px; cursor:pointer;">
                Cancelar
            </button>
            <a id="btn-confirmar-imprimir" href="#" target="_blank"
               onclick="document.getElementById('modal-imprimir').style.display='none'"
               style="padding:8px 18px; border-radius:8px; border:none; background:#0369a1; color:white; font-size:13px; cursor:pointer; font-weight:500; text-decoration:none;">
                Confirmar e imprimir
            </a>
        </div>
    </div>
</div>
</x-panel-layout>
