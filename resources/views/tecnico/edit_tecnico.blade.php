<x-panel-layout title="Panel Técnico — {{ $entrada->codigo_org }}">

<div class="px-2 py-2">
    <div style="max-width:760px; margin:0 auto;">

        {{-- DATOS DE LA ORGANIZACIÓN --}}
        <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:20px; margin-bottom:14px; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px; padding-bottom:10px; border-bottom:1px solid #f3f4f6;">
                <h3 style="font-size:13px; font-weight:600; color:#374151; text-transform:uppercase; letter-spacing:0.5px; margin:0;">Datos de la organización</h3>
                <a href="{{ route('tecnico.organizaciones') }}"
                   style="display:inline-flex; align-items:center; gap:6px; background:#f3f4f6; color:#374151; padding:6px 14px; border-radius:8px; font-size:12px; text-decoration:none; font-weight:500;">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <polyline points="15 18 9 12 15 6"/>
                    </svg>
                    Volver
                </a>
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                <div>
                    <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Organización</label>
                    <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ $entrada->nombre_organizacion }}</p>
                    <p style="font-size:12px; color:#6b7280; margin:2px 0 0;">{{ $entrada->tipo_organizacion }}</p>
                </div>
                <div>
                    <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Representante</label>
                    <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ $entrada->nombre_representante }}</p>
                    @if($entrada->telefono_representante)
                    <p style="font-size:12px; color:#6b7280; margin:2px 0 0;">{{ $entrada->telefono_representante }}</p>
                    @endif
                </div>
                <div>
                    <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Fecha de elección</label>
                    <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ $entrada->fecha_eleccion?->format('d/m/Y') ?? '—' }}</p>
                </div>
                <div>
                    <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Asunto</label>
                    <p style="font-size:14px; font-weight:700; color:#111827; font-family:monospace; margin:0;">{{ $entrada->asunto_texto }}</p>
                </div>
            </div>
        </div>

        {{-- SECCIÓN LOGÍSTICA (solo lectura) --}}
        @if($entrada->asunto_log)
        <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:20px; margin-bottom:14px; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
            <div style="margin-bottom:16px; padding-bottom:10px; border-bottom:1px solid #f3f4f6;">
                <h3 style="font-size:13px; font-weight:600; color:#374151; text-transform:uppercase; letter-spacing:0.5px; margin:0; display:flex; align-items:center; gap:8px;">
                    Detalle Logístico
                    @php $logDot = ($entrada->log_estado ?? 'pendiente') === 'entregada' ? '#16a34a' : '#eab308'; @endphp
                    <span style="display:inline-flex; align-items:center; gap:4px; font-size:11px; font-weight:500; color:#6b7280; text-transform:none;">
                        <span style="width:9px; height:9px; border-radius:50%; background:{{ $logDot }}; display:inline-block;"></span>
                        {{ ($entrada->log_estado ?? 'pendiente') === 'entregada' ? 'Entregada' : 'Pendiente' }}
                    </span>
                </h3>
            </div>
            <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:12px;">
                <div style="text-align:center;">
                    <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Urnas</label>
                    <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ $entrada->log_urnas ?? 0 }}</p>
                </div>
                <div style="text-align:center;">
                    <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Cuartos oscuros</label>
                    <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ $entrada->log_cuartos ?? 0 }}</p>
                </div>
                <div style="text-align:center;">
                    <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Tintas</label>
                    <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ $entrada->log_tintas ?? 0 }}</p>
                </div>
            </div>
        </div>
        @endif

        {{-- DATOS DEL ASESOR --}}
