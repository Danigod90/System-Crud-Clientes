<x-panel-layout title="Gestión de Log">
<div class="px-2 py-2">
    <div style="max-width:1200px; margin:0 auto;">

        @if(session('success'))
        <div style="background:#d1fae5; color:#065f46; padding:10px 14px; border-radius:8px; margin-bottom:14px; font-size:13px;">
            {{ session('success') }}
        </div>
        @endif

        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
            <div>
                <h2 style="font-size:16px; font-weight:700; color:#1e293b; margin:0;">Gestión de Log</h2>
                <p style="font-size:12px; color:#94a3b8; margin:2px 0 0;">Control de materiales prestados y devueltos</p>
            </div>
            <a href="{{ route('panel.dashboard') }}"
               style="display:inline-flex; align-items:center; gap:6px; background:#2563eb; color:#fff; padding:7px 14px; border-radius:8px; font-size:12px; font-weight:500; text-decoration:none;">
                ← Volver al panel
            </a>
        </div>

        <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:10px 16px; margin-bottom:14px; box-shadow:0 1px 4px rgba(0,0,0,0.04); display:flex; align-items:center; gap:10px;">
            <svg width="14" height="14" fill="none" stroke="#9ca3af" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            <input type="text" id="filtro-org" placeholder="Buscar organización en todas las grillas..."
                   oninput="filtrarTablas(this.value)"
                   style="border:none; outline:none; font-size:13px; color:#374151; width:100%;">
        </div>

        {{-- PENDIENTES --}}
        <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; box-shadow:0 1px 4px rgba(0,0,0,0.04); margin-bottom:14px; overflow:hidden;">
            <div style="padding:10px 16px; border-bottom:1px solid #f3f4f6; background:#fffbeb; display:flex; align-items:center; justify-content:space-between;">
                <span style="font-size:13px; font-weight:600; color:#92400e;">⏳ Pendientes de entrega</span>
                <span style="font-size:11px; font-weight:600; background:#fef3c7; color:#92400e; padding:2px 8px; border-radius:20px;">{{ $pendientes->count() }}</span>
            </div>
            <div class="tabla-scroll" style="overflow-y:auto; max-height:280px;">
                <table style="width:100%; border-collapse:collapse; font-size:12px;">
                    <thead style="position:sticky; top:0; z-index:2;">
                        <tr style="background:#f8fafc;">
                            <th style="padding:7px 12px; text-align:left; font-size:10px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; white-space:nowrap;">Código</th>
                            <th style="padding:7px 12px; text-align:left; font-size:10px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Organización</th>
                            <th style="padding:7px 12px; text-align:left; font-size:10px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Asunto</th>
                            <th style="padding:7px 12px; text-align:left; font-size:10px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Asesor</th>
                            <th style="padding:7px 12px; text-align:center; font-size:10px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Urnas</th>
                            <th style="padding:7px 12px; text-align:center; font-size:10px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Cuartos</th>
                            <th style="padding:7px 12px; text-align:center; font-size:10px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Tintas</th>
                            <th style="padding:7px 12px; text-align:left; font-size:10px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendientes as $entrada)
                        @php
                            $mTec    = $entrada->detalleTecnico;
                            $m       = $mTec->cantidad_mesas ?? 0;
                            $p       = $mTec->cantidad_papeletas ?? 0;
                            $urnas   = ($entrada->asunto_tec && $entrada->asunto_log) ? ($mTec->mat_final_urnas   ?? ($m * $p)) : ($entrada->asunto_log ? $entrada->log_urnas   : 0);
                            $cuartos = ($entrada->asunto_tec && $entrada->asunto_log) ? ($mTec->mat_final_cuartos ?? $m)        : ($entrada->asunto_log ? $entrada->log_cuartos : 0);
                            $tintas  = ($entrada->asunto_tec && $entrada->asunto_log) ? ($mTec->mat_final_tintas  ?? $m)        : ($entrada->asunto_log ? $entrada->log_tintas  : 0);
                        @endphp
                        <tr style="border-bottom:1px solid #f3f4f6;" data-org="{{ $entrada->nombre_organizacion }}">
                            <td style="padding:7px 12px; color:#185FA5; font-weight:600; font-family:monospace; white-space:nowrap; font-size:11px;">{{ $entrada->codigo_org }}</td>
                            <td style="padding:7px 12px; color:#1e293b; font-weight:500; font-size:12px;">{{ $entrada->nombre_organizacion }}</td>
                            <td style="padding:7px 12px;">
                                @if($entrada->asunto_tec && $entrada->asunto_log)
                                    <span style="display:inline-flex; gap:4px;">
                                        <span style="background:#ede9fe; color:#6d28d9; font-size:10px; font-weight:600; padding:2px 6px; border-radius:4px;">TEC</span>
                                        <span style="background:#d1fae5; color:#065f46; font-size:10px; font-weight:600; padding:2px 6px; border-radius:4px;">LOG</span>
                                    </span>
                                @elseif($entrada->asunto_tec)
                                    <span style="background:#ede9fe; color:#6d28d9; font-size:10px; font-weight:600; padding:2px 6px; border-radius:4px;">TEC</span>
                                @elseif($entrada->asunto_log)
                                    <span style="background:#d1fae5; color:#065f46; font-size:10px; font-weight:600; padding:2px 6px; border-radius:4px;">LOG</span>
                                @endif
                            </td>
                            <td style="padding:7px 12px; color:#374151; font-size:12px; white-space:nowrap;">{{ $entrada->asesor_asignado ?? '—' }}</td>
                            <td style="padding:7px 12px; text-align:center; color:#374151; font-size:12px;">{{ $urnas }}</td>
                            <td style="padding:7px 12px; text-align:center; color:#374151; font-size:12px;">{{ $cuartos }}</td>
                            <td style="padding:7px 12px; text-align:center; color:#374151; font-size:12px;">{{ $tintas }}</td>
                            <td style="padding:7px 12px; white-space:nowrap;">
                                @if($entrada->asunto_log && !$entrada->asunto_tec)
                                    <button onclick="abrirModalImprimirLog({{ $entrada->id }}, '{{ addslashes($entrada->nombre_organizacion) }}')"
                                            style="display:inline-flex; align-items:center; gap:4px; background:#f0f9ff; border:1px solid #bae6fd; color:#0369a1; padding:3px 8px; border-radius:6px; font-size:11px; cursor:pointer; font-weight:500;">
                                        <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <polyline points="6 9 6 2 18 2 18 9"/>
                                            <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                                            <rect x="6" y="14" width="12" height="8"/>
                                        </svg>
                                        Imprimir Log
                                    </button>
                                @elseif($entrada->asunto_tec && $entrada->detalleTecnico?->impreso)
                                    <button onclick="abrirModalEntregar({{ $entrada->id }}, '{{ addslashes($entrada->nombre_organizacion) }}')"
                                            style="display:inline-flex; align-items:center; gap:4px; background:#dcfce7; border:1px solid #86efac; color:#166534; padding:3px 8px; border-radius:6px; font-size:11px; cursor:pointer; font-weight:500;">
                                        ✓ Entregar
                                    </button>
                                @else
                                    <span style="font-size:11px; color:#94a3b8;">Sin imprimir Tec</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="8" style="padding:24px; text-align:center; color:#94a3b8; font-size:13px;">✅ No hay log pendientes.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ENTREGADOS --}}
        <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; box-shadow:0 1px 4px rgba(0,0,0,0.04); margin-bottom:14px; overflow:hidden;">
            <div style="padding:10px 16px; border-bottom:1px solid #f3f4f6; background:#eff6ff; display:flex; align-items:center; justify-content:space-between;">
                <span style="font-size:13px; font-weight:600; color:#1d4ed8;">📦 Entregados — esperando devolución</span>
                <span style="font-size:11px; font-weight:600; background:#dbeafe; color:#1d4ed8; padding:2px 8px; border-radius:20px;">{{ $entregados->count() }}</span>
            </div>
            <div class="tabla-scroll" style="overflow-y:auto; max-height:280px;">
                <table style="width:100%; border-collapse:collapse; font-size:12px;">
                    <thead style="position:sticky; top:0; z-index:2;">
                        <tr style="background:#f8fafc;">
                            <th style="padding:7px 12px; text-align:left; font-size:10px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; white-space:nowrap;">Código</th>
                            <th style="padding:7px 12px; text-align:left; font-size:10px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Organización</th>
                            <th style="padding:7px 12px; text-align:left; font-size:10px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Asunto</th>
                            <th style="padding:7px 12px; text-align:left; font-size:10px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Asesor</th>
                            <th style="padding:7px 12px; text-align:center; font-size:10px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Urnas</th>
                            <th style="padding:7px 12px; text-align:center; font-size:10px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Cuartos</th>
                            <th style="padding:7px 12px; text-align:center; font-size:10px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Tintas</th>
                            <th style="padding:7px 12px; text-align:left; font-size:10px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; white-space:nowrap;">Funcionario entrega</th>
                            <th style="padding:7px 12px; text-align:left; font-size:10px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; white-space:nowrap;">Fecha entrega</th>
                            <th style="padding:7px 12px; text-align:left; font-size:10px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($entregados as $entrada)
                        @php
                            $mTec    = $entrada->detalleTecnico;
                            $m       = $mTec->cantidad_mesas ?? 0;
                            $p       = $mTec->cantidad_papeletas ?? 0;
                            $urnas   = ($entrada->asunto_tec && $entrada->asunto_log) ? ($mTec->mat_final_urnas   ?? ($m * $p)) : ($entrada->asunto_log ? $entrada->log_urnas   : 0);
                            $cuartos = ($entrada->asunto_tec && $entrada->asunto_log) ? ($mTec->mat_final_cuartos ?? $m)        : ($entrada->asunto_log ? $entrada->log_cuartos : 0);
                            $tintas  = ($entrada->asunto_tec && $entrada->asunto_log) ? ($mTec->mat_final_tintas  ?? $m)        : ($entrada->asunto_log ? $entrada->log_tintas  : 0);
                            $fechaEntregaJs = $entrada->fecha_entrega ? $entrada->fecha_entrega->format('Y-m-d\TH:i') : '';
                        @endphp
                        <tr style="border-bottom:1px solid #f3f4f6;" data-org="{{ $entrada->nombre_organizacion }}">
                            <td style="padding:7px 12px; color:#185FA5; font-weight:600; font-family:monospace; white-space:nowrap; font-size:11px;">{{ $entrada->codigo_org }}</td>
                            <td style="padding:7px 12px; color:#1e293b; font-weight:500; font-size:12px;">{{ $entrada->nombre_organizacion }}</td>
                            <td style="padding:7px 12px;">
                                @if($entrada->asunto_tec && $entrada->asunto_log)
                                    <span style="display:inline-flex; gap:4px;">
                                        <span style="background:#ede9fe; color:#6d28d9; font-size:10px; font-weight:600; padding:2px 6px; border-radius:4px;">TEC</span>
                                        <span style="background:#d1fae5; color:#065f46; font-size:10px; font-weight:600; padding:2px 6px; border-radius:4px;">LOG</span>
                                    </span>
                                @elseif($entrada->asunto_tec)
                                    <span style="background:#ede9fe; color:#6d28d9; font-size:10px; font-weight:600; padding:2px 6px; border-radius:4px;">TEC</span>
                                @elseif($entrada->asunto_log)
                                    <span style="background:#d1fae5; color:#065f46; font-size:10px; font-weight:600; padding:2px 6px; border-radius:4px;">LOG</span>
                                @endif
                            </td>
                            <td style="padding:7px 12px; color:#374151; font-size:12px; white-space:nowrap;">{{ $entrada->asesor_asignado ?? '—' }}</td>
                            <td style="padding:7px 12px; text-align:center; color:#374151; font-size:12px;">{{ $urnas }}</td>
                            <td style="padding:7px 12px; text-align:center; color:#374151; font-size:12px;">{{ $cuartos }}</td>
                            <td style="padding:7px 12px; text-align:center; color:#374151; font-size:12px;">{{ $tintas }}</td>
                            <td style="padding:7px 12px; color:#374151; font-size:12px;">{{ $entrada->entregado_por ?? '—' }}</td>
                            <td style="padding:7px 12px; color:#94a3b8; white-space:nowrap; font-size:11px;">{{ $entrada->fecha_entrega ? $entrada->fecha_entrega->format('d/m/Y H:i') : '—' }}</td>
                            <td style="padding:7px 12px; white-space:nowrap;">
                                <div style="display:flex; gap:5px; align-items:center;">
                                    <button onclick="abrirModalDetalleEntrega({{ $entrada->id }}, '{{ addslashes($entrada->nombre_organizacion) }}', '{{ addslashes($entrada->entregado_por ?? '') }}', '{{ $fechaEntregaJs }}', '{{ addslashes($entrada->persona_retira ?? '') }}', '{{ addslashes($entrada->telefono_retira ?? '') }}')"
                                            title="Ver detalle de entrega"
                                            style="display:inline-flex; align-items:center; justify-content:center; background:#f8fafc; border:1px solid #e5e7eb; color:#6b7280; padding:3px 6px; border-radius:6px; font-size:11px; cursor:pointer; line-height:1;">
                                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                            <circle cx="12" cy="12" r="3"/>
                                        </svg>
                                    </button>
                                    @if($entrada->asunto_log)
                                        <button onclick="abrirModal({{ $entrada->id }}, '{{ addslashes($entrada->nombre_organizacion) }}', {{ $urnas }}, {{ $cuartos }}, {{ $tintas }})"
                                                style="background:#2563eb; color:white; border:none; padding:3px 8px; border-radius:6px; font-size:11px; cursor:pointer; font-weight:500; white-space:nowrap;">
                                            Registrar devolución
                                        </button>
                                    @else
                                        <span style="font-size:11px; color:#16a34a; font-weight:500;">✓ Entregado</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="10" style="padding:24px; text-align:center; color:#94a3b8; font-size:13px;">Sin materiales entregados pendientes de devolución.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- DEVUELTOS --}}
        <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; box-shadow:0 1px 4px rgba(0,0,0,0.04); overflow:hidden;">
            <div style="padding:10px 16px; border-bottom:1px solid #f3f4f6; background:#f0fdf4; display:flex; align-items:center; justify-content:space-between;">
                <span style="font-size:13px; font-weight:600; color:#15803d;">✅ Devueltos</span>
                <span style="font-size:11px; font-weight:600; background:#dcfce7; color:#15803d; padding:2px 8px; border-radius:20px;">{{ $devueltos->count() }}</span>
            </div>
            <div class="tabla-scroll" style="overflow-y:auto; max-height:280px;">
                <table style="width:100%; border-collapse:collapse; font-size:12px;">
                    <thead style="position:sticky; top:0; z-index:2;">
                        <tr style="background:#f8fafc;">
                            <th style="padding:7px 12px; text-align:left; font-size:10px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; white-space:nowrap;">Código</th>
                            <th style="padding:7px 12px; text-align:left; font-size:10px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Organización</th>
                            <th style="padding:7px 12px; text-align:left; font-size:10px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Asunto</th>
                            <th style="padding:7px 12px; text-align:left; font-size:10px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Asesor</th>
                            <th style="padding:7px 12px; text-align:left; font-size:10px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; white-space:nowrap;">Entregado por</th>
                            <th style="padding:7px 12px; text-align:left; font-size:10px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; white-space:nowrap;">Fecha entrega</th>
                            <th style="padding:7px 12px; text-align:left; font-size:10px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; white-space:nowrap;">Devuelto por</th>
                            <th style="padding:7px 12px; text-align:center; font-size:10px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Urnas</th>
                            <th style="padding:7px 12px; text-align:center; font-size:10px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Cuartos</th>
                            <th style="padding:7px 12px; text-align:center; font-size:10px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Tintas</th>
                            <th style="padding:7px 12px; text-align:left; font-size:10px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; white-space:nowrap;">Fecha devolución</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($devueltos as $entrada)
                        <tr style="border-bottom:1px solid #f3f4f6;" data-org="{{ $entrada->nombre_organizacion }}">
                            <td style="padding:7px 12px; color:#185FA5; font-weight:600; font-family:monospace; white-space:nowrap; font-size:11px;">{{ $entrada->codigo_org }}</td>
                            <td style="padding:7px 12px; color:#1e293b; font-weight:500; font-size:12px;">{{ $entrada->nombre_organizacion }}</td>
                            <td style="padding:7px 12px;">
                                @if($entrada->asunto_tec && $entrada->asunto_log)
                                    <span style="display:inline-flex; gap:4px;">
                                        <span style="background:#ede9fe; color:#6d28d9; font-size:10px; font-weight:600; padding:2px 6px; border-radius:4px;">TEC</span>
                                        <span style="background:#d1fae5; color:#065f46; font-size:10px; font-weight:600; padding:2px 6px; border-radius:4px;">LOG</span>
                                    </span>
                                @elseif($entrada->asunto_tec)
                                    <span style="background:#ede9fe; color:#6d28d9; font-size:10px; font-weight:600; padding:2px 6px; border-radius:4px;">TEC</span>
                                @elseif($entrada->asunto_log)
                                    <span style="background:#d1fae5; color:#065f46; font-size:10px; font-weight:600; padding:2px 6px; border-radius:4px;">LOG</span>
                                @endif
                            </td>
                            <td style="padding:7px 12px; color:#374151; font-size:12px; white-space:nowrap;">{{ $entrada->asesor_asignado ?? '—' }}</td>
                            <td style="padding:7px 12px; color:#374151; font-size:12px;">{{ $entrada->entregado_por ?? '—' }}</td>
                            <td style="padding:7px 12px; color:#94a3b8; white-space:nowrap; font-size:11px;">{{ $entrada->fecha_entrega ? $entrada->fecha_entrega->format('d/m/Y H:i') : '—' }}</td>
                            <td style="padding:7px 12px; color:#374151; font-size:12px;">{{ $entrada->logDevolucion?->devuelto_por ?? '—' }}</td>
                            <td style="padding:7px 12px; text-align:center; color:#374151; font-size:12px;">{{ $entrada->logDevolucion?->urnas_devueltas ?? '—' }}</td>
                            <td style="padding:7px 12px; text-align:center; color:#374151; font-size:12px;">{{ $entrada->logDevolucion?->cuartos_devueltos ?? '—' }}</td>
                            <td style="padding:7px 12px; text-align:center; color:#374151; font-size:12px;">{{ $entrada->logDevolucion?->tintas_devueltas ?? '—' }}</td>
                            <td style="padding:7px 12px; color:#94a3b8; white-space:nowrap; font-size:11px;">{{ $entrada->logDevolucion?->created_at?->format('d/m/Y') ?? '—' }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="11" style="padding:24px; text-align:center; color:#94a3b8; font-size:13px;">Sin devoluciones registradas todavía.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- MODAL: ENTREGAR --}}
