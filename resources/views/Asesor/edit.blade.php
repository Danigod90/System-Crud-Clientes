<x-panel-layout title="Editar Organización — {{ $entrada->codigo_org }}" :charlasPendientes="$charlasPendientes">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/l10n/es.min.js"></script>
<style>
.flatpickr-calendar { font-size: 12px !important; width: 240px !important; }
.flatpickr-day { max-width: 30px !important; height: 30px !important; line-height: 30px !important; }
.flatpickr-months .flatpickr-month { height: 34px !important; }
</style>

<div class="px-2 py-2">
    <div style="max-width:760px; margin:0 auto;">

        {{-- DATOS DE LA ORGANIZACIÓN (solo lectura) --}}
        <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:20px; margin-bottom:14px; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px; padding-bottom:10px; border-bottom:1px solid #f3f4f6;">
                <h3 style="font-size:13px; font-weight:600; color:#374151; text-transform:uppercase; letter-spacing:0.5px; margin:0;">Datos de la organización</h3>
                <div style="display:flex; gap:8px; align-items:center;">
                    <a href="{{ route('secretaria.con-nota.edit', ['conNota' => $entrada->id]) }}?from=asesor&entrada_id={{ $entrada->id }}"
                       style="display:inline-flex; align-items:center; gap:6px; background:#f59e0b; color:white; padding:6px 14px; border-radius:8px; font-size:12px; text-decoration:none; font-weight:500;">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                        </svg>
                        Editar entrada
                    </a>
                    @if($entrada->via_ingreso == 'presencial')
                    <a href="{{ route('secretaria.con-nota.nota-pdf', $entrada->id) }}" target="_blank"
                       style="display:inline-flex; align-items:center; gap:6px; background:#1e3a5f; color:white; padding:6px 14px; border-radius:8px; font-size:12px; text-decoration:none; font-weight:500;">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                        </svg>
                        Imprimir Nota
                    </a>
                    @endif
                    @if($entrada->asunto_log)
                    <a href="{{ route('secretaria.con-nota.recibo-logistica', $entrada->id) }}" target="_blank"
                       style="display:inline-flex; align-items:center; gap:6px; background:#065f46; color:white; padding:6px 14px; border-radius:8px; font-size:12px; text-decoration:none; font-weight:500;">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                        </svg>
                        Imprimir Logístico
                    </a>
                    @endif
                </div>
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:12px;">
                <div>
                    <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Organización</label>
                    <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ $entrada->nombre_organizacion }}</p>
                    <p style="font-size:12px; color:#6b7280; margin:2px 0 0;">{{ $entrada->tipo_organizacion }}</p>
                </div>
                <div>
                    <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Representante</label>
                    <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ $entrada->nombre_representante }}</p>
                    @if($entrada->telefono_representante)
                    <p style="font-size:12px; color:#6b7280; margin:2px 0 0;">{{ $entrada->telefono_representante }}</p>
                    @endif
                </div>
            <div>
                    <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Asesor Asignado</label>
                    <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ $entrada->asesor_asignado ?? '—' }}</p>
                </div>
                <div>
                    <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Vía de Ingreso</label>
                    <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ ucfirst($entrada->via_ingreso ?? '—') }}</p>
                </div>
                <div>
                    <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Fecha de elección</label>
                    <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ $entrada->fecha_eleccion?->format('d/m/Y') ?? '—' }}</p>
                </div>
                <div>
                    <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Asunto</label>
                    <p style="font-size:14px; font-weight:700; color:#111827; font-family:monospace; margin:0;">{{ $entrada->asunto_texto }}</p>
                </div>
            </div>
        </div>

        {{-- SECCIÓN LOGÍSTICA (solo lectura) --}}
        @if($entrada->asunto_log && !$entrada->asunto_tec)
        <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:20px; margin-bottom:14px; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px; padding-bottom:10px; border-bottom:1px solid #f3f4f6;">
                <h3 style="font-size:13px; font-weight:600; color:#374151; text-transform:uppercase; letter-spacing:0.5px; margin:0; display:flex; align-items:center; gap:8px;">
                    Detalle Logístico
                    @php $logDot = ($entrada->log_estado ?? 'pendiente') === 'entregada' ? '#16a34a' : '#eab308'; @endphp
                    <span style="display:inline-flex; align-items:center; gap:4px; font-size:11px; font-weight:500; color:#6b7280; text-transform:none;">
                        <span style="width:9px; height:9px; border-radius:50%; background:{{ $logDot }}; display:inline-block;"></span>
                        {{ ($entrada->log_estado ?? 'pendiente') === 'entregada' ? 'Entregada' : 'Pendiente' }}
                    </span>
                </h3>
                @if($entrada->asunto_log && !$entrada->asunto_tec && $entrada->log_estado !== 'entregada')
                <form method="POST" action="{{ route('secretaria.con-nota.entregar-log', $entrada->id) }}" style="display:inline;">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                            onclick="return confirm('¿Confirmar entrega logística de {{ $entrada->nombre_organizacion }}?')"
                            style="display:inline-flex; align-items:center; gap:6px; background:#065f46; color:white; padding:6px 14px; border-radius:8px; font-size:12px; border:none; cursor:pointer; font-weight:500;">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                        Marcar entregado
                    </button>
                </form>
                @elseif($entrada->log_estado === 'entregada')
                <span style="display:inline-flex; align-items:center; gap:6px; background:#d1fae5; color:#065f46; padding:6px 14px; border-radius:8px; font-size:12px; font-weight:500;">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    Entregado
                </span>
                @endif
            </div>
            <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:12px;">
                <div style="text-align:center;">
                    <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Urnas</label>
                    <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ $entrada->log_urnas ?? 0 }}</p>
                </div>
                <div style="text-align:center;">
                    <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Cuartos oscuros</label>
                    <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ $entrada->log_cuartos ?? 0 }}</p>
                </div>
                <div style="text-align:center;">
                    <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Tintas</label>
                    <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ $entrada->log_tintas ?? 0 }}</p>
                </div>
            </div>
        </div>
        @endif

        {{-- SECCIÓN CHARLA --}}
        @if($entrada->asunto_char)
        <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:20px; margin-bottom:14px; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px; padding-bottom:10px; border-bottom:1px solid #f3f4f6;">
                <h3 style="font-size:13px; font-weight:600; color:#374151; text-transform:uppercase; letter-spacing:0.5px; margin:0; display:flex; align-items:center; gap:8px;">
                    Detalle de Charla
                    @if($entrada->charla)
                        @php
                            $dotColor = match($entrada->charla->estado) {
                                'realizada'  => '#16a34a',
                                'cancelada'  => '#dc2626',
                                'suspendida' => '#f97316',
                                'vencida'    => '#dc2626',
                                default      => '#eab308',
                            };
                        @endphp
                        <span style="display:inline-flex; align-items:center; gap:4px; font-size:11px; font-weight:500; color:#6b7280; text-transform:none;">
                            <span style="width:9px; height:9px; border-radius:50%; background:{{ $dotColor }}; display:inline-block;"></span>
                            {{ ucfirst($entrada->charla->estado) }}
                        </span>
                    @endif
                </h3>
                <div style="display:flex; gap:8px; align-items:center;">

                    <button id="btn-editar-charla" onclick="activarEdicion()"
                            style="display:{{ $entrada->charla ? 'inline-flex' : 'none' }}; align-items:center; gap:6px; background:#f3f4f6; color:#374151; padding:6px 14px; border-radius:8px; font-size:12px; border:none; cursor:pointer; font-weight:500;">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                        </svg>
                        Editar
                    </button>
                </div>
            </div>

            {{-- VISTA SOLO LECTURA --}}
            <div id="charla-readonly" style="display:{{ $entrada->charla ? 'grid' : 'none' }}; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:12px;">
                <div>
                    <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Modalidad</label>
                    <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">
                        {{ $entrada->charla?->modalidad == 'virtual' ? 'Virtual' : ($entrada->charla?->modalidad == 'presencial_oficina' ? 'Presencial — Oficina' : 'Presencial — Externa') }}
                    </p>
                </div>
                @if($entrada->charla?->char_tipo)
                <div>
                    <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Tipo de charla</label>
                    @php
                        $tipoLabel = match($entrada->charla->char_tipo) {
                            'proceso_electoral' => 'Charla sobre Proceso Electoral',
                            'mmrv'              => 'Charla para MMRV',
                            'ambos'             => 'Charla sobre Proceso - Charla MMRV',
                            default             => '—',
                        };
                    @endphp
                    <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ $tipoLabel }}</p>
                </div>
                @endif
                <div>
                    <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Fecha y hora</label>
                    <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">
                        {{ $entrada->charla?->fecha_hora?->format('d/m/Y H:i') ?? '—' }}
                    </p>
                </div>
                @if($entrada->charla?->direccion)
                <div style="grid-column:span 2;">
                    <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Dirección</label>
                    <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ $entrada->charla->direccion }}</p>
                </div>
                @endif
                @if($entrada->charla?->descripcion)
                <div style="grid-column:span 2;">
                    <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Descripción</label>
                    <p style="font-size:14px; color:#111827; margin:0;">{{ $entrada->charla->descripcion }}</p>
                </div>
                @endif
            </div>

            {{-- FORMULARIO EDITABLE --}}
            <form id="charla-form" method="POST" action="{{ route('asesor.charla.store', $entrada) }}"
                  style="display:{{ $entrada->charla ? 'none' : 'block' }};">
                @csrf
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:12px;">
                    <div>
                        <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Modalidad *</label>
                        <select name="modalidad" id="modalidad-select"
                                style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; background:#fff; box-sizing:border-box;">
                            <option value="">Seleccionar...</option>
                            <option value="virtual" {{ $entrada->charla?->modalidad == 'virtual' ? 'selected' : '' }}>Virtual</option>
                            <option value="presencial_oficina" {{ $entrada->charla?->modalidad == 'presencial_oficina' ? 'selected' : '' }}>Presencial — Oficina</option>
                            <option value="presencial_externa" {{ $entrada->charla?->modalidad == 'presencial_externa' ? 'selected' : '' }}>Presencial — Externa</option>
                        </select>
                    </div>
                    <div>
                        <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Tipo de charla</label>
                        <select name="char_tipo"
                                style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; background:#fff; box-sizing:border-box;">
                            <option value="">-- Seleccionar --</option>
                            <option value="proceso_electoral" {{ $entrada->charla?->char_tipo == 'proceso_electoral' ? 'selected' : '' }}>Charla sobre Proceso Electoral</option>
                            <option value="mmrv" {{ $entrada->charla?->char_tipo == 'mmrv' ? 'selected' : '' }}>Charla para MMRV</option>
