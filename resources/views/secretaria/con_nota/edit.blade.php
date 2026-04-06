<x-panel-layout title="Editar Mesa de Entrada — {{ $conNota->codigo_org }}">

<div class="px-2 py-2">
    <div style="max-width:760px; margin:0 auto;">

        @if(session('success'))
        <div style="background:#d1fae5; color:#065f46; padding:10px 14px; border-radius:8px; margin-bottom:14px; font-size:13px;">
            {{ session('success') }}
        </div>
        @endif

        <form method="POST" action="{{ route('secretaria.con-nota.update', $conNota) }}">
            @csrf
            @method('PUT')
<input type="hidden" name="from" value="{{ request('from') }}">
<input type="hidden" name="entrada_id" value="{{ request('entrada_id', $conNota->id) }}">
            {{-- DATOS DE LA ORGANIZACIÓN --}}
            <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:20px; margin-bottom:14px; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
                <h3 style="font-size:13px; font-weight:600; color:#374151; margin-bottom:16px; padding-bottom:10px; border-bottom:1px solid #f3f4f6; text-transform:uppercase; letter-spacing:0.5px;">Datos de la organización</h3>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:12px;">
                    <div>
                        <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Nombre de la organización *</label>
                        <input type="text" name="nombre_organizacion"
                               value="{{ old('nombre_organizacion', $conNota->nombre_organizacion) }}"
                               style="width:100%; border:1px solid {{ $errors->has('nombre_organizacion') ? '#f87171' : '#e5e7eb' }}; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
                        @error('nombre_organizacion')<p style="color:#ef4444; font-size:11px; margin-top:3px;">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Tipo de organización *</label>
                        <select name="tipo_organizacion"
                                style="width:100%; border:1px solid {{ $errors->has('tipo_organizacion') ? '#f87171' : '#e5e7eb' }}; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; background:#fff; box-sizing:border-box;">
                            <option value="">Seleccionar tipo...</option>
                            @foreach($tipos as $tipo)
                            <option value="{{ $tipo->nombre }}" {{ old('tipo_organizacion', $conNota->tipo_organizacion) == $tipo->nombre ? 'selected' : '' }}>{{ $tipo->nombre }}</option>
                        @endforeach
                        </select>
                        @error('tipo_organizacion')<p style="color:#ef4444; font-size:11px; margin-top:3px;">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:12px;">
                    <div>
                        <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Nombre del representante *</label>
                        <input type="text" name="nombre_representante"
                               value="{{ old('nombre_representante', $conNota->nombre_representante) }}"
                               style="width:100%; border:1px solid {{ $errors->has('nombre_representante') ? '#f87171' : '#e5e7eb' }}; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
                        @error('nombre_representante')<p style="color:#ef4444; font-size:11px; margin-top:3px;">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Teléfono del representante</label>
                        <input type="text" name="telefono_representante"
                               value="{{ old('telefono_representante', $conNota->telefono_representante) }}"
                               placeholder="Opcional"
                               style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
                    </div>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:12px;">
                    <div>
                        <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Fecha de elección</label>
                        <input type="date" name="fecha_eleccion"
                               value="{{ old('fecha_eleccion', $conNota->fecha_eleccion?->format('Y-m-d')) }}"
                               style="width:100%; border:1px solid {{ $errors->has('fecha_eleccion') ? '#f87171' : '#e5e7eb' }}; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
                        @error('fecha_eleccion')<p style="color:#ef4444; font-size:11px; margin-top:3px;">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Vía de ingreso *</label>
                        <select name="via_ingreso"
                                style="width:100%; border:1px solid {{ $errors->has('via_ingreso') ? '#f87171' : '#e5e7eb' }}; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; background:#fff; box-sizing:border-box;">
                            <option value="">Seleccionar...</option>
                            <option value="presencial" {{ old('via_ingreso', $conNota->via_ingreso) == 'presencial' ? 'selected' : '' }}>Presencial</option>
                            <option value="correo" {{ old('via_ingreso', $conNota->via_ingreso) == 'correo' ? 'selected' : '' }}>Correo</option>
                        </select>
                        @error('via_ingreso')<p style="color:#ef4444; font-size:11px; margin-top:3px;">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Asesor asignado *</label>
                        <select name="asesor_asignado"
                                style="width:100%; border:1px solid {{ $errors->has('asesor_asignado') ? '#f87171' : '#e5e7eb' }}; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; background:#fff; box-sizing:border-box;">
                            <option value="">Seleccionar asesor...</option>
                            @foreach($asesores as $asesor)
                                <option value="{{ $asesor->nombre }} {{ $asesor->apellido }}"
                                    {{ old('asesor_asignado', $conNota->asesor_asignado) == $asesor->nombre . ' ' . $asesor->apellido ? 'selected' : '' }}>
                                    {{ $asesor->nombre }} {{ $asesor->apellido }}
                                </option>
                            @endforeach
                        </select>
                        @error('asesor_asignado')<p style="color:#ef4444; font-size:11px; margin-top:3px;">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            {{-- ASUNTO --}}
            <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:20px; margin-bottom:14px; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
                <h3 style="font-size:13px; font-weight:600; color:#374151; margin-bottom:6px; padding-bottom:10px; border-bottom:1px solid #f3f4f6; text-transform:uppercase; letter-spacing:0.5px;">Asunto solicitado *</h3>
                <p style="font-size:11px; color:#9ca3af; margin-bottom:14px;">Podés agregar o quitar servicios en cualquier momento.</p>

                @error('asunto')<p style="color:#ef4444; font-size:11px; margin-bottom:10px;">{{ $message }}</p>@enderror

                <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:10px;">
                    <label style="display:flex; align-items:center; gap:10px; border:1px solid #e5e7eb; border-radius:10px; padding:12px 14px; cursor:pointer;">
                        <input type="checkbox" name="asunto[]" value="char"
                               {{ old('asunto') ? (in_array('char', old('asunto')) ? 'checked' : '') : ($conNota->asunto_char ? 'checked' : '') }}
                               style="width:15px; height:15px; accent-color:#2563eb;">
                        <div>
                            <span style="font-size:13px; font-weight:600; color:#1f2937;">Char</span>
                            <p style="font-size:11px; color:#9ca3af; margin:0;">Charla</p>
                        </div>
                    </label>
                    <label style="display:flex; align-items:center; gap:10px; border:1px solid #e5e7eb; border-radius:10px; padding:12px 14px; cursor:pointer;">
                        <input type="checkbox" name="asunto[]" value="log" id="check-log"
                               {{ old('asunto') ? (in_array('log', old('asunto')) ? 'checked' : '') : ($conNota->asunto_log ? 'checked' : '') }}
                               style="width:15px; height:15px; accent-color:#2563eb;">
                        <div>
                            <span style="font-size:13px; font-weight:600; color:#1f2937;">Log</span>
                            <p style="font-size:11px; color:#9ca3af; margin:0;">Logística</p>
                        </div>
                    </label>
                    <label style="display:flex; align-items:center; gap:10px; border:1px solid #e5e7eb; border-radius:10px; padding:12px 14px; cursor:pointer;">
                        <input type="checkbox" name="asunto[]" value="tec"
                               {{ old('asunto') ? (in_array('tec', old('asunto')) ? 'checked' : '') : ($conNota->asunto_tec ? 'checked' : '') }}
                               style="width:15px; height:15px; accent-color:#2563eb;">
                        <div>
                            <span style="font-size:13px; font-weight:600; color:#1f2937;">Tec</span>
                            <p style="font-size:11px; color:#9ca3af; margin:0;">Técnica</p>
                        </div>
                    </label>
                </div>
            </div>

            {{-- SECCIÓN LOGÍSTICA --}}
            <div id="seccion-logistica" style="display:none; background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:20px; margin-bottom:14px; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
                <h3 style="font-size:13px; font-weight:600; color:#374151; margin-bottom:6px; padding-bottom:10px; border-bottom:1px solid #f3f4f6; text-transform:uppercase; letter-spacing:0.5px;">Detalle Logístico</h3>
                <p style="font-size:11px; color:#9ca3af; margin-bottom:14px;">Cargá las cantidades según la nota. Dejá en 0 si no aplica.</p>
                <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:12px;">
                    <div>
                        <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Urnas</label>
                        <input type="number" name="log_urnas" min="0"
                               value="{{ old('log_urnas', $conNota->log_urnas) }}"
                               style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
                    </div>
                    <div>
                        <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Cuartos oscuros</label>
                        <input type="number" name="log_cuartos" min="0"
                               value="{{ old('log_cuartos', $conNota->log_cuartos) }}"
                               style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
                    </div>
                    <div>
                        <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Tintas</label>
                        <input type="number" name="log_tintas" min="0"
                               value="{{ old('log_tintas', $conNota->log_tintas) }}"
                               style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
                    </div>
                </div>
            </div>

            {{-- BOTONES --}}
            <div style="display:flex; justify-content:flex-end; gap:10px;">
<a href="{{ request('from') == 'asesor' ? route('asesor.organizacion.edit', $conNota->id) : route('secretaria.con-nota.show', $conNota) }}"   style="display:inline-flex; align-items:center; gap:6px; background:#f3f4f6; color:#374151; padding:8px 18px; border-radius:8px; font-size:13px; text-decoration:none;">
    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
    </svg>
    Cancelar
</a>
                <button type="submit"
                        style="display:inline-flex; align-items:center; gap:6px; background:#2563eb; color:white; padding:8px 18px; border-radius:8px; font-size:13px; border:none; cursor:pointer; font-weight:500;">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    Guardar cambios
                </button>
            </div>

        </form>
    </div>
</div>

<script>
    const checkLog = document.getElementById('check-log');
    const seccionLog = document.getElementById('seccion-logistica');
    function toggleLogistica() { seccionLog.style.display = checkLog.checked ? 'block' : 'none'; }
    checkLog.addEventListener('change', toggleLogistica);
    toggleLogistica();
</script>

</x-panel-layout>
