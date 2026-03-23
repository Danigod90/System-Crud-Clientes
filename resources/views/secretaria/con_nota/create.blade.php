<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nueva Entrada Con Nota
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

                <form method="POST" action="{{ route('secretaria.con-nota.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-1">Nombre de la Organización</label>
                        <input type="text" name="nombre_organizacion" value="{{ old('nombre_organizacion') }}"
                               class="w-full border rounded px-3 py-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-1">Tipo de Organización</label>
                        <select name="tipo_organizacion" class="w-full border rounded px-3 py-2" required>
                            <option value="">Seleccionar...</option>
                            <option value="Club" {{ old('tipo_organizacion') == 'Club' ? 'selected' : '' }}>Club</option>
                            <option value="Escuela" {{ old('tipo_organizacion') == 'Escuela' ? 'selected' : '' }}>Escuela</option>
                            <option value="Cooperativa" {{ old('tipo_organizacion') == 'Cooperativa' ? 'selected' : '' }}>Cooperativa</option>
                            <option value="Municipalidad" {{ old('tipo_organizacion') == 'Municipalidad' ? 'selected' : '' }}>Municipalidad</option>
                            <option value="Otro" {{ old('tipo_organizacion') == 'Otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-1">Nombre del Representante</label>
                        <input type="text" name="nombre_representante" value="{{ old('nombre_representante') }}"
                               class="w-full border rounded px-3 py-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-1">Asesor Asignado</label>
                        <input type="text" name="asesor_asignado" value="{{ old('asesor_asignado') }}"
                               class="w-full border rounded px-3 py-2">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-1">Vía de Ingreso</label>
                        <select name="via_ingreso" class="w-full border rounded px-3 py-2" required>
                            <option value="">Seleccionar...</option>
                            <option value="correo" {{ old('via_ingreso') == 'correo' ? 'selected' : '' }}>Correo</option>
                            <option value="presencial" {{ old('via_ingreso') == 'presencial' ? 'selected' : '' }}>Presencial</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Servicios Solicitados</label>

                        <div class="space-y-4">
                            <div>
                                <label class="flex items-center gap-2">
                                    <input type="checkbox" name="servicios[]" value="asesoramiento_electoral">
                                    Asesoramiento Electoral
                                </label>
                            </div>
                            <div>
                                <label class="flex items-center gap-2">
                                    <input type="checkbox" name="servicios[]" value="parte_tecnica">
                                    Parte Técnica (papeletas, actas, padrón)
                                </label>
                            </div>
                            <div>
                                <label class="flex items-center gap-2">
                                    <input type="checkbox" name="servicios[]" value="logistica">
                                    Logística (urnas, cuartos oscuros, tinta)
                                </label>
                            </div>

                            <!-- Charla Asesoramiento -->
                            <div>
                                <label class="flex items-center gap-2">
                                    <input type="checkbox" name="servicios[]" value="charla_asesoramiento"
                                           onchange="toggleCharla('charla_asesoramiento')">
                                    Charla de Asesoramiento Electoral
                                </label>
                                <div id="charla_asesoramiento" class="hidden ml-6 mt-2 space-y-2">
                                    <select name="lugar_charla_charla_asesoramiento" class="w-full border rounded px-3 py-2"
                                            onchange="toggleDireccion('charla_asesoramiento', this.value)">
                                        <option value="">Lugar...</option>
                                        <option value="oficina">En Oficina</option>
                                        <option value="fuera">Fuera de Oficina</option>
                                    </select>
                                    <div id="dir_charla_asesoramiento" class="hidden">
                                        <input type="text" name="direccion_charla_charla_asesoramiento"
                                               placeholder="Dirección" class="w-full border rounded px-3 py-2">
                                    </div>
                                    <input type="datetime-local" name="fecha_hora_charla_charla_asesoramiento"
                                           class="w-full border rounded px-3 py-2">
                                </div>
                            </div>

                            <!-- Charla Mesa Receptora -->
                            <div>
                                <label class="flex items-center gap-2">
                                    <input type="checkbox" name="servicios[]" value="charla_mesa_receptora"
                                           onchange="toggleCharla('charla_mesa_receptora')">
                                    Charla para Miembros de Mesa Receptora
                                </label>
                                <div id="charla_mesa_receptora" class="hidden ml-6 mt-2 space-y-2">
                                    <select name="lugar_charla_charla_mesa_receptora" class="w-full border rounded px-3 py-2"
                                            onchange="toggleDireccion('charla_mesa_receptora', this.value)">
                                        <option value="">Lugar...</option>
                                        <option value="oficina">En Oficina</option>
                                        <option value="fuera">Fuera de Oficina</option>
                                    </select>
                                    <div id="dir_charla_mesa_receptora" class="hidden">
                                        <input type="text" name="direccion_charla_charla_mesa_receptora"
                                               placeholder="Dirección" class="w-full border rounded px-3 py-2">
                                    </div>
                                    <input type="datetime-local" name="fecha_hora_charla_charla_mesa_receptora"
                                           class="w-full border rounded px-3 py-2">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <button type="submit"
                                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            Registrar Entrada
                        </button>
                        <a href="{{ route('secretaria.con-nota.index') }}"
                           class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">
                            Cancelar
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        function toggleCharla(id) {
            const div = document.getElementById(id);
            div.classList.toggle('hidden');
        }
        function toggleDireccion(id, value) {
            const div = document.getElementById('dir_' + id);
            if (value === 'fuera') {
                div.classList.remove('hidden