@if($entrada->detalleTecnico)
<div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:20px; margin-bottom:14px; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px; padding-bottom:10px; border-bottom:1px solid #f3f4f6;">
        <h3 style="font-size:13px; font-weight:600; color:#374151; text-transform:uppercase; letter-spacing:0.5px; margin:0; display:flex; align-items:center; gap:8px;">
            Datos del Asesor
            @php $tecDot = $entrada->detalleTecnico->enviado_tecnica ? '#16a34a' : '#eab308'; @endphp
            <span style="display:inline-flex; align-items:center; gap:4px; font-size:11px; font-weight:500; color:#6b7280; text-transform:none;">
                <span style="width:9px; height:9px; border-radius:50%; background:{{ $tecDot }}; display:inline-block;"></span>
                {{ $entrada->detalleTecnico->enviado_tecnica ? 'Enviado a Técnica' : 'Pendiente' }}
            </span>
        </h3>
        <button id="btn-editar-asesor" onclick="activarEdicionAsesor()"
                style="display:inline-flex; align-items:center; gap:6px; background:#f3f4f6; color:#374151; padding:6px 14px; border-radius:8px; font-size:12px; border:none; cursor:pointer; font-weight:500;">
            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
            </svg>
            Editar
        </button>
    </div>

    {{-- SOLO LECTURA --}}
    <div id="asesor-readonly" style="display:block;">
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:12px;">
            <div>
                <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Órgano Electoral</label>
                <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ $entrada->detalleTecnico->organo_electoral ?? '—' }}</p>
            </div>
            <div>
                <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Cantidad de Listas</label>
                <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ $entrada->detalleTecnico->cantidad_listas ?? '—' }}</p>
            </div>
            <div>
                <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Cantidad de Papeletas</label>
                <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ $entrada->detalleTecnico->cantidad_papeletas ?? '—' }}</p>
            </div>
            <div>
                <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Cantidad de Mesas</label>
                <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ $entrada->detalleTecnico->cantidad_mesas ?? '—' }}</p>
            </div>
        </div>

        {{-- PAPELETAS SOLO LECTURA --}}
        @php
            $cantPapRO = $entrada->detalleTecnico->cantidad_papeletas ?? 0;
            $ordinalRO = ['Primera','Segunda','Tercera','Cuarta','Quinta','Sexta','Séptima','Octava','Novena','Décima'];
        @endphp
        @if($cantPapRO > 0)
        <div style="margin-bottom:12px;">
            <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:8px; text-transform:uppercase; letter-spacing:0.5px;">Papeletas</label>
            @for($p = 1; $p <= min($cantPapRO, 10); $p++)
            @php
                $candidaturaRO = $entrada->detalleTecnico->{"pap_{$p}_lista_1_candidatura"} ?? '—';
                $sistemaRO     = $entrada->detalleTecnico->{"pap_{$p}_sistema_eleccion"} ?? '—';
            @endphp
            <div style="display:flex; align-items:center; gap:12px; padding:8px 12px; background:#f9fafb; border:1px solid #e5e7eb; border-radius:8px; margin-bottom:6px;">
                <span style="font-size:12px; font-weight:700; color:#374151; white-space:nowrap;">{{ $ordinalRO[$p-1] }}</span>
                <span style="font-size:13px; color:#111827; flex:1;">{{ $candidaturaRO }}</span>
                <span style="font-size:11px; color:#6b7280; white-space:nowrap;">{{ $sistemaRO }}</span>
            </div>
            @endfor
        </div>
        @endif

        {{-- ESTIMADO --}}
        @if($entrada->detalleTecnico->cantidad_mesas && $entrada->detalleTecnico->cantidad_papeletas)
        @php
            $mesasRO    = $entrada->detalleTecnico->cantidad_mesas;
            $papeletasRO = $entrada->detalleTecnico->cantidad_papeletas;
            $actasRO    = $mesasRO * 3;
            $padronesRO = $mesasRO * 3;
            $cuartosRO  = $mesasRO;
            $urnasRO    = $mesasRO * $papeletasRO;
        @endphp
        <div style="background:#eff6ff; border:1px solid #bfdbfe; border-radius:8px; padding:12px 16px;">
            <p style="font-size:11px; font-weight:700; color:#1e40af; text-transform:uppercase; margin:0 0 10px;">Estimado de materiales</p>
            <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:8px;">
                <div style="text-align:center;">
                    <p style="font-size:11px; color:#6b7280; margin:0 0 2px;">Actas</p>
                    <p style="font-size:18px; font-weight:700; color:#1e40af; margin:0;">{{ $actasRO }}</p>
                </div>
                <div style="text-align:center;">
                    <p style="font-size:11px; color:#6b7280; margin:0 0 2px;">Padrones</p>
                    <p style="font-size:18px; font-weight:700; color:#1e40af; margin:0;">{{ $padronesRO }}</p>
                </div>
                <div style="text-align:center;">
                    <p style="font-size:11px; color:#6b7280; margin:0 0 2px;">Cuartos Oscuros</p>
                    <p style="font-size:18px; font-weight:700; color:#1e40af; margin:0;">{{ $cuartosRO }}</p>
                </div>
                <div style="text-align:center;">
                    <p style="font-size:11px; color:#6b7280; margin:0 0 2px;">Urnas</p>
                    <p style="font-size:18px; font-weight:700; color:#1e40af; margin:0;">{{ $urnasRO }}</p>
                </div>
            </div>
        </div>
        @endif
    </div>

    {{-- FORMULARIO EDITABLE ASESOR --}}
    <form id="asesor-form" method="POST" action="{{ route('asesor.detalle_tecnico.saveAsesor', $entrada->id) }}"
          style="display:none;">
        @csrf

        <div style="margin-bottom:14px;">
            <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:8px; text-transform:uppercase; letter-spacing:0.5px;">Órgano Electoral</label>
            <div style="display:flex; gap:10px; flex-wrap:wrap;">
                @foreach(['TEI' => 'T.E.I.', 'JEI' => 'J.E.I.', 'CEI' => 'C.E.I.'] as $value => $label)
                <label style="display:flex; align-items:center; gap:8px; padding:8px 14px; border:1px solid #d1d5db; border-radius:8px; cursor:pointer; background:#fff;">
                    <input type="radio" name="organo_electoral" value="{{ $value }}"
                        {{ $entrada->detalleTecnico->organo_electoral == $value ? 'checked' : '' }}
                        style="width:15px; height:15px; accent-color:#2563eb;">
                    <span style="font-size:13px; font-weight:600; color:#374151;">{{ $label }}</span>
                </label>
                @endforeach
            </div>
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:12px; margin-bottom:14px;">
            <div>
                <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Cantidad de Listas</label>
                <input type="number" name="cantidad_listas" min="1" max="10"
                    value="{{ $entrada->detalleTecnico->cantidad_listas }}"
                    style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; background:#fff; box-sizing:border-box;">
            </div>
            <div>
                <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Cantidad de Papeletas</label>
                <input type="number" name="cantidad_papeletas" id="input_papeletas" min="1" max="10"
    value="{{ $entrada->detalleTecnico->cantidad_papeletas }}"
                    style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; background:#fff; box-sizing:border-box;">
            </div>
            <div>
                <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Cantidad de Mesas</label>
                <input type="number" name="cantidad_mesas" id="input_mesas" min="1"
    value="{{ $entrada->detalleTecnico->cantidad_mesas }}"
                    style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; background:#fff; box-sizing:border-box;">
            </div>
        </div>

        {{-- PAPELETAS --}}
        @php
            $cantPapTec = $entrada->detalleTecnico->cantidad_papeletas ?? 1;
            $cantListasTec = $entrada->detalleTecnico->cantidad_listas ?? 1;
            $candidaturasTec = ['Presidente y Vicepresidentes','Presidente y Vicepresidente','Secretario General y Adjunto','Comisión Directiva','Miembros Titulares','Miembros Titulares y Suplentes','Vocales Titulares','Vocales Titulares y Suplentes','Tribunal Electoral Independiente','Junta Electoral','Colegio Electoral','Síndico','Comité Revisadora de Cuentas'];
            $sistemasTec = ['Lista Única','Lista Cerrada','Lista Desbloqueada','Lista Cerrada Bloqueada','Nominal'];
            $ordinalTec = ['Primera','Segunda','Tercera','Cuarta','Quinta','Sexta','Séptima','Octava','Novena','Décima'];
        @endphp

        <div style="margin-bottom:14px;">
            <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:8px; text-transform:uppercase; letter-spacing:0.5px;">Papeletas</label>
            @for($p = 1; $p <= min($cantPapTec, 10); $p++)
            <div style="background:#f9fafb; border:1px solid #e5e7eb; border-radius:10px; padding:14px; margin-bottom:10px;">
                <p style="font-size:12px; font-weight:700; color:#374151; margin:0 0 10px;">{{ $ordinalTec[$p-1] }} Papeleta</p>
                <div style="display:flex; gap:8px; align-items:flex-start;">
                    <div style="flex:1; display:flex; flex-direction:column; gap:4px;">
                        <label style="font-size:11px; font-weight:600; color:#6b7280; text-transform:uppercase;">Lista</label>
                        @for($l = 1; $l <= min($cantListasTec, 5); $l++)
                        <input type="text" name="pap_{{ $p }}_lista_{{ $l }}_nombre"
                            value="{{ $entrada->detalleTecnico->{"pap_{$p}_lista_{$l}_nombre"} }}"
                            placeholder="{{ $ordinalTec[$l-1] }} Lista"
                            style="width:100%; border:1px solid #d1d5db; border-radius:6px; padding:5px 7px; font-size:12px; color:#111827; background:#fff; box-sizing:border-box;">
                        @endfor
                    </div>
                    <div style="flex:1;">
                        <label style="font-size:11px; font-weight:600; color:#6b7280; text-transform:uppercase; display:block; margin-bottom:4px;">Candidatura</label>
                        <div style="display:flex; align-items:center; height:calc(100% - 20px);">
                            <input type="text" name="pap_{{ $p }}_lista_1_candidatura"
                                value="{{ $entrada->detalleTecnico->{"pap_{$p}_lista_1_candidatura"} }}"
                                list="candidaturas-tec-list"
                                placeholder="Candidatura..."
                                style="width:100%; border:1px solid #d1d5db; border-radius:6px; padding:5px 7px; font-size:12px; color:#111827; background:#fff; box-sizing:border-box; margin-top:{{ $cantListasTec > 1 ? round(($cantListasTec-1) * 29 / 2) : 0 }}px;">
                        </div>
                    </div>
                    <div style="flex:1;">
                        <label style="font-size:11px; font-weight:600; color:#6b7280; text-transform:uppercase; display:block; margin-bottom:4px;">Sistema de Elección</label>
                        <div style="display:flex; align-items:center; height:calc(100% - 20px);">
                            <input type="text" name="pap_{{ $p }}_sistema_eleccion"
                                value="{{ $entrada->detalleTecnico->{"pap_{$p}_sistema_eleccion"} }}"
                                list="sistemas-tec-list"
                                placeholder="Sistema..."
                                style="width:100%; border:1px solid #d1d5db; border-radius:6px; padding:5px 7px; font-size:12px; color:#111827; background:#fff; box-sizing:border-box; margin-top:{{ $cantListasTec > 1 ? round(($cantListasTec-1) * 29 / 2) : 0 }}px;">
                        </div>
                    </div>
                </div>
            </div>
            @endfor
            <datalist id="candidaturas-tec-list">
                @foreach($candidaturasTec as $c)
                <option value="{{ $c }}">
                @endforeach
            </datalist>
            <datalist id="sistemas-tec-list">
                @foreach($sistemasTec as $s)
                <option value="{{ $s }}">
                @endforeach
            </datalist>
        </div>

        <div style="display:flex; justify-content:flex-end; gap:8px;">
            <button type="button" onclick="cancelarEdicionAsesor()"
                    style="display:inline-flex; align-items:center; gap:6px; background:#f3f4f6; color:#374151; padding:8px 18px; border-radius:8px; font-size:13px; border:none; cursor:pointer; font-weight:500;">
                Cancelar
            </button>
            <button type="submit"
                    style="display:inline-flex; align-items:center; gap:6px; background:#2563eb; color:white; padding:8px 18px; border-radius:8px; font-size:13px; border:none; cursor:pointer; font-weight:500;">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
                Guardar
            </button>
        </div>
    </form>
