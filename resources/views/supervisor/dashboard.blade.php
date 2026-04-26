<x-panel-layout title="Dashboard Supervisor">
<div class="px-2 py-2">
    <div style="max-width:1000px; margin:0 auto;">

        <div style="margin-bottom:16px;">
            <h2 style="font-size:16px; font-weight:700; color:#1e293b; margin:0;">Panel Supervisor</h2>
            <p style="font-size:12px; color:#94a3b8; margin:2px 0 0;">Seguimiento de cargas en el sistema institucional</p>
        </div>

        {{-- CARDS --}}
        <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:12px; margin-bottom:20px;">
            <div style="background:#1e3a5f; border-radius:12px; padding:16px; color:#fff;">
                <div style="font-size:11px; color:rgba(255,255,255,0.6); text-transform:uppercase; letter-spacing:0.5px; margin-bottom:6px;">Total entradas</div>
                <div style="font-size:28px; font-weight:700;">{{ $stats['total'] }}</div>
            </div>
            <div style="background:#16a34a; border-radius:12px; padding:16px; color:#fff;">
                <div style="font-size:11px; color:rgba(255,255,255,0.6); text-transform:uppercase; letter-spacing:0.5px; margin-bottom:6px;">Cargados</div>
                <div style="font-size:28px; font-weight:700;">{{ $stats['cargados'] }}</div>
            </div>
            <div style="background:#d97706; border-radius:12px; padding:16px; color:#fff;">
                <div style="font-size:11px; color:rgba(255,255,255,0.6); text-transform:uppercase; letter-spacing:0.5px; margin-bottom:6px;">Pendientes</div>
                <div style="font-size:28px; font-weight:700;">{{ $stats['pendientes'] }}</div>
            </div>
            <div style="background:#2563eb; border-radius:12px; padding:16px; color:#fff;">
                <div style="font-size:11px; color:rgba(255,255,255,0.6); text-transform:uppercase; letter-spacing:0.5px; margin-bottom:6px;">Este mes</div>
                <div style="font-size:28px; font-weight:700;">{{ $stats['este_mes'] }}</div>
            </div>
        </div>

        {{-- TABLA RECIENTES --}}
        <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; overflow:hidden; box-shadow:0 1px 4px rgba(0,0,0,0.04);">
            <div style="padding:12px 16px; border-bottom:1px solid #f3f4f6; display:flex; justify-content:space-between; align-items:center;">
                <span style="font-size:13px; font-weight:600; color:#1e293b;">Últimas entradas</span>
                <a href="{{ route('supervisor.index') }}" style="font-size:12px; color:#2563eb; text-decoration:none;">Ver todas →</a>
            </div>
            <table style="width:100%; border-collapse:collapse; font-size:12px;">
                <thead>
                    <tr style="background:#f8fafc;">
                        <th style="padding:8px 16px; text-align:left; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase;">Código</th>
                        <th style="padding:8px 16px; text-align:left; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase;">Organización</th>
                        <th style="padding:8px 16px; text-align:left; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase;">Asesor</th>
                        <th style="padding:8px 16px; text-align:center; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase;">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recientes as $entrada)
                    <tr style="border-bottom:1px solid #f3f4f6; {{ $entrada->supervisor_cargado ? 'background:#f0fdf4;' : '' }}">
                        <td style="padding:10px 16px; color:#185FA5; font-weight:600; font-family:monospace;">{{ $entrada->codigo_org }}</td>
                        <td style="padding:10px 16px; color:#1e293b; font-weight:500;">{{ $entrada->nombre_organizacion }}</td>
                        <td style="padding:10px 16px; color:#374151;">{{ $entrada->asesor_asignado ?? '—' }}</td>
                        <td style="padding:10px 16px; text-align:center;">
                            @if($entrada->supervisor_cargado)
                                <span style="background:#dcfce7; color:#16a34a; font-size:11px; font-weight:600; padding:3px 10px; border-radius:999px;">✓ Cargado</span>
                            @else
                                <span style="background:#fef9c3; color:#854d0e; font-size:11px; font-weight:600; padding:3px 10px; border-radius:999px;">Pendiente</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="padding:30px; text-align:center; color:#94a3b8;">No hay entradas.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>
</x-panel-layout>