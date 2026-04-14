<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Asesor
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

                <form method="POST" action="{{ url('admin/asesores/' . $asesor->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-1">Nombre</label>
                        <input type="text" name="nombre" value="{{ old('nombre', $asesor->nombre) }}"
                               class="w-full border rounded px-3 py-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-1">Apellido</label>
                        <input type="text" name="apellido" value="{{ old('apellido', $asesor->apellido) }}"
                               class="w-full border rounded px-3 py-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-1">Cargo</label>
                        <input type="text" name="cargo" value="{{ old('cargo', $asesor->cargo) }}"
                               class="w-full border rounded px-3 py-2" placeholder="Ej: Asesor Electoral">
                    </div>

                    <div class="mb-4">
    <label class="flex items-center gap-2">
        <input type="checkbox" name="activo" value="1"
               {{ old('activo', $asesor->activo) ? 'checked' : '' }}>
        <span class="text-gray-700 font-semibold">Asesor Activo</span>
    </label>
</div>

<div class="mb-4">
    <label class="block text-gray-700 font-semibold mb-1">Usuario vinculado</label>
    <select name="user_id" class="w-full border rounded px-3 py-2">
        <option value="">-- Sin usuario --</option>
        @foreach($usuarios as $usuario)
        <option value="{{ $usuario->id }}" {{ old('user_id', $asesor->user_id) == $usuario->id ? 'selected' : '' }}>
            {{ $usuario->name }} ({{ $usuario->email }})
        </option>
        @endforeach
    </select>
</div>

<div class="flex gap-4">
                        <button type="submit"
                                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            Actualizar Asesor
                        </button>
                        <a href="{{ route('admin.asesores.index') }}"
                           class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">
                            Cancelar
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
