<x-panel-layout title="Editar Organización — {{ $entrada->codigo_org }}" :charlasPendientes="$charlasPendientes">
    @php
if (request()->has('volver')) {
    session(['volver_organizacion' => request('volver')]);
}
@endphp

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/l10n/es.min.js"></script>
<style>
.flatpickr-calendar { font-size: 12px !important; width: 300px !important; }
.flatpickr-day { max-width: 30px !important; height: 30px !important; line-height: 30px !important; }
.flatpickr-months .flatpickr-month { height: 34px !important; }
</style>

<div class="px-2 py-2">
    <div style="max-width:760px; margin:0 auto;">


@if(session('error'))
<div style="background:#fee2e2; border:1px solid #fecaca; color:#991b1b; padding:12px 16px; border-radius:10px; margin-bottom:14px; font-size:13px;">
    {{ session('error') }}
</div>

@endif
        @if(session('success'))
        <div style="display:flex; align-items:center; gap:10px; background:#d1fae5; color:#065f46; padding:12px 16px; border-radius:10px; margin-bottom:14px; font-size:13px; border-left:4px solid #16a34a; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
            <svg width="18" height="18" fill="none" stroke="#16a34a" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;">
                <circle cx="12" cy="12" r="10"/><polyline points="9 12 11 14 15 10"/>
            </svg>
            {{ session('success') }}
        </div>
        @endif

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
                    @if($entrada->asunto_log && !$entrada->asunto_tec)
<a href="{{ route('secretaria.con-nota.recibo-logistica', $entrada->id) }}" target="_blank"
                       style="display:inline-flex; align-items:center; gap:6px; background:#065f46; color:white; padding:6px 14px; border-radius:8px; font-size:12px; text-decoration:none; font-weight:500;">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                        </svg>
                        Imprimir Logístico
                    </a>
              @endif
                    @if($entrada->asunto_log && !$entrada->asunto_tec && $entrada->log_estado !== 'entregada')
                    <form method="POST" action="{{ route('secretaria.con-nota.entregar-log', $entrada->id) }}" style="display:inline;">
                        @csrf @method('PATCH')
                        <button type="submit"
                                onclick="return confirm('¿Confirmar entrega logística de {{ addslashes($entrada->nombre_organizacion) }}?')"
                                style="display:inline-flex; align-items:center; gap:6px; background:#065f46; color:white; padding:6px 14px; border-radius:8px; font-size:12px; border:none; cursor:pointer; font-weight:500;">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                            Marcar entregado
                        </button>
                    </form>
                    @elseif($entrada->asunto_log && !$entrada->asunto_tec && $entrada->log_estado === 'entregada')
                    <span style="display:inline-flex; align-items:center; gap:6px; background:#d1fae5; color:#065f46; padding:6px 14px; border-radius:8px; font-size:12px; font-weight:500;">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                        Entregado
                    </span>
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
                @if($entrada->direccion)
<div style="grid-column:span 2;">
    <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Dirección</label>
    <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ $entrada->direccion }}</p>