<option value="ambos" {{ $entrada->charla?->char_tipo == 'ambos' ? 'selected' : '' }}>Charla sobre Proceso - Charla MMRV</option>
                        </select>
                    </div>
                    <div>
                        <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Fecha y hora <span style="color:#9ca3af; font-weight:400;">(opcional)</span></label>
                        <div style="position:relative;">
                            <input type="text" id="fecha_hora_display"
                                   placeholder="Seleccionar fecha y hora..."
                                   value="{{ $entrada->charla?->fecha_hora?->format('d/m/Y H:i') }}"
                                   style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 32px 7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box; cursor:pointer;">
                            <button type="button" onclick="limpiarFecha()"
                                    style="position:absolute; right:8px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:#9ca3af; font-size:14px; padding:0; line-height:1;">✕</button>
                        </div>
                        <input type="hidden" name="fecha_hora" id="fecha_hora_input"
                               value="{{ $entrada->charla?->fecha_hora?->format('Y-m-d H:i:s') }}">
                    </div>
                </div>
                <div id="seccion-direccion" style="display:{{ $entrada->charla?->modalidad == 'presencial_externa' ? 'block' : 'none' }}; margin-bottom:12px;">
                    <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Dirección *</label>
                    <input type="text" name="direccion"
                           value="{{ $entrada->charla?->direccion }}"
                           placeholder="Dirección del local donde se realizará la charla..."
                           style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
                </div>
                <div style="margin-bottom:12px;">
                    <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Descripción <span style="color:#9ca3af; font-weight:400;">(opcional)</span></label>
                    <textarea name="descripcion" rows="3"
                              placeholder="Ej: Charla a confirmar, pendiente de respuesta del representante..."
                              style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box; resize:vertical;">{{ $entrada->charla?->descripcion }}</textarea>
                </div>
                <div style="display:flex; justify-content:flex-end; gap:8px;">
                    @if($entrada->charla)
                    <button type="button" onclick="cancelarEdicion()"
                            style="display:inline-flex; align-items:center; gap:6px; background:#f3f4f6; color:#374151; padding:8px 18px; border-radius:8px; font-size:13px; border:none; cursor:pointer; font-weight:500;">
                        Cancelar
                    </button>
                    @endif
                    <button type="submit"
                            style="display:inline-flex; align-items:center; gap:6px; background:#2563eb; color:white; padding:8px 18px; border-radius:8px; font-size:13px; border:none; cursor:pointer; font-weight:500;">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                        Guardar charla
                    </button>
                </div>
            </form>

            @if($entrada->charla)
            <div style="border-top:1px solid #f3f4f6; margin-top:16px; padding-top:16px;">
                <p style="font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:10px;">Cambiar estado</p>
                <div style="display:flex; gap:8px; flex-wrap:wrap;">
                    <form method="POST" action="{{ route('asesor.charla.estado', $entrada->charla) }}">
                        @csrf @method('PATCH')
                        <input type="hidden" name="estado" value="realizada">
                        <button type="submit" onclick="return confirm('¿Marcar la charla como realizada?')"
                                style="display:inline-flex; align-items:center; gap:6px; background:#16a34a; color:white; padding:8px 16px; border-radius:8px; font-size:13px; border:none; cursor:pointer; font-weight:500;">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                            Realizada
                        </button>
                    </form>
                    <form method="POST" action="{{ route('asesor.charla.estado', $entrada->charla) }}">
                        @csrf @method('PATCH')
                        <input type="hidden" name="estado" value="suspendida">
                        <button type="submit" onclick="return confirm('¿Marcar la charla como suspendida?')"
                                style="display:inline-flex; align-items:center; gap:6px; background:#f97316; color:white; padding:8px 16px; border-radius:8px; font-size:13px; border:none; cursor:pointer; font-weight:500;">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="10" y1="15" x2="10" y2="9"/><line x1="14" y1="15" x2="14" y2="9"/></svg>
                            Suspendida
                        </button>
                    </form>
                    <form method="POST" action="{{ route('asesor.charla.estado', $entrada->charla) }}">
                        @csrf @method('PATCH')
                        <input type="hidden" name="estado" value="cancelada">
                        <button type="submit" onclick="return confirm('¿Confirmar cancelación de la charla?')"
                                style="display:inline-flex; align-items:center; gap:6px; background:#dc2626; color:white; padding:8px 16px; border-radius:8px; font-size:13px; border:none; cursor:pointer; font-weight:500;">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                            Cancelada
                        </button>
                    </form>
                </div>
            </div>
            @endif
        </div>
        @endif

        {{-- SECCIÓN OBSERVADORES --}}
        @if($entrada->asunto_obs)
        <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:20px; margin-bottom:14px; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px; padding-bottom:10px; border-bottom:1px solid #f3f4f6;">
                <h3 style="font-size:13px; font-weight:600; color:#374151; text-transform:uppercase; letter-spacing:0.5px; margin:0; display:flex; align-items:center; gap:8px;">
                    Observadores
                    @if($entrada->observador)
                        @php
                            $obsDot = match($entrada->observador->estado) {
                                'realizada'  => '#16a34a',
                                'cancelada'  => '#dc2626',
                                'suspendida' => '#f97316',
                                default      => '#eab308',
                            };
                        @endphp
                        <span style="display:inline-flex; align-items:center; gap:4px; font-size:11px; font-weight:500; color:#6b7280; text-transform:none;">
                            <span style="width:9px; height:9px; border-radius:50%; background:{{ $obsDot }}; display:inline-block;"></span>
                            {{ ucfirst($entrada->observador->estado) }}
                        </span>
                    @endif
                </h3>
                <button id="btn-editar-obs" onclick="activarEdicionObs()"
                        style="display:{{ $entrada->observador ? 'inline-flex' : 'none' }}; align-items:center; gap:6px; background:#f3f4f6; color:#374151; padding:6px 14px; border-radius:8px; font-size:12px; border:none; cursor:pointer; font-weight:500;">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                    Editar
                </button>
            </div>

            <div id="obs-readonly" style="display:{{ $entrada->observador ? 'grid' : 'none' }}; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:12px;">
                <div>
                    <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Fecha y hora</label>
                    <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">
                        {{ $entrada->observador?->fecha_hora?->format('d/m/Y H:i') ?? '—' }}
                    </p>
                </div>
                @if($entrada->observador?->observadores)
                <div>
                    <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Observadores asistentes</label>
                    <p style="font-size:14px; color:#111827; margin:0;">{{ $entrada->observador->observadores }}</p>
                </div>
                @endif
                @if($entrada->observador?->descripcion)
                <div style="grid-column:span 2;">
                    <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Descripción</label>
                    <p style="font-size:14px; color:#111827; margin:0;">{{ $entrada->observador->descripcion }}</p>
                </div>
                @endif
            </div>

            <form id="obs-form" method="POST" action="{{ route('asesor.observador.store', $entrada) }}"
                  style="display:{{ $entrada->observador ? 'none' : 'block' }};">
                @csrf
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:12px;">
                    <div>
                        <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Fecha y hora <span style="color:#9ca3af; font-weight:400;">(opcional)</span></label>
                        <div style="position:relative;">
                            <input type="text" id="obs_fecha_hora_display"
                                   placeholder="Seleccionar fecha y hora..."
                                   value="{{ $entrada->observador?->fecha_hora?->format('d/m/Y H:i') }}"
                                   style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 32px 7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box; cursor:pointer;">
                            <button type="button" onclick="limpiarFechaObs()"
                                    style="position:absolute; right:8px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:#9ca3af; font-size:14px; padding:0; line-height:1;">✕</button>
                        </div>
                        <input type="hidden" name="fecha_hora" id="obs_fecha_hora_input"
                               value="{{ $entrada->observador?->fecha_hora?->format('Y-m-d H:i:s') }}">
                    </div>
                    <div>
                        <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Descripción <span style="color:#9ca3af; font-weight:400;">(opcional)</span></label>
                        <textarea name="descripcion" rows="2"
                                  placeholder="Observaciones adicionales..."
                                  style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box; resize:vertical;">{{ $entrada->observador?->descripcion }}</textarea>
                    </div>
                </div>
                <div style="margin-bottom:12px;">
                    <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Observadores asistentes <span style="color:#9ca3af; font-weight:400;">(opcional)</span></label>
                    <textarea name="observadores" rows="3"
                              placeholder="Ej: Juan Pérez, María García, Carlos López..."
                              style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box; resize:vertical;">{{ $entrada->observador?->observadores }}</textarea>
                </div>
                <div style="display:flex; justify-content:flex-end; gap:8px;">
                    @if($entrada->observador)
                    <button type="button" onclick="cancelarEdicionObs()"
                            style="display:inline-flex; align-items:center; gap:6px; background:#f3f4f6; color:#374151; padding:8px 18px; border-radius:8px; font-size:13px; border:none; cursor:pointer; font-weight:500;">
                        Cancelar
                    </button>
                    @endif
                    <button type="submit"
                            style="display:inline-flex; align-items:center; gap:6px; background:#2563eb; color:white; padding:8px 18px; border-radius:8px; font-size:13px; border:none; cursor:pointer; font-weight:500;">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                        Guardar observadores
                    </button>
                </div>
            </form>

            @if($entrada->observador)
            <div style="border-top:1px solid #f3f4f6; margin-top:16px; padding-top:16px;">
                <p style="font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:10px;">Cambiar estado</p>
                <div style="display:flex; gap:8px; flex-wrap:wrap;">
                    <form method="POST" action="{{ route('asesor.observador.estado', $entrada->observador) }}">
                        @csrf @method('PATCH')
                        <input type="hidden" name="estado" value="realizada">
                        <button type="submit" onclick="return confirm('¿Marcar como realizada?')"
                                style="display:inline-flex; align-items:center; gap:6px; background:#16a34a; color:white; padding:8px 16px; border-radius:8px; font-size:13px; border:none; cursor:pointer; font-weight:500;">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                            Realizada
                        </button>
                    </form>
                    <form method="POST" action="{{ route('asesor.observador.estado', $entrada->observador) }}">
                        @csrf @method('PATCH')
                        <input type="hidden" name="estado" value="suspendida">
                        <button type="submit" onclick="return confirm('¿Marcar como suspendida?')"
                                style="display:inline-flex; align-items:center; gap:6px; background:#f97316; color:white; padding:8px 16px; border-radius:8px; font-size:13px; border:none; cursor:pointer; font-weight:500;">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="10" y1="15" x2="10" y2="9"/><line x1="14" y1="15" x2="14" y2="9"/></svg>
                            Suspendida
                        </button>
                    </form>
                    <form method="POST" action="{{ route('asesor.observador.estado', $entrada->observador) }}">
                        @csrf @method('PATCH')
                        <input type="hidden" name="estado" value="cancelada">
                        <button type="submit" onclick="return confirm('¿Confirmar cancelación?')"
                                style="display:inline-flex; align-items:center; gap:6px; background:#dc2626; color:white; padding:8px 16px; border-radius:8px; font-size:13px; border:none; cursor:pointer; font-weight:500;">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                            Cancelada
                        </button>
                    </form>
                </div>
            </div>
            @endif
        </div>
        @endif
{{-- SECCIÓN TÉCNICA (ASESOR) --}}
@if($entrada->asunto_tec)
<div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:20px; margin-bottom:14px; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px; padding-bottom:10px; border-bottom:1px solid #f3f4f6;">
        <h3 style="font-size:13px; font-weight:600; color:#374151; text-transform:uppercase; letter-spacing:0.5px; margin:0; display:flex; align-items:center; gap:8px;">
            Detalle Técnico
            @if($entrada->detalleTecnico)
                @php
                    $tecDot   = $entrada->detalleTecnico->tec_realizado ? '#16a34a' : '#eab308';
                    $tecLabel = $entrada->detalleTecnico->tec_realizado ? 'Realizado' : 'Pendiente';
                @endphp
                <span style="display:inline-flex; align-items:center; gap:4px; font-size:11px; font-weight:500; color:#6b7280; text-transform:none;">
                    <span style="width:9px; height:9px; border-radius:50%; background:{{ $tecDot }}; display:inline-block;"></span>
                    {{ $tecLabel }}
                </span>
            @endif
        </h3>
        <button id="btn-editar-tec" onclick="activarEdicionTec()"
                style="display:{{ $entrada->detalleTecnico ? 'inline-flex' : 'none' }}; align-items:center; gap:6px; background:#f3f4f6; color:#374151; padding:6px 14px; border-radius:8px; font-size:12px; border:none; cursor:pointer; font-weight:500;">
            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
            </svg>
            Editar
        </button>
    </div>

    {{-- VISTA SOLO LECTURA --}}
    <div id="tec-readonly" style="display:{{ $entrada->detalleTecnico ? 'block' : 'none' }};">
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:12px;">
        <div>
            <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Órgano Electoral</label>
            <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ $entrada->detalleTecnico?->organo_electoral ?? '—' }}</p>
        </div>
        <div>
            <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Cantidad de Listas</label>
            <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ $entrada->detalleTecnico?->cantidad_listas ?? '—' }}</p>
        </div>
        <div>
            <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Cantidad de Papeletas</label>
            <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ $entrada->detalleTecnico?->cantidad_papeletas ?? '—' }}</p>
        </div>
        <div>
            <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Cantidad de Mesas</label>
            <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ $entrada->detalleTecnico?->cantidad_mesas ?? '—' }}</p>
        </div>
    </div>

    @php
        $cantPap = $entrada->detalleTecnico?->cantidad_papeletas ?? 0;
        $ordinal = ['Primera','Segunda','Tercera','Cuarta','Quinta','Sexta','Séptima','Octava','Novena','Décima'];
    @endphp
    @if($cantPap > 0)
    <div style="margin-bottom:12px;">
        <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:8px; text-transform:uppercase; letter-spacing:0.5px;">Papeletas</label>
        @for($p = 1; $p <= min($cantPap, 10); $p++)
        @php
            $candidatura = $entrada->detalleTecnico?->{"pap_{$p}_lista_1_candidatura"} ?? '—';
            $sistema     = $entrada->detalleTecnico?->{"pap_{$p}_sistema_eleccion"} ?? '—';
        @endphp
       <div style="display:flex; align-items:center; gap:12px; padding:8px 12px; background:#f9fafb; border:1px solid #e5e7eb; border-radius:8px; margin-bottom:6px;">
    <span style="font-size:12px; font-weight:700; color:#374151; white-space:nowrap;">{{ $ordinal[$p-1] }} Papeleta</span>
    @php
        $listaNombres = [];
        for ($l = 1; $l <= ($entrada->detalleTecnico?->cantidad_listas ?? 1); $l++) {
            $n = $entrada->detalleTecnico?->{"pap_{$p}_lista_{$l}_nombre"} ?? null;
            if ($n) $listaNombres[] = $n;
        }
    @endphp
    @if(count($listaNombres))
    <span style="font-size:11px; background:#e5e7eb; color:#374151; padding:2px 8px; border-radius:4px; white-space:nowrap;">Lista {{ implode(', ', $listaNombres) }}</span>
    @endif
    <span style="font-size:13px; color:#111827; flex:1;">{{ $candidatura }}</span>
    <span style="font-size:11px; color:#6b7280; white-space:nowrap;">{{ $sistema }}</span>
