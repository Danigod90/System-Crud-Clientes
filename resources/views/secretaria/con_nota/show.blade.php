<x-panel-layout title="Ver Entrada — {{ $conNota->codigo_org }}">

<div class="px-2 py-2">
    <div style="max-width:760px; margin:0 auto;">

        {{-- ENCABEZADO --}}
        <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:20px; margin-bottom:14px; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
            <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                <div>
                    <span style="font-family:monospace; color:#185FA5; font-weight:700; font-size:18px;">{{ $conNota->codigo_org }}</span>
                    <p style="font-size:11px; color:#9ca3af; margin-top:4px;">Registrado por {{ $conNota->registrado_por }} el {{ $conNota->created_at?->format('d/m/Y H:i') ?? '-' }}</p>
                </div>
                <div style="display:flex; gap:8px; flex-wrap:wrap; justify-content:flex-end;">
                    <a href="{{ route('secretaria.con-nota.edit', ['conNota' => $conNota->id]) }}"
                       style="display:inline-flex; align-items:center; gap:6px; background:#f59e0b; color:white; padding:8px 14px; border-radius:8px; font-size:13px; text-decoration:none;">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                        </svg>
                        Editar
                    </a>

                    @if($conNota->via_ingreso == 'presencial')
                    <a href="{{ route('secretaria.con-nota.nota-pdf', $conNota->id) }}" target="_blank"
                       style="display:inline-flex; align-items:center; gap:6px; background:#1e3a5f; color:white; padding:8px 14px; border-radius:8px; font-size:13px; text-decoration:none;">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                        </svg>
                        Imprimir Nota
                    </a>
                    @endif

                    @if($conNota->asunto_log && !$conNota->asunto_tec)
                    <a href="{{ route('secretaria.con-nota.recibo-logistica', $conNota->id) }}" target="_blank"
                       style="display:inline-flex; align-items:center; gap:6px; background:#065f46; color:white; padding:8px 14px; border-radius:8px; font-size:13px; text-decoration:none;">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                        </svg>
                        Imprimir Logístico
                    </a>
                    @endif

                    @if($conNota->asunto_log && !$conNota->asunto_tec && $conNota->log_estado !== 'entregada')
                    <form method="POST" action="{{ route('secretaria.con-nota.entregar-log', $conNota->id) }}" style="display:inline;">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                                onclick="return confirm('¿Confirmar entrega logística de {{ $conNota->nombre_organizacion }}?')"
                                style="display:inline-flex; align-items:center; gap:6px; background:#065f46; color:white; padding:8px 14px; border-radius:8px; font-size:13px; border:none; cursor:pointer;">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                            Marcar entregado
                        </button>
                    </form>
                    @else
                    <a href="{{ route('secretaria.con-nota.index') }}"
                       style="display:inline-flex; align-items:center; gap:6px; background:#f3f4f6; color:#374151; padding:8px 14px; border-radius:8px; font-size:13px; text-decoration:none;">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <polyline points="15 18 9 12 15 6"/>
                        </svg>
                        Volver
                    </a>
                    @endif
                </div>
            </div>
        </div>

        {{-- DATOS --}}
        <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:20px; margin-bottom:14px; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
            <h3 style="font-size:13px; font-weight:600; color:#374151; margin-bottom:16px; padding-bottom:10px; border-bottom:1px solid #f3f4f6; text-transform:uppercase; letter-spacing:0.5px;">Datos de la organización</h3>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                <div>
                    <p style="font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px;">Organización</p>
                    <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ $conNota->nombre_organizacion }}</p>
                    <p style="font-size:12px; color:#6b7280; margin:2px 0 0;">{{ $conNota->tipo_organizacion }}</p>
                </div>
                <div>
                    <p style="font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px;">Representante</p>
                    <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ $conNota->nombre_representante }}</p>
                    @if($conNota->telefono_representante)
                    <p style="font-size:12px; color:#6b7280; margin:2px 0 0;">{{ $conNota->telefono_representante }}</p>
                    @endif
                </div>
                <div>
                    <p style="font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px;">Asesor asignado</p>
                    <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ $conNota->asesor_asignado ?? '-' }}</p>
                </div>
                <div>
                    <p style="font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px;">Vía de ingreso</p>
                    <p style="font-size:14px; font-weight:600; color:#111827; margin:0; text-transform:capitalize;">{{ $conNota->via_ingreso }}</p>
                </div>
                <div>
                    <p style="font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px;">Fecha de elección</p>
                    <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">
                        {{ $conNota->fecha_eleccion ? $conNota->fecha_eleccion->format('d/m/Y') : '—' }}
                    </p>
                </div>
                <div>
                    <p style="font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px;">Asunto</p>
                    <p style="font-size:14px; font-weight:700; color:#111827; font-family:monospace; margin:0;">{{ $conNota->asunto_texto }}</p>
                </div>
            </div>
        </div>

        {{-- SERVICIOS --}}
        <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:20px; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
            <h3 style="font-size:13px; font-weight:600; color:#374151; margin-bottom:16px; padding-bottom:10px; border-bottom:1px solid #f3f4f6; text-transform:uppercase; letter-spacing:0.5px;">Servicios solicitados</h3>

            <div style="display:flex; gap:10px; flex-wrap:wrap;">
                <span style="display:inline-flex; align-items:center; gap:6px; padding:6px 14px; border-radius:20px; font-size:13px; font-weight:500;
                    background:{{ $conNota->asunto_char ? '#dbeafe' : '#f3f4f6' }};
                    color:{{ $conNota->asunto_char ? '#1d4ed8' : '#9ca3af' }};
                    text-decoration:{{ $conNota->asunto_char ? 'none' : 'line-through' }};">
                    Char — Charla
                </span>

                <span style="display:inline-flex; align-items:center; gap:6px; padding:6px 14px; border-radius:20px; font-size:13px; font-weight:500;
                    background:{{ $conNota->asunto_log ? '#d1fae5' : '#f3f4f6' }};
                    color:{{ $conNota->asunto_log ? '#065f46' : '#9ca3af' }};
                    text-decoration:{{ $conNota->asunto_log ? 'none' : 'line-through' }};">
                    Log — Logística
                    @if($conNota->asunto_log && ($conNota->log_urnas || $conNota->log_cuartos || $conNota->log_tintas))
                        @if($conNota->log_urnas) &nbsp;({{ $conNota->log_urnas }}) urnas @endif
                        @if($conNota->log_cuartos) &nbsp;({{ $conNota->log_cuartos }}) cuartos @endif
                        @if($conNota->log_tintas) &nbsp;({{ $conNota->log_tintas }}) tintas @endif
                    @endif
                </span>

                <span style="display:inline-flex; align-items:center; gap:6px; padding:6px 14px; border-radius:20px; font-size:13px; font-weight:500;
                    background:{{ $conNota->asunto_tec ? '#ede9fe' : '#f3f4f6' }};
                    color:{{ $conNota->asunto_tec ? '#6d28d9' : '#9ca3af' }};
                    text-decoration:{{ $conNota->asunto_tec ? 'none' : 'line-through' }};">
                    Tec — Técnica
                </span>
            </div>
            {{-- DETALLE DE CHARLA (solo lectura) --}}
        @if($conNota->asunto_char && $conNota->charla)
        @php
            $dotColor = match($conNota->charla->estado) {
                'realizada'  => '#16a34a',
                'cancelada'  => '#dc2626',
                'suspendida' => '#f97316',
                'vencida'    => '#dc2626',
                default      => '#eab308',
            };
        @endphp
        <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:20px; margin-top:14px; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
            <h3 style="font-size:13px; font-weight:600; color:#374151; margin-bottom:16px; padding-bottom:10px; border-bottom:1px solid #f3f4f6; text-transform:uppercase; letter-spacing:0.5px; display:flex; align-items:center; gap:8px;">
                Detalle de Charla
                <span style="display:inline-flex; align-items:center; gap:4px; font-size:11px; font-weight:500; color:#6b7280; text-transform:none;">
                    <span style="width:9px; height:9px; border-radius:50%; background:{{ $dotColor }}; display:inline-block;"></span>
                    {{ ucfirst($conNota->charla->estado) }}
                </span>
            </h3>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                <div>
                    <p style="font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px;">Modalidad</p>
                    <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">
                        {{ $conNota->charla->modalidad == 'virtual' ? 'Virtual' : ($conNota->charla->modalidad == 'presencial_oficina' ? 'Presencial — Oficina' : 'Presencial — Externa') }}
                    </p>
                </div>
                <div>
                    <p style="font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px;">Fecha y hora</p>
                    <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">
                        {{ $conNota->charla->fecha_hora?->format('d/m/Y H:i') ?? '—' }}
                    </p>
                </div>
                @if($conNota->charla->direccion)
                <div style="grid-column:span 2;">
                    <p style="font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px;">Dirección</p>
                    <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ $conNota->charla->direccion }}</p>
                </div>
                @endif
                @if($conNota->charla->descripcion)
                <div style="grid-column:span 2;">
                    <p style="font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px;">Descripción</p>
                    <p style="font-size:14px; color:#111827; margin:0;">{{ $conNota->charla->descripcion }}</p>
                </div>
                @endif
            </div>
        </div>
        @endif
        </div>

    </div>
</div>

</x-panel-layout>
