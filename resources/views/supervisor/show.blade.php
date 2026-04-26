<x-panel-layout title="Ver Entrada — {{ $entrada->codigo_org }}">
<div class="px-2 py-2">
    <div style="max-width:760px; margin:0 auto;">

        @if(session('success'))
        <div style="background:#d1fae5; color:#065f46; padding:10px 14px; border-radius:8px; margin-bottom:14px; font-size:13px;">
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

        {{-- ASUNTOS --}}
        <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:20px; margin-bottom:14px; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
            <h3 style="font-size:13px; font-weight:600; color:#374151; margin-bottom:16px; padding-bottom:10px; border-bottom:1px solid #f3f4f6; text-transform:uppercase; letter-spacing:0.5px;">Servicios</h3>
            <div style="display:flex; gap:8px; flex-wrap:wrap;">
                <span style="padding:6px 14px; border-radius:20px; font-size:13px; font-weight:500; background:{{ $entrada->asunto_char ? '#dbeafe' : '#f3f4f6' }}; color:{{ $entrada->asunto_char ? '#1d4ed8' : '#9ca3af' }}; text-decoration:{{ $entrada->asunto_char ? 'none' : 'line-through' }};">CHARLA</span>
                <span style="padding:6px 14px; border-radius:20px; font-size:13px; font-weight:500; background:{{ $entrada->asunto_log ? '#d1fae5' : '#f3f4f6' }}; color:{{ $entrada->asunto_log ? '#065f46' : '#9ca3af' }}; text-decoration:{{ $entrada->asunto_log ? 'none' : 'line-through' }};">LOGÍSTICA</span>
                <span style="padding:6px 14px; border-radius:20px; font-size:13px; font-weight:500; background:{{ $entrada->asunto_tec ? '#ede9fe' : '#f3f4f6' }}; color:{{ $entrada->asunto_tec ? '#6d28d9' : '#9ca3af' }}; text-decoration:{{ $entrada->asunto_tec ? 'none' : 'line-through' }};">TECNICA</span>
                <span style="padding:6px 14px; border-radius:20px; font-size:13px; font-weight:500; background:{{ $entrada->asunto_obs ? '#fef3c7' : '#f3f4f6' }}; color:{{ $entrada->asunto_obs ? '#92400e' : '#9ca3af' }}; text-decoration:{{ $entrada->asunto_obs ? 'none' : 'line-through' }};">OBSERVADORES</span>
            </div>
        </div>

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
                @if($entrada->observador->descripcion)
                <div style="grid-column:span 2;">
                    <p style="font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px;">Descripción</p>
                    <p style="font-size:14px; color:#111827; margin:0;">{{ $entrada->observador->descripcion }}</p>
                </div>
                @endif
            </div>
        </div>
        @endif

    </div>
</div>
</x-panel-layout>