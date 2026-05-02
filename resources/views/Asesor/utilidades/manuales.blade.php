<x-panel-layout title="Manuales" :charlasPendientes="$charlasPendientes">

<style>
.manual-row { transition: background 0.15s; }
.manual-row:hover { background: #f9fafb; }
</style>

<div style="max-width:800px; margin:0 auto; padding:0 8px 40px;">

    <div style="background:linear-gradient(135deg, #1e3a5f 0%, #0f2444 100%); border-radius:16px; padding:24px 28px; margin-bottom:20px;">
        <h1 style="font-size:20px; font-weight:700; color:#fff; margin:0 0 4px;">📂 Manuales</h1>
        <p style="font-size:13px; color:rgba(255,255,255,0.6); margin:0;">Documentos y recursos para asesores</p>
    </div>

    @if(session('success'))
    <div style="background:#d1fae5; color:#065f46; padding:10px 16px; border-radius:10px; margin-bottom:14px; font-size:13px; border-left:4px solid #16a34a;">
        {{ session('success') }}
    </div>
    @endif

    {{-- LISTA DE MANUALES --}}
    <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:20px; margin-bottom:16px; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
        <h2 style="font-size:12px; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:0.8px; margin:0 0 16px;">
            Archivos disponibles
            <span style="font-weight:400; text-transform:none;">— {{ $manuales->count() }} archivo(s)</span>
        </h2>

        @forelse($manuales as $manual)
        <div class="manual-row" style="display:flex; align-items:center; gap:10px; padding:10px; border:1px solid #e5e7eb; border-radius:8px; margin-bottom:8px;">

            {{-- ÍCONO --}}
            <div style="flex-shrink:0; font-size:20px;">
                @if($manual->extension == 'pdf') 📄
                @elseif(in_array($manual->extension, ['doc','docx'])) 📝
                @elseif(in_array($manual->extension, ['xls','xlsx'])) 📊
                @elseif(in_array($manual->extension, ['jpg','jpeg','png','gif'])) 🖼
                @else 📎
                @endif
            </div>

            {{-- NOMBRE (editable inline) --}}
            <div style="flex:1; min-width:0;">
                <div id="nombre-readonly-{{ $manual->id }}">
                    <p style="font-size:13px; font-weight:600; color:#111827; margin:0; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ $manual->nombre }}</p>
                    <p style="font-size:10px; color:#9ca3af; margin:2px 0 0;">{{ strtoupper($manual->extension) }} · {{ number_format($manual->tamanio / 1024, 1) }} KB · {{ $manual->user->name ?? '—' }} · {{ $manual->created_at->format('d/m/Y') }}</p>
                </div>
                <div id="nombre-edit-{{ $manual->id }}" style="display:none;">
                    <form method="POST" action="{{ route('asesor.manuales.update', $manual->id) }}" style="display:flex; gap:6px; align-items:center;">
                        @csrf @method('PATCH')
                        <input type="text" name="nombre" value="{{ $manual->nombre }}"
                               style="flex:1; border:1px solid #2563eb; border-radius:6px; padding:5px 8px; font-size:13px; color:#111827; outline:none;">
                        <button type="submit" style="background:#2563eb; color:white; border:none; border-radius:6px; padding:5px 12px; font-size:12px; cursor:pointer; font-weight:500;">Guardar</button>
                        <button type="button" onclick="cancelarEdicion({{ $manual->id }})" style="background:#f3f4f6; color:#374151; border:none; border-radius:6px; padding:5px 10px; font-size:12px; cursor:pointer;">Cancelar</button>
                    </form>
                </div>
            </div>

            {{-- ACCIONES --}}
            <div style="display:flex; gap:6px; flex-shrink:0;">
                <a href="{{ route('asesor.manuales.show', $manual->id) }}" target="_blank"
                   style="display:inline-flex; align-items:center; gap:4px; background:#eff6ff; color:#2563eb; padding:5px 10px; border-radius:6px; font-size:11px; text-decoration:none; font-weight:500;">
                    Ver
                </a>
                <button onclick="activarEdicion({{ $manual->id }})"
                        style="display:inline-flex; align-items:center; gap:4px; background:#fef3c7; color:#92400e; padding:5px 10px; border-radius:6px; font-size:11px; border:none; cursor:pointer; font-weight:500;">
                    ✏️ Editar
                </button>
                <form method="POST" action="{{ route('asesor.manuales.destroy', $manual->id) }}">
                    @csrf @method('DELETE')
                    <button type="submit" onclick="return confirm('¿Eliminar este manual?')"
                            style="display:inline-flex; align-items:center; gap:4px; background:#fef2f2; color:#dc2626; padding:5px 10px; border-radius:6px; font-size:11px; border:none; cursor:pointer; font-weight:500;">
                        Eliminar
                    </button>
                </form>
            </div>
        </div>
        @empty
        <p style="font-size:13px; color:#9ca3af; text-align:center; padding:20px 0; margin:0;">No hay manuales cargados aún.</p>
        @endforelse
    </div>

    {{-- FORM SUBIR --}}
    <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:20px; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
        <h2 style="font-size:12px; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:0.8px; margin:0 0 16px;">Subir nuevo manual</h2>
        <form method="POST" action="{{ route('asesor.manuales.store') }}" enctype="multipart/form-data">
            @csrf
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:12px;">
                <div>
                    <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Nombre del documento</label>
                    <input type="text" name="nombre" placeholder="Ej: Manual de procedimientos..."
                           style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
                </div>
                <div>
                    <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Archivo (máx. 10MB)</label>
                    <input type="file" name="archivo" required
                           style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:6px 10px; font-size:12px; color:#374151; outline:none; box-sizing:border-box; background:#fff;">
                </div>
            </div>
            <div style="display:flex; justify-content:flex-end;">
                <button type="submit"
                        style="display:inline-flex; align-items:center; gap:6px; background:#1e3a5f; color:white; padding:8px 18px; border-radius:8px; font-size:13px; border:none; cursor:pointer; font-weight:500;">
                    Subir manual
                </button>
            </div>
        </form>
    </div>

</div>

<script>
function activarEdicion(id) {
    document.getElementById('nombre-readonly-' + id).style.display = 'none';
    document.getElementById('nombre-edit-' + id).style.display = 'block';
}
function cancelarEdicion(id) {
    document.getElementById('nombre-readonly-' + id).style.display = 'block';
    document.getElementById('nombre-edit-' + id).style.display = 'none';
}
</script>

</x-panel-layout>