<div id="modal-entregar" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.4); z-index:50; align-items:center; justify-content:center;">
    <div style="background:white; border-radius:12px; padding:28px; max-width:440px; width:90%; box-shadow:0 20px 60px rgba(0,0,0,0.3);">
        <h3 style="font-size:15px; font-weight:700; color:#1e293b; margin-bottom:4px;">Registrar entrega</h3>
        <p id="modal-entregar-org" style="font-size:12px; color:#64748b; margin-bottom:18px;"></p>
        <form id="form-entregar" method="POST">
            @csrf @method('PATCH')
            <div style="margin-bottom:14px;">
                <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Funcionario que entrega *</label>
                <input type="text" name="entregado_por" id="entregar-funcionario" required placeholder="Nombre completo..."
                       style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:8px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
            </div>
            <div style="margin-bottom:14px;">
                <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Fecha y hora de entrega *</label>
                <input type="datetime-local" name="fecha_entrega" id="entregar-fecha" required
                       style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:8px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
            </div>
            <div style="margin-bottom:14px;">
                <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Persona que retira *</label>
                <input type="text" name="persona_retira" id="entregar-persona-retira" required placeholder="Nombre completo..."
                       style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:8px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
            </div>
            <div style="margin-bottom:20px;">
                <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Teléfono de contacto *</label>
                <input type="text" name="telefono_retira" id="entregar-telefono-retira" required placeholder="Ej: 0981 123 456"
                       style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:8px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
            </div>
            <div style="display:flex; gap:10px; justify-content:flex-end;">
                <button type="button" onclick="document.getElementById('modal-entregar').style.display='none'"
                        style="padding:8px 18px; border-radius:8px; border:1px solid #e5e7eb; background:white; color:#374151; font-size:13px; cursor:pointer;">Cancelar</button>
                <button type="submit" style="padding:8px 18px; border-radius:8px; border:none; background:#16a34a; color:white; font-size:13px; cursor:pointer; font-weight:500;">✓ Confirmar entrega</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL: IMPRIMIR LOG --}}
