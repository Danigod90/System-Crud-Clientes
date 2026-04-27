<x-panel-layout title="Ver Entrada — {{ $entrada->codigo_org }}">
<div class="px-2 py-2">
    <div style="max-width:760px; margin:0 auto;">

       @if(session('success'))
<div style="display:flex; align-items:center; gap:10px; background:#d1fae5; color:#065f46; padding:12px 16px; border-radius:10px; margin-bottom:14px; font-size:13px; border-left:4px solid #16a34a; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
    <svg width="18" height="18" fill="none" stroke="#16a34a" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;">
        <circle cx="12" cy="12" r="10"/><polyline points="9 12 11 14 15 10"/>
    </svg>
    {{ session('success') }}
</div>
@endif

        {{-- ENCABEZADO --}}
        <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:20px; margin-bottom:14px; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
            <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                <div>
                    <span style="font-family:monospace; color:#185FA5; font-weight:700; font-size:18px;">{{ $entrada->codigo_org }}</span>
                    <p style="font-size:11px; color:#9ca3af; margin-top:4px;">Registrado por {{ $entrada->registrado_por }} el {{ $entrada->created_at?->format('d/m/Y H:i') ?? '-' }}</p>
                    @if($entrada->supervisor_cargado)
                    <span style="display:inline-flex; align-items:center; gap:6px; background:#dcfce7; color:#16a34a; padding:4px 12px; border-radius:999px; font-size:12px; font-weight:600; margin-top:8px;">
                        ✓ Cargado el {{ $entrada->supervisor_cargado_at?->format('d/m/Y H:i') }}
                    </span>
                    @endif
                </div>
                <div style="display:flex; gap:8px; flex-wrap:wrap; justify-content:flex-end;">
                    <a href="{{ route('supervisor.index') }}"
                       style="display:inline-flex; align-items:center; gap:6px; background:#f3f4f6; color:#374151; padding:8px 14px; border-radius:8px; font-size:13px; text-decoration:none;">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <polyline points="15 18 9 12 15 6"/>
                        </svg>
                        Volver
                    </a>
                </div>
            </div>
        </div>

        {{-- DATOS --}}
        <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:20px; margin-bottom:14px; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
            <h3 style="font-size:13px; font-weight:600; color:#374151; margin-bottom:16px; padding-bottom:10px; border-bottom:1px solid #f3f4f6; text-transform:uppercase; letter-spacing:0.5px;">Datos de la organización</h3>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                <div>
                    <p style="font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px;">Organización</p>
                    <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ $entrada->nombre_organizacion }}</p>
                    <p style="font-size:12px; color:#6b7280; margin:2px 0 0;">{{ $entrada->tipo_organizacion }}</p>
                </div>
                <div>
                    <p style="font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px;">Representante</p>
                    <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ $entrada->nombre_representante }}</p>
                    @if($entrada->telefono_representante)
                    <p style="font-size:12px; color:#6b7280; margin:2px 0 0;">{{ $entrada->telefono_representante }}</p>
                    @endif
                </div>
                <div>
                    <p style="font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px;">Asesor asignado</p>
                    <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ $entrada->asesor_asignado ?? '-' }}</p>
                </div>
                <div>
                    <p style="font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px;">Vía de ingreso</p>
                    <p style="font-size:14px; font-weight:600; color:#111827; margin:0; text-transform:capitalize;">{{ $entrada->via_ingreso }}</p>
                </div>
                <div>
                    <p style="font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px;">Fecha de elección</p>
                    <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ $entrada->fecha_eleccion ? $entrada->fecha_eleccion->format('d/m/Y') : '—' }}</p>
                </div>
                <div>
                    <p style="font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px;">Asunto</p>
                    <p style="font-size:14px; font-weight:700; color:#111827; font-family:monospace; margin:0;">{{ $entrada->asunto_texto }}</p>
                </div>
            </div>
        </div>

        {{-- SERVICIOS --}}
        <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:20px; margin-bottom:14px; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
            <h3 style="font-size:13px; font-weight:600; color:#374151; margin-bottom:16px; padding-bottom:10px; border-bottom:1px solid #f3f4f6; text-transform:uppercase; letter-spacing:0.5px;">Servicios</h3>
            <div style="display:flex; gap:8px; flex-wrap:wrap;">
                <span style="padding:6px 14px; border-radius:20px; font-size:13px; font-weight:500; background:{{ $entrada->asunto_char ? '#dbeafe' : '#f3f4f6' }}; color:{{ $entrada->asunto_char ? '#1d4ed8' : '#9ca3af' }}; text-decoration:{{ $entrada->asunto_char ? 'none' : 'line-through' }};">CHARLA</span>
                <span style="padding:6px 14px; border-radius:20px; font-size:13px; font-weight:500; background:{{ $entrada->asunto_log ? '#d1fae5' : '#f3f4f6' }}; color:{{ $entrada->asunto_log ? '#065f46' : '#9ca3af' }}; text-decoration:{{ $entrada->asunto_log ? 'none' : 'line-through' }};">LOGÍSTICA</span>
                <span style="padding:6px 14px; border-radius:20px; font-size:13px; font-weight:500; background:{{ $entrada->asunto_tec ? '#ede9fe' : '#f3f4f6' }}; color:{{ $entrada->asunto_tec ? '#6d28d9' : '#9ca3af' }}; text-decoration:{{ $entrada->asunto_tec ? 'none' : 'line-through' }};">TECNICA</span>
                <span style="padding:6px 14px; border-radius:20px; font-size:13px; font-weight:500; background:{{ $entrada->asunto_obs ? '#fef3c7' : '#f3f4f6' }}; color:{{ $entrada->asunto_obs ? '#92400e' : '#9ca3af' }}; text-decoration:{{ $entrada->asunto_obs ? 'none' : 'line-through' }};">OBSERVADORES</span>
            </div>
        </div>

        {{-- CHARLAS --}}
        @if($entrada->asunto_char && $entrada->charlas->count() > 0)
        @foreach($entrada->charlas as $i => $ch)
        @php
            $dotColor = match($ch->estado) { 'realizada' => '#16a34a', 'cancelada' => '#dc2626', 'suspendida' => '#f97316', default => '#eab308' };
            $tipoLabel = match($ch->char_tipo ?? '') { 'proceso_electoral' => 'Charla sobre Proceso Electoral', 'mmrv' => 'Charla para MMRV', 'ambos' => 'Charla sobre Proceso - Charla MMRV', default => '—' };
        @endphp
        <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:20px; margin-bottom:14px; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
            <h3 style="font-size:13px; font-weight:600; color:#374151; margin-bottom:16px; padding-bottom:10px; border-bottom:1px solid #f3f4f6; text-transform:uppercase; letter-spacing:0.5px; display:flex; align-items:center; gap:8px;">
                Charla {{ $i+1 }}
                <span style="display:inline-flex; align-items:center; gap:4px; font-size:11px; font-weight:500; color:#6b7280; text-transform:none;">
                    <span style="width:9px; height:9px; border-radius:50%; background:{{ $dotColor }}; display:inline-block;"></span>
                    {{ ucfirst($ch->estado) }}
                </span>
            </h3>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                <div>
                    <p style="font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px;">Modalidad</p>
                    <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ $ch->modalidad == 'virtual' ? 'Virtual' : ($ch->modalidad == 'presencial_oficina' ? 'Presencial — Oficina' : 'Presencial — Externa') }}</p>
                </div>
                @if($ch->char_tipo)
                <div>
                    <p style="font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px;">Tipo de charla</p>
                    <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ $tipoLabel }}</p>
                </div>
                @endif
                <div>
                    <p style="font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px;">Fecha y hora</p>
                    <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ $ch->fecha_hora?->format('d/m/Y H:i') ?? '—' }}</p>
                </div>
                @if($ch->descripcion)
                <div style="grid-column:span 2;">
                    <p style="font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px;">Descripción</p>
                    <p style="font-size:14px; color:#111827; margin:0;">{{ $ch->descripcion }}</p>
                </div>
                @endif
            </div>
        </div>
        @endforeach
        @endif

        {{-- OBSERVADORES --}}
        @if($entrada->asunto_obs && $entrada->observador)
        @php $obsDot = match($entrada->observador->estado) { 'realizada' => '#16a34a', 'cancelada' => '#dc2626', 'suspendida' => '#f97316', default => '#eab308' }; @endphp
        <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:20px; margin-bottom:14px; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
            <h3 style="font-size:13px; font-weight:600; color:#374151; margin-bottom:16px; padding-bottom:10px; border-bottom:1px solid #f3f4f6; text-transform:uppercase; letter-spacing:0.5px; display:flex; align-items:center; gap:8px;">
                Observadores
                <span style="display:inline-flex; align-items:center; gap:4px; font-size:11px; font-weight:500; color:#6b7280; text-transform:none;">
                    <span style="width:9px; height:9px; border-radius:50%; background:{{ $obsDot }}; display:inline-block;"></span>
                    {{ ucfirst($entrada->observador->estado) }}
                </span>
            </h3>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                <div>
                    <p style="font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px;">Fecha y hora</p>
                    <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ $entrada->observador->fecha_hora?->format('d/m/Y H:i') ?? '—' }}</p>
                </div>
                @if($entrada->observador->observadores)