</div>
@endif
                <div>
                    <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Asunto</label>
                    <p style="font-size:14px; font-weight:700; color:#111827; font-family:monospace; margin:0;">{{ $entrada->asunto_texto }}</p>
                </div>
            </div>
        </div>
{{-- SECCIÓN DOCUMENTOS --}}
        <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:20px; margin-bottom:14px; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px; padding-bottom:10px; border-bottom:1px solid #f3f4f6;">
                <h3 style="font-size:13px; font-weight:600; color:#374151; text-transform:uppercase; letter-spacing:0.5px; margin:0; display:flex; align-items:center; gap:8px;">
                    Documentos
                    <span style="font-size:11px; font-weight:400; color:#9ca3af; text-transform:none;">{{ $entrada->documentos->count() }} archivo(s)</span>
                </h3>
            </div>

            {{-- LISTA DE DOCUMENTOS --}}
            @forelse($entrada->documentos as $doc)
            <div style="display:flex; align-items:center; gap:10px; padding:8px 10px; background:#f9fafb; border:1px solid #e5e7eb; border-radius:8px; margin-bottom:8px;">
                <div style="flex-shrink:0;">
                    @if(in_array($doc->extension, ['jpg','jpeg','png','gif']))
                        <span style="font-size:18px;">🖼</span>
                    @elseif($doc->extension == 'pdf')
                        <span style="font-size:18px;">📄</span>
                    @elseif(in_array($doc->extension, ['doc','docx']))
                        <span style="font-size:18px;">📝</span>
                    @else
                        <span style="font-size:18px;">📎</span>
                    @endif
                </div>
                <div style="flex:1; min-width:0;">
                    <p style="font-size:12px; font-weight:600; color:#111827; margin:0; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ $doc->nombre }}</p>
                    <p style="font-size:10px; color:#9ca3af; margin:0;">{{ strtoupper($doc->extension) }} · {{ number_format($doc->tamanio / 1024, 1) }} KB · {{ $doc->user->name ?? '—' }} · {{ $doc->created_at->format('d/m/Y') }}</p>
                </div>
                <div style="display:flex; gap:6px; flex-shrink:0;">
                    <a href="{{ Storage::disk('public')->url($doc->ruta) }}" download="{{ $doc->nombre }}"
                       style="display:inline-flex; align-items:center; gap:4px; background:#eff6ff; color:#2563eb; padding:4px 10px; border-radius:6px; font-size:11px; text-decoration:none; font-weight:500;">
                        Ver
                    </a>
                    <form method="POST" action="{{ route('documentos.destroy', $doc->id) }}">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('¿Eliminar documento?')"
                                style="display:inline-flex; align-items:center; gap:4px; background:#fef2f2; color:#dc2626; padding:4px 10px; border-radius:6px; font-size:11px; border:none; cursor:pointer; font-weight:500;">
                            Eliminar
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <p style="font-size:12px; color:#9ca3af; margin:0 0 12px;">No hay documentos cargados aún.</p>
            @endforelse

            {{-- FORM SUBIR --}}
            <form method="POST" action="{{ route('documentos.store', $entrada->id) }}" enctype="multipart/form-data" style="margin-top:12px; border-top:1px solid #f3f4f6; padding-top:12px;">
                @csrf
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-bottom:10px;">
                    <div>
                        <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Nombre del documento</label>
                        <input type="text" name="nombre" placeholder="Ej: Resolución, Lista candidatos..."
                               style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
                    </div>
                    <div>
                        <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Archivo (máx. 10MB)</label>
                        <input type="file" name="archivo" required
                               style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:6px 10px; font-size:12px; color:#374151; outline:none; box-sizing:border-box; background:#fff;">
                    </div>
                </div>
                <div style="display:flex; justify-content:flex-end;">
                    <button type="submit"
                            style="display:inline-flex; align-items:center; gap:6px; background:#2563eb; color:white; padding:7px 16px; border-radius:8px; font-size:12px; border:none; cursor:pointer; font-weight:500;">
                        Subir documento
                    </button>
                </div>
            </form>
        </div>

        {{-- SECCIÓN LOGÍSTICA (solo lectura) --}}
        @if($entrada->asunto_log && !$entrada->asunto_tec)
        <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:20px; margin-bottom:14px; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px; padding-bottom:10px; border-bottom:1px solid #f3f4f6;">
                <h3 style="font-size:13px; font-weight:600; color:#374151; text-transform:uppercase; letter-spacing:0.5px; margin:0; display:flex; align-items:center; gap:8px;">
                    Detalle Logístico
                    @php $logDot = in_array($entrada->log_estado ?? 'pendiente', ['entregada', 'realizado']) ? '#16a34a' : '#eab308'; @endphp
                    <span style="display:inline-flex; align-items:center; gap:4px; font-size:11px; font-weight:500; color:#6b7280; text-transform:none;">
                        <span style="width:9px; height:9px; border-radius:50%; background:{{ $logDot }}; display:inline-block;"></span>
                        {{ in_array($entrada->log_estado ?? 'pendiente', ['entregada', 'realizado']) ? 'Entregada' : 'Pendiente' }}
                    </span>
                </h3>

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
            {{-- GLOBITOS --}}
            @foreach($entrada->charlas as $i => $ch)
                @php
                    $dotColor = match($ch->estado) {
                        'realizada'  => '#16a34a',
                        'cancelada'  => '#dc2626',
                        'suspendida' => '#f97316',
                        'vencida'    => '#dc2626',
                        default      => '#eab308',
                    };
                @endphp
                <span style="display:inline-flex; align-items:center; gap:3px; font-size:11px; font-weight:500; color:#6b7280; text-transform:none;">
                    <span style="width:9px; height:9px; border-radius:50%; background:{{ $dotColor }}; display:inline-block;"></span>
                    <sup style="font-size:9px;">{{ $i+1 }}</sup>
                </span>
            @endforeach
        </h3>
        <div style="display:flex; gap:8px; align-items:center;">
            @if($entrada->charlas->count() < 2)
            <button onclick="mostrarFormNuevaCharla()"
                    style="display:inline-flex; align-items:center; gap:5px; background:#2563eb; color:white; padding:6px 12px; border-radius:8px; font-size:12px; border:none; cursor:pointer; font-weight:500;">
                + Agregar charla
            </button>
            @endif
        </div>
    </div>

    {{-- CHARLAS EXISTENTES --}}
    @foreach($entrada->charlas as $i => $ch)
    @php
        $dotColor = match($ch->estado) {
            'realizada'  => '#16a34a',
            'cancelada'  => '#dc2626',
            'suspendida' => '#f97316',
            'vencida'    => '#dc2626',
            default      => '#eab308',
        };
        $tipoLabel = match($ch->char_tipo ?? '') {
            'proceso_electoral' => 'Proceso Electoral',
            'mmrv'              => 'MMRV',
            'ambos'             => 'Proceso + MMRV',
            default             => '—',
        };
    @endphp
    <div style="border:1px solid #f3f4f6; border-radius:10px; padding:14px; margin-bottom:12px; background:#fafafa;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
            <span style="display:inline-flex; align-items:center; gap:6px; font-size:12px; font-weight:600; color:#374151;">
                <span style="width:9px; height:9px; border-radius:50%; background:{{ $dotColor }}; display:inline-block;"></span>
                Charla {{ $i+1 }} — {{ $tipoLabel }}
                <span style="font-size:11px; color:#6b7280; font-weight:400;">{{ ucfirst($ch->estado) }}</span>
            </span>
            <button onclick="toggleEditarCharla({{ $ch->id }})"
                    style="display:inline-flex; align-items:center; gap:5px; background:#f3f4f6; color:#374151; padding:5px 10px; border-radius:6px; font-size:11px; border:none; cursor:pointer;">
                ✏️ Editar
            </button>
        </div>

        {{-- READONLY --}}
        <div id="readonly-{{ $ch->id }}" style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
            <div>
                <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:3px; text-transform:uppercase; letter-spacing:0.5px;">Modalidad</label>
                <p style="font-size:13px; font-weight:600; color:#111827; margin:0;">
                    {{ $ch->modalidad == 'virtual' ? 'Virtual' : ($ch->modalidad == 'presencial_oficina' ? 'Presencial — Oficina' : 'Presencial — Externa') }}
                </p>
            </div>
            <div>
                <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:3px; text-transform:uppercase; letter-spacing:0.5px;">Fecha y hora</label>
                <p style="font-size:13px; font-weight:600; color:#111827; margin:0;">{{ $ch->fecha_hora?->format('d/m/Y H:i') ?? '—' }}</p>
            </div>
            @if($ch->direccion)
            <div style="grid-column:span 2;">
                <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:3px; text-transform:uppercase; letter-spacing:0.5px;">Dirección</label>
                <p style="font-size:13px; color:#111827; margin:0;">{{ $ch->direccion }}</p>
            </div>
            @endif
            @if($ch->descripcion)
            <div style="grid-column:span 2;">
                <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:3px; text-transform:uppercase; letter-spacing:0.5px;">Descripción</label>
                <p style="font-size:13px; color:#111827; margin:0;">{{ $ch->descripcion }}</p>
            </div>
            @endif
        </div>

        {{-- FORM EDITAR --}}
        <div id="edit-{{ $ch->id }}" style="display:none; margin-top:12px; border-top:1px solid #e5e7eb; padding-top:12px;">
            <form method="POST" action="{{ route('asesor.charla.store', $entrada) }}">
                @csrf
                <input type="hidden" name="charla_id" value="{{ $ch->id }}">
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-bottom:10px;">
    <div>
        <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Modalidad *</label>
        <select name="modalidad" onchange="toggleDireccionEditar(this, {{ $ch->id }})" style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; background:#fff; box-sizing:border-box;">
    <option value="virtual" {{ $ch->modalidad == 'virtual' ? 'selected' : '' }}>Virtual</option>
    <option value="presencial_oficina" {{ $ch->modalidad == 'presencial_oficina' ? 'selected' : '' }}>Presencial — Oficina</option>
    <option value="presencial_externa" {{ $ch->modalidad == 'presencial_externa' ? 'selected' : '' }}>Presencial — Externa</option>
