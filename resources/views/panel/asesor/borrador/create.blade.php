<x-panel-layout title="Nuevo Borrador Privado">
<div class="px-2 py-2">
    <div style="max-width:760px; margin:0 auto;">

        @if(session('error'))
        <div style="background:#fee2e2; color:#991b1b; padding:10px 14px; border-radius:8px; margin-bottom:14px; font-size:13px;">
            {{ session('error') }}
        </div>
        @endif

        <form method="POST" action="{{ route('asesor.borrador.store') }}">
            @csrf

            {{-- DATOS --}}
            <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:20px; margin-bottom:14px; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
                <h3 style="font-size:13px; font-weight:600; color:#374151; margin-bottom:16px; padding-bottom:10px; border-bottom:1px solid #f3f4f6; text-transform:uppercase; letter-spacing:0.5px;">Datos de la organización</h3>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:12px;">
                    <div>
                        <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Nombre de la organización *</label>
                        <input type="text" name="nombre_organizacion" value="{{ old('nombre_organizacion') }}"
                               style="width:100%; border:1px solid {{ $errors->has('nombre_organizacion') ? '#f87171' : '#e5e7eb' }}; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
                        @error('nombre_organizacion')<p style="color:#ef4444; font-size:11px; margin-top:3px;">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Tipo de organización</label>
                        <select name="tipo_organizacion"
                                style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; background:#fff; box-sizing:border-box;">
                            <option value="">Seleccionar tipo...</option>
                            @foreach($tipos as $tipo)
                                <option value="{{ $tipo->nombre }}" {{ old('tipo_organizacion') == $tipo->nombre ? 'selected' : '' }}>{{ $tipo->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:12px;">
                    <div>
                        <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Nombre del representante</label>
                        <input type="text" name="nombre_representante" value="{{ old('nombre_representante') }}"
                               placeholder="Opcional"
                               style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
                    </div>
                    <div>
                        <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Teléfono del representante</label>
                        <input type="text" name="telefono_representante" value="{{ old('telefono_representante') }}"
                               placeholder="Opcional"
                               style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
                    </div>
                </div>

                <div>
                    <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Notas generales</label>
                    <textarea name="notas_generales" rows="3" placeholder="Contexto inicial, cómo surgió el contacto, etc."
                              style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box; resize:vertical;">{{ old('notas_generales') }}</textarea>
                </div>
            </div>

            {{-- BOTONES --}}
            <div style="display:flex; justify-content:flex-end; gap:10px;">
                <a href="{{ route('asesor.borrador.index') }}"
                   style="display:inline-flex; align-items:center; gap:6px; background:#f3f4f6; color:#374151; padding:8px 18px; border-radius:8px; font-size:13px; text-decoration:none;">
                    Cancelar
                </a>
                <button type="submit"
                        style="display:inline-flex; align-items:center; gap:6px; background:#2563eb; color:white; padding:8px 18px; border-radius:8px; font-size:13px; border:none; cursor:pointer; font-weight:500;">
                    Guardar borrador
                </button>
            </div>
        </form>
    </div>
</div>
</x-panel-layout>