<div id="modal-imprimir-log" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.4); z-index:50; align-items:center; justify-content:center;">
    <div style="background:white; border-radius:12px; padding:28px; max-width:440px; width:90%; box-shadow:0 20px 60px rgba(0,0,0,0.3);">
        <div style="font-size:32px; text-align:center; margin-bottom:10px;">🖨️</div>
        <h3 style="font-size:15px; font-weight:700; color:#1e293b; margin-bottom:4px; text-align:center;">Imprimir logística</h3>
        <p id="modal-log-org" style="font-size:12px; color:#64748b; margin-bottom:18px; text-align:center;"></p>
        <div style="margin-bottom:14px;">
            <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Funcionario que entrega *</label>
            <input type="text" id="log-funcionario" required placeholder="Nombre completo..."
                   style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:8px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
        </div>
        <div style="margin-bottom:20px;">
            <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Fecha y hora *</label>
            <input type="datetime-local" id="log-fecha" required
                   style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:8px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
        </div>
        <p style="font-size:11px; color:#94a3b8; margin-bottom:16px; text-align:center;">Al confirmar se guarda el registro y se muestra la vista previa.</p>
        <div style="display:flex; gap:10px; justify-content:center;">
            <button onclick="document.getElementById('modal-imprimir-log').style.display='none'"
                    style="padding:8px 18px; border-radius:8px; border:1px solid #e5e7eb; background:white; color:#374151; font-size:13px; cursor:pointer;">Cancelar</button>
            <button onclick="confirmarImprimirLog()"
                    style="padding:8px 18px; border-radius:8px; border:none; background:#0369a1; color:white; font-size:13px; cursor:pointer; font-weight:500;">Confirmar e imprimir</button>
        </div>
    </div>