</select>
    </div>
    <div>
        <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Tipo de charla</label>
        <select name="char_tipo" style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; background:#fff; box-sizing:border-box;">
            <option value="">-- Seleccionar --</option>
            <option value="proceso_electoral">Proceso Electoral</option>
            <option value="mmrv">MMRV</option>
            <option value="ambos">Proceso + MMRV</option>
        </select>
    </div>
    <div>
        <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Fecha y hora</label>
        <input type="datetime-local" name="fecha_hora"
               style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
    </div>
    <div>
        <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Descripción</label>
        <input type="text" name="descripcion" placeholder="Opcional..."
               style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
    </div>
    <div id="nueva-direccion" style="display:none; grid-column:span 2;">
        <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Dirección</label>
        <input type="text" name="direccion" placeholder="Dirección del lugar..."
               style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
    </div>
</div>
                <div style="display:flex; justify-content:flex-end; gap:8px;">
                    <button type="button" onclick="toggleEditarCharla({{ $ch->id }})"
                            style="padding:6px 14px; border-radius:8px; border:1px solid #e5e7eb; background:white; color:#374151; font-size:12px; cursor:pointer;">
                        Cancelar
                    </button>
                    <button type="submit"
                            style="padding:6px 14px; border-radius:8px; border:none; background:#2563eb; color:white; font-size:12px; cursor:pointer; font-weight:500;">
                        Guardar
                    </button>
                </div>
            </form>
        </div>

        {{-- CAMBIAR ESTADO --}}
        <div style="border-top:1px solid #f3f4f6; margin-top:12px; padding-top:12px; display:flex; gap:8px; flex-wrap:wrap;">
            <form method="POST" action="{{ route('asesor.charla.estado', $ch) }}">
                @csrf @method('PATCH')
                <input type="hidden" name="estado" value="realizada">
                <button type="submit" onclick="return confirm('¿Marcar como realizada?')"
                        style="display:inline-flex; align-items:center; gap:5px; background:#16a34a; color:white; padding:6px 12px; border-radius:8px; font-size:12px; border:none; cursor:pointer; font-weight:500;">
                    ✓ Realizada
                </button>
            </form>
            <form method="POST" action="{{ route('asesor.charla.estado', $ch) }}">
                @csrf @method('PATCH')
                <input type="hidden" name="estado" value="suspendida">
                <button type="submit" onclick="return confirm('¿Marcar como suspendida?')"
                        style="display:inline-flex; align-items:center; gap:5px; background:#f97316; color:white; padding:6px 12px; border-radius:8px; font-size:12px; border:none; cursor:pointer; font-weight:500;">
                    Suspendida
                </button>
            </form>
            <form method="POST" action="{{ route('asesor.charla.estado', $ch) }}">
                @csrf @method('PATCH')
                <input type="hidden" name="estado" value="cancelada">
                <button type="submit" onclick="return confirm('¿Confirmar cancelación?')"
                        style="display:inline-flex; align-items:center; gap:5px; background:#dc2626; color:white; padding:6px 12px; border-radius:8px; font-size:12px; border:none; cursor:pointer; font-weight:500;">
                    Cancelada
                </button>
            </form>
            <form method="POST" action="{{ route('asesor.charla.destroy', $ch) }}">
    @csrf @method('DELETE')
    <button type="submit" onclick="return confirm('¿Eliminar esta charla?')"
            style="display:inline-flex; align-items:center; gap:5px; background:#6b7280; color:white; padding:6px 12px; border-radius:8px; font-size:12px; border:none; cursor:pointer; font-weight:500;">
        🗑 Eliminar
    </button>