</div>
        @endfor
    </div>
    @endif

    @if($entrada->detalleTecnico?->cantidad_mesas)
    @php
        $mesas     = $entrada->detalleTecnico->cantidad_mesas;
        $papeletas = $entrada->detalleTecnico->cantidad_papeletas;
        $actas    = $entrada->detalleTecnico->mat_final_actas    !== null ? $entrada->detalleTecnico->mat_final_actas    : ($mesas * 3);
$padrones = $entrada->detalleTecnico->mat_final_padrones !== null ? $entrada->detalleTecnico->mat_final_padrones : ($mesas * 3);
$cuartos  = $entrada->detalleTecnico->mat_final_cuartos  !== null ? $entrada->detalleTecnico->mat_final_cuartos  : $mesas;
$urnas    = $entrada->detalleTecnico->mat_final_urnas    !== null ? $entrada->detalleTecnico->mat_final_urnas    : ($mesas * $papeletas);
$tintas   = $entrada->detalleTecnico->mat_final_tintas   !== null ? $entrada->detalleTecnico->mat_final_tintas   : $mesas;
   @endphp
<div style="background:#eff6ff; border:1px solid #bfdbfe; border-radius:8px; padding:12px 16px;">
    <p style="font-size:11px; font-weight:700; color:#1e40af; text-transform:uppercase; margin:0 0 10px;">Materiales a Entregar</p>
    <div style="display:grid; grid-template-columns:repeat(6,1fr); gap:8px;">
        <div style="text-align:center;">
            <p style="font-size:11px; color:#6b7280; margin:0 0 2px;">Papeletas</p>
            <p style="font-size:18px; font-weight:700; color:#1e40af; margin:0;">{{ $entrada->detalleTecnico->mat_final_papeletas !== null ? $entrada->detalleTecnico->mat_final_papeletas : ($entrada->detalleTecnico->cantidad_papeletas ?? 0) }}</p>
            @if($entrada->detalleTecnico->mat_final_papeletas_formato)
            <p style="font-size:10px; color:#6b7280; margin:2px 0 0;">{{ ucfirst($entrada->detalleTecnico->mat_final_papeletas_formato) }}</p>
            @endif
        </div>
        <div style="text-align:center;">
            <p style="font-size:11px; color:#6b7280; margin:0 0 2px;">Actas</p>
            <p style="font-size:18px; font-weight:700; color:#1e40af; margin:0;">{{ $actas }}</p>
            @if($entrada->detalleTecnico->mat_final_actas_formato)
            <p style="font-size:10px; color:#6b7280; margin:2px 0 0;">{{ ucfirst($entrada->detalleTecnico->mat_final_actas_formato) }}</p>
            @endif
        </div>
        <div style="text-align:center;">
            <p style="font-size:11px; color:#6b7280; margin:0 0 2px;">Padrones</p>
            <p style="font-size:18px; font-weight:700; color:#1e40af; margin:0;">{{ $padrones }}</p>
            @if($entrada->detalleTecnico->mat_final_padrones_formato)
            <p style="font-size:10px; color:#6b7280; margin:2px 0 0;">{{ ucfirst($entrada->detalleTecnico->mat_final_padrones_formato) }}</p>
            @endif
        </div>
        <div style="text-align:center;">
            <p style="font-size:11px; color:#6b7280; margin:0 0 2px;">Cuartos Oscuros</p>
            <p style="font-size:18px; font-weight:700; color:#1e40af; margin:0;">{{ $cuartos }}</p>
        </div>
        <div style="text-align:center;">
            <p style="font-size:11px; color:#6b7280; margin:0 0 2px;">Urnas</p>
            <p style="font-size:18px; font-weight:700; color:#1e40af; margin:0;">{{ $urnas }}</p>
        </div>
        <div style="text-align:center;">
            <p style="font-size:11px; color:#6b7280; margin:0 0 2px;">Tintas</p>
            <p style="font-size:18px; font-weight:700; color:#1e40af; margin:0;">{{ $tintas }}</p>
        </div>
    </div>