</div>

{{-- MODAL: DETALLE / EDITAR ENTREGA --}}
<div id="modal-detalle-entrega" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.4); z-index:50; align-items:center; justify-content:center;">
    <div style="background:white; border-radius:12px; padding:28px; max-width:460px; width:90%; box-shadow:0 20px 60px rgba(0,0,0,0.3); max-height:88vh; overflow-y:auto;">
        <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:10px;">
            <div>
                <h3 style="font-size:15px; font-weight:700; color:#1e293b; margin-bottom:4px;">Detalle de entrega</h3>
                <p id="detalle-org" style="font-size:12px; color:#64748b; margin:0;"></p>
            </div>
            <button type="button" id="btn-editar-detalle" onclick="activarEdicionDetalle()"
                    style="display:inline-flex; align-items:center; gap:5px; background:#f3f4f6; color:#374151; padding:6px 12px; border-radius:8px; font-size:11px; border:none; cursor:pointer; font-weight:500; flex-shrink:0;">
                ✏️ Editar
            </button>
        </div>
        <form id="form-detalle-entrega" method="POST" style="margin-top:18px;">
            @csrf @method('PATCH')
            <div style="margin-bottom:14px;">
                <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Funcionario que entrega *</label>
                <input type="text" name="entregado_por" id="detalle-funcionario" required disabled
                       style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:8px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box; background:#f9fafb;">
            </div>
            <div style="margin-bottom:14px;">
                <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Fecha y hora de entrega *</label>
                <input type="datetime-local" name="fecha_entrega" id="detalle-fecha" required disabled
                       style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:8px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box; background:#f9fafb;">
            </div>
            <div style="margin-bottom:14px;">
                <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Persona que retira *</label>
                <input type="text" name="persona_retira" id="detalle-persona-retira" required disabled
                       style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:8px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box; background:#f9fafb;">
            </div>
            <div style="margin-bottom:20px;">
                <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Teléfono de contacto *</label>
                <input type="text" name="telefono_retira" id="detalle-telefono-retira" required disabled
                       style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:8px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box; background:#f9fafb;">
            </div>
            <div style="display:flex; gap:10px; justify-content:flex-end;">
                <button type="button" onclick="document.getElementById('modal-detalle-entrega').style.display='none'"
                        style="padding:8px 18px; border-radius:8px; border:1px solid #e5e7eb; background:white; color:#374151; font-size:13px; cursor:pointer;">Cerrar</button>
                <button type="submit" id="btn-guardar-detalle" style="display:none; padding:8px 18px; border-radius:8px; border:none; background:#2563eb; color:white; font-size:13px; cursor:pointer; font-weight:500;">Guardar cambios</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL: DEVOLUCIÓN --}}
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
                        style="padding:8px 18px; border-radius:8px; border:1px solid #e5e7eb; background:white; color:#374151; font-size:13px; cursor:pointer;">Cancelar</button>
                <button type="submit" style="padding:8px 18px; border-radius:8px; border:none; background:#2563eb; color:white; font-size:13px; cursor:pointer; font-weight:500;">Confirmar devolución</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL: VISTA PREVIA RECIBO LOG --}}
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