</div>
@endif
        {{-- SECCIÓN TÉCNICA --}}
        <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:20px; margin-bottom:14px; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px; padding-bottom:10px; border-bottom:1px solid #f3f4f6;">
                <h3 style="font-size:13px; font-weight:600; color:#374151; text-transform:uppercase; letter-spacing:0.5px; margin:0;">
                    Detalle Técnico
                </h3>
                @if($entrada->detalleTecnico?->impreso)
                <span style="display:inline-flex; align-items:center; gap:6px; background:#d1fae5; color:#065f46; padding:6px 14px; border-radius:8px; font-size:12px; font-weight:500;">
                    ✓ Impreso {{ $entrada->detalleTecnico->impreso_at?->format('d/m/Y H:i') }}
                </span>
                @endif
            </div>

            @if(session('success'))
            <div style="background:#d1fae5; border:1px solid #6ee7b7; border-radius:8px; padding:12px 16px; margin-bottom:16px; font-size:13px; color:#065f46;">
                {{ session('success') }}
            </div>
            @endif

            <form method="POST" action="{{ route('tecnico.detalle_tecnico.saveTecnico', $entrada->id) }}">
                @csrf


                {{-- MATERIALES CALCULADOS --}}
<div style="margin-bottom:20px;">
    <p style="font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase; margin:0 0 14px;">Materiales Estimados</p>
    <div style="background:#eff6ff; border:1px solid #bfdbfe; border-radius:10px; padding:16px; margin-bottom:12px;">
        <p style="font-size:11px; font-weight:600; color:#1e40af; margin:0 0 12px; text-transform:uppercase;">Calculado automáticamente — podés editar los valores</p>
        <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:12px;">
            <div>
                <label style="display:block; font-size:11px; font-weight:600; color:#1e40af; margin-bottom:6px; text-transform:uppercase;">Actas</label>
                <input type="number" id="mat_final_actas" name="mat_final_actas" min="0"
                    value="{{ old('mat_final_actas', $entrada->detalleTecnico?->mat_final_actas) }}"
                    style="width:100%; border:1px solid #bfdbfe; border-radius:6px; padding:6px 8px; font-size:14px; font-weight:700; color:#1e40af; background:#fff; box-sizing:border-box; text-align:center;">
            </div>
            <div>
                <label style="display:block; font-size:11px; font-weight:600; color:#1e40af; margin-bottom:6px; text-transform:uppercase;">Padrones</label>
                <input type="number" id="mat_final_padrones" name="mat_final_padrones" min="0"
                    value="{{ old('mat_final_padrones', $entrada->detalleTecnico?->mat_final_padrones) }}"
                    style="width:100%; border:1px solid #bfdbfe; border-radius:6px; padding:6px 8px; font-size:14px; font-weight:700; color:#1e40af; background:#fff; box-sizing:border-box; text-align:center;">
            </div>
            <div>
                <label style="display:block; font-size:11px; font-weight:600; color:#1e40af; margin-bottom:6px; text-transform:uppercase;">Cuartos Oscuros</label>
                <input type="number" id="mat_final_cuartos" name="mat_final_cuartos" min="0"
                    value="{{ old('mat_final_cuartos', $entrada->detalleTecnico?->mat_final_cuartos) }}"
                    style="width:100%; border:1px solid #bfdbfe; border-radius:6px; padding:6px 8px; font-size:14px; font-weight:700; color:#1e40af; background:#fff; box-sizing:border-box; text-align:center;">
            </div>
            <div>
                <label style="display:block; font-size:11px; font-weight:600; color:#1e40af; margin-bottom:6px; text-transform:uppercase;">Urnas</label>
                <input type="number" id="mat_final_urnas" name="mat_final_urnas" min="0"
                    value="{{ old('mat_final_urnas', $entrada->detalleTecnico?->mat_final_urnas) }}"
                    style="width:100%; border:1px solid #bfdbfe; border-radius:6px; padding:6px 8px; font-size:14px; font-weight:700; color:#1e40af; background:#fff; box-sizing:border-box; text-align:center;">
            </div>
        </div>
    </div>
