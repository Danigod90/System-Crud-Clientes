<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mesas de Entrada — Con Nota
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
    <div style="background-color: #d1fae5; color: #065f46; padding: 12px 16px; border-radius: 6px; margin-bottom: 16px; font-size: 14px;">
        {{ session('success') }}
    </div>
        @endif
    @if(session('error'))
    <div style="background-color: #fee2e2; color: #991b1b; padding: 12px 16px; border-radius: 6px; margin-bottom: 16px; font-size: 14px;">
        {{ session('error') }}
    </div>
        @endif
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
    <h3 style="font-size: 18px; font-weight: 600; color: #1f2937;">Listado de entradas</h3>
    <div style="display:flex; gap:8px;">
        <a href="{{ route('panel.dashboard') }}"
           style="background-color: #1e3a5f; color: white; padding: 8px 16px; border-radius: 6px; font-size: 14px; text-decoration: none;">
            ← Panel general
        </a>
        <a href="{{ route('secretaria.con-nota.create') }}"
           style="background-color: #2563eb; color: white; padding: 8px 16px; border-radius: 6px; font-size: 14px; text-decoration: none;">
            + Nueva mesa de entrada
        </a>
    </div>
</div>

{{-- FILTROS --}}
<form method="GET" action="{{ route('secretaria.con-nota.index') }}" style="margin-bottom: 20px;">
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-bottom: 10px;">
        <div>
            <label style="display: block; font-size: 12px; font-weight: 600; color: #374151; margin-bottom: 4px;">Organizacion</label>
            <input type="text" name="organizacion" id="buscar-organizacion" value="{{ request('organizacion') }}"
       placeholder="Buscar..."
       style="width: 100%; border: 1px solid #d1d5db; border-radius: 6px; padding: 6px 10px; font-size: 13px;"
       autocomplete="off">
        </div>
        <div>
            <label style="display: block; font-size: 12px; font-weight: 600; color: #374151; margin-bottom: 4px;">Asesor</label>
            <select name="asesor" style="width: 100%; border: 1px solid #d1d5db; border-radius: 6px; padding: 6px 10px; font-size: 13px;">
                <option value="">Todos</option>
                @foreach($asesores as $asesor)
                    <option value="{{ $asesor->nombre }} {{ $asesor->apellido }}"
                        {{ request('asesor') == $asesor->nombre . ' ' . $asesor->apellido ? 'selected' : '' }}>
                        {{ $asesor->nombre }} {{ $asesor->apellido }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label style="display: block; font-size: 12px; font-weight: 600; color: #374151; margin-bottom: 4px;">Asunto</label>
            <select name="asunto" style="width: 100%; border: 1px solid #d1d5db; border-radius: 6px; padding: 6px 10px; font-size: 13px;">
                <option value="">Todos</option>
                <option value="char" {{ request('asunto') == 'char' ? 'selected' : '' }}>Char — Charla</option>
                <option value="log" {{ request('asunto') == 'log' ? 'selected' : '' }}>Log — Logistica</option>
                <option value="tec" {{ request('asunto') == 'tec' ? 'selected' : '' }}>Tec — Tecnica</option>
            </select>
        </div>
        <div>
    <label style="display: block; font-size: 12px; font-weight: 600; color: #374151; margin-bottom: 4px;">Fecha ingreso</label>
<input type="month" name="mes_ingreso" value="{{ request('mes_ingreso') }}"
       style="width: 100%; border: 1px solid #d1d5db; border-radius: 6px; padding: 6px 10px; font-size: 13px;">
</div>
    </div>
    <div style="display: flex; gap: 8px;">
        <button type="submit"
                style="background-color: #2563eb; color: white; padding: 7px 16px; border-radius: 6px; font-size: 13px; border: none; cursor: pointer;">
            Filtrar
        </button>
        <a href="{{ route('secretaria.con-nota.index') }}"
           style="background-color: #e5e7eb; color: #374151; padding: 7px 16px; border-radius: 6px; font-size: 13px; text-decoration: none;">
            Limpiar
        </a>
    </div>
</form>
</div>
                <table class="w-full table-auto border-collapse text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-gray-600 uppercase text-xs">
                            <th class="border border-gray-200 px-4 py-3 text-left">Codigo ORG</th>
                            <th class="border border-gray-200 px-4 py-3 text-left">Organizacion</th>
                            <th class="border border-gray-200 px-4 py-3 text-left">Asesor</th>
                            <th class="border border-gray-200 px-4 py-3 text-left">Asunto</th>
                            <th class="border border-gray-200 px-4 py-3 text-left">Via</th>
                            <th class="border border-gray-200 px-4 py-3 text-left">Fecha eleccion</th>
                            <th class="border border-gray-200 px-4 py-3 text-left">Registrado por</th>
                            <th class="border border-gray-200 px-4 py-3 text-left">Fecha ingreso</th>
                            <th class="border border-gray-200 px-4 py-3 text-left">Estado</th>
                            <th class="border border-gray-200 px-4 py-3 text-left">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($entradas as $entrada)
                            <tr class="hover:bg-gray-50">
                                <td class="border border-gray-200 px-4 py-2 font-mono font-semibold text-blue-700">
                                    {{ $entrada->codigo_org }}
                                </td>
                                <td class="border border-gray-200 px-4 py-2 font-medium">
                                    {{ $entrada->nombre_organizacion }}
                                </td>
                                <td class="border border-gray-200 px-4 py-2">
                                    {{ $entrada->asesor_asignado ?? '-' }}
                                </td>
                                <td class="border border-gray-200 px-4 py-2">
                                    <span class="font-mono font-semibold text-gray-800">
                                        {{ $entrada->asunto_texto }}
                                    </span>
                                </td>
                                <td class="border border-gray-200 px-4 py-2 capitalize">
                                    {{ $entrada->via_ingreso }}
                                </td>
                                <td class="border border-gray-200 px-4 py-2">
                                  @if($entrada->fecha_eleccion)
    {{ $entrada->fecha_eleccion->format('d/m/Y') }}
@else
    <span style="background:#fef9c3; color:#854d0e; font-size:11px; padding:2px 8px; border-radius:999px; font-weight:600;">
        ⚠️ Sin fecha
    </span>
@endif
                                </td>
                                <td class="border border-gray-200 px-4 py-2 text-xs text-gray-600">
                                 {{ $entrada->registrado_por }}
                                </td>
                                    <td class="border border-gray-200 px-4 py-2 text-xs text-gray-600">
                                     {{ $entrada->created_at?->format('d/m/Y H:i') ?? '-' }}
                                </td>
       <td class="border border-gray-200 px-4 py-2" style="white-space:nowrap;">
    @if($entrada->asunto_char)
        @php
            $charDot = match($entrada->char_estado ?? 'pendiente') {
                'realizada' => '#16a34a',
                'cancelada' => '#ea580c',
                'vencida'   => '#dc2626',
                default     => '#ca8a04',
            };
        @endphp
        <span style="display:inline-flex; align-items:center; gap:3px; margin-right:8px;">
            <span style="font-size:11px; color:#6b7280;">Char</span>
            <span style="width:9px; height:9px; border-radius:50%; background:{{ $charDot }}; display:inline-block;"></span>
        </span>
    @endif

    @if($entrada->asunto_log)
        @php $logDot = ($entrada->log_estado ?? 'pendiente') === 'entregada' ? '#16a34a' : '#ca8a04'; @endphp
        <span style="display:inline-flex; align-items:center; gap:3px; margin-right:8px;">
            <span style="font-size:11px; color:#6b7280;">Log</span>
            <span style="width:9px; height:9px; border-radius:50%; background:{{ $logDot }}; display:inline-block;"></span>
        </span>
    @endif

    @if($entrada->asunto_tec)
        @php $tecDot = ($entrada->tec_estado ?? 'pendiente') === 'entregada' ? '#16a34a' : '#ca8a04'; @endphp
        <span style="display:inline-flex; align-items:center; gap:3px;">
            <span style="font-size:11px; color:#6b7280;">Tec</span>
            <span style="width:9px; height:9px; border-radius:50%; background:{{ $tecDot }}; display:inline-block;"></span>
        </span>
    @endif
</td>
                                <td class="border border-gray-200 px-4 py-2">
                                    <div class="flex gap-2">
                                        <a href="{{ route('secretaria.con-nota.show', $entrada) }}"
                                           class="bg-gray-500 text-white px-3 py-1 rounded hover:bg-gray-600 text-xs">
                                            Ver
                                        </a>
                                        <a href="{{ route('secretaria.con-nota.edit', $entrada) }}"
                                           class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 text-xs">
                                            Editar
                                        </a>
                                        <form action="{{ route('secretaria.con-nota.destroy', $entrada) }}"
                                              method="POST"
                                              onsubmit="return confirm('Eliminar esta entrada?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-xs">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="border border-gray-200 px-4 py-6 text-center text-gray-500">
                                    No hay entradas registradas aun.
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
    <script>
    const input = document.getElementById('buscar-organizacion');
    let timer;
    input.addEventListener('input', function() {
        clearTimeout(timer);
        timer = setTimeout(() => {
            const form = input.closest('form');
            form.submit();
        }, 500);
    });
</script>
</x-app-layout>
