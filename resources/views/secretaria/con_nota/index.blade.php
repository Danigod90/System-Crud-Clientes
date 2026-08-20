<x-panel-layout title="Mesa de Entrada" :charlasPendientes="$charlasPendientes">
<div class="px-4">
    <div class="max-w-7xl mx-auto">

        @if(session('success'))
<div style="display:flex; align-items:center; gap:10px; background:#d1fae5; color:#065f46; padding:12px 16px; border-radius:10px; margin-bottom:14px; font-size:13px; border-left:4px solid #16a34a; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
    <svg width="18" height="18" fill="none" stroke="#16a34a" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;">
        <circle cx="12" cy="12" r="10"/><polyline points="9 12 11 14 15 10"/>
    </svg>
    {{ session('success') }}
</div>
@endif
@if(session('error'))
<div style="display:flex; align-items:center; gap:10px; background:#fee2e2; color:#991b1b; padding:12px 16px; border-radius:10px; margin-bottom:14px; font-size:13px; border-left:4px solid #dc2626; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
    <svg width="18" height="18" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;">
        <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
    </svg>
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
    <option value="suspendida" {{ request('asunto') == 'suspendida' ? 'selected' : '' }}>Susp — Suspendida</option>
    <option value="inf" {{ request('asunto') == 'inf' ? 'selected' : '' }}>Inf — Informativo</option>
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
    <button type="button" onclick="abrirModalListado()"
        style="display:inline-flex; align-items:center; gap:6px; background:#065f46; color:white; padding:7px 16px; border-radius:8px; font-size:13px; border:none; cursor:pointer;">
        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <polyline points="6 9 6 2 18 2 18 9"/>
            <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
            <rect x="6" y="14" width="12" height="8"/>
        </svg>
        Imprimir listado
    </button>
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
                            @php
                                $partesAsunto = collect([
                                    $entrada->asunto_char ? 'Char' : null,
                                    $entrada->asunto_log  ? 'Log'  : null,
                                    $entrada->asunto_tec  ? 'Tec'  : null,
                                    $entrada->asunto_obs  ? 'Obs'  : null,
                                    $entrada->asunto_inf  ? 'Inf'  : null,
                                ])->filter()->values();
                                $lineasAsunto = $partesAsunto->chunk(2)->map(fn($l) => $l->implode(' · '));
                            @endphp
                            <span class="font-mono font-semibold text-gray-800" style="font-size:12px;">
                                @forelse($lineasAsunto as $linea)
                                    <span style="white-space:nowrap;">{{ $linea }}</span>@if(!$loop->last)<br>@endif
                                @empty
                                    —
                                @endforelse
                            </span>
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
                        <td class="border border-gray-200 px-2 py-2" style="width:120px;">
                           @if($entrada->eleccion_suspendida)
   <span style="display:inline-flex; align-items:center; gap:4px;">
    <span style="font-size:11px; color:#dc2626; font-weight:600;">Suspendido</span>
    <span style="width:9px; height:9px; border-radius:50%; background:#dc2626; display:inline-block;"></span>
</span>
@else
@php
    $tiposEstado = collect([
        $entrada->asunto_char ? 'char' : null,
        $entrada->asunto_log  ? 'log'  : null,
        $entrada->asunto_tec  ? 'tec'  : null,
        $entrada->asunto_obs  ? 'obs'  : null,
        $entrada->asunto_inf  ? 'inf'  : null,
    ])->filter()->values();
@endphp
<div style="display:inline-grid; grid-template-columns:auto auto auto auto; column-gap:6px; row-gap:3px; align-items:center;">
    @foreach($tiposEstado as $tipo)
        @if($tipo === 'char')
            <span style="font-size:11px; color:#6b7280;">Char</span>
            <span style="display:inline-flex; align-items:center; gap:3px;">
                @foreach($entrada->charlas as $i => $ch)
                    @php $charDot = match($ch->estado) { 'realizada' => '#16a34a', 'cancelada' => '#dc2626', 'suspendida' => '#f97316', 'vencida' => '#dc2626', default => '#eab308' }; @endphp
                    <span style="width:9px; height:9px; border-radius:50%; background:{{ $charDot }}; display:inline-block;"></span>
                    <sup style="font-size:8px; color:#6b7280;">{{ $i+1 }}</sup>
                @endforeach
                @if($entrada->charlas->isEmpty())
                    <span style="width:9px; height:9px; border-radius:50%; background:#eab308; display:inline-block;"></span>
                @endif
            </span>
        @elseif($tipo === 'log')
            @php $logDot = in_array($entrada->log_estado ?? 'pendiente', ['entregada', 'realizado']) ? '#16a34a' : '#eab308'; @endphp
            <span style="font-size:11px; color:#6b7280;">Log</span>
            <span style="width:9px; height:9px; border-radius:50%; background:{{ $logDot }}; display:inline-block;"></span>
        @elseif($tipo === 'tec')
            @php $tecDot = $entrada->detalleTecnico?->tec_realizado ? '#16a34a' : '#eab308'; @endphp
            <span style="font-size:11px; color:#6b7280;">Tec</span>
            <span style="width:9px; height:9px; border-radius:50%; background:{{ $tecDot }}; display:inline-block;"></span>
        @elseif($tipo === 'obs')
            @php $obsDot = match($entrada->observador?->estado ?? 'pendiente') { 'realizada' => '#16a34a', 'cancelada' => '#dc2626', 'suspendida' => '#f97316', default => '#eab308' }; @endphp
            <span style="font-size:11px; color:#6b7280;">Obs</span>
            <span style="width:9px; height:9px; border-radius:50%; background:{{ $obsDot }}; display:inline-block;"></span>
        @elseif($tipo === 'inf')
            <span style="font-size:11px; color:#6b7280;">Informativo</span>
            <span style="width:9px; height:9px; border-radius:50%; background:#9ca3af; display:inline-block;"></span>
        @endif
    @endforeach