</form>
        </div>

    </div>
    @endforeach

    {{-- FORM NUEVA CHARLA --}}
    <div id="form-nueva-charla" style="display:none; border:1px dashed #2563eb; border-radius:10px; padding:14px; margin-top:8px; background:#f0f7ff;">
        <p style="font-size:12px; font-weight:600; color:#2563eb; margin:0 0 12px;">Nueva charla</p>
        <form method="POST" action="{{ route('asesor.charla.store', $entrada) }}">
            @csrf
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-bottom:10px;">
                <div>
                    <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Modalidad *</label>
                   <select name="modalidad" onchange="toggleDireccionNueva(this.value)" style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; background:#fff; box-sizing:border-box;">
    <option value="">Seleccionar...</option>
    <option value="virtual">Virtual</option>
    <option value="presencial_oficina">Presencial — Oficina</option>
    <option value="presencial_externa">Presencial — Externa</option>
</select>
                </div>
                <div>
                    <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Tipo de charla</label>
                    <select name="char_tipo" style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; background:#fff; box-sizing:border-box;">
                        <option value="">-- Seleccionar --</option>
                        <option value="proceso_electoral">Proceso Electoral</option>
                        <option value="mmrv">MMRV</option>
                        <option value="ambos">Proceso + MMRV</option>
                    </select>
                </div>
                <div>
                    <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Fecha y hora</label>
                    <input type="datetime-local" name="fecha_hora"
                           style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
                </div>
              <div>
                    <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Descripción</label>
                    <input type="text" name="descripcion" placeholder="Opcional..."
                           style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
                </div>
                <div id="nueva-direccion" style="display:none; grid-column:span 2;">
                    <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Dirección</label>
                    <input type="text" name="direccion" placeholder="Dirección del lugar..."
                           style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
                </div>
            </div>
            <div style="display:flex; justify-content:flex-end; gap:8px;">
                <button type="button" onclick="document.getElementById('form-nueva-charla').style.display='none'"
                        style="padding:6px 14px; border-radius:8px; border:1px solid #e5e7eb; background:white; color:#374151; font-size:12px; cursor:pointer;">
                    Cancelar
                </button>
                <button type="submit"
                        style="padding:6px 14px; border-radius:8px; border:none; background:#2563eb; color:white; font-size:12px; cursor:pointer; font-weight:500;">
                    Guardar charla
                </button>
            </div>
        </form>
    </div>

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
                        <input type="datetime-local" name="fecha_hora"
                               value="{{ $entrada->observador?->fecha_hora?->format('Y-m-d\TH:i') }}"
                               style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
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
    <livewire:detalle-tecnico-asesor :entrada="$entrada" />

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
    <a href="{{ session('volver_organizacion', route('asesor.mis-organizaciones')) }}"
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


function limpiarFecha() {
    if (fpInstance) fpInstance.clear();
    document.getElementById('fecha_hora_input').value = '';
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

function mostrarFormNuevaCharla() {
    document.getElementById('form-nueva-charla').style.display = 'block';
}

function toggleDireccionNueva(val) {
    document.getElementById('nueva-direccion').style.display = val === 'presencial_externa' ? 'block' : 'none';
}
function toggleEditarCharla(id) {
    const edit = document.getElementById('edit-' + id);
    const readonly = document.getElementById('readonly-' + id);
    const visible = edit.style.display === 'block';
    edit.style.display = visible ? 'none' : 'block';
    readonly.style.display = visible ? 'grid' : 'none';
}

</script>

</x-panel-layout>