</div>

{{-- MATERIALES ENTREGADOS --}}
<div style="margin-bottom:20px;">
    <p style="font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase; margin:0 0 14px;">Materiales Entregados</p>
    <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:12px;">
        @foreach([
            ['mat_mesas', 'Mesa/s', false],
            ['mat_actas_electorales', 'Actas Electorales', true],
            ['mat_padron', 'Padrón Electoral', true],
            ['mat_matriz_boletin', 'Matriz de Boletín', true],
            ['mat_actas_proclamacion', 'Actas de Proclamación', false],
            ['mat_certificados', 'Certificados de Resultados', false],
            ['mat_cuenta_votos', 'Cuenta Votos', false],
        ] as [$field, $label, $hasFormato])
        <div style="background:#f9fafb; border:1px solid #e5e7eb; border-radius:8px; padding:12px;">
            <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:6px;">{{ $label }}</label>
            <input type="number" name="{{ $field }}" min="0"
                value="{{ old($field, $entrada->detalleTecnico?->$field) }}"
                style="width:100%; border:1px solid #d1d5db; border-radius:6px; padding:6px 8px; font-size:13px; color:#111827; background:#fff; box-sizing:border-box; margin-bottom:{{ $hasFormato ? '6px' : '0' }};">
            @if($hasFormato)
            <select name="{{ $field }}_formato"
                style="width:100%; border:1px solid #d1d5db; border-radius:6px; padding:6px 8px; font-size:12px; color:#374151; background:#fff; box-sizing:border-box;">
                <option value="">Formato...</option>
                <option value="impreso" {{ old("{$field}_formato", $entrada->detalleTecnico?->{"{$field}_formato"}) == 'impreso' ? 'selected' : '' }}>Impreso</option>
                <option value="digital" {{ old("{$field}_formato", $entrada->detalleTecnico?->{"{$field}_formato"}) == 'digital' ? 'selected' : '' }}>Digital</option>
            </select>
            @endif
        </div>
        @endforeach
    </div>
