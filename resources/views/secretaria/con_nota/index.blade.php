<x-panel-layout title="Mesa de Entrada" :charlasPendientes="$charlasPendientes">
<div class="px-4">
    <div class="max-w-7xl mx-auto">

        @if(session('success'))
        <div style="background-color:#d1fae5; color:#065f46; padding:12px 16px; border-radius:6px; margin-bottom:16px; font-size:14px;">
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div style="background-color:#fee2e2; color:#991b1b; padding:12px 16px; border-radius:6px; margin-bottom:16px; font-size:14px;">
            {{ session('error') }}
        </div>
        @endif

        <div class="bg-white shadow-sm sm:rounded-lg p-6">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
                <h3 style="font-size:18px; font-weight:600; color:#1f2937;">Listado de entradas</h3>
                <div style="display:flex; gap:8px;">
                    <a href="{{ route('panel.dashboard') }}"
                       style="display:inline-flex; align-items:center; gap:8px; background-color:#1e3a5f; color:white; padding:8px 16px; border-radius:6px; font-size:14px; text-decoration:none;">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                            <polyline points="9 22 9 12 15 12 15 22"/>
                        </svg>
                        Panel general
                    </a>
                    <a href="{{ route('secretaria.con-nota.create') }}"
                       style="display:inline-flex; align-items:center; gap:8px; background-color:#2563eb; color:white; padding:8px 16px; border-radius:6px; font-size:14px; text-decoration:none;">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="12" y1="8" x2="12" y2="16"/>
                            <line x1="8" y1="12" x2="16" y2="12"/>
                        </svg>
                        Nueva mesa de entrada
                    </a>
                </div>
            </div>

            {{-- FILTROS --}}
            <form method="GET" action="{{ route('secretaria.con-nota.index') }}" style="margin-bottom:20px;">
                <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:20px; box-shadow:0 1px 4px rgba(0,0,0,0.06);">
                    <div style="display:flex; align-items:center; gap:8px; margin-bottom:16px;">
                        <svg width="16" height="16" fill="none" stroke="#6b7280" stroke-width="1.8" viewBox="0 0 24 24">
                            <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/>
                        </svg>
                        <span style="font-size:13px; font-weight:500; color:#374151;">Filtros</span>
                    </div>

<div style="display:grid; grid-template-columns:repeat(5,1fr); gap:12px; margin-bottom:14px;">                        <div>
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
    <option value="obs" {{ request('asunto') == 'obs' ? 'selected' : '' }}>Obs — Observadores</option>
    <option value="char" {{ request('asunto') == 'char' ? 'selected' : '' }}>Char — Charla</option>
    <option value="log" {{ request('asunto') == 'log' ? 'selected' : '' }}>Log — Logística</option>
    <option value="tec" {{ request('asunto') == 'tec' ? 'selected' : '' }}>Tec — Técnica</option>
    <option value="char_realizada" {{ request('asunto') == 'char_realizada' ? 'selected' : '' }}>Char — Realizada</option>
    <option value="char_pendiente" {{ request('asunto') == 'char_pendiente' ? 'selected' : '' }}>Char — Pendiente</option>
    <option value="char_suspendida" {{ request('asunto') == 'char_suspendida' ? 'selected' : '' }}>Char — Suspendida</option>
    <option value="char_cancelada" {{ request('asunto') == 'char_cancelada' ? 'selected' : '' }}>Char — Cancelada</option>
</select>
                        </div>
                        <div>
                            <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Fecha ingreso</label>
                            <input type="month" name="mes_ingreso" value="{{ request('mes_ingreso') }}"
                                style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
                        </div>
                        <div>
    <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Mes de elección</label>
    <input type="month" name="mes_eleccion" value="{{ request('mes_eleccion') }}"
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
                        <a href="{{ route('secretaria.con-nota.index') }}"
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
<table class="w-full table-fixed border-collapse text-sm" style="min-width:900px;">
    <thead>
    <tr class="bg-gray-50 text-gray-600 uppercase text-xs">
        <th class="border border-gray-200 px-2 py-3 text-center" style="width:100px;">Codigo ORG</th>
        <th class="border border-gray-200 px-2 py-3 text-center" style="width:180px;">Organizacion</th>
        <th class="border border-gray-200 px-2 py-3 text-center" style="width:90px;">Asesor</th>
        <th class="border border-gray-200 px-2 py-3 text-center" style="width:80px;">Asunto</th>
        <th class="border border-gray-200 px-2 py-3 text-center" style="width:75px;">Via</th>
        <th class="border border-gray-200 px-2 py-3 text-center" style="width:90px;">Fecha eleccion</th>
        <th class="border border-gray-200 px-2 py-3 text-center" style="width:100px;">Registrado por</th>
        <th class="border border-gray-200 px-2 py-3 text-center" style="width:90px;">Fecha ingreso</th>
        <th class="border border-gray-200 px-2 py-3 text-center" style="width:120px;">Estado</th>
        <th class="border border-gray-200 px-2 py-3 text-center" style="width:110px;">Acciones</th>
    </tr>
