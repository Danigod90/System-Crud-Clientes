<x-panel-layout title="Mis Organizaciones — Supervisor">
<div class="px-4">
    <div class="max-w-7xl mx-auto">

        @if(session('success'))
        <div style="background:#d1fae5; color:#065f46; padding:12px 16px; border-radius:6px; margin-bottom:16px; font-size:14px;">
            {{ session('success') }}
        </div>
        @endif

        <div class="bg-white shadow-sm sm:rounded-lg p-6">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
                <h3 style="font-size:18px; font-weight:600; color:#1f2937;">Listado de entradas</h3>
                <a href="{{ route('supervisor.dashboard') }}"
                   style="display:inline-flex; align-items:center; gap:8px; background-color:#1e3a5f; color:white; padding:8px 16px; border-radius:6px; font-size:14px; text-decoration:none;">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                        <polyline points="9 22 9 12 15 12 15 22"/>
                    </svg>
                    Panel general
                </a>
            </div>

            {{-- FILTROS --}}
            <form method="GET" action="{{ route('supervisor.index') }}" style="margin-bottom:20px;">
                <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:20px; box-shadow:0 1px 4px rgba(0,0,0,0.06);">
                    <div style="display:flex; align-items:center; gap:8px; margin-bottom:16px;">
                        <svg width="16" height="16" fill="none" stroke="#6b7280" stroke-width="1.8" viewBox="0 0 24 24">
                            <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/>
                        </svg>
                        <span style="font-size:13px; font-weight:500; color:#374151;">Filtros</span>
                    </div>

                    <div style="display:grid; grid-template-columns:repeat(6,1fr); gap:12px; margin-bottom:14px;">
                        <div>
                            <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Organización</label>
                            <input type="text" name="organizacion" id="buscar-organizacion" value="{{ request('organizacion') }}"
                                placeholder="Buscar..."
                                style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;"
                                autocomplete="off">
                        </div>
                       <div>
    <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Asesor</label>
    <select name="asesor" style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; background:#fff;">
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
                            <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Asunto</label>
                            <select name="asunto" style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; background:#fff;">
                                <option value="">Todos</option>
                                <option value="char" {{ request('asunto') == 'char' ? 'selected' : '' }}>Char — Charla</option>
                                <option value="log" {{ request('asunto') == 'log' ? 'selected' : '' }}>Log — Logística</option>
                                <option value="tec" {{ request('asunto') == 'tec' ? 'selected' : '' }}>Tec — Técnica</option>
                                <option value="obs" {{ request('asunto') == 'obs' ? 'selected' : '' }}>Obs — Observadores</option>
                            </select>
                        </div>
                          <div>
                            <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Cargado</label>
                            <select name="cargado" style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; background:#fff;">
                                <option value="">Todos</option>
                                <option value="si" {{ request('cargado') == 'si' ? 'selected' : '' }}>✓ Cargados</option>
                                <option value="no" {{ request('cargado') == 'no' ? 'selected' : '' }}>Pendientes</option>
                            </select>
                        </div>
                        <div>
                            <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Fecha ingreso</label>
                            <input type="month" name="mes_ingreso" value="{{ request('mes_ingreso') }}"
                                style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
                        </div>
                        <div>
                            <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Mes elección</label>
                            <input type="month" name="mes_eleccion" value="{{ request('mes_eleccion') }}"
                                style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
                        </div>
                      
                    </div>

                    <div style="display:flex; gap:8px;">
                        <button type="submit"
                            style="display:inline-flex; align-items:center; gap:6px; background:#2563eb; color:white; padding:7px 16px; border-radius:8px; font-size:13px; border:none; cursor:pointer;">
                            Filtrar
                        </button>
                        <a href="{{ route('supervisor.index') }}"
                            style="display:inline-flex; align-items:center; gap:6px; background:#1e3a5f; color:white; padding:7px 16px; border-radius:8px; font-size:13px; text-decoration:none;">
                            Limpiar
                        </a>
                    </div>
                </div>
            </form>

            {{-- TABLA --}}
            <div style="overflow-x:auto;">
                <table class="w-full table-fixed border-collapse text-sm" style="min-width:900px;">
                    <thead>
                        <tr class="bg-gray-50 text-gray-600 uppercase text-xs">
                            <th class="border border-gray-200 px-2 py-3 text-center" style="width:100px;">Código ORG</th>
                            <th class="border border-gray-200 px-2 py-3 text-center" style="width:180px;">Organización</th>
                            <th class="border border-gray-200 px-2 py-3 text-center" style="width:90px;">Asesor</th>
                            <th class="border border-gray-200 px-2 py-3 text-center" style="width:80px;">Asunto</th>
                            <th class="border border-gray-200 px-2 py-3 text-center" style="width:90px;">Fecha elección</th>
                            <th class="border border-gray-200 px-2 py-3 text-center" style="width:90px;">Fecha ingreso</th>
                            <th class="border border-gray-200 px-2 py-3 text-center" style="width:120px;">Estado</th>
                            <th class="border border-gray-200 px-2 py-3 text-center" style="width:90px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($entradas as $entrada)
                        <tr class="hover:bg-gray-50" id="fila-{{ $entrada->id }}"
                            style="{{ $entrada->supervisor_cargado ? 'background:#f0fdf4;' : '' }}">
                            <td class="border border-gray-200 px-2 py-2 font-mono font-semibold text-blue-700" style="text-align:center;">
                                {{ $entrada->codigo_org }}
                            </td>
                            <td class="border border-gray-200 px-2 py-2" style="font-size:11px; font-weight:500; text-align:center;">
                                {{ $entrada->nombre_organizacion }}
                            </td>
                            <td class="border border-gray-200 px-2 py-2" style="text-align:center;">
                                {{ $entrada->asesor_asignado ?? '—' }}
                            </td>
                            <td class="border border-gray-200 px-2 py-2" style="text-align:center;">
                                <span class="font-mono font-semibold text-gray-800" style="font-size:12px;">{{ $entrada->asunto_texto }}</span>
                            </td>
                            <td class="border border-gray-200 px-2 py-2" style="font-size:11px; text-align:center;">
                                @if($entrada->fecha_eleccion)
                                    {{ $entrada->fecha_eleccion->format('d/m/Y') }}
                                @else
                                    <span style="background:#fef9c3; color:#854d0e; font-size:11px; padding:2px 8px; border-radius:999px; font-weight:600;">⚠ Sin fecha</span>
                                @endif
                            </td>
                            <td class="border border-gray-200 px-2 py-2 text-xs text-gray-600" style="text-align:center;">
                                {{ $entrada->created_at?->format('d/m/Y H:i') ?? '—' }}
                            </td>
                            <td class="border border-gray-200 px-2 py-2" style="text-align:center;">
                                @if($entrada->supervisor_cargado)
                                    <span style="background:#dcfce7; color:#16a34a; font-size:11px; font-weight:600; padding:3px 10px; border-radius:999px;">✓ Cargado</span>
                                @else
                                    <span style="background:#fef9c3; color:#854d0e; font-size:11px; font-weight:600; padding:3px 10px; border-radius:999px;">Pendiente</span>
                                @endif
                            </td>
                            <td class="border border-gray-200 px-2 py-2">
                                <div style="display:flex; gap:6px; align-items:center; justify-content:center;">
                                    <a href="{{ route('supervisor.show', $entrada) }}"
                                       style="display:inline-flex; align-items:center; justify-content:center; width:30px; height:30px; background:#e0f2fe; border-radius:8px; color:#0369a1; text-decoration:none;"
                                       title="Ver">
                                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                            <circle cx="12" cy="12" r="3"/>
                                        </svg>
                                    </a>
                                    @if(!$entrada->supervisor_cargado)
                                    <button onclick="marcarCargado({{ $entrada->id }})"
                                            id="btn-cargado-{{ $entrada->id }}"
                                            style="display:inline-flex; align-items:center; justify-content:center; width:30px; height:30px; background:#dcfce7; border-radius:8px; color:#16a34a; border:none; cursor:pointer;"
                                            title="Marcar como cargado">
                                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <circle cx="12" cy="12" r="10"/>
                                            <polyline points="9 12 11 14 15 10"/>
                                        </svg>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="border border-gray-200 px-4 py-6 text-center text-gray-500">
                                No hay entradas registradas.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

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
    timer = setTimeout(() => input.closest('form').submit(), 500);
});

function marcarCargado(id) {
    fetch('/supervisor/organizaciones/' + id + '/cargado', {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        }
    }).then(r => r.json()).then(d => {
        if (d.success) {
            const fila = document.getElementById('fila-' + id);
            fila.style.background = '#f0fdf4';
            const btn = document.getElementById('btn-cargado-' + id);
            if (btn) btn.remove();
            const td = fila.querySelector('td:nth-child(7)');
            td.innerHTML = '<span style="background:#dcfce7; color:#16a34a; font-size:11px; font-weight:600; padding:3px 10px; border-radius:999px;">✓ Cargado</span>';
        }
    });
}
</script>

</x-panel-layout>