</div>

@if($entrada->detalleTecnico->nota_asesor)
<div style="margin-top:10px; background:#fef9c3; border:1px solid #fde047; border-radius:8px; padding:10px 14px; display:flex; gap:8px;">
    <svg width="15" height="15" fill="none" stroke="#854d0e" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0; margin-top:1px;">
        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
        <polyline points="14 2 14 8 20 8"/>
        <line x1="16" y1="13" x2="8" y2="13"/>
        <line x1="16" y1="17" x2="8" y2="17"/>
    </svg>
    <div>
        <p style="font-size:11px; font-weight:700; color:#854d0e; text-transform:uppercase; margin:0 0 4px;">Importante</p>
        <p style="font-size:13px; color:#713f12; margin:0;">{{ $entrada->detalleTecnico->nota_asesor }}</p>
    </div>
</div>
@endif
@endif
</div>

    {{-- FORMULARIO EDITABLE --}}
    <form id="tec-form" method="POST" action="{{ route('asesor.detalle_tecnico.saveAsesor', $entrada->id) }}"
          style="display:{{ $entrada->detalleTecnico ? 'none' : 'block' }};">
        @csrf

        <div style="margin-bottom:14px;">
            <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:8px; text-transform:uppercase; letter-spacing:0.5px;">Órgano Electoral</label>
            <div style="display:flex; gap:10px; flex-wrap:wrap;">
                @foreach(['TEI' => 'T.E.I.', 'JEI' => 'J.E.I.', 'CEI' => 'C.E.I.'] as $value => $label)
                <label style="display:flex; align-items:center; gap:8px; padding:8px 14px; border:1px solid #d1d5db; border-radius:8px; cursor:pointer; background:#fff;">
                    <input type="radio" name="organo_electoral" value="{{ $value }}"
                        {{ old('organo_electoral', $entrada->detalleTecnico?->organo_electoral) == $value ? 'checked' : '' }}
                        style="width:15px; height:15px; accent-color:#2563eb;">
                    <span style="font-size:13px; font-weight:600; color:#374151;">{{ $label }}</span>
                </label>
                @endforeach
            </div>
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:12px; margin-bottom:14px;">
            <div>
                <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Cantidad de Papeletas</label>
                <input type="number" name="cantidad_papeletas" id="asesor_input_papeletas" min="0" max="10"
                    value="{{ old('cantidad_papeletas', $entrada->detalleTecnico?->cantidad_papeletas) }}"
                    style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; background:#fff; box-sizing:border-box;">
            </div>
            <div>
                <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Cantidad de Listas</label>
                <input type="number" name="cantidad_listas" min="0"
                    value="{{ old('cantidad_listas', $entrada->detalleTecnico?->cantidad_listas) }}"
                    style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; background:#fff; box-sizing:border-box;">
            </div>
            <div>
                <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Cantidad de Mesas</label>
                <input type="number" name="cantidad_mesas" id="asesor_input_mesas" min="1"
                    value="{{ old('cantidad_mesas', $entrada->detalleTecnico?->cantidad_mesas) }}"
                    style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; background:#fff; box-sizing:border-box;">
            </div>
        </div>

        @php
            $datosGuardadosBlade = [];
            for ($p = 1; $p <= 10; $p++) {
                $datosGuardadosBlade[$p] = [
                    'sistema'      => $entrada->detalleTecnico?->{"pap_{$p}_sistema_eleccion"} ?? '',
                    'candidatura'  => $entrada->detalleTecnico?->{"pap_{$p}_lista_1_candidatura"} ?? '',
                    'listas'       => []
                ];
                for ($l = 1; $l <= 5; $l++) {
                    $datosGuardadosBlade[$p]['listas'][$l] = $entrada->detalleTecnico?->{"pap_{$p}_lista_{$l}_nombre"} ?? '';
                }
            }
        @endphp

        <div style="margin-bottom:14px;">
            <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:8px; text-transform:uppercase; letter-spacing:0.5px;">Papeletas</label>
            <div id="papeletas-container"></div>
            <datalist id="candidaturas-asesor-list">
                <option value="Presidente y Vicepresidentes">
                <option value="Presidente y Vicepresidente">
                <option value="Secretario General y Adjunto">
                <option value="Comisión Directiva">
                <option value="Miembros Titulares">
                <option value="Miembros Titulares y Suplentes">
                <option value="Vocales Titulares">
                <option value="Vocales Titulares y Suplentes">
                <option value="Tribunal Electoral Independiente">
                <option value="Junta Electoral">
                <option value="Colegio Electoral">
                <option value="Síndico">
                <option value="Comité Revisadora de Cuentas">
            </datalist>
            <datalist id="sistemas-asesor-list">
                <option value="Lista Única">
                <option value="Lista Cerrada">
                <option value="Lista Desbloqueada">
                <option value="Lista Cerrada Bloqueada">
                <option value="Nominal">
            </datalist>
        </div>