</thead>
                <tbody>
                    @forelse($entradas as $entrada)
                    <tr class="hover:bg-gray-50">
                        <td class="border border-gray-200 px-2 py-2 font-mono font-semibold text-blue-700" style="text-align:center;">
                            {{ $entrada->codigo_org }}
                        </td>
                        <td class="border border-gray-200 px-2 py-2" style="font-size:11px; font-weight:500; text-align:center;">
                            {{ $entrada->nombre_organizacion }}
                        </td>
                        <td class="border border-gray-200 px-2 py-2" style="text-align:center;">
                            {{ $entrada->asesor_asignado ?? '-' }}
                        </td>
                        <td class="border border-gray-200 px-2 py-2" style="text-align:center;">
                            <span class="font-mono font-semibold text-gray-800" style="font-size:12px;">{{ $entrada->asunto_texto }}</span>
                        </td>
                        <td class="border border-gray-200 px-2 py-2 capitalize" style="text-align:center;">
                            {{ $entrada->via_ingreso }}
                        </td>
                        <td class="border border-gray-200 px-2 py-2" style="font-size:11px; text-align:center;">
                            @if($entrada->fecha_eleccion)
                                {{ $entrada->fecha_eleccion->format('d/m/Y') }}
                            @else
                                <span style="background:#fef9c3; color:#854d0e; font-size:11px; padding:2px 8px; border-radius:999px; font-weight:600;">⚠️ Sin fecha</span>
                            @endif
                        </td>
                        <td class="border border-gray-200 px-2 py-2 text-xs text-gray-600" style="text-align:center;">
                            {{ $entrada->registrado_por }}
                        </td>
                        <td class="border border-gray-200 px-2 py-2 text-xs text-gray-600" style="text-align:center;">
                            {{ $entrada->created_at?->format('d/m/Y H:i') ?? '-' }}
                        </td>
                        <td class="border border-gray-200 px-2 py-2" style="width:120px; white-space:nowrap;">
                            @if($entrada->asunto_char)
                                @php $charDot = match($entrada->charla?->estado ?? 'pendiente') { 'realizada' => '#16a34a', 'cancelada' => '#dc2626', 'suspendida' => '#f97316', 'vencida' => '#dc2626', default => '#eab308' }; @endphp
                                <span style="display:inline-flex; align-items:center; gap:3px; margin-right:8px;">
                                    <span style="font-size:11px; color:#6b7280;">Char</span>
                                    <span style="width:9px; height:9px; border-radius:50%; background:{{ $charDot }}; display:inline-block;"></span>
                                </span>
                            @endif
                            @if($entrada->asunto_log)
                                @php $logDot = in_array($entrada->log_estado ?? 'pendiente', ['entregada', 'realizado']) ? '#16a34a' : '#eab308'; @endphp
                                <span style="display:inline-flex; align-items:center; gap:3px; margin-right:8px;">
                                    <span style="font-size:11px; color:#6b7280;">Log</span>
                                    <span style="width:9px; height:9px; border-radius:50%; background:{{ $logDot }}; display:inline-block;"></span>
                                </span>
                            @endif
                           @if($entrada->asunto_tec)
    @php $tecDot = $entrada->detalleTecnico?->tec_realizado ? '#16a34a' : '#eab308'; @endphp
    <span style="display:inline-flex; align-items:center; gap:3px; margin-right:8px;">
        <span style="font-size:11px; color:#6b7280;">Tec</span>
        <span style="width:9px; height:9px; border-radius:50%; background:{{ $tecDot }}; display:inline-block;"></span>
    </span>
@endif
                            @if($entrada->asunto_obs)
                                @php $obsDot = match($entrada->observador?->estado ?? 'pendiente') { 'realizada' => '#16a34a', 'cancelada' => '#dc2626', 'suspendida' => '#f97316', default => '#eab308' }; @endphp
                                <span style="display:inline-flex; align-items:center; gap:3px;">
                                    <span style="font-size:11px; color:#6b7280;">Obs</span>
                                    <span style="width:9px; height:9px; border-radius:50%; background:{{ $obsDot }}; display:inline-block;"></span>
                                </span>
                            @endif
                        </td>
                        <td class="border border-gray-200 px-2 py-2" style="width:110px;">
                            <div style="display:flex; gap:6px; align-items:center; justify-content:center;">
                                <a href="{{ route('secretaria.con-nota.show', $entrada) }}"
                                   style="display:inline-flex; align-items:center; justify-content:center; width:30px; height:30px; background:#e0f2fe; border-radius:8px; color:#0369a1; text-decoration:none; flex-shrink:0;"
                                   title="Ver">
                                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                </a>
                                <a href="{{ route('secretaria.con-nota.edit', $entrada) }}"
                                   style="display:inline-flex; align-items:center; justify-content:center; width:30px; height:30px; background:#fef9c3; border-radius:8px; color:#854d0e; text-decoration:none; flex-shrink:0;"
                                   title="Editar">
                                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                    </svg>
                                </a>
                                <form action="{{ route('secretaria.con-nota.destroy', $entrada) }}"
                                      method="POST"
                                      style="display:inline; flex-shrink:0;"
                                      onsubmit="return confirm('Eliminar esta entrada?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        style="display:inline-flex; align-items:center; justify-content:center; width:30px; height:30px; background:#fee2e2; border-radius:8px; color:#991b1b; border:none; cursor:pointer;"
                                        title="Eliminar">
                                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                            <polyline points="3 6 5 6 21 6"/>
                                            <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                                            <path d="M10 11v6M14 11v6"/>
                                            <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="border border-gray-200 px-4 py-6 text-center text-gray-500">
                            No hay entradas registradas aun.
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
        const form = input.closest('form');
        form.submit();
    }, 500);
});
</script>

</x-panel-layout>