</div>
@endif
                        </td>
                        <td class="border border-gray-200 px-2 py-2" style="width:110px;">
                            <div style="display:flex; gap:6px; align-items:center; justify-content:center;">
                        <a href="{{ route('secretaria.con-nota.show', $entrada) }}?{{ http_build_query(['volver' => request()->fullUrl()]) }}"
   style="display:inline-flex; align-items:center; justify-content:center; width:30px; height:30px; background:#e0f2fe; border-radius:8px; color:#0369a1; text-decoration:none; flex-shrink:0;"
   title="Ver">
    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
        <circle cx="12" cy="12" r="3"/>
    </svg>
</a>
                                <a href="{{ route('secretaria.con-nota.edit', $entrada) }}?{{ http_build_query(['volver' => request()->fullUrl()]) }}"
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
{{-- MODAL LISTADO PDF --}}
<div id="modal-listado" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.6); z-index:9999; align-items:center; justify-content:center;">
    <div style="background:#fff; border-radius:12px; width:90%; max-width:860px; max-height:90vh; display:flex; flex-direction:column; box-shadow:0 8px 32px rgba(0,0,0,0.3);">

        <div style="display:flex; align-items:center; justify-content:space-between; padding:14px 20px; border-bottom:1px solid #e5e7eb; flex-shrink:0;">
            <span style="font-size:14px; font-weight:600; color:#111827;">Vista previa — Listado de entradas</span>
            <div style="display:flex; gap:8px;">
                <button onclick="imprimirListado()"
                    style="display:inline-flex; align-items:center; gap:6px; background:#065f46; color:white; padding:8px 18px; border-radius:8px; font-size:13px; border:none; cursor:pointer; font-weight:500;">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <polyline points="6 9 6 2 18 2 18 9"/>
                        <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                        <rect x="6" y="14" width="12" height="8"/>
                    </svg>
                    Imprimir
                </button>
                <button onclick="cerrarModalListado()"
                    style="display:inline-flex; align-items:center; gap:6px; background:#f3f4f6; color:#374151; padding:8px 18px; border-radius:8px; font-size:13px; border:none; cursor:pointer; font-weight:500;">
                    ✕ Cerrar
                </button>
            </div>
        </div>

        <div style="flex:1; overflow-y:auto; padding:20px; background:#f9fafb;">
            <div id="listado-html" style="background:#fff; border-radius:8px; padding:16px; box-shadow:0 1px 4px rgba(0,0,0,0.08);">
            </div>
        </div>
    </div>
</div>

<script>
async function abrirModalListado() {
    const params = new URLSearchParams({
        organizacion: '{{ request('organizacion') }}',
        asesor:       '{{ request('asesor') }}',
        asunto:       '{{ request('asunto') }}',
        mes_ingreso:  '{{ request('mes_ingreso') }}',
        mes_eleccion: '{{ request('mes_eleccion') }}',
    });

    const btn = document.querySelector('button[onclick="abrirModalListado()"]');
    btn.disabled = true;
    btn.textContent = 'Cargando...';

    try {
        const response = await fetch('{{ route('secretaria.con-nota.export-pdf') }}?' + params.toString(), {
            headers: { 'Accept': 'application/json' }
        });

        const data = await response.json();
        document.getElementById('listado-html').innerHTML = data.html;
        document.getElementById('modal-listado').style.display = 'flex';

    } catch (e) {
        alert('Error al cargar el listado. Intentá de nuevo.');
        console.error(e);
    } finally {
        btn.disabled = false;
        btn.innerHTML = `<svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <polyline points="6 9 6 2 18 2 18 9"/>
            <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
            <rect x="6" y="14" width="12" height="8"/>
        </svg> Imprimir listado`;
    }
}

function imprimirListado() {
    const contenido = document.getElementById('listado-html').innerHTML;
    const tituloOriginal = document.title;
    const bodyOriginal = document.body.innerHTML;

    document.title = 'Listado de Entradas — Dir. Org. Intermedias';
    document.body.innerHTML = contenido;
    window.print();
    document.body.innerHTML = bodyOriginal;
    document.title = tituloOriginal;
    window.location.reload();
}

function cerrarModalListado() {
    document.getElementById('modal-listado').style.display = 'none';
    document.getElementById('listado-html').innerHTML = '';
}
</script>
</x-panel-layout>