<div style="margin-bottom:14px;">
    <p style="font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase; margin:0 0 10px;">Materiales Estimados</p>
    <div style="background:#eff6ff; border:1px solid #bfdbfe; border-radius:10px; padding:16px;">
        <p style="font-size:11px; font-weight:600; color:#1e40af; margin:0 0 12px; text-transform:uppercase;">Calculado automáticamente — podés editar los valores</p>
        <div style="display:grid; grid-template-columns:repeat(6,1fr); gap:12px;">
            <div>
                <label style="display:block; font-size:11px; font-weight:600; color:#1e40af; margin-bottom:6px; text-transform:uppercase;">Papeletas</label>
                <input type="number" id="asesor_mat_papeletas" name="mat_final_papeletas" min="0"
                    value="{{ old('mat_final_papeletas', $entrada->detalleTecnico?->mat_final_papeletas ?? $entrada->detalleTecnico?->cantidad_papeletas) }}"
                    style="width:100%; border:1px solid #bfdbfe; border-radius:6px; padding:6px 8px; font-size:14px; font-weight:700; color:#1e40af; background:#fff; box-sizing:border-box; text-align:center; margin-bottom:4px;">
                <select name="mat_final_papeletas_formato" style="width:100%; border:1px solid #bfdbfe; border-radius:6px; padding:5px 6px; font-size:11px; color:#1e40af; background:#fff; box-sizing:border-box;">
                    <option value="">Formato...</option>
                    <option value="impreso" {{ old('mat_final_papeletas_formato', $entrada->detalleTecnico?->mat_final_papeletas_formato) == 'impreso' ? 'selected' : '' }}>Impreso</option>
                    <option value="digital" {{ old('mat_final_papeletas_formato', $entrada->detalleTecnico?->mat_final_papeletas_formato) == 'digital' ? 'selected' : '' }}>Digital</option>
                </select>
            </div>
            <div>
                <label style="display:block; font-size:11px; font-weight:600; color:#1e40af; margin-bottom:6px; text-transform:uppercase;">Actas</label>
                <input type="number" id="asesor_mat_actas" name="mat_final_actas" min="0"
                    value="{{ old('mat_final_actas', $entrada->detalleTecnico?->mat_final_actas) }}"
                    style="width:100%; border:1px solid #bfdbfe; border-radius:6px; padding:6px 8px; font-size:14px; font-weight:700; color:#1e40af; background:#fff; box-sizing:border-box; text-align:center; margin-bottom:4px;">
                <select name="mat_final_actas_formato" style="width:100%; border:1px solid #bfdbfe; border-radius:6px; padding:5px 6px; font-size:11px; color:#1e40af; background:#fff; box-sizing:border-box;">
                    <option value="">Formato...</option>
                    <option value="impreso" {{ old('mat_final_actas_formato', $entrada->detalleTecnico?->mat_final_actas_formato) == 'impreso' ? 'selected' : '' }}>Impreso</option>
                    <option value="digital" {{ old('mat_final_actas_formato', $entrada->detalleTecnico?->mat_final_actas_formato) == 'digital' ? 'selected' : '' }}>Digital</option>
                </select>
            </div>
            <div>
                <label style="display:block; font-size:11px; font-weight:600; color:#1e40af; margin-bottom:6px; text-transform:uppercase;">Padrones</label>
                <input type="number" id="asesor_mat_padrones" name="mat_final_padrones" min="0"
                    value="{{ old('mat_final_padrones', $entrada->detalleTecnico?->mat_final_padrones) }}"
                    style="width:100%; border:1px solid #bfdbfe; border-radius:6px; padding:6px 8px; font-size:14px; font-weight:700; color:#1e40af; background:#fff; box-sizing:border-box; text-align:center; margin-bottom:4px;">
                <select name="mat_final_padrones_formato" style="width:100%; border:1px solid #bfdbfe; border-radius:6px; padding:5px 6px; font-size:11px; color:#1e40af; background:#fff; box-sizing:border-box;">
                    <option value="">Formato...</option>
                    <option value="impreso" {{ old('mat_final_padrones_formato', $entrada->detalleTecnico?->mat_final_padrones_formato) == 'impreso' ? 'selected' : '' }}>Impreso</option>
                    <option value="digital" {{ old('mat_final_padrones_formato', $entrada->detalleTecnico?->mat_final_padrones_formato) == 'digital' ? 'selected' : '' }}>Digital</option>
                </select>
            </div>
            <div>
                <label style="display:block; font-size:11px; font-weight:600; color:#1e40af; margin-bottom:6px; text-transform:uppercase;">Cuartos</label>
                <input type="number" id="asesor_mat_cuartos" name="mat_final_cuartos" min="0"
                    value="{{ old('mat_final_cuartos', $entrada->detalleTecnico?->mat_final_cuartos) }}"
                    style="width:100%; border:1px solid #bfdbfe; border-radius:6px; padding:6px 8px; font-size:14px; font-weight:700; color:#1e40af; background:#fff; box-sizing:border-box; text-align:center;">
            </div>
            <div>
                <label style="display:block; font-size:11px; font-weight:600; color:#1e40af; margin-bottom:6px; text-transform:uppercase;">Urnas</label>
                <input type="number" id="asesor_mat_urnas" name="mat_final_urnas" min="0"
                    value="{{ old('mat_final_urnas', $entrada->detalleTecnico?->mat_final_urnas) }}"
                    style="width:100%; border:1px solid #bfdbfe; border-radius:6px; padding:6px 8px; font-size:14px; font-weight:700; color:#1e40af; background:#fff; box-sizing:border-box; text-align:center;">
            </div>
            <div>
                <label style="display:block; font-size:11px; font-weight:600; color:#1e40af; margin-bottom:6px; text-transform:uppercase;">Tintas</label>
                <input type="number" id="asesor_mat_tintas" name="mat_final_tintas" min="0"
                    value="{{ old('mat_final_tintas', $entrada->detalleTecnico?->mat_final_tintas) }}"
                    style="width:100%; border:1px solid #bfdbfe; border-radius:6px; padding:6px 8px; font-size:14px; font-weight:700; color:#1e40af; background:#fff; box-sizing:border-box; text-align:center;">
            </div>
        </div>
    </div>
