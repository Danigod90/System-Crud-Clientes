<x-panel-layout title="Detalle de Entrada Sin Nota">
<div class="px-2 py-2">
    <div style="max-width:560px; margin:0 auto;">

        @if(session('success'))
        <div style="background:#d1fae5; color:#065f46; padding:10px 14px; border-radius:8px; margin-bottom:14px; font-size:13px;">
            {{ session('success') }}
        </div>
        @endif

        <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:24px; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
            <div style="margin-bottom:20px; padding-bottom:12px; border-bottom:1px solid #f3f4f6;">
                <p style="font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin:0 0 4px;">N° de Entrada</p>
                <p style="font-size:22px; font-weight:700; color:#2563eb; margin:0;">{{ $sinNota->numero_entrada }}</p>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:20px;">
                <div style="grid-column: span 2;">
    <p style="font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin:0 0 3px;">Nombre/s y Apellido/s</p>
    <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ $sinNota->nombre_completo }}</p>
</div>
                <div>
                    <p style="font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin:0 0 3px;">Teléfono</p>
                    <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ $sinNota->telefono ?? '—' }}</p>
                </div>
                <div>
                    <p style="font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin:0 0 3px;">Tipo de Servicio</p>
                    <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ $sinNota->tipo_charla }}</p>
                </div>
                <div>
                    <p style="font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin:0 0 3px;">Asesor que atendió</p>
                    <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ $sinNota->asesor ? $sinNota->asesor->nombre . ' ' . $sinNota->asesor->apellido : '—' }}</p>
                </div>
                <div>
                    <p style="font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin:0 0 3px;">Fecha de Atención</p>
                    <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ $sinNota->fecha ? \Carbon\Carbon::parse($sinNota->fecha)->format('d/m/Y') : '—' }}</p>
                </div>
                <div>
                    <p style="font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin:0 0 3px;">Registrado por</p>
                    <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ $sinNota->user ? $sinNota->user->name : '—' }}</p>
                </div>
            </div>

            <div style="display:flex; gap:10px; padding-top:16px; border-top:1px solid #f3f4f6;">
                <a href="{{ route('secretaria.sin-nota.edit', $sinNota) }}"
                   style="padding:8px 18px; border-radius:8px; border:none; background:#f59e0b; color:white; font-size:13px; text-decoration:none; font-weight:500;">
                    Editar
                </a>
                <form method="POST" action="{{ route('secretaria.sin-nota.destroy', $sinNota) }}"
                      onsubmit="return confirm('¿Estás seguro de eliminar esta entrada?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                            style="padding:8px 18px; border-radius:8px; border:none; background:#dc2626; color:white; font-size:13px; cursor:pointer; font-weight:500;">
                        Eliminar
                    </button>
                </form>
                <a href="{{ route('secretaria.sin-nota.index') }}"
                   style="padding:8px 18px; border-radius:8px; border:1px solid #e5e7eb; background:white; color:#374151; font-size:13px; text-decoration:none; font-weight:500;">
                    Volver al listado
                </a>
            </div>
        </div>

    </div>
</div>
</x-panel-layout>
