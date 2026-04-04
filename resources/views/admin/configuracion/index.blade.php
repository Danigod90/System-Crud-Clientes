<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Configuración del Sistema
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-6 border-b pb-3">Autoridades</h3>

                {{-- PRESIDENTE ACTUAL --}}
                <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-medium mb-1">Presidente en ejercicio</p>
                            <p class="text-lg font-semibold text-gray-800">{{ $presidente->valor ?? '-' }}</p>
                        </div>
                        <button onclick="document.getElementById('form-presidente').classList.toggle('hidden')"
                                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 text-sm">
                            Cambiar
                        </button>
                    </div>

                    {{-- FORMULARIO OCULTO --}}
                    <div id="form-presidente" class="hidden mt-4 border-t pt-4">
                        <form method="POST" action="{{ route('admin.configuracion.update') }}">
                            @csrf
                            @method('PATCH')
                            <label class="block text-sm font-medium text-gray-700 mb-2">Seleccionar presidente:</label>
                            <select name="valor" class="w-full border border-gray-300 rounded px-3 py-2 text-sm mb-3">
                                <option value="Jorge Enrique Bogarín" {{ $presidente->valor == 'Jorge Enrique Bogarín' ? 'selected' : '' }}>Jorge Enrique Bogarín</option>
                                <option value="César Rossel" {{ $presidente->valor == 'César Rossel' ? 'selected' : '' }}>César Rossel</option>
                                <option value="Jaime Bestard" {{ $presidente->valor == 'Jaime Bestard' ? 'selected' : '' }}>Jaime Bestard</option>
                            </select>
                            <div class="flex gap-2">
                                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 text-sm">
                                    Guardar
                                </button>
                                <button type="button" onclick="document.getElementById('form-presidente').classList.add('hidden')"
                                        class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400 text-sm">
                                    Cancelar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="flex gap-2 mt-6">
<a href="{{ route('admin.users.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 text-sm">                        ← Volver
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
