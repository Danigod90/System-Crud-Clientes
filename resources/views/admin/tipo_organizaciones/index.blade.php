<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tipos de Organización
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
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-700">Listado de tipos</h3>
                    <a href="{{ route('admin.users.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 text-sm">← Volver</a>
                </div>

                {{-- FORMULARIO AGREGAR --}}
                <form method="POST" action="{{ route('admin.tipo-organizaciones.store') }}" class="mb-6 flex gap-2">
                    @csrf
                    <input type="text" name="nombre" placeholder="Nuevo tipo de organización..."
                        class="flex-1 border border-gray-300 rounded px-3 py-2 text-sm">
                    @error('nombre')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 text-sm">
                        Agregar
                    </button>
                </form>

                {{-- LISTADO --}}
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-3 text-left">Nombre</th>
                            <th class="p-3 text-left">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tipos as $tipo)
                        <tr class="border-b">
                            <td class="p-3">{{ $tipo->nombre }}</td>
                            <td class="p-3">
                                <form action="{{ route('admin.tipo-organizaciones.destroy', $tipo) }}"
                                      method="POST"
                                      onsubmit="return confirm('¿Eliminar este tipo?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-sm">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="p-3 text-center text-gray-500">No hay tipos registrados.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