</div>
                {{-- PADRÓN --}}
                <div style="margin-bottom:20px;">
                    <p style="font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase; margin:0 0 14px;">Padrón</p>
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:12px;">
                        <label style="display:flex; align-items:center; gap:10px; padding:10px 14px; border:1px solid #d1d5db; border-radius:8px; cursor:pointer; background:#fff;">
                            <input type="checkbox" name="padron_definitivo" value="1"
                                {{ old('padron_definitivo', $entrada->detalleTecnico?->padron_definitivo) ? 'checked' : '' }}
                                style="width:15px; height:15px; accent-color:#2563eb;">
                            <span style="font-size:13px; font-weight:600; color:#374151;">Padrón Definitivo</span>
                        </label>
                        <label style="display:flex; align-items:center; gap:10px; padding:10px 14px; border:1px solid #d1d5db; border-radius:8px; cursor:pointer; background:#fff;">
                            <input type="checkbox" name="padron_con_cedula" value="1"
                                {{ old('padron_con_cedula', $entrada->detalleTecnico?->padron_con_cedula) ? 'checked' : '' }}
                                style="width:15px; height:15px; accent-color:#2563eb;">
                            <span style="font-size:13px; font-weight:600; color:#374151;">Padrón con Cédula</span>
                        </label>
                    </div>
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                        <div>
                            <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:6px;">Cantidad de Electores</label>
                            <input type="number" name="cantidad_electores" min="0"
                                value="{{ old('cantidad_electores', $entrada->detalleTecnico?->cantidad_electores) }}"
                                style="width:100%; border:1px solid #d1d5db; border-radius:8px; padding:8px 10px; font-size:13px; color:#111827; background:#fff; box-sizing:border-box;">
                        </div>
                        <div>
                            <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:6px;">Electores sin C.I.</label>
                            <input type="number" name="cantidad_electores_sin_ci" min="0"
                                value="{{ old('cantidad_electores_sin_ci', $entrada->detalleTecnico?->cantidad_electores_sin_ci) }}"
                                style="width:100%; border:1px solid #d1d5db; border-radius:8px; padding:8px 10px; font-size:13px; color:#111827; background:#fff; box-sizing:border-box;">
                        </div>
                    </div>
                </div>

                {{-- RESPONSABLES --}}
                <div style="margin-bottom:24px;">
                    <p style="font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase; margin:0 0 14px;">Responsables</p>
                    <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:12px;">
                        @foreach([
                            ['resp_actas_electorales', 'Actas Electorales'],
                            ['resp_papeletas', 'Papeletas / Boletín'],
                            ['resp_padron_electoral', 'Padrón Electoral'],
                        ] as [$field, $label])
                        <div>
                            <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:6px;">{{ $label }}</label>
                            <input type="text" name="{{ $field }}"
                                value="{{ old($field, $entrada->detalleTecnico?->$field) }}"
                                list="tecnicos-list"
                                placeholder="Nombre del responsable..."
                                style="width:100%; border:1px solid #d1d5db; border-radius:8px; padding:8px 10px; font-size:13px; color:#111827; background:#fff; box-sizing:border-box;">
                        </div>
                        @endforeach
                    </div>
                    <datalist id="tecnicos-list">
                        {{-- Se pueden agregar técnicos registrados aquí --}}
                    </datalist>
                </div>

                {{-- BOTONES --}}
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <form method="POST" action="{{ route('tecnico.detalle_tecnico.imprimir', $entrada->id) }}">
                        @csrf
                        <button type="submit" onclick="return confirm('¿Marcar como impreso?')"
                            style="display:inline-flex; align-items:center; gap:6px; background:#1e3a5f; color:white; padding:10px 20px; border-radius:8px; font-size:13px; border:none; cursor:pointer; font-weight:500;">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <polyline points="6 9 6 2 18 2 18 9"/>
                                <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                                <rect x="6" y="14" width="12" height="8"/>
                            </svg>
                            Imprimir Logística
                        </button>
                    </form>
                    <button type="submit"
                        style="display:inline-flex; align-items:center; gap:6px; background:#2563eb; color:white; padding:10px 24px; border-radius:8px; font-size:13px; border:none; cursor:pointer; font-weight:500;">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                        Guardar
                    </button>
                </div>

            </form>
        </div>

        {{-- VOLVER --}}
        <div style="display:flex; justify-content:flex-end;">
            <a href="{{ route('tecnico.organizaciones') }}"
               style="display:inline-flex; align-items:center; gap:6px; background:#1e3a5f; color:white; padding:10px 20px; border-radius:8px; font-size:14px; text-decoration:none; font-weight:500;">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="15 18 9 12 15 6"/>
                </svg>
                Volver a organizaciones
            </a>
        </div>

    </div>
