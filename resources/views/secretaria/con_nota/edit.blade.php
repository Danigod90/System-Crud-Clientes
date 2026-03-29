<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Mesa de Entrada — {{ $conNota->codigo_org }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <form method="POST" action="{{ route('secretaria.con-nota.update', $conNota) }}">
                    @csrf
                    @method('PUT')

                    {{-- DATOS DE LA ORGANIZACIÓN --}}
                    <h3 class="text-md font-semibold text-gray-700 mb-4 border-b pb-2">Datos de la organizacion</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nombre de la organizacion *</label>
                            <input type="text" name="nombre_organizacion"
                                   value="{{ old('nombre_organizacion', $conNota->nombre_organizacion) }}"
                                   class="w-full border rounded px-3 py-2 text-sm @error('nombre_organizacion') border-red-500 @enderror">
                            @error('nombre_organizacion')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de organizacion *</label>
                            <select name="tipo_organizacion"
        class="w-full border rounded px-3 py-2 text-sm @error('tipo_organizacion') border-red-500 @enderror">
    <option value="">Seleccionar tipo...</option>
    <option value="Club" {{ old('tipo_organizacion', $conNota->tipo_organizacion) == 'Club' ? 'selected' : '' }}>Club</option>
    <option value="Universidad" {{ old('tipo_organizacion', $conNota->tipo_organizacion) == 'Universidad' ? 'selected' : '' }}>Universidad</option>
    <option value="Cooperativa" {{ old('tipo_organizacion', $conNota->tipo_organizacion) == 'Cooperativa' ? 'selected' : '' }}>Cooperativa</option>
    <option value="Escuela y Colegio" {{ old('tipo_organizacion', $conNota->tipo_organizacion) == 'Escuela y Colegio' ? 'selected' : '' }}>Escuela y Colegio</option>
    <option value="Asentamiento" {{ old('tipo_organizacion', $conNota->tipo_organizacion) == 'Asentamiento' ? 'selected' : '' }}>Asentamiento</option>
    <option value="Comision Vecinal" {{ old('tipo_organizacion', $conNota->tipo_organizacion) == 'Comision Vecinal' ? 'selected' : '' }}>Comision Vecinal</option>
</select>
                            @error('tipo_organizacion')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nombre del representante *</label>
                            <input type="text" name="nombre_representante"
                                   value="{{ old('nombre_representante', $conNota->nombre_representante) }}"
                                   class="w-full border rounded px-3 py-2 text-sm @error('nombre_representante') border-red-500 @enderror">
                            @error('nombre_representante')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Telefono del representante</label>
                            <input type="text" name="telefono_representante"
                                   value="{{ old('telefono_representante', $conNota->telefono_representante) }}"
                                   placeholder="Opcional"
                                   class="w-full border rounded px-3 py-2 text-sm">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de eleccion *</label>
                            <input type="date" name="fecha_eleccion"
                                   value="{{ old('fecha_eleccion', $conNota->fecha_eleccion?->format('Y-m-d')) }}"
                                   class="w-full border rounded px-3 py-2 text-sm @error('fecha_eleccion') border-red-500 @enderror">
                            @error('fecha_eleccion')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Via de ingreso *</label>
                            <select name="via_ingreso"
                                    class="w-full border rounded px-3 py-2 text-sm @error('via_ingreso') border-red-500 @enderror">
                                <option value="">Seleccionar...</option>
                                <option value="presencial" {{ old('via_ingreso', $conNota->via_ingreso) == 'presencial' ? 'selected' : '' }}>Presencial</option>
                                <option value="correo" {{ old('via_ingreso', $conNota->via_ingreso) == 'correo' ? 'selected' : '' }}>Correo</option>
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
                                    {{ old('asesor_asignado', $conNota->asesor_asignado) == $asesor->nombre . ' ' . $asesor->apellido ? 'selected' : '' }}>
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
                    <p class="text-xs text-gray-500 mb-3">Podés agregar o quitar servicios en cualquier momento.</p>

                    @error('asunto')
                        <p class="text-red-500 text-xs mb-3">{{ $message }}</p>
                    @enderror

                    <div class="grid grid-cols-3 gap-4 mb-6">
                        <label class="flex items-center gap-3 border rounded-lg p-4 cursor-pointer hover:bg-blue-50 transition">
                            <input type="checkbox" name="asunto[]" value="char"
                                   {{ old('asunto') ? (in_array('char', old('asunto')) ? 'checked' : '') : ($conNota->asunto_char ? 'checked' : '') }}
                                   class="w-4 h-4 text-blue-600">
                            <div>
                                <span class="font-semibold text-gray-800">Char</span>
                                <p class="text-xs text-gray-500">Charla</p>
                            </div>
                        </label>
                        <label class="flex items-center gap-3 border rounded-lg p-4 cursor-pointer hover:bg-blue-50 transition">
                            <input type="checkbox" name="asunto[]" value="log"
                                   {{ old('asunto') ? (in_array('log', old('asunto')) ? 'checked' : '') : ($conNota->asunto_log ? 'checked' : '') }}
                                   class="w-4 h-4 text-blue-600">
                            <div>
                                <span class="font-semibold text-gray-800">Log</span>
                                <p class="text-xs text-gray-500">Logistica</p>
                            </div>
                        </label>
                        <label class="flex items-center gap-3 border rounded-lg p-4 cursor-pointer hover:bg-blue-50 transition">
                            <input type="checkbox" name="asunto[]" value="tec"
                                   {{ old('asunto') ? (in_array('tec', old('asunto')) ? 'checked' : '') : ($conNota->asunto_tec ? 'checked' : '') }}
                                   class="w-4 h-4 text-blue-600">
                            <div>
                                <span class="font-semibold text-gray-800">Tec</span>
                                <p class="text-xs text-gray-500">Tecnica</p>
                            </div>
                        </label>
                    </div>

                    {{-- BOTONES --}}
                    <div class="flex justify-end gap-3">
                        <a href="{{ route('secretaria.con-nota.index') }}"
                           class="bg-gray-200 text-gray-700 px-5 py-2 rounded hover:bg-gray-300 text-sm">
                            Cancelar
                        </a>
                        <button type="submit"
                                style="background-color: #2563eb; color: white; padding: 8px 20px; border-radius: 6px; font-size: 14px; font-weight: 500; border: none; cursor: pointer;">
                            Guardar cambios
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