<div>
    <p style="font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px;">Observadores asistentes</p>
    <p style="font-size:14px; color:#111827; margin:0;">{{ $entrada->observador->observadores }}</p>
</div>
@endif
                @if($entrada->observador->descripcion)
                <div style="grid-column:span 2;">
                    <p style="font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px;">Descripción</p>
                    <p style="font-size:14px; color:#111827; margin:0;">{{ $entrada->observador->descripcion }}</p>
                </div>
                @endif
            </div>
        </div>
        @endif

        {{-- DETALLE LOGÍSTICO --}}
        @if($entrada->asunto_log && !$entrada->asunto_tec)
        <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:20px; margin-bottom:14px; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
            <h3 style="font-size:13px; font-weight:600; color:#374151; margin-bottom:16px; padding-bottom:10px; border-bottom:1px solid #f3f4f6; text-transform:uppercase; letter-spacing:0.5px; display:flex; align-items:center; gap:8px;">
                Detalle Logístico
                @php $logDot = in_array($entrada->log_estado ?? 'pendiente', ['entregada','realizado']) ? '#16a34a' : '#eab308'; @endphp
                <span style="display:inline-flex; align-items:center; gap:4px; font-size:11px; font-weight:500; color:#6b7280; text-transform:none;">
                    <span style="width:9px; height:9px; border-radius:50%; background:{{ $logDot }}; display:inline-block;"></span>
                    {{ in_array($entrada->log_estado ?? 'pendiente', ['entregada','realizado']) ? 'Entregada' : 'Pendiente' }}
                </span>
            </h3>
            <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:12px;">
                <div style="text-align:center;">
                    <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase;">Urnas</label>
                    <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ $entrada->log_urnas ?? 0 }}</p>
                </div>
                <div style="text-align:center;">
                    <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase;">Cuartos oscuros</label>
                    <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ $entrada->log_cuartos ?? 0 }}</p>
                </div>
                <div style="text-align:center;">
                    <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase;">Tintas</label>
                    <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ $entrada->log_tintas ?? 0 }}</p>
                </div>
            </div>
        </div>
        @endif

        {{-- DATOS DEL ASESOR --}}
        @if($entrada->detalleTecnico)
        @php $mTec = $entrada->detalleTecnico; @endphp
        <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:20px; margin-bottom:14px; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
            <h3 style="font-size:13px; font-weight:600; color:#374151; text-transform:uppercase; letter-spacing:0.5px; margin:0 0 16px; padding-bottom:10px; border-bottom:1px solid #f3f4f6; display:flex; align-items:center; gap:8px;">
                Datos del Asesor
                <span style="display:inline-flex; align-items:center; gap:4px; font-size:11px; font-weight:500; color:#6b7280; text-transform:none;">
                    <span style="width:9px; height:9px; border-radius:50%; background:{{ $mTec->enviado_tecnica ? '#16a34a' : '#eab308' }}; display:inline-block;"></span>
                    {{ $mTec->enviado_tecnica ? 'Enviado a Técnica' : 'Pendiente' }}
                </span>
            </h3>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                <div>
                    <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase;">Órgano Electoral</label>
                    <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ $mTec->organo_electoral ?? '—' }}</p>
                </div>
                <div>
                    <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase;">Cantidad de Listas</label>
                    <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ $mTec->cantidad_listas ?? '—' }}</p>
                </div>
                <div>
                    <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase;">Cantidad de Papeletas</label>
                    <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ $mTec->cantidad_papeletas ?? '—' }}</p>
                </div>
                <div>
                    <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase;">Cantidad de Mesas</label>
                    <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ $mTec->cantidad_mesas ?? '—' }}</p>
                </div>
            </div>
        </div>
        @endif

        {{-- MATERIALES A ENTREGAR --}}
        @if($entrada->detalleTecnico?->cantidad_mesas)
        @php
            $mTec = $entrada->detalleTecnico;
            $estActas    = $mTec->mat_final_actas    !== null ? $mTec->mat_final_actas    : (($mTec->cantidad_mesas ?? 0) * 3);
            $estPadrones = $mTec->mat_final_padrones !== null ? $mTec->mat_final_padrones : (($mTec->cantidad_mesas ?? 0) * 3);
            $estCuartos  = $mTec->mat_final_cuartos  !== null ? $mTec->mat_final_cuartos  : ($mTec->cantidad_mesas ?? 0);
            $estUrnas    = $mTec->mat_final_urnas    !== null ? $mTec->mat_final_urnas    : (($mTec->cantidad_mesas ?? 0) * ($mTec->cantidad_papeletas ?? 0));
            $estTintas   = $mTec->mat_final_tintas   !== null ? $mTec->mat_final_tintas   : ($mTec->cantidad_mesas ?? 0);
        @endphp
        <div style="background:#eff6ff; border:1px solid #bfdbfe; border-radius:8px; padding:12px 16px; margin-bottom:14px;">
            <p style="font-size:11px; font-weight:700; color:#1e40af; text-transform:uppercase; margin:0 0 10px;">Materiales a Entregar</p>
            <div style="display:grid; grid-template-columns:repeat(6,1fr); gap:8px;">
                <div style="text-align:center;">
                    <p style="font-size:11px; color:#6b7280; margin:0 0 2px;">Papeletas</p>
                    <p style="font-size:18px; font-weight:700; color:#1e40af; margin:0;">{{ $mTec->mat_final_papeletas ?? $mTec->cantidad_papeletas ?? 0 }}</p>
                    @if($mTec->mat_final_papeletas_formato)
                    <p style="font-size:10px; color:#6b7280; margin:2px 0 0;">{{ ucfirst($mTec->mat_final_papeletas_formato) }}</p>
                    @endif
                </div>
                <div style="text-align:center;">
                    <p style="font-size:11px; color:#6b7280; margin:0 0 2px;">Actas</p>
                    <p style="font-size:18px; font-weight:700; color:#1e40af; margin:0;">{{ $estActas }}</p>
                    @if($mTec->mat_final_actas_formato)
                    <p style="font-size:10px; color:#6b7280; margin:2px 0 0;">{{ ucfirst($mTec->mat_final_actas_formato) }}</p>
                    @endif
                </div>
                <div style="text-align:center;">
                    <p style="font-size:11px; color:#6b7280; margin:0 0 2px;">Padrones</p>
                    <p style="font-size:18px; font-weight:700; color:#1e40af; margin:0;">{{ $estPadrones }}</p>
                    @if($mTec->mat_final_padrones_formato)
                    <p style="font-size:10px; color:#6b7280; margin:2px 0 0;">{{ ucfirst($mTec->mat_final_padrones_formato) }}</p>
                    @endif
                </div>
                @if($entrada->asunto_log)
                <div style="text-align:center;">
                    <p style="font-size:11px; color:#6b7280; margin:0 0 2px;">Cuartos Oscuros</p>
                    <p style="font-size:18px; font-weight:700; color:#1e40af; margin:0;">{{ $estCuartos }}</p>
                </div>
                <div style="text-align:center;">
                    <p style="font-size:11px; color:#6b7280; margin:0 0 2px;">Urnas</p>
                    <p style="font-size:18px; font-weight:700; color:#1e40af; margin:0;">{{ $estUrnas }}</p>
                </div>
                <div style="text-align:center;">
                    <p style="font-size:11px; color:#6b7280; margin:0 0 2px;">Tintas</p>
                    <p style="font-size:18px; font-weight:700; color:#1e40af; margin:0;">{{ $estTintas }}</p>
                </div>
                @endif
            </div>
        </div>
        @endif

        {{-- TRABAJO TÉCNICO REALIZADO --}}
        @if($entrada->detalleTecnico?->tec_realizado)
        @php $mTec = $entrada->detalleTecnico; @endphp
        <div style="background:#f0fdf4; border-radius:12px; border:1px solid #bbf7d0; padding:20px; margin-bottom:14px; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
            <div style="display:flex; align-items:center; gap:8px; margin-bottom:16px; padding-bottom:10px; border-bottom:1px solid #bbf7d0;">
                <h3 style="font-size:13px; font-weight:600; color:#166534; text-transform:uppercase; letter-spacing:0.5px; margin:0;">✓ Trabajo Técnico Realizado</h3>
                <span style="font-size:11px; color:#16a34a;">{{ $mTec->tec_realizado_at ? \Carbon\Carbon::parse($mTec->tec_realizado_at)->format('d/m/Y H:i') : '' }}</span>
            </div>
            <p style="font-size:11px; font-weight:700; color:#166534; text-transform:uppercase; margin:0 0 10px;">Materiales Entregados</p>
            <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:10px; margin-bottom:16px;">
                @foreach([
                    ['mat_mesas', 'Mesa/s', false, 'cantidad_mesas', null],
                    ['mat_actas_electorales', 'Actas Electorales', 'mat_actas_electorales_formato', 'mat_final_actas', 'mat_final_actas_formato'],
                    ['mat_padron', 'Padrón Electoral', 'mat_padron_formato', 'mat_final_padrones', 'mat_final_padrones_formato'],
                    ['mat_matriz_boletin', 'Matriz de Boletín', 'mat_matriz_boletin_formato', 'mat_final_papeletas', 'mat_final_papeletas_formato'],
                    ['mat_actas_proclamacion', 'Actas de Proclamación', false, null, null],
                    ['mat_certificados', 'Certificados de Resultados', false, null, null],
                    ['mat_cuenta_votos', 'Cuenta Votos', false, null, null],
                ] as [$field, $label, $formatoField, $campoAsesor, $formatoAsesor])
                <div style="background:#fff; border:1px solid #d1fae5; border-radius:8px; padding:10px;">
                    <label style="display:block; font-size:11px; font-weight:600; color:#16a34a; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px;">{{ $label }}</label>
                    <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ ($campoAsesor ? $mTec->$campoAsesor : null) ?? $mTec->$field ?? '—' }}</p>
                    @if($formatoField)
                    @php $fmt = ($formatoAsesor ? $mTec->$formatoAsesor : null) ?? ($formatoField ? $mTec->$formatoField : null); @endphp
                    @if($fmt)
                    <p style="font-size:11px; color:#6b7280; margin:2px 0 0;">{{ ucfirst($fmt) }}</p>
                    @endif
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

    </div>
</div>
</x-panel-layout>