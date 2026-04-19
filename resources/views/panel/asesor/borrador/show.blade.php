<x-panel-layout title="Borrador Privado">
<div class="px-2 py-2">
    <div style="max-width:860px; margin:0 auto;">

        @if(session('success'))
        <div style="background:#d1fae5; color:#065f46; padding:10px 14px; border-radius:8px; margin-bottom:14px; font-size:13px;">
            {{ session('success') }}
        </div>
        @endif

        {{-- HEADER --}}
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
            <div>
                <a href="{{ route('asesor.borrador.index') }}" style="font-size:12px; color:#94a3b8; text-decoration:none;">← Volver</a>
                <h2 style="font-size:16px; font-weight:700; color:#1e293b; margin:4px 0 0;">{{ $borrador->nombre_organizacion }}</h2>
                <p style="font-size:12px; color:#94a3b8; margin:2px 0 0;">
                    {{ $borrador->tipo_organizacion ?? 'Sin tipo' }}
                    @if($borrador->nombre_representante) · {{ $borrador->nombre_representante }} @endif
                    @if($borrador->telefono_representante) · {{ $borrador->telefono_representante }} @endif
                </p>
            </div>
            <div style="display:flex; gap:8px; align-items:center;">
                @if($borrador->estado === 'activo')
                <button onclick="document.getElementById('modal-mesa').style.display='flex'"
                        style="display:inline-flex; align-items:center; gap:6px; background:#0f172a; color:white; padding:8px 14px; border-radius:8px; font-size:12px; border:none; cursor:pointer; font-weight:500;">
                    📋 Pasar a Mesa de Entrada
                </button>
                @else
                <span style="background:#dbeafe; color:#1d4ed8; font-size:11px; font-weight:600; padding:4px 12px; border-radius:20px;">
                    Enviado a Mesa de Entrada
                </span>
                @endif

                <form method="POST" action="{{ route('asesor.borrador.destroy', $borrador->id) }}"
                      onsubmit="return confirm('¿Eliminar este borrador?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                            style="display:inline-flex; align-items:center; background:#fee2e2; color:#991b1b; padding:8px 12px; border-radius:8px; font-size:12px; border:none; cursor:pointer;">
                        🗑
                    </button>
                </form>
            </div>
        </div>

        {{-- NOTAS GENERALES --}}
        @if($borrador->notas_generales)
        <div style="background:#fefce8; border:1px solid #fde68a; border-radius:12px; padding:14px 18px; margin-bottom:14px;">
            <p style="font-size:11px; font-weight:600; color:#92400e; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Notas generales</p>
            <p style="font-size:13px; color:#374151; margin:0;">{{ $borrador->notas_generales }}</p>
        </div>
        @endif

        {{-- TAREAS --}}
        <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:20px; margin-bottom:14px; box-shadow:0 1px 4px rgba(0,0,0,0.04);">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px; padding-bottom:10px; border-bottom:1px solid #f3f4f6;">
                <h3 style="font-size:13px; font-weight:600; color:#374151; margin:0; text-transform:uppercase; letter-spacing:0.5px;">Seguimiento</h3>
                <button onclick="document.getElementById('form-tarea').style.display = document.getElementById('form-tarea').style.display === 'none' ? 'block' : 'none'"
                        style="display:inline-flex; align-items:center; gap:5px; background:#2563eb; color:white; padding:6px 12px; border-radius:8px; font-size:12px; border:none; cursor:pointer; font-weight:500;">
                    + Nueva tarea
                </button>
            </div>

            {{-- FORM NUEVA TAREA --}}
            <div id="form-tarea" style="display:none; background:#f8fafc; border-radius:10px; padding:16px; margin-bottom:16px; border:1px solid #e2e8f0;">
                <form method="POST" action="{{ route('asesor.borrador.storeTarea', $borrador->id) }}">
                    @csrf
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:12px;">
                        <div>
                            <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Tipo *</label>
                            <select name="tipo" style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; background:#fff; box-sizing:border-box;">
                                <option value="">Seleccionar...</option>
                                <option value="Charla">Charla</option>
                                <option value="Asesoramiento">Asesoramiento</option>
                                <option value="Visita">Visita</option>
                                <option value="Reunión">Reunión</option>
                                <option value="Llamada">Llamada</option>
                                <option value="Otro">Otro</option>
                            </select>
                        </div>
                        <div>
                            <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Fecha *</label>
                            <input type="date" name="fecha" value="{{ date('Y-m-d') }}"
                                   style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box;">
                        </div>
                    </div>
                    <div style="margin-bottom:12px;">
                        <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Nota *</label>
                        <textarea name="nota" rows="3" placeholder="Describí lo que se trató, acordó o pendiente..."
                                  style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box; resize:vertical;"></textarea>
                    </div>
                    <div style="display:flex; justify-content:flex-end; gap:8px;">
                        <button type="button" onclick="document.getElementById('form-tarea').style.display='none'"
                                style="padding:7px 14px; border-radius:8px; border:1px solid #e5e7eb; background:white; color:#374151; font-size:12px; cursor:pointer;">
                            Cancelar
                        </button>
                        <button type="submit"
                                style="padding:7px 14px; border-radius:8px; border:none; background:#2563eb; color:white; font-size:12px; cursor:pointer; font-weight:500;">
                            Guardar tarea
                        </button>
                    </div>
                </form>
            </div>

            {{-- LISTA TAREAS --}}
            @forelse($borrador->tareas as $tarea)
            <div style="border-left:3px solid #2563eb; padding:10px 14px; margin-bottom:10px; background:#f8fafc; border-radius:0 8px 8px 0;">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:4px;">
                    <span style="font-size:12px; font-weight:600; color:#2563eb;">{{ $tarea->tipo }}</span>
                    <span style="font-size:11px; color:#94a3b8;">{{ \Carbon\Carbon::parse($tarea->fecha)->format('d/m/Y') }}</span>
                </div>
                <p style="font-size:13px; color:#374151; margin:0;">{{ $tarea->nota }}</p>
            </div>
            @empty
            <div style="text-align:center; padding:30px; color:#94a3b8;">
                <p style="font-size:13px;">Sin tareas todavía. Presioná <strong>+ Nueva tarea</strong> para registrar una actividad.</p>
            </div>
            @endforelse
        </div>

    </div>
</div>

{{-- MODAL MESA DE ENTRADA --}}
<div id="modal-mesa" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.4); z-index:50; align-items:center; justify-content:center;">
    <div style="background:white; border-radius:12px; padding:28px; max-width:440px; width:90%; box-shadow:0 20px 60px rgba(0,0,0,0.3);">
        <h3 style="font-size:15px; font-weight:700; color:#1e293b; margin-bottom:6px;">Pasar a Mesa de Entrada</h3>
        <p style="font-size:12px; color:#64748b; margin-bottom:18px;">Se creará una entrada oficial con los siguientes datos:</p>

        <div style="background:#f8fafc; border-radius:8px; padding:14px; margin-bottom:18px; font-size:13px; color:#374151;">
            <div style="margin-bottom:6px;"><strong>Organización:</strong> {{ $borrador->nombre_organizacion }}</div>
            <div style="margin-bottom:6px;"><strong>Tipo:</strong> {{ $borrador->tipo_organizacion ?? '—' }}</div>
            <div><strong>Representante:</strong> {{ $borrador->nombre_representante ?? '—' }}</div>
        </div>

        <p style="font-size:11px; color:#94a3b8; margin-bottom:18px;">El borrador quedará marcado como <em>Enviado</em> y no se eliminará.</p>

        <div style="display:flex; gap:10px; justify-content:flex-end;">
            <button onclick="document.getElementById('modal-mesa').style.display='none'"
                    style="padding:8px 18px; border-radius:8px; border:1px solid #e5e7eb; background:white; color:#374151; font-size:13px; cursor:pointer;">
                Cancelar
            </button>
            <form method="POST" action="{{ route('asesor.borrador.enviar', $borrador->id) }}">
                @csrf
                <button type="submit"
                        style="padding:8px 18px; border-radius:8px; border:none; background:#0f172a; color:white; font-size:13px; cursor:pointer; font-weight:500;">
                    Confirmar y enviar
                </button>
            </form>
        </div>
    </div>
</div>

</x-panel-layout>
