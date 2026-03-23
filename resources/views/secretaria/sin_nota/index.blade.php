<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Entradas Sin Nota
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if(session('success'))
                    <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Filtros --}}
                <form method="GET" action="{{ route('secretaria.sin-nota.index') }}" class="mb-6">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-3">
                        <div>
                            <label class="block text-gray-700 text-sm font-semibold mb-1">Nombre o Apellido</label>
                            <input type="text" name="nombre" value="{{ request('nombre') }}"
                                   placeholder="Buscar..." class="w-full border rounded px-3 py-2 text-sm">
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-semibold mb-1">Asesor</label>
                            <select name="asesor_id" class="w-full border rounded px-3 py-2 text-sm">
                                <option value="">Todos los asesores</option>
                                @foreach($asesores as $asesor)
                                    <option value="{{ $asesor->id }}" {{ request('asesor_id') == $asesor->id ? 'selected' : '' }}>
                                        {{ $asesor->nombre }} {{ $asesor->apellido }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-semibold mb-1">Fecha Desde</label>
                            <input type="date" name="fecha_desde" value="{{ request('fecha_desde') }}"
                                   class="w-full border rounded px-3 py-2 text-sm">
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-semibold mb-1">Fecha Hasta</label>
                            <input type="date" name="fecha_hasta" value="{{ request('fecha_hasta') }}"
                                   class="w-full border rounded px-3 py-2 text-sm">
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit"
                                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 text-sm">
                            Filtrar
                        </button>
                        <a href="{{ route('secretaria.sin-nota.index') }}"
                           class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400 text-sm">
                            Limpiar
                        </a>
                        <a href="{{ route('secretaria.sin-nota.pdf', request()->query()) }}"
                           target="_blank"
                           class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 text-sm">
                            Exportar PDF
                        </a>
                    </div>
                </form>

                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Listado de Entradas</h3>
                    <a href="{{ route('secretaria.sin-nota.create') }}"
                       class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        + Nueva Entrada
                    </a>
                </div>

                <table class="w-full table-auto border-collapse">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border px-4 py-2 text-left">N° Entrada</th>
                            <th class="border px-4 py-2 text-left">Nombre</th>
                            <th class="border px-4 py-2 text-left">Apellido</th>
                            <th class="border px-4 py-2 text-left">Tipo de Charla</th>
                            <th class="border px-4 py-2 text-left">Asesor</th>
                            <th class="border px-4 py-2 text-left">Fecha</th>
                            <th class="border px-4 py-2 text-left">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($entradas as $entrada)
                            <tr class="hover:bg-gray-50">
                                <td class="border px-4 py-2">{{ $entrada->numero_entrada }}</td>
                                <td class="border px-4 py-2">{{ $entrada->nombre }}</td>
                                <td class="border px-4 py-2">{{ $entrada->apellido }}</td>
                                <td class="border px-4 py-2">{{ $entrada->tipo_charla }}</td>
                                <td class="border px-4 py-2">{{ $entrada->asesor ? $entrada->asesor->nombre . ' ' . $entrada->asesor->apellido : '-' }}</td>
                                <td class="border px-4 py-2">{{ $entrada->created_at ? $entrada->created_at->format('d/m/Y') : '-' }}</td>
                                <td class="border px-4 py-2">
                                    <a href="{{ route('secretaria.sin-nota.show', ['sinNota' => $entrada->id]) }}"
                                       class="bg-gray-500 text-white px-3 py-1 rounded hover:bg-gray-600 text-sm">
                                        Ver
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="border px-4 py-4 text-center text-gray-500">
                                    No hay entradas registradas aún.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $entradas->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
