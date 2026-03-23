<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gestión de Asesores
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
                    <h3 class="text-lg font-semibold">Listado de Asesores</h3>
                    <a href="{{ route('admin.asesores.create') }}"
                       class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        + Nuevo Asesor
                    </a>
                </div>

                <table class="w-full table-auto border-collapse">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border px-4 py-2 text-left">Nombre</th>
                            <th class="border px-4 py-2 text-left">Apellido</th>
                            <th class="border px-4 py-2 text-left">Cargo</th>
                            <th class="border px-4 py-2 text-left">Estado</th>
                            <th class="border px-4 py-2 text-left">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($asesores as $asesor)
                            <tr class="hover:bg-gray-50">
                                <td class="border px-4 py-2">{{ $asesor->nombre }}</td>
                                <td class="border px-4 py-2">{{ $asesor->apellido }}</td>
                                <td class="border px-4 py-2">{{ $asesor->cargo ?? '-' }}</td>
                                <td class="border px-4 py-2">
                                    @if($asesor->activo)
                                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm">Activo</span>
                                    @else
                                        <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-sm">Inactivo</span>
                                    @endif
                                </td>
                                <td class="border px-4 py-2 flex gap-2">
                                    <a href="{{ route('admin.asesores.edit', $asesor) }}"
                                       class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 text-sm">
                                        Editar
                                    </a>
                                    <form method="POST" action="{{ route('admin.asesores.destroy', $asesor) }}"
                                          onsubmit="return confirm('¿Eliminar este asesor?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-sm">
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="border px-4 py-4 text-center text-gray-500">
                                    No hay asesores registrados aún.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $asesores->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
