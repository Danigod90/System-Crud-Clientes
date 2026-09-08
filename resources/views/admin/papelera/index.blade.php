<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Papelera — Organizaciones eliminadas
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
                    <h3 class="text-lg font-semibold">Organizaciones eliminadas</h3>
                    <a href="{{ route('admin.users.index') }}"
                       class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                        ← Volver
                    </a>
                </div>

                <p class="text-sm text-gray-500 mb-4">
                    Estas organizaciones fueron eliminadas por algún usuario, pero no se borraron de la base —
                    podés revisarlas acá y restaurarlas si fue un error.
                </p>

                <table class="w-full table-auto border-collapse">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border px-4 py-2 text-left">Código</th>
                            <th class="border px-4 py-2 text-left">Organización</th>
                            <th class="border px-4 py-2 text-left">Eliminado por</th>
                            <th class="border px-4 py-2 text-left">Fecha de eliminación</th>
                            <th class="border px-4 py-2 text-left">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($eliminadas as $entrada)
                            <tr class="hover:bg-gray-50">
                                <td class="border px-4 py-2 font-mono text-sm">{{ $entrada->codigo_org }}</td>
                                <td class="border px-4 py-2">{{ $entrada->nombre_organizacion }}</td>
                                <td class="border px-4 py-2">{{ $entrada->eliminadoPor?->name ?? '—' }}</td>
                                <td class="border px-4 py-2">{{ $entrada->deleted_at?->format('d/m/Y H:i') }}</td>
                                <td class="border px-4 py-2">
                                    <div style="display:flex; gap:6px;">
                                        <form method="POST" action="{{ route('admin.papelera.restore', $entrada->id) }}"
                                              onsubmit="return confirm('¿Restaurar esta organización?')">
                                            @csrf
                                            <button type="submit"
                                                    class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 text-sm">
                                                Restaurar
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.papelera.force-delete', $entrada->id) }}"
                                              onsubmit="return confirm('Esto borra la organización \'{{ $entrada->nombre_organizacion }}\' PARA SIEMPRE, ya no se puede deshacer ni recuperar de ningún lado. ¿Confirmás?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 text-sm">
                                                🗑 Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="border px-4 py-4 text-center text-gray-500">
                                    No hay organizaciones eliminadas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $eliminadas->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
