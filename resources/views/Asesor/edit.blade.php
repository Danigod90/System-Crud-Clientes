<x-panel-layout title="Editar Organización — {{ $entrada->codigo_org }}">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/l10n/es.min.js"></script>

<div class="px-2 py-2">
    <div style="max-width:760px; margin:0 auto;">

        {{-- DATOS DE LA ORGANIZACIÓN (solo lectura) --}}
        <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:20px; margin-bottom:14px; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
            <h3 style="font-size:13px; font-weight:600; color:#374151; margin-bottom:16px; padding-bottom:10px; border-bottom:1px solid #f3f4f6; text-transform:uppercase; letter-spacing:0.5px;">Datos de la organización</h3>
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
                    <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Fecha de elección</label>
                    <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ $entrada->fecha_eleccion?->format('d/m/Y') ?? '—' }}</p>
                </div>
                <div>
                    <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Asunto</label>
                    <p style="font-size:14px; font-weight:700; color:#111827; font-family:monospace; margin:0;">{{ $entrada->asunto_texto }}</p>
                </div>
            </div>
        </div>

        {{-- SECCIÓN CHARLA --}}
        @if($entrada->asunto_char)
        <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:20px; margin-bottom:14px; box-shadow:0 1px 4px rgba(0,0,0,0.05);">

            {{-- HEADER --}}
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
                <button id="btn-editar-charla" onclick="activarEdicion()"
                        style="display:{{ $entrada->charla ? 'inline-flex' : 'none' }}; align-items:center; gap:6px; background:#f3f4f6; color:#374151; padding:6px 14px; border-radius:8px; font-size:12px; border:none; cursor:pointer; font-weight:500;">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                    Editar
                </button>
            </div>

            {{-- VISTA SOLO LECTURA --}}
            <div id="charla-readonly" style="display:{{ $entrada->charla ? 'grid' : 'none' }}; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:12px;">
                <div>
                    <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Modalidad</label>
                    <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">
                        {{ $entrada->charla?->modalidad == 'virtual' ? 'Virtual' : ($entrada->charla?->modalidad == 'presencial_oficina' ? 'Presencial — Oficina' : 'Presencial — Externa') }}
                    </p>
                </div>
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
            </div>

            {{-- FORMULARIO EDICIÓN --}}
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
                        <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Fecha y hora *</label>
                        {{-- Input visible para Flatpickr --}}
<input type="text" id="fecha_hora_display"
       placeholder="Seleccionar fecha y hora..."
       value="{{ $entrada->charla?->fecha_hora?->format('d/m/Y H:i') }}"
       style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box; cursor:pointer;">                        {{-- Input oculto con formato para Laravel --}}
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

            {{-- CAMBIAR ESTADO --}}
            @if($entrada->charla)
            <div style="border-top:1px solid #f3f4f6; margin-top:16px; padding-top:16px;">
                <p style="font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:10px;">Cambiar estado</p>
                <div style="display:flex; gap:8px; flex-wrap:wrap;">

                    <form method="POST" action="{{ route('asesor.charla.estado', $entrada->charla) }}">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="estado" value="realizada">
                        <button type="submit"
                                onclick="return confirm('¿Marcar la charla como realizada?')"
                                style="display:inline-flex; align-items:center; gap:6px; background:#16a34a; color:white; padding:8px 16px; border-radius:8px; font-size:13px; border:none; cursor:pointer; font-weight:500;">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                            Realizada
                        </button>
                    </form>

                    <form method="POST" action="{{ route('asesor.charla.estado', $entrada->charla) }}">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="estado" value="suspendida">
                        <button type="submit"
                                onclick="return confirm('¿Marcar la charla como suspendida?')"
                                style="display:inline-flex; align-items:center; gap:6px; background:#f97316; color:white; padding:8px 16px; border-radius:8px; font-size:13px; border:none; cursor:pointer; font-weight:500;">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10"/>
                                <line x1="10" y1="15" x2="10" y2="9"/>
                                <line x1="14" y1="15" x2="14" y2="9"/>
                            </svg>
                            Suspendida
                        </button>
                    </form>

                    <form method="POST" action="{{ route('asesor.charla.estado', $entrada->charla) }}">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="estado" value="cancelada">
                        <button type="submit"
                                onclick="return confirm('¿Confirmar cancelación de la charla?')"
                                style="display:inline-flex; align-items:center; gap:6px; background:#dc2626; color:white; padding:8px 16px; border-radius:8px; font-size:13px; border:none; cursor:pointer; font-weight:500;">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <line x1="18" y1="6" x2="6" y2="18"/>
                                <line x1="6" y1="6" x2="18" y2="18"/>
                            </svg>
                            Cancelada
                        </button>
                    </form>

                </div>
            </div>
            @endif

        </div>
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
let fpInstance = flatpickr("#fecha_hora_display", {
    locale: "es",
    enableTime: true,
    time_24hr: true,
    dateFormat: "d/m/Y H:i",
    defaultDate: document.getElementById('fecha_hora_display').value || "{{ now()->format('d/m/Y H:i') }}",
    closeOnSelect: false,
    onOpen: function(selectedDates, dateStr, instance) {
        instance.jumpToDate(instance.selectedDates[0] || new Date());
    },
    onChange: function(selectedDates, dateStr) {
        if (selectedDates.length > 0) {
            const d = selectedDates[0];
            const formatted =
                d.getFullYear() + '-' +
                String(d.getMonth()+1).padStart(2,'0') + '-' +
                String(d.getDate()).padStart(2,'0') + ' ' +
                String(d.getHours()).padStart(2,'0') + ':' +
                String(d.getMinutes()).padStart(2,'0') + ':00';
            document.getElementById('fecha_hora_input').value = formatted;
        }
    },
    onReady: function(selectedDates, dateStr, instance) {
        const btn = document.createElement('button');
        btn.textContent = '✓ Listo';
        btn.type = 'button';
        btn.style.cssText = 'width:100%; margin-top:8px; padding:7px; background:#2563eb; color:white; border:none; border-radius:6px; font-size:13px; font-weight:500; cursor:pointer;';
        btn.addEventListener('click', function() { instance.close(); });
        instance.calendarContainer.appendChild(btn);
    }
});

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
    fpInstance.jumpToDate(fpInstance.selectedDates[0] || new Date());
}

function cancelarEdicion() {
    document.getElementById('charla-readonly').style.display = 'grid';
    document.getElementById('charla-form').style.display = 'none';
    document.getElementById('btn-editar-charla').style.display = 'inline-flex';
}
</script>

</x-panel-layout>
