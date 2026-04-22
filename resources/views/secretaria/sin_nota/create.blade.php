<x-panel-layout title="Nueva Entrada Sin Nota">
<div class="px-2 py-2">
    <div style="max-width:560px; margin:0 auto;">

        @if($errors->any())
        <div style="background:#fee2e2; color:#991b1b; padding:10px 14px; border-radius:8px; margin-bottom:14px; font-size:13px;">
            <ul style="margin:0; padding-left:16px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:24px; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
            <div style="margin-bottom:20px; padding-bottom:12px; border-bottom:1px solid #f3f4f6;">
                <h3 style="font-size:14px; font-weight:700; color:#1e293b; margin:0;">Nueva Entrada Sin Nota</h3>
                <p style="font-size:12px; color:#94a3b8; margin:4px 0 0;">Registrar atención sin expediente</p>
            </div>

            <form method="POST" action="{{ route('secretaria.sin-nota.store') }}">
                @csrf

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:12px;">
                    <div>
                        <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Nombre *</label>
                        <input type="text" name="nombre" value="{{ old('nombre') }}" required
                               style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
                    </div>
                    <div>
                        <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Apellido *</label>
                        <input type="text" name="apellido" value="{{ old('apellido') }}" required
                               style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
                    </div>
                </div>

                <div style="margin-bottom:12px;">
                    <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Teléfono <span style="font-weight:400; text-transform:none;">(opcional)</span></label>
                    <input type="text" name="telefono" value="{{ old('telefono') }}" placeholder="Ej: 0981 123 456"
                           style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
                </div>
<div style="margin-bottom:12px;">
    <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Fecha *</label>
    <input type="date" name="fecha" value="{{ old('fecha', date('Y-m-d')) }}" required
           style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
</div>
                <div style="margin-bottom:12px;">
                    <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Tipo de Servicio *</label>
                    <select name="tipo_charla" required
                            style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; background:#fff; box-sizing:border-box;">
                        <option value="">Seleccionar...</option>
                        <option value="Asesoramiento Electoral" {{ old('tipo_charla') == 'Asesoramiento Electoral' ? 'selected' : '' }}>Asesoramiento Electoral</option>
                        <option value="Charla para Miembros de Mesa" {{ old('tipo_charla') == 'Charla para Miembros de Mesa' ? 'selected' : '' }}>Charla para Miembros de Mesa</option>
                        <option value="Materiales Entregados" {{ old('tipo_charla') == 'Materiales Entregados' ? 'selected' : '' }}>Materiales Entregados</option>
                    </select>
                </div>

                <div style="margin-bottom:20px;">
                    <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Asesor que atendió <span style="font-weight:400; text-transform:none;">(opcional)</span></label>
                    <select name="asesor_id"
                            style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; background:#fff; box-sizing:border-box;">
                        <option value="">Sin asesor asignado</option>
                        @foreach($asesores as $asesor)
                            <option value="{{ $asesor->id }}" {{ old('asesor_id') == $asesor->id ? 'selected' : '' }}>
                                {{ $asesor->nombre }} {{ $asesor->apellido }}
                                @if($asesor->cargo) — {{ $asesor->cargo }} @endif
                            </option>
                        @endforeach
                    </select>
                </div>

                <div style="display:flex; gap:10px; justify-content:flex-end;">
                    <a href="{{ route('secretaria.sin-nota.index') }}"
                       style="padding:8px 18px; border-radius:8px; border:1px solid #e5e7eb; background:white; color:#374151; font-size:13px; text-decoration:none; font-weight:500;">
                        Cancelar
                    </a>
                    <button type="submit"
                            style="padding:8px 18px; border-radius:8px; border:none; background:#2563eb; color:white; font-size:13px; cursor:pointer; font-weight:500;">
                        Registrar Entrada
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
</x-panel-layout>