</div>
<script>
function calcularMateriales() {
    const mesas     = parseInt(document.getElementById('input_mesas')?.value) || 0;
    const papeletas = parseInt(document.getElementById('input_papeletas')?.value) || 0;

    const actas   = mesas * 3;
    const padrones = mesas * 3;
    const cuartos = mesas;
    const urnas   = mesas * papeletas;

    const fActas    = document.getElementById('mat_final_actas');
    const fPadrones = document.getElementById('mat_final_padrones');
    const fCuartos  = document.getElementById('mat_final_cuartos');
    const fUrnas    = document.getElementById('mat_final_urnas');

    if (fActas && !fActas.dataset.editado)    fActas.value    = actas;
    if (fPadrones && !fPadrones.dataset.editado) fPadrones.value = padrones;
    if (fCuartos && !fCuartos.dataset.editado)  fCuartos.value  = cuartos;
    if (fUrnas && !fUrnas.dataset.editado)    fUrnas.value    = urnas;
}

// Marcar como editado manualmente
['mat_final_actas','mat_final_padrones','mat_final_cuartos','mat_final_urnas'].forEach(id => {
    const el = document.getElementById(id);
    if (el) el.addEventListener('input', () => el.dataset.editado = '1');
});

// Escuchar cambios en mesas y papeletas
document.getElementById('input_mesas')?.addEventListener('input', calcularMateriales);
document.getElementById('input_papeletas')?.addEventListener('input', calcularMateriales);

// Calcular al cargar si no hay valores guardados
calcularMateriales();
</script>

</x-panel-layout>
