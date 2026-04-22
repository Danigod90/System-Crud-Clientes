<x-panel-layout title="Organizaciones Técnica">
<div style="padding:0 8px;">
    <div style="width:100%;">

        @if(session('success'))
        <div style="background-color:#d1fae5; color:#065f46; padding:12px 16px; border-radius:6px; margin-bottom:16px; font-size:14px;">
            {{ session('success') }}
        </div>
        @endif

        <div class="bg-white shadow-sm sm:rounded-lg p-6">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
                <h3 style="font-size:18px; font-weight:600; color:#1f2937;">Mis Organizaciones</h3>
                <a href="{{ route('tecnico.dashboard') }}"
                   style="display:inline-flex; align-items:center; gap:8px; background-color:#1e3a5f; color:white; padding:8px 16px; border-radius:6px; font-size:14px; text-decoration:none;">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                        <polyline points="9 22 9 12 15 12 15 22"/>
                    </svg>
                    Panel general
                </a>
            </div>

            {{-- FILTROS --}}
            <form method="GET" action="{{ route('tecnico.organizaciones') }}" style="margin-bottom:20px;">
                <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:20px; box-shadow:0 1px 4px rgba(0,0,0,0.06);">
                    <div style="display:flex; align-items:center; gap:8px; margin-bottom:16px;">
                        <svg width="16" height="16" fill="none" stroke="#6b7280" stroke-width="1.8" viewBox="0 0 24 24">
                            <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/>
                        </svg>
                        <span style="font-size:13px; font-weight:500; color:#374151;">Filtros</span>
                    </div>

                    <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:12px; margin-bottom:14px;">
                        <div>
                            <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Organización</label>
                            <div style="position:relative;">
                                <svg style="position:absolute; left:9px; top:50%; transform:translateY(-50%);" width="13" height="13" fill="none" stroke="#9ca3af" stroke-width="1.8" viewBox="0 0 24 24">
                                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                                </svg>
                                <input type="text" name="organizacion" id="buscar-organizacion" value="{{ request('organizacion') }}"
                                    placeholder="Buscar..."
                                    style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px 7px 28px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;"
                                    autocomplete="off">
                            </div>
                        </div>
                        <div>
                            <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Estado</label>
                            <select name="estado" style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; background:#fff;">
                                <option value="">Todos</option>
                                <option value="enviado" {{ request('estado') == 'enviado' ? 'selected' : '' }}>Enviado a Técnica</option>
                                <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="impreso" {{ request('estado') == 'impreso' ? 'selected' : '' }}>Impreso</option>
                            </select>
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
                            <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Fecha ingreso</label>
                            <input type="month" name="mes_ingreso" value="{{ request('mes_ingreso') }}"
                                style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
                        </div>
                    </div>

                    <div style="display:flex; gap:8px;">
                        <button type="submit"
                            style="display:inline-flex; align-items:center; gap:6px; background:#2563eb; color:white; padding:7px 16px; border-radius:8px; font-size:13px; border:none; cursor:pointer;">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/>
                            </svg>
                            Filtrar
                        </button>
                        <a href="{{ route('tecnico.organizaciones') }}"
                            style="display:inline-flex; align-items:center; gap:6px; background:#1e3a5f; color:white; padding:7px 16px; border-radius:8px; font-size:13px; text-decoration:none;">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <polyline points="1 4 1 10 7 10"/>
                                <path d="M3.51 15a9 9 0 1 0 .49-4"/>
                            </svg>
                            Limpiar
                        </a>
                    </div>
                </div>
            </form>

            <div style="overflow-x:auto;">
            <table class="w-full table-fixed border-collapse text-sm" style="min-width:800px;">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 uppercase text-xs">
                        <th class="border border-gray-200 px-2 py-3 text-left" style="width:100px;">Codigo ORG</th>
                        <th class="border border-gray-200 px-2 py-3 text-left" style="width:220px;">Organizacion</th>
                        <th class="border border-gray-200 px-2 py-3 text-left" style="width:80px;">Asunto</th>
                        <th class="border border-gray-200 px-2 py-3 text-left" style="width:100px;">Asesor</th>
                        <th class="border border-gray-200 px-2 py-3 text-left" style="width:90px;">Fecha eleccion</th>
                        <th class="border border-gray-200 px-2 py-3 text-left" style="width:90px;">Fecha ingreso</th>
                        <th class="border border-gray-200 px-2 py-3 text-left" style="width:80px;">Estado</th>
                        <th class="border border-gray-200 px-2 py-3 text-center" style="width:90px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($entradas as $entrada)
                    <tr class="hover:bg-gray-50">
                        <td class="border border-gray-200 px-2 py-2 font-mono font-semibold text-blue-700">
                            {{ $entrada->codigo_org }}
                        </td>
                        <td class="border border-gray-200 px-2 py-2" style="font-size:11px; font-weight:500;">
                            {{ $entrada->nombre_organizacion }}
                        </td>
                        <td class="border border-gray-200 px-2 py-2">
                            <span class="font-mono font-semibold text-gray-800">{{ $entrada->asunto_texto }}</span>
                        </td>
                        <td class="border border-gray-200 px-2 py-2" style="font-size:11px;">
                                  {{ $entrada->asesor_asignado ?? '—' }}
                        </td>
                        <td class="border border-gray-200 px-2 py-2" style="white-space:nowrap;">
                            @if($entrada->fecha_eleccion)
                                {{ $entrada->fecha_eleccion->format('d/m/Y') }}
                            @else
                                <span style="background:#fef9c3; color:#854d0e; font-size:11px; padding:2px 8px; border-radius:999px; font-weight:600;">⚠️ Sin fecha</span>
                            @endif
                        </td>
                        <td class="border border-gray-200 px-2 py-2 text-xs text-gray-600">
                            {{ $entrada->created_at?->format('d/m/Y H:i') ?? '-' }}
                        </td>
                        <td class="border border-gray-200 px-2 py-2" style="white-space:nowrap;">
                            @if($entrada->asunto_log)
                                @php $logDot = in_array($entrada->log_estado ?? 'pendiente', ['entregada', 'realizado']) ? '#16a34a' : '#eab308'; @endphp
                                <span style="display:inline-flex; align-items:center; gap:3px; margin-right:8px;">
                                    <span style="font-size:11px; color:#6b7280;">Log</span>
                                    <span style="width:9px; height:9px; border-radius:50%; background:{{ $logDot }}; display:inline-block;"></span>
                                </span>
                            @endif
                            @if($entrada->asunto_tec)
                                @php $tecDot = $entrada->detalleTecnico?->tec_realizado ? '#16a34a' : '#eab308'; @endphp
                                <span style="display:inline-flex; align-items:center; gap:3px;">
                                    <span style="font-size:11px; color:#6b7280;">Tec</span>
                                    <span style="width:9px; height:9px; border-radius:50%; background:{{ $tecDot }}; display:inline-block;"></span>
                                </span>
                            @endif
                        </td>
                        <td class="border border-gray-200 px-2 py-2">
    <div style="display:flex; gap:4px; align-items:center; justify-content:center;">
        <a href="{{ route('tecnico.organizacion.edit', $entrada->id) }}"
           style="display:inline-flex; align-items:center; justify-content:center; width:30px; height:30px; background:#fef9c3; border-radius:8px; color:#854d0e; text-decoration:none;"
           title="Editar">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <rect x="2" y="7" width="20" height="14" rx="2"/>
                <path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/>
                <line x1="2" y1="13" x2="22" y2="13"/>
                <rect x="9" y="10" width="6" height="6" rx="1"/>
            </svg>
        </a>
        <button onclick="togglePin({{ $entrada->id }}, this)"
                data-activo="{{ $prioridades->pluck('entrada_con_nota_id')->contains($entrada->id) ? '1' : '0' }}"
                style="display:inline-flex; align-items:center; justify-content:center; width:30px; height:30px; border-radius:8px; border:none; cursor:pointer; background:{{ $prioridades->pluck('entrada_con_nota_id')->contains($entrada->id) ? '#fce7f3' : '#f3f4f6' }};"
                title="Marcar como prioridad">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="{{ $prioridades->pluck('entrada_con_nota_id')->contains($entrada->id) ? '#db2777' : 'none' }}" stroke="{{ $prioridades->pluck('entrada_con_nota_id')->contains($entrada->id) ? '#db2777' : '#6b7280' }}" stroke-width="2">
                <path d="M12 2L9 9H2l6 4.5-2.5 7.5L12 17l6.5 4-2.5-7.5L22 9h-7z"/>
            </svg>
        </button>
    </div>
</td>                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="border border-gray-200 px-4 py-6 text-center text-gray-500">
                            No hay organizaciones con técnica aún.
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
    timer = setTimeout(() => {
        input.closest('form').submit();
    }, 500);
});
</script>
<script>
function togglePin(entradaId, btn) {
    fetch('/tecnico/prioridad/' + entradaId, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(r => r.json())
    .then(data => {
        if (data.error) {
            alert(data.error);
            return;
        }
        window.location.reload();
    })
    .catch(() => alert('Error al actualizar prioridad'));
}
</script>
</x-panel-layout>
