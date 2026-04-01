<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nueva Mesa de Entrada — Con Nota
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <form method="POST" action="{{ route('secretaria.con-nota.store') }}" id="form-entrada">
                    @csrf

                    {{-- DATOS DE LA ORGANIZACIÓN --}}
                    <h3 class="text-md font-semibold text-gray-700 mb-4 border-b pb-2">Datos de la organización</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nombre de la organización *</label>
                            <input type="text" name="nombre_organizacion" value="{{ old('nombre_organizacion') }}"
                                   class="w-full border rounded px-3 py-2 text-sm @error('nombre_organizacion') border-red-500 @enderror">
                            @error('nombre_organizacion')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de organización *</label>
                            <select name="tipo_organizacion"
                                    class="w-full border rounded px-3 py-2 text-sm @error('tipo_organizacion') border-red-500 @enderror">
                                <option value="">Seleccionar tipo...</option>
                                @foreach(['Club','Universidad','Cooperativa','Escuela y Colegio','Asentamiento','Comision Vecinal'] as $tipo)
                                    <option value="{{ $tipo }}" {{ old('tipo_organizacion') == $tipo ? 'selected' : '' }}>{{ $tipo }}</option>
                                @endforeach
                            </select>
                            @error('tipo_organizacion')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nombre del representante *</label>
                            <input type="text" name="nombre_representante" value="{{ old('nombre_representante') }}"
                                   class="w-full border rounded px-3 py-2 text-sm @error('nombre_representante') border-red-500 @enderror">
                            @error('nombre_representante')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono del representante</label>
                            <input type="text" name="telefono_representante" value="{{ old('telefono_representante') }}"
                                   placeholder="Opcional"
                                   class="w-full border rounded px-3 py-2 text-sm">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            {{-- ← Sin asterisco, ahora es opcional --}}
                            <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de elección</label>
                            <input type="date" name="fecha_eleccion" id="fecha_eleccion" value="{{ old('fecha_eleccion') }}"
                                   class="w-full border rounded px-3 py-2 text-sm @error('fecha_eleccion') border-red-500 @enderror">
                            @error('fecha_eleccion')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Vía de ingreso *</label>
                            <select name="via_ingreso"
                                    class="w-full border rounded px-3 py-2 text-sm @error('via_ingreso') border-red-500 @enderror">
                                <option value="">Seleccionar...</option>
                                <option value="presencial" {{ old('via_ingreso') == 'presencial' ? 'selected' : '' }}>Presencial</option>
                                <option value="correo" {{ old('via_ingreso') == 'correo' ? 'selected' : '' }}>Correo</option>
                            </select>
                            @error('via_ingreso')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- ASESOR --}}
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Asesor asignado *</label>
                        <select name="asesor_asignado"
                                class="w-full border rounded px-3 py-2 text-sm @error('asesor_asignado') border-red-500 @enderror">
                            <option value="">Seleccionar asesor...</option>
                            @foreach($asesores as $asesor)
                                <option value="{{ $asesor->nombre }} {{ $asesor->apellido }}"
                                    {{ old('asesor_asignado') == $asesor->nombre . ' ' . $asesor->apellido ? 'selected' : '' }}>
                                    {{ $asesor->nombre }} {{ $asesor->apellido }}
                                </option>
                            @endforeach
                        </select>
                        @error('asesor_asignado')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- ASUNTO --}}
                    <h3 class="text-md font-semibold text-gray-700 mb-3 border-b pb-2">Asunto solicitado *</h3>
                    <p class="text-xs text-gray-500 mb-3">Seleccioná uno o más servicios que solicita la organización.</p>

                    @error('asunto')
                        <p class="text-red-500 text-xs mb-3">{{ $message }}</p>
                    @enderror

                    <div class="grid grid-cols-3 gap-4 mb-4">
                        <label class="flex items-center gap-3 border rounded-lg p-4 cursor-pointer hover:bg-blue-50 transition">
                            <input type="checkbox" name="asunto[]" value="char"
                                   {{ is_array(old('asunto')) && in_array('char', old('asunto')) ? 'checked' : '' }}
                                   class="w-4 h-4 text-blue-600">
                            <div>
                                <span class="font-semibold text-gray-800">Char</span>
                                <p class="text-xs text-gray-500">Charla</p>
                            </div>
                        </label>
                        <label class="flex items-center gap-3 border rounded-lg p-4 cursor-pointer hover:bg-blue-50 transition">
                            <input type="checkbox" name="asunto[]" value="log" id="check-log"
                                   {{ is_array(old('asunto')) && in_array('log', old('asunto')) ? 'checked' : '' }}
                                   class="w-4 h-4 text-blue-600">
                            <div>
                                <span class="font-semibold text-gray-800">Log</span>
                                <p class="text-xs text-gray-500">Logística</p>
                            </div>
                        </label>
                        <label class="flex items-center gap-3 border rounded-lg p-4 cursor-pointer hover:bg-blue-50 transition">
                            <input type="checkbox" name="asunto[]" value="tec"
                                   {{ is_array(old('asunto')) && in_array('tec', old('asunto')) ? 'checked' : '' }}
                                   class="w-4 h-4 text-blue-600">
                            <div>
                                <span class="font-semibold text-gray-800">Tec</span>
                                <p class="text-xs text-gray-500">Técnica</p>
                            </div>
                        </label>
                    </div>

                    {{-- SECCION LOGISTICA --}}
                    <div id="seccion-logistica" style="display: none;" class="mb-6">
                        <h3 class="text-md font-semibold text-gray-700 mb-3 border-b pb-2">Detalle Logístico</h3>
                        <p class="text-xs text-gray-500 mb-3">Cargá las cantidades según la nota. Dejá en 0 si no aplica.</p>
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Urnas</label>
                                <input type="number" name="log_urnas" min="0"
                                       value="{{ old('log_urnas', 0) }}"
                                       class="w-full border rounded px-3 py-2 text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Cuartos oscuros</label>
                                <input type="number" name="log_cuartos" min="0"
                                       value="{{ old('log_cuartos', 0) }}"
                                       class="w-full border rounded px-3 py-2 text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tintas</label>
                                <input type="number" name="log_tintas" min="0"
                                       value="{{ old('log_tintas', 0) }}"
                                       class="w-full border rounded px-3 py-2 text-sm">
                            </div>
                        </div>
                    </div>

                    {{-- BOTONES --}}
                    <div class="flex justify-end gap-3">
                        <a href="{{ route('secretaria.con-nota.index') }}"
                           class="bg-gray-200 text-gray-700 px-5 py-2 rounded hover:bg-gray-300 text-sm">
                            Cancelar
                        </a>
                        <button type="button" id="btn-guardar"
                                style="background-color: #2563eb; color: white; padding: 8px 20px; border-radius: 6px; font-size: 14px; font-weight: 500; border: none; cursor: pointer;">
                            Registrar entrada
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    {{-- MODAL: Confirmar guardar sin fecha --}}
    <div id="modal-sin-fecha" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.4); z-index:50; align-items:center; justify-content:center;">
        <div style="background:white; border-radius:12px; padding:32px; max-width:400px; width:90%; box-shadow:0 20px 60px rgba(0,0,0,0.3); text-align:center;">
            <div style="font-size:48px; margin-bottom:12px;">📅</div>
            <h3 style="font-size:18px; font-weight:700; color:#1e293b; margin-bottom:8px;">¿Guardar sin fecha de elección?</h3>
            <p style="font-size:14px; color:#64748b; margin-bottom:24px;">No ingresaste una fecha de elección. Podés guardar igual y completarla después.</p>
            <div style="display:flex; gap:12px; justify-content:center;">
                <button id="btn-modal-no"
                        style="padding:10px 24px; border-radius:8px; border:1px solid #cbd5e1; background:white; color:#374151; font-size:14px; cursor:pointer; font-weight:500;">
                    No, volver
                </button>
                <button id="btn-modal-si"
                        style="padding:10px 24px; border-radius:8px; border:none; background:#2563eb; color:white; font-size:14px; cursor:pointer; font-weight:500;">
                    Sí, guardar igual
                </button>
            </div>
        </div>
    </div>

    <script>
        // Toggle logística
        const checkLog = document.getElementById('check-log');
        const seccionLog = document.getElementById('seccion-logistica');

        function toggleLogistica() {
            seccionLog.style.display = checkLog.checked ? 'block' : 'none';
        }
        checkLog.addEventListener('change', toggleLogistica);
        toggleLogistica();

        // Modal fecha opcional
        const form        = document.getElementById('form-entrada');
        const btnGuardar  = document.getElementById('btn-guardar');
        const modal       = document.getElementById('modal-sin-fecha');
        const btnSi       = document.getElementById('btn-modal-si');
        const btnNo       = document.getElementById('btn-modal-no');
        const inputFecha  = document.getElementById('fecha_eleccion');

        let confirmado = false;

        btnGuardar.addEventListener('click', function () {
            if (!inputFecha.value && !confirmado) {
                // Mostrar modal
                modal.style.display = 'flex';
            } else {
                form.submit();
            }
        });

        btnSi.addEventListener('click', function () {
            confirmado = true;
            modal.style.display = 'none';
            form.submit();
        });

        btnNo.addEventListener('click', function () {
            modal.style.display = 'none';
        });

        // Cerrar modal clickeando el fondo
        modal.addEventListener('click', function (e) {
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        });
    </script>
</x-app-layout>
