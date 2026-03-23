<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detalle de Entrada Sin Nota
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if(session('success'))
                    <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="mb-6 border-b pb-4">
                    <p class="text-gray-500 text-sm">N° de Entrada</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $sinNota->numero_entrada }}</p>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <p class="text-gray-500 text-sm">Nombre</p>
                        <p class="font-semibold">{{ $sinNota->nombre }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Apellido</p>
                        <p class="font-semibold">{{ $sinNota->apellido }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Teléfono</p>
                        <p class="font-semibold">{{ $sinNota->telefono ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Tipo de Charla</p>
                        <p class="font-semibold">{{ $sinNota->tipo_charla }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Asesor que atendió</p>
                        <p class="font-semibold">{{ $sinNota->asesor ? $sinNota->asesor->nombre . ' ' . $sinNota->asesor->apellido : '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Fecha de Registro</p>
                        <p class="font-semibold">{{ $sinNota->created_at ? $sinNota->created_at->format('d/m/Y H:i') : '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Registrado por</p>
                        <p class="font-semibold">{{ $sinNota->user ? $sinNota->user->name : '-' }}</p>
                    </div>
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('secretaria.sin-nota.edit', $sinNota) }}"
                       class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                        Editar
                    </a>
                    <form method="POST" action="{{ route('secretaria.sin-nota.destroy', $sinNota) }}"
                          onsubmit="return confirm('¿Estás seguro de eliminar esta entrada?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                            Eliminar
                        </button>
                    </form>
                    <a href="{{ route('secretaria.sin-nota.index') }}"
                       class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">
                        Volver al listado
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
