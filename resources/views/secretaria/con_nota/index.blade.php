<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Entradas Con Nota
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

                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Listado de Entradas</h3>
                    <a href="{{ route('secretaria.con-nota.create') }}"
                       class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        + Nueva Entrada
                    </a>
                </div>

                <table class="w-full table-auto border-collapse">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border px-4 py-2 text-left">N° Entrada</th>
                            <th class="border px-4 py-2 text-left">Organización</th>
                            <th class="border px-4 py-2 text-left">Representante</th>
                            <th class="border px-4 py-2 text-left">Vía Ingreso</th>
                            <th class="border px-4 py-2 text-left">Servicios</th>
                            <th class="border px-4 py-2 text-left">Fecha</th>
                            <th class="border px-4 py-2 text-left">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($entradas as $entrada)
                            <tr class="hover:bg-gray-50">
                                <td class="border px-4 py-2">{{ $entrada->numero_entrada }}</td>
                                <td class="border px-4 py-2">{{ $entrada->nombre_organizacion }}</td>
                                <td class="border px-4 py-2">{{ $entrada->nombre_representante }}</td>
                                <td class="border px-4 py-2 capitalize">{{ $entrada->via_ingreso }}</td>
                                <td class="border px-4 py-2">{{ $entrada->servicios->count() }} servicio(s)</td>
                                <td class="border px-4 py-2">{{ $entrada->created_at->format('d/m/Y H:i') }}</td>
                                <td class="border px-4 py-2">
                                    <a href="{{ route('secretaria.con-nota.show', $entrada) }}"
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