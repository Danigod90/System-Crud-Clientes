<x-panel-layout title="Mesa de Entrada Sin Nota">
<div class="px-2 py-2">
    <div style="max-width:1000px; margin:0 auto;">

        @if(session('success'))
        <div style="background:#d1fae5; color:#065f46; padding:10px 14px; border-radius:8px; margin-bottom:14px; font-size:13px;">
            {{ session('success') }}
        </div>
        @endif

        {{-- HEADER --}}
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
            <div>
                <h2 style="font-size:16px; font-weight:700; color:#1e293b; margin:0;">Mesa de Entrada Sin Nota</h2>
                <p style="font-size:12px; color:#94a3b8; margin:2px 0 0;">Registros de visitas sin nota oficial</p>
            </div>
            <div style="display:flex; gap:8px;">
                <a href="{{ route('secretaria.sin-nota.pdf', request()->query()) }}" target="_blank"
                   style="display:inline-flex; align-items:center; gap:6px; background:#ef4444; color:white; padding:8px 14px; border-radius:8px; font-size:12px; text-decoration:none; font-weight:500;">
                    📄 Exportar PDF
                </a>
                <a href="{{ route('secretaria.sin-nota.create') }}"
                   style="display:inline-flex; align-items:center; gap:6px; background:#2563eb; color:white; padding:8px 14px; border-radius:8px; font-size:12px; text-decoration:none; font-weight:500;">
                    + Nueva entrada
                </a>
            </div>
        </div>

        {{-- FILTROS --}}
        <form method="GET" action="{{ route('secretaria.sin-nota.index') }}">
        <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:16px 20px; margin-bottom:14px; box-shadow:0 1px 4px rgba(0,0,0,0.04);">
            <div style="display:grid; grid-template-columns:2fr 1fr 1fr 1fr; gap:12px; margin-bottom:12px;">
                <div>
                    <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Nombre o Apellido</label>
                    <input type="text" name="nombre" value="{{ request('nombre') }}" placeholder="Buscar..."
                           style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
                </div>
                <div>
                    <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Asesor</label>
                    <select name="asesor_id" style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; background:#fff; box-sizing:border-box;">
                        <option value="">Todos</option>
                        @foreach($asesores as $asesor)
                            <option value="{{ $asesor->id }}" {{ request('asesor_id') == $asesor->id ? 'selected' : '' }}>
                                {{ $asesor->nombre }} {{ $asesor->apellido }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Fecha Desde</label>
                    <input type="date" name="fecha_desde" value="{{ request('fecha_desde') }}"
                           style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
                </div>
                <div>
                    <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Fecha Hasta</label>
                    <input type="date" name="fecha_hasta" value="{{ request('fecha_hasta') }}"
                           style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
                </div>
            </div>
            <div style="display:flex; gap:8px;">
                <button type="submit" style="padding:7px 16px; border-radius:8px; border:none; background:#2563eb; color:white; font-size:12px; cursor:pointer; font-weight:500;">Filtrar</button>
                <a href="{{ route('secretaria.sin-nota.index') }}" style="padding:7px 16px; border-radius:8px; border:1px solid #e5e7eb; background:white; color:#374151; font-size:12px; text-decoration:none;">Limpiar</a>
            </div>
        </div>
        </form>

        {{-- TABLA --}}
        <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; overflow:hidden; box-shadow:0 1px 4px rgba(0,0,0,0.04);">
            <table style="width:100%; border-collapse:collapse;">
                <thead>
                    <tr style="background:#f8fafc; border-bottom:1px solid #e5e7eb;">
                        <th style="padding:10px 16px; text-align:left; font-size:11px; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px;">N° Entrada</th>
                        <th style="padding:10px 16px; text-align:left; font-size:11px; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px;">Nombre</th>
                        <th style="padding:10px 16px; text-align:left; font-size:11px; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px;">Apellido</th>
                        <th style="padding:10px 16px; text-align:left; font-size:11px; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px;">Tipo de Charla</th>
                        <th style="padding:10px 16px; text-align:left; font-size:11px; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px;">Asesor</th>
                        <th style="padding:10px 16px; text-align:left; font-size:11px; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px;">Fecha</th>
                        <th style="padding:10px 16px; text-align:left; font-size:11px; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px;"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($entradas as $entrada)
                    <tr style="border-bottom:1px solid #f3f4f6;">
                        <td style="padding:10px 16px; font-size:12px; color:#6b7280; font-weight:600;">{{ $entrada->numero_entrada }}</td>
                        <td style="padding:10px 16px; font-size:13px; color:#1e293b; font-weight:500;">{{ $entrada->nombre }}</td>
                        <td style="padding:10px 16px; font-size:13px; color:#1e293b;">{{ $entrada->apellido }}</td>
                        <td style="padding:10px 16px; font-size:13px; color:#374151;">{{ $entrada->tipo_charla }}</td>
                        <td style="padding:10px 16px; font-size:13px; color:#374151;">{{ $entrada->asesor ? $entrada->asesor->nombre . ' ' . $entrada->asesor->apellido : '—' }}</td>
                        <td style="padding:10px 16px; font-size:12px; color:#94a3b8;">{{ $entrada->created_at ? $entrada->created_at->format('d/m/Y') : '—' }}</td>
                        <td style="padding:10px 16px;">
                            <a href="{{ route('secretaria.sin-nota.show', ['sinNota' => $entrada->id]) }}"
                               style="font-size:12px; color:#2563eb; text-decoration:none; font-weight:500;">Ver →</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="padding:40px; text-align:center; color:#94a3b8; font-size:13px;">
                            No hay entradas registradas.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- PAGINACION --}}
            @if($entradas->hasPages())
            <div style="padding:12px 16px; border-top:1px solid #f3f4f6;">
                {{ $entradas->links() }}
            </div>
            @endif
        </div>

    </div>
</div>
</x-panel-layout>