<script>
function fechaLocalAhora() {
    const now = new Date();
    const pad = n => String(n).padStart(2, '0');
    return now.getFullYear() + '-' + pad(now.getMonth()+1) + '-' + pad(now.getDate())
        + 'T' + pad(now.getHours()) + ':' + pad(now.getMinutes());
}

function abrirModalEntregar(id, org) {
    document.getElementById('modal-entregar-org').textContent = org;
    document.getElementById('entregar-fecha').value = fechaLocalAhora();
    document.getElementById('entregar-funcionario').value = '';
    document.getElementById('entregar-persona-retira').value = '';
    document.getElementById('entregar-telefono-retira').value = '';
    document.getElementById('form-entregar').action = '/secretaria/sin-nota/log/' + id + '/entregar';
    document.getElementById('modal-entregar').style.display = 'flex';
    setTimeout(() => document.getElementById('entregar-funcionario').focus(), 100);
}

let _logEntradaId = null;
function abrirModalImprimirLog(id, org) {
    _logEntradaId = id;
    document.getElementById('modal-log-org').textContent = org;
    document.getElementById('log-fecha').value = fechaLocalAhora();
    document.getElementById('log-funcionario').value = '';
    document.getElementById('modal-imprimir-log').style.display = 'flex';
    setTimeout(() => document.getElementById('log-funcionario').focus(), 100);
}