</div>
<div style="margin-top:14px;">
    <div style="display:flex; align-items:center; gap:8px; margin-bottom:8px;">
        <svg width="15" height="15" fill="none" stroke="#374151" stroke-width="2" viewBox="0 0 24 24">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
            <polyline points="14 2 14 8 20 8"/>
            <line x1="16" y1="13" x2="8" y2="13"/>
            <line x1="16" y1="17" x2="8" y2="17"/>
            <polyline points="10 9 9 9 8 9"/>
        </svg>
        <label style="font-size:11px; font-weight:700; color:#374151; text-transform:uppercase; letter-spacing:0.5px;">Importante — Nota para Técnica</label>
    </div>
    <textarea name="nota_asesor" rows="3"
        placeholder="Escribí acá cualquier detalle importante que técnica deba saber..."
        style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:8px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box; resize:vertical;">{{ old('nota_asesor', $entrada->detalleTecnico?->nota_asesor) }}</textarea>
</div>
        <div style="display:flex; justify-content:flex-end; gap:8px;">
            @if($entrada->detalleTecnico)
            <button type="button" onclick="cancelarEdicionTec()"
                    style="display:inline-flex; align-items:center; gap:6px; background:#f3f4f6; color:#374151; padding:8px 18px; border-radius:8px; font-size:13px; border:none; cursor:pointer; font-weight:500;">
                Cancelar
            </button>
            @endif
            <button type="submit"
                    style="display:inline-flex; align-items:center; gap:6px; background:#2563eb; color:white; padding:8px 18px; border-radius:8px; font-size:13px; border:none; cursor:pointer; font-weight:500;">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
                Guardar
            </button>
        </div>
    </form>

    {{-- BOTÓN ENVIAR A TÉCNICA --}}
    @if($entrada->detalleTecnico && !$entrada->detalleTecnico->enviado_tecnica)
    <div style="border-top:1px solid #f3f4f6; margin-top:16px; padding-top:16px;">
        <form method="POST" action="{{ route('asesor.detalle_tecnico.enviarTecnica', $entrada->id) }}">
            @csrf
            <button type="submit" onclick="return confirm('¿Enviar datos a Técnica?')"
                    style="display:inline-flex; align-items:center; gap:6px; background:#16a34a; color:white; padding:8px 18px; border-radius:8px; font-size:13px; border:none; cursor:pointer; font-weight:500;">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
                Enviar a Técnica
            </button>
        </form>
    </div>
    @elseif($entrada->detalleTecnico && $entrada->detalleTecnico->enviado_tecnica)
    <div style="border-top:1px solid #f3f4f6; margin-top:16px; padding-top:16px;">
        <span style="display:inline-flex; align-items:center; gap:6px; background:#bbf7d0; color:#166534; padding:8px 18px; border-radius:8px; font-size:13px; font-weight:500; cursor:default;">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <polyline points="20 6 9 17 4 12"/>
            </svg>
            Enviado a Técnica
        </span>
    </div>
    @endif
</div>

