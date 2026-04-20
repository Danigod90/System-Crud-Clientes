<x-panel-layout title="Panel General" :elecciones="$elecciones" :charlasPendientes="$charlasPendientes">
<style>
.card-stat {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    cursor: default;
}
.card-stat:hover {
    transform: translateY(-4px) scale(1.02);
    box-shadow: 0 16px 32px rgba(0,0,0,0.2) !important;
}
</style>

<div style="max-width:1000px; margin:0 auto; padding:8px 0;">

    {{-- CARDS --}}
    <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:14px; margin-bottom:20px;">

        {{-- 1. Entradas del mes --}}
        <div class="card-stat" style="background:linear-gradient(135deg,#7C6FC4,#D088C0); border-radius:14px; padding:18px 20px; position:relative; overflow:hidden; box-shadow:0 4px 12px rgba(124,111,196,0.35);">
            <div style="position:absolute;top:14px;right:16px;opacity:0.55;">
                <svg width="36" height="36" fill="none" stroke="#fff" stroke-width="1.5" viewBox="0 0 24 24">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/>
                    <line x1="16" y1="17" x2="8" y2="17"/>
                    <polyline points="10 9 9 9 8 9"/>
                </svg>
            </div>
            <div style="font-size:11px; color:rgba(255,255,255,0.85); margin-bottom:6px; font-weight:500;">Entradas del mes</div>
            <div style="font-size:36px; font-weight:700; color:#fff; line-height:1;">{{ $stats['entradas_mes'] }}</div>
            <span style="display:inline-flex; background:rgba(255,255,255,0.22); border-radius:20px; padding:3px 10px; font-size:10px; color:#fff; margin-top:10px;">{{ now()->translatedFormat('F Y') }}</span>
        </div>

        {{-- 2. Log pendientes --}}
        <div class="card-stat" style="background:linear-gradient(135deg,#F09060,#F0C040); border-radius:14px; padding:18px 20px; position:relative; overflow:hidden; box-shadow:0 4px 12px rgba(240,144,96,0.35);">
            <div style="position:absolute;top:14px;right:16px;opacity:0.55;">
                <svg width="36" height="36" fill="none" stroke="#fff" stroke-width="1.5" viewBox="0 0 24 24">
                    <path d="M21 10H3M21 6H3M21 14H3M21 18H3"/>
                </svg>
            </div>
            <div style="font-size:11px; color:rgba(255,255,255,0.85); margin-bottom:6px; font-weight:500;">Log pendientes</div>
            <div style="font-size:36px; font-weight:700; color:#fff; line-height:1;">{{ $stats['log_pendientes'] }}</div>
            <span style="display:inline-flex; background:rgba(255,255,255,0.22); border-radius:20px; padding:3px 10px; font-size:10px; color:#fff; margin-top:10px;">sin entregar</span>
        </div>

        {{-- 3. Log devueltos --}}
        <div class="card-stat" style="background:linear-gradient(135deg,#4ABFB0,#60A8E0); border-radius:14px; padding:18px 20px; position:relative; overflow:hidden; box-shadow:0 4px 12px rgba(74,191,176,0.35);">
            <div style="position:absolute;top:14px;right:16px;opacity:0.55;">
                <svg width="36" height="36" fill="none" stroke="#fff" stroke-width="1.5" viewBox="0 0 24 24">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
            </div>
            <div style="font-size:11px; color:rgba(255,255,255,0.85); margin-bottom:6px; font-weight:500;">Log devueltos</div>
            <div style="font-size:36px; font-weight:700; color:#fff; line-height:1;">{{ $stats['log_devueltos'] }}</div>
            <span style="display:inline-flex; background:rgba(255,255,255,0.22); border-radius:20px; padding:3px 10px; font-size:10px; color:#fff; margin-top:10px;">materiales recuperados</span>
        </div>

    </div>

    {{-- LOG PENDIENTES TABLA --}}
    <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; overflow:hidden; box-shadow:0 1px 4px rgba(0,0,0,0.04); margin-bottom:14px;">
        <div style="padding:12px 16px; border-bottom:1px solid #f3f4f6; display:flex; justify-content:space-between; align-items:center;">
            <span style="font-size:13px; font-weight:600; color:#374151;">Log pendientes de devolución</span>
            <a href="{{ route('secretaria.sin-nota.log') }}" style="font-size:12px; color:#2563eb; text-decoration:none;">Ver todos →</a>
        </div>
        <table style="width:100%; border-collapse:collapse; font-size:12px;">
            <thead>
                <tr style="background:#f8fafc;">
                    <th style="padding:8px 16px; text-align:left; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Código</th>
                    <th style="padding:8px 16px; text-align:left; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Organización</th>
                    <th style="padding:8px 16px; text-align:left; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Urnas</th>
                    <th style="padding:8px 16px; text-align:left; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Cuartos</th>
                    <th style="padding:8px 16px; text-align:left; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Tintas</th>
                    <th style="padding:8px 16px; text-align:left; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;"></th>
                </tr>
            </thead>
            <tbody>
                @php
                    $logPendientes = \App\Models\EntradaConNota::where('asunto_log', true)
    ->where('log_estado', 'entregada')
    ->latest()->take(5)->get();
                @endphp
                @forelse($logPendientes as $entrada)
                <tr style="border-bottom:1px solid #f3f4f6;">
                    <td style="padding:10px 16px; color:#185FA5; font-weight:600; font-family:monospace;">{{ $entrada->codigo_org }}</td>
                    <td style="padding:10px 16px; color:#1e293b;">{{ $entrada->nombre_organizacion }}</td>
                    <td style="padding:10px 16px; color:#374151;">{{ $entrada->log_urnas }}</td>
                    <td style="padding:10px 16px; color:#374151;">{{ $entrada->log_cuartos }}</td>
                    <td style="padding:10px 16px; color:#374151;">{{ $entrada->log_tintas }}</td>
                    <td style="padding:10px 16px;">
                        <a href="{{ route('secretaria.sin-nota.log') }}"
                           style="font-size:12px; color:#2563eb; text-decoration:none; font-weight:500;">Ver →</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding:30px; text-align:center; color:#94a3b8; font-size:13px;">
                        ✅ No hay log pendientes de devolución.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ENTRADAS SIN NOTA RECIENTES --}}
    <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; overflow:hidden; box-shadow:0 1px 4px rgba(0,0,0,0.04);">
        <div style="padding:12px 16px; border-bottom:1px solid #f3f4f6; display:flex; justify-content:space-between; align-items:center;">
            <span style="font-size:13px; font-weight:600; color:#374151;">Últimas entradas sin nota</span>
            <a href="{{ route('secretaria.sin-nota.index') }}" style="font-size:12px; color:#2563eb; text-decoration:none;">Ver todas →</a>
        </div>
        <table style="width:100%; border-collapse:collapse; font-size:12px;">
            <thead>
                <tr style="background:#f8fafc;">
                    <th style="padding:8px 16px; text-align:left; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">N° Entrada</th>
                    <th style="padding:8px 16px; text-align:left; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Nombre</th>
                    <th style="padding:8px 16px; text-align:left; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Apellido</th>
                    <th style="padding:8px 16px; text-align:left; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Asesor</th>
                    <th style="padding:8px 16px; text-align:left; font-size:11px; color:#6b7280; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Fecha</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $ultimasEntradas = \App\Models\EntradaSinNota::with('asesor')->latest()->take(5)->get();
                @endphp
                @forelse($ultimasEntradas as $entrada)
                <tr style="border-bottom:1px solid #f3f4f6;">
                    <td style="padding:10px 16px; color:#6b7280; font-weight:600; font-family:monospace;">{{ $entrada->numero_entrada }}</td>
                    <td style="padding:10px 16px; color:#1e293b; font-weight:500;">{{ $entrada->nombre }}</td>
                    <td style="padding:10px 16px; color:#374151;">{{ $entrada->apellido }}</td>
                    <td style="padding:10px 16px; color:#374151;">{{ $entrada->asesor ? $entrada->asesor->nombre . ' ' . $entrada->asesor->apellido : '—' }}</td>
                    <td style="padding:10px 16px; color:#94a3b8;">{{ $entrada->created_at->format('d/m/Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding:30px; text-align:center; color:#94a3b8; font-size:13px;">
                        No hay entradas registradas.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
</x-panel-layout>
