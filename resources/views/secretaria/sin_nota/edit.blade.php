<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Entrada Sin Nota
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if($errors->any())
                    <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mb-6 border-b pb-4">
                    <p class="text-gray-500 text-sm">N° de Entrada</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $sinNota->numero_entrada }}</p>
                </div>

                <form method="POST" action="{{ route('secretaria.sin-nota.update', $sinNota) }}">
                    @csrf
                    @method('PUT')

                    <div style="margin-bottom:12px;">
    <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Nombre/s y Apellido/s *</label>
    <input type="text" name="nombre_completo" value="{{ old('nombre_completo', $sinNota->nombre_completo) }}" required
           placeholder="Ej: Juan Carlos García"
           style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
</div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-1">Teléfono <span class="text-gray-400 font-normal">(opcional)</span></label>
                        <input type="text" name="telefono" value="{{ old('telefono', $sinNota->telefono) }}"
                               class="w-full border rounded px-3 py-2" placeholder="Ej: 0981 123 456">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-1">Tipo de Charla</label>
                        <select name="tipo_charla" class="w-full border rounded px-3 py-2" required>
                            <option value="">Seleccionar...</option>
                            <option value="Asesoramiento Electoral" {{ old('tipo_charla', $sinNota->tipo_charla) == 'Asesoramiento Electoral' ? 'selected' : '' }}>Asesoramiento Electoral</option>
                            <option value="Charla para Miembros de Mesa" {{ old('tipo_charla', $sinNota->tipo_charla) == 'Charla para Miembros de Mesa' ? 'selected' : '' }}>Charla para Miembros de Mesa</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-1">Asesor que atendió <span class="text-gray-400 font-normal">(opcional)</span></label>
                        <select name="asesor_id" class="w-full border rounded px-3 py-2">
                            <option value="">Sin asesor asignado</option>
                            @foreach($asesores as $asesor)
                                <option value="{{ $asesor->id }}" {{ old('asesor_id', $sinNota->asesor_id) == $asesor->id ? 'selected' : '' }}>
                                    {{ $asesor->nombre }} {{ $asesor->apellido }}
                                    @if($asesor->cargo) — {{ $asesor->cargo }} @endif
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex gap-4">
                        <button type="submit"
                                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            Guardar Cambios
                        </button>
                        <a href="{{ route('secretaria.sin-nota.show', $sinNota) }}"
                           class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">
                            Cancelar
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