{{-- TRABAJO TÉCNICO REALIZADO --}}
@if($entrada->detalleTecnico?->tec_realizado)
<div style="background:#f0fdf4; border-radius:12px; border:1px solid #bbf7d0; padding:20px; margin-bottom:14px; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
    <div style="display:flex; align-items:center; gap:8px; margin-bottom:16px; padding-bottom:10px; border-bottom:1px solid #bbf7d0;">
        <h3 style="font-size:13px; font-weight:600; color:#166534; text-transform:uppercase; letter-spacing:0.5px; margin:0;">✓ Trabajo Técnico Realizado</h3>
        <span style="font-size:11px; color:#16a34a;">{{ $entrada->detalleTecnico->tec_realizado_at ? \Carbon\Carbon::parse($entrada->detalleTecnico->tec_realizado_at)->format('d/m/Y H:i') : '' }}</span>
    </div>
    @php
        $mTec = $entrada->detalleTecnico;
        $mesasTec = $mTec->cantidad_mesas ?? 0;
        $matDefaults = [
            'mat_mesas'              => $mTec->mat_mesas ?? $mesasTec,
            'mat_actas_electorales'  => $mTec->mat_actas_electorales ?? ($mesasTec * 3),
            'mat_padron'             => $mTec->mat_padron ?? ($mesasTec * 3),
            'mat_matriz_boletin'     => $mTec->mat_matriz_boletin ?? ($mesasTec * 3),
            'mat_actas_proclamacion' => $mTec->mat_actas_proclamacion,
            'mat_certificados'       => $mTec->mat_certificados,
            'mat_cuenta_votos'       => $mTec->mat_cuenta_votos,
        ];
    @endphp
    <p style="font-size:11px; font-weight:700; color:#166534; text-transform:uppercase; margin:0 0 10px;">Materiales Entregados</p>
    <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:10px; margin-bottom:16px;">
        @foreach([
            ['mat_mesas', 'Mesa/s', false],
            ['mat_actas_electorales', 'Actas Electorales', 'mat_actas_electorales_formato'],
            ['mat_padron', 'Padrón Electoral', 'mat_padron_formato'],
            ['mat_matriz_boletin', 'Matriz de Boletín', 'mat_matriz_boletin_formato'],
            ['mat_actas_proclamacion', 'Actas de Proclamación', false],
            ['mat_certificados', 'Certificados de Resultados', false],
            ['mat_cuenta_votos', 'Cuenta Votos', false],
        ] as [$field, $label, $formatoField])
        <div style="background:#fff; border:1px solid #d1fae5; border-radius:8px; padding:10px;">
            <label style="display:block; font-size:11px; font-weight:600; color:#16a34a; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px;">{{ $label }}</label>
            <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ $matDefaults[$field] ?? '—' }}</p>
            @if($formatoField && $mTec->$formatoField)
            <p style="font-size:11px; color:#6b7280; margin:2px 0 0;">{{ ucfirst($mTec->$formatoField) }}</p>
            @endif
        </div>
        @endforeach
    </div>
    <p style="font-size:11px; font-weight:700; color:#166534; text-transform:uppercase; margin:0 0 10px;">Padrón</p>
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-bottom:10px;">
        <div style="background:#fff; border:1px solid #d1fae5; border-radius:8px; padding:10px;">
            <p style="font-size:13px; font-weight:600; color:#111827; margin:0;">{{ $mTec->padron_definitivo ? '✓ Padrón Definitivo' : '✗ Sin Padrón Definitivo' }}</p>
        </div>
        <div style="background:#fff; border:1px solid #d1fae5; border-radius:8px; padding:10px;">
            <p style="font-size:13px; font-weight:600; color:#111827; margin:0;">{{ $mTec->padron_con_cedula ? '✓ Padrón con Cédula' : '✗ Sin Padrón con Cédula' }}</p>
        </div>
    </div>
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-bottom:16px;">
        <div>
            <label style="display:block; font-size:11px; font-weight:600; color:#16a34a; margin-bottom:4px; text-transform:uppercase;">Cantidad de Electores</label>
            <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ $mTec->cantidad_electores ?? '—' }}</p>
        </div>
        <div>
            <label style="display:block; font-size:11px; font-weight:600; color:#16a34a; margin-bottom:4px; text-transform:uppercase;">Electores sin C.I.</label>
            <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ $mTec->cantidad_electores_sin_ci ?? '—' }}</p>
        </div>
    </div>
    <p style="font-size:11px; font-weight:700; color:#166534; text-transform:uppercase; margin:0 0 10px;">Responsables</p>
    <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:10px;">
        @foreach([
            ['resp_actas_electorales', 'Actas Electorales'],
            ['resp_papeletas', 'Papeletas / Boletín'],
            ['resp_padron_electoral', 'Padrón Electoral'],
        ] as [$field, $label])
        <div>
            <label style="display:block; font-size:11px; font-weight:600; color:#16a34a; margin-bottom:4px; text-transform:uppercase;">{{ $label }}</label>
            <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ $mTec->$field ?? '—' }}</p>
        </div>
        @endforeach
    </div>
</div>
@endif

@endif

        {{-- BOTONES --}}
        <div style="display:flex; justify-content:flex-end; gap:10px;">
            <a href="{{ route('asesor.mis-organizaciones') }}"
               style="display:inline-flex; align-items:center; gap:6px; background:#1e3a5f; color:white; padding:10px 20px; border-radius:8px; font-size:14px; text-decoration:none; font-weight:500;">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="15 18 9 12 15 6"/>
                </svg>
                Volver a mis organizaciones
            </a>
        </div>

    </div>
</div>

<script>
let botonListoAgregado = false;
let botonListoObsAgregado = false;

let fpInstance;
if (document.getElementById('fecha_hora_display')) {
    fpInstance = flatpickr("#fecha_hora_display", {
        locale: "es",
        enableTime: true,
        time_24hr: true,
        dateFormat: "d/m/Y H:i",
        defaultDate: document.getElementById('fecha_hora_display').value || null,
        closeOnSelect: false,
        onOpen: function(selectedDates, dateStr, instance) {
            instance.jumpToDate(instance.selectedDates[0] || new Date());
            if (!botonListoAgregado) {
                const btn = document.createElement('button');
                btn.textContent = '✓ Listo';
                btn.type = 'button';
                btn.style.cssText = 'width:100%; margin-top:8px; padding:7px; background:#2563eb; color:white; border:none; border-radius:6px; font-size:13px; font-weight:500; cursor:pointer;';
                btn.addEventListener('click', function() { instance.close(); });
                instance.calendarContainer.appendChild(btn);
                botonListoAgregado = true;
            }
        },
        onChange: function(selectedDates) {
            if (selectedDates.length > 0) {
                const d = selectedDates[0];
                document.getElementById('fecha_hora_input').value =
                    d.getFullYear() + '-' +
                    String(d.getMonth()+1).padStart(2,'0') + '-' +
                    String(d.getDate()).padStart(2,'0') + ' ' +
                    String(d.getHours()).padStart(2,'0') + ':' +
                    String(d.getMinutes()).padStart(2,'0') + ':00';
            }
        }
    });
}

let fpObsInstance;
if (document.getElementById('obs_fecha_hora_display')) {
    fpObsInstance = flatpickr("#obs_fecha_hora_display", {
        locale: "es",
        enableTime: true,
        time_24hr: true,
        dateFormat: "d/m/Y H:i",
        defaultDate: document.getElementById('obs_fecha_hora_display').value || null,
        closeOnSelect: false,
        onOpen: function(selectedDates, dateStr, instance) {
            instance.jumpToDate(instance.selectedDates[0] || new Date());
            if (!botonListoObsAgregado) {
                const btn = document.createElement('button');
                btn.textContent = '✓ Listo';
                btn.type = 'button';
                btn.style.cssText = 'width:100%; margin-top:8px; padding:7px; background:#2563eb; color:white; border:none; border-radius:6px; font-size:13px; font-weight:500; cursor:pointer;';
                btn.addEventListener('click', function() { instance.close(); });
                instance.calendarContainer.appendChild(btn);
                botonListoObsAgregado = true;
            }
        },
        onChange: function(selectedDates) {
            if (selectedDates.length > 0) {
                const d = selectedDates[0];
                document.getElementById('obs_fecha_hora_input').value =
                    d.getFullYear() + '-' +
                    String(d.getMonth()+1).padStart(2,'0') + '-' +
                    String(d.getDate()).padStart(2,'0') + ' ' +
                    String(d.getHours()).padStart(2,'0') + ':' +
                    String(d.getMinutes()).padStart(2,'0') + ':00';
            }
        }
    });
}

function limpiarFecha() {
    if (fpInstance) fpInstance.clear();
    document.getElementById('fecha_hora_input').value = '';
}

function limpiarFechaObs() {
    if (fpObsInstance) fpObsInstance.clear();
    document.getElementById('obs_fecha_hora_input').value = '';
}

const modalidadSelect = document.getElementById('modalidad-select');
const seccionDireccion = document.getElementById('seccion-direccion');
if (modalidadSelect) {
    modalidadSelect.addEventListener('change', function() {
        seccionDireccion.style.display = this.value === 'presencial_externa' ? 'block' : 'none';
    });
}