async function confirmarImprimirLog() {
    const funcionario = document.getElementById('log-funcionario').value.trim();
    const fecha       = document.getElementById('log-fecha').value;
    if (!funcionario) { alert('Por favor ingresá el nombre del funcionario.'); return; }
    if (!fecha)       { alert('Por favor ingresá la fecha.'); return; }

    const url = '/secretaria/sin-nota/log/' + _logEntradaId + '/imprimir-logistica'
        + '?entregado_por=' + encodeURIComponent(funcionario)
        + '&fecha_entrega=' + encodeURIComponent(fecha);

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

function abrirModalDetalleEntrega(id, org, funcionario, fecha, personaRetira, telefonoRetira) {
    document.getElementById('detalle-org').textContent = org;
    document.getElementById('detalle-funcionario').value = funcionario;
    document.getElementById('detalle-fecha').value = fecha || fechaLocalAhora();
    document.getElementById('detalle-persona-retira').value = personaRetira;
    document.getElementById('detalle-telefono-retira').value = telefonoRetira;
    document.getElementById('form-detalle-entrega').action = '/secretaria/sin-nota/log/' + id + '/editar-entrega';
    desactivarEdicionDetalle();
    document.getElementById('modal-detalle-entrega').style.display = 'flex';
}

function activarEdicionDetalle() {
    document.querySelectorAll('#form-detalle-entrega input').forEach(i => i.disabled = false);
    document.querySelectorAll('#form-detalle-entrega input').forEach(i => i.style.background = '#fff');
    document.getElementById('btn-guardar-detalle').style.display = 'inline-block';
    document.getElementById('btn-editar-detalle').style.display = 'none';
    setTimeout(() => document.getElementById('detalle-funcionario').focus(), 100);
}

function desactivarEdicionDetalle() {
    document.querySelectorAll('#form-detalle-entrega input').forEach(i => i.disabled = true);
    document.querySelectorAll('#form-detalle-entrega input').forEach(i => i.style.background = '#f9fafb');
    document.getElementById('btn-guardar-detalle').style.display = 'none';
    document.getElementById('btn-editar-detalle').style.display = 'inline-flex';
}

function abrirModal(id, org, urnas, cuartos, tintas) {
    document.getElementById('modal-org').textContent  = org;
    document.getElementById('modal-urnas').value      = urnas;
    document.getElementById('modal-cuartos').value    = cuartos;
    document.getElementById('modal-tintas').value     = tintas;
    document.getElementById('form-devolucion').action = '/secretaria/sin-nota/log/' + id + '/devolucion';
    document.getElementById('modal-devolucion').style.display = 'flex';
}

function filtrarTablas(valor) {
    valor = valor.toLowerCase();
    document.querySelectorAll('tbody tr[data-org]').forEach(tr => {
        tr.style.display = tr.dataset.org.toLowerCase().includes(valor) ? '' : 'none';
    });
}

['modal-entregar', 'modal-imprimir-log', 'modal-detalle-entrega', 'modal-devolucion', 'modal-recibo-log'].forEach(id => {
    document.getElementById(id).addEventListener('click', function(e) {
        if (e.target === this) this.style.display = 'none';
    });
});
</script>
</x-panel-layout>