function activarEdicion() {
    document.getElementById('charla-readonly').style.display = 'none';
    document.getElementById('charla-form').style.display = 'block';
    document.getElementById('btn-editar-charla').style.display = 'none';
    if (fpInstance) fpInstance.jumpToDate(fpInstance.selectedDates[0] || new Date());
}

function cancelarEdicion() {
    document.getElementById('charla-readonly').style.display = 'grid';
    document.getElementById('charla-form').style.display = 'none';
    document.getElementById('btn-editar-charla').style.display = 'inline-flex';
}

function activarEdicionObs() {
    document.getElementById('obs-readonly').style.display = 'none';
    document.getElementById('obs-form').style.display = 'block';
    document.getElementById('btn-editar-obs').style.display = 'none';
}

function cancelarEdicionObs() {
    document.getElementById('obs-readonly').style.display = 'grid';
    document.getElementById('obs-form').style.display = 'none';
    document.getElementById('btn-editar-obs').style.display = 'inline-flex';
}

function activarEdicionTec() {
    document.getElementById('tec-readonly').style.display = 'none';
    document.getElementById('tec-form').style.display = 'block';
    document.getElementById('btn-editar-tec').style.display = 'none';
    generarPapeletas();
    calcularMaterialesAsesor();
}

function cancelarEdicionTec() {
    document.getElementById('tec-readonly').style.display = 'block';
    document.getElementById('tec-form').style.display = 'none';
    document.getElementById('btn-editar-tec').style.display = 'inline-flex';
}
const ordinalListas = ['Primera','Segunda','Tercera','Cuarta','Quinta'];

const ordinalPapJS = ['Primera','Segunda','Tercera','Cuarta','Quinta','Sexta','Séptima','Octava','Novena','Décima'];
const ordinalLisJS = ['Primera','Segunda','Tercera','Cuarta','Quinta'];
const savedData    = @json($datosGuardadosBlade ?? []);

function generarPapeletas() {
    const cantPap = parseInt(document.getElementById('asesor_input_papeletas')?.value) || 0;
    const cantLis = parseInt(document.querySelector('[name="cantidad_listas"]')?.value) || 0;
    const container = document.getElementById('papeletas-container');
    if (!container) return;

    // Guardar valores actuales si ya hay inputs
    const valoresActuales = {};
    container.querySelectorAll('input').forEach(input => {
        if (input.name) valoresActuales[input.name] = input.value;
    });

    container.innerHTML = '';
    const marginTop = cantLis > 1 ? Math.round((cantLis - 1) * 29 / 2) : 0;

    for (let p = 1; p <= Math.min(cantPap, 10); p++) {
        const saved = savedData[p] || {};

        let listasHTML = '';
        for (let l = 1; l <= Math.min(cantLis, 5); l++) {
            const nombreKey = `pap_${p}_lista_${l}_nombre`;
            // Prioridad: valor actual del input > dato guardado en BD
            const valor = (valoresActuales[nombreKey] !== undefined && valoresActuales[nombreKey] !== '')
                ? valoresActuales[nombreKey]
                : (saved.listas?.[l] || '');
            listasHTML += `<input type="text" name="${nombreKey}" value="${valor}"
                placeholder="${ordinalLisJS[l-1]} Lista"
                style="width:100%; border:1px solid #d1d5db; border-radius:6px; padding:5px 7px; font-size:12px; color:#111827; background:#fff; box-sizing:border-box; margin-bottom:4px;">`;
        }

        const candidaturaKey = `pap_${p}_lista_1_candidatura`;
        const sistemaKey = `pap_${p}_sistema_eleccion`;
        const candidaturaVal = (valoresActuales[candidaturaKey] !== undefined && valoresActuales[candidaturaKey] !== '')
            ? valoresActuales[candidaturaKey]
            : (saved.candidatura || '');
        const sistemaVal = (valoresActuales[sistemaKey] !== undefined && valoresActuales[sistemaKey] !== '')
            ? valoresActuales[sistemaKey]
            : (saved.sistema || '');

        container.innerHTML += `
        <div class="papeleta-block" style="background:#f9fafb; border:1px solid #e5e7eb; border-radius:10px; padding:14px; margin-bottom:10px;">
            <p style="font-size:12px; font-weight:700; color:#374151; margin:0 0 10px;">${ordinalPapJS[p-1]} Papeleta</p>
            <div style="display:flex; gap:8px; align-items:flex-start;">
                <div style="flex:1; display:flex; flex-direction:column; gap:4px;">
                    <label style="font-size:11px; font-weight:600; color:#6b7280; text-transform:uppercase;">Lista</label>
                    ${listasHTML}
                </div>
                <div style="flex:1;">
                    <label style="font-size:11px; font-weight:600; color:#6b7280; text-transform:uppercase; display:block; margin-bottom:4px;">Candidatura</label>
                    <input type="text" name="${candidaturaKey}" value="${candidaturaVal}"
                        list="candidaturas-asesor-list" placeholder="Candidatura..."
                        style="width:100%; border:1px solid #d1d5db; border-radius:6px; padding:5px 7px; font-size:12px; color:#111827; background:#fff; box-sizing:border-box; margin-top:${marginTop}px;">
                </div>
                <div style="flex:1;">
                    <label style="font-size:11px; font-weight:600; color:#6b7280; text-transform:uppercase; display:block; margin-bottom:4px;">Sistema de Elección</label>
                    <input type="text" name="${sistemaKey}" value="${sistemaVal}"
                        list="sistemas-asesor-list" placeholder="Sistema..."
                        style="width:100%; border:1px solid #d1d5db; border-radius:6px; padding:5px 7px; font-size:12px; color:#111827; background:#fff; box-sizing:border-box; margin-top:${marginTop}px;">
                </div>
            </div>
        </div>`;
    }
}

function calcularMaterialesAsesor() {
    const mesas     = parseInt(document.getElementById('asesor_input_mesas')?.value) || 0;
    const papeletas = parseInt(document.getElementById('asesor_input_papeletas')?.value) || 0;

    const actas    = mesas * 3;
    const padrones = mesas * 3;
    const cuartos  = mesas;
    const urnas    = mesas * papeletas;

    const fActas    = document.getElementById('asesor_mat_actas');
    const fPadrones = document.getElementById('asesor_mat_padrones');
    const fCuartos  = document.getElementById('asesor_mat_cuartos');
    const fUrnas    = document.getElementById('asesor_mat_urnas');

  const tintas = mesas;

    if (fActas)    fActas.value    = actas;
    if (fPadrones) fPadrones.value = padrones;
    if (fCuartos)  fCuartos.value  = cuartos;
    if (fUrnas)    fUrnas.value    = urnas;

    const fPapeletas = document.getElementById('asesor_mat_papeletas');
if (fPapeletas) fPapeletas.value = papeletas;

    const fTintas = document.getElementById('asesor_mat_tintas');
    if (fTintas) fTintas.value = tintas;
}

document.querySelector('[name="cantidad_listas"]')?.addEventListener('input', generarPapeletas);
document.getElementById('asesor_input_papeletas')?.addEventListener('input', () => {
    generarPapeletas();
    calcularMaterialesAsesor();
});
document.getElementById('asesor_input_mesas')?.addEventListener('input', calcularMaterialesAsesor);

// Sincronización inversa — cambiás papeletas en materiales y se actualiza arriba
document.getElementById('asesor_mat_papeletas')?.addEventListener('input', function() {
    const val = parseInt(this.value) || 0;
    const inputCantPap = document.getElementById('asesor_input_papeletas');
    if (inputCantPap) {
        inputCantPap.value = val;
        generarPapeletas();
    }
});

calcularMaterialesAsesor();
</script>
</x-panel-layout>
