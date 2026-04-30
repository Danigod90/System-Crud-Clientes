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
                    <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Asesor Asignado</label>
                    <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ $entrada->asesor_asignado ?? '—' }}</p>
                </div>
                <div>
                    <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Vía de Ingreso</label>
                    <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ $entrada->via_ingreso ?? '—' }}</p>
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

{{-- SECCIÓN DOCUMENTOS (solo lectura) --}}
        <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:20px; margin-bottom:14px; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px; padding-bottom:10px; border-bottom:1px solid #f3f4f6;">
                <h3 style="font-size:13px; font-weight:600; color:#374151; text-transform:uppercase; letter-spacing:0.5px; margin:0; display:flex; align-items:center; gap:8px;">
                    Documentos
                    <span style="font-size:11px; font-weight:400; color:#9ca3af; text-transform:none;">{{ $entrada->documentos->count() }} archivo(s)</span>
                </h3>
            </div>
            @forelse($entrada->documentos as $doc)
            <div style="display:flex; align-items:center; gap:10px; padding:8px 10px; background:#f9fafb; border:1px solid #e5e7eb; border-radius:8px; margin-bottom:8px;">
                <div style="flex-shrink:0;">
                    @if(in_array($doc->extension, ['jpg','jpeg','png','gif']))
                        <span style="font-size:18px;">🖼</span>
                    @elseif($doc->extension == 'pdf')
                        <span style="font-size:18px;">📄</span>
                    @elseif(in_array($doc->extension, ['doc','docx']))
                        <span style="font-size:18px;">📝</span>
                    @else
                        <span style="font-size:18px;">📎</span>
                    @endif
                </div>
                <div style="flex:1; min-width:0;">
                    <p style="font-size:12px; font-weight:600; color:#111827; margin:0; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ $doc->nombre }}</p>
                    <p style="font-size:10px; color:#9ca3af; margin:0;">{{ strtoupper($doc->extension) }} · {{ number_format($doc->tamanio / 1024, 1) }} KB · {{ $doc->user->name ?? '—' }} · {{ $doc->created_at->format('d/m/Y') }}</p>
                </div>
                <a href="{{ route('documentos.show', $doc->id) }}" target="_blank"
                   style="display:inline-flex; align-items:center; gap:4px; background:#eff6ff; color:#2563eb; padding:4px 10px; border-radius:6px; font-size:11px; text-decoration:none; font-weight:500; flex-shrink:0;">
                    Ver
                </a>
            </div>
            @empty
            <p style="font-size:12px; color:#9ca3af; margin:0;">No hay documentos cargados aún.</p>
            @endforelse
        </div>

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
    <span style="font-size:12px; font-weight:700; color:#374151; white-space:nowrap;">{{ $ordinalRO[$p-1] }} Papeleta</span>
    @php
        $listaNombres = [];
        for ($l = 1; $l <= ($entrada->detalleTecnico?->cantidad_listas ?? 1); $l++) {
            $n = $entrada->detalleTecnico?->{"pap_{$p}_lista_{$l}_nombre"} ?? null;
            if ($n) $listaNombres[] = $n;
        }
    @endphp
    @if(count($listaNombres))
    <span style="font-size:11px; background:#e5e7eb; color:#374151; padding:2px 8px; border-radius:4px; white-space:nowrap;">Lista {{ implode(', ', $listaNombres) }}</span>
    @endif
    <span style="font-size:13px; color:#111827; flex:1;">{{ $candidaturaRO }}</span>
    <span style="font-size:11px; color:#6b7280; white-space:nowrap;">{{ $sistemaRO }}</span>
</div>
            @endfor
        </div>
        @endif

       {{-- ESTIMADO --}}
@if($entrada->detalleTecnico->cantidad_mesas)
@php
    $mesasRO     = $entrada->detalleTecnico->cantidad_mesas;
    $papeletasRO = $entrada->detalleTecnico->cantidad_papeletas;
    $actasRO     = $entrada->detalleTecnico->mat_final_actas    !== null ? $entrada->detalleTecnico->mat_final_actas    : ($mesasRO * 3);
    $padronesRO  = $entrada->detalleTecnico->mat_final_padrones !== null ? $entrada->detalleTecnico->mat_final_padrones : ($mesasRO * 3);
    $cuartosRO   = $entrada->detalleTecnico->mat_final_cuartos  !== null ? $entrada->detalleTecnico->mat_final_cuartos  : $mesasRO;
    $urnasRO     = $entrada->detalleTecnico->mat_final_urnas     !== null ? $entrada->detalleTecnico->mat_final_urnas    : ($mesasRO * $papeletasRO);
    $tintasRO    = $entrada->detalleTecnico->mat_final_tintas    !== null ? $entrada->detalleTecnico->mat_final_tintas   : $mesasRO;
@endphp
        <div style="background:#eff6ff; border:1px solid #bfdbfe; border-radius:8px; padding:12px 16px;">
            <p style="font-size:11px; font-weight:700; color:#1e40af; text-transform:uppercase; margin:0 0 10px;">Materiales a Entregar</p>
           <div style="display:grid; grid-template-columns:repeat(6,1fr); gap:4px; min-width:0;">
                <div style="text-align:center;">
                    <p style="font-size:11px; color:#6b7280; margin:0 0 2px;">Papeletas</p>
                    <p style="font-size:18px; font-weight:700; color:#1e40af; margin:0;">{{ $entrada->detalleTecnico->mat_final_papeletas !== null ? $entrada->detalleTecnico->mat_final_papeletas : ($entrada->detalleTecnico->cantidad_papeletas ?? 0) }}</p>
                    @if($entrada->detalleTecnico->mat_final_papeletas_formato)
                    <p style="font-size:10px; color:#6b7280; margin:2px 0 0;">{{ ucfirst($entrada->detalleTecnico->mat_final_papeletas_formato) }}</p>
                    @endif
                </div>
                <div style="text-align:center;">
    <p style="font-size:11px; color:#6b7280; margin:0 0 2px;">Actas</p>
    <p style="font-size:18px; font-weight:700; color:#1e40af; margin:0;">{{ $actasRO }}</p>
    @if($entrada->detalleTecnico->mat_final_actas_formato)
    <p style="font-size:10px; color:#6b7280; margin:2px 0 0;">{{ ucfirst($entrada->detalleTecnico->mat_final_actas_formato) }}</p>
    @endif
</div>
<div style="text-align:center;">
    <p style="font-size:11px; color:#6b7280; margin:0 0 2px;">Padrones</p>
    <p style="font-size:18px; font-weight:700; color:#1e40af; margin:0;">{{ $padronesRO }}</p>
    @if($entrada->detalleTecnico->mat_final_padrones_formato)
    <p style="font-size:10px; color:#6b7280; margin:2px 0 0;">{{ ucfirst($entrada->detalleTecnico->mat_final_padrones_formato) }}</p>
    @endif
</div>
@if($entrada->asunto_log)
<div style="text-align:center;">
    <p style="font-size:11px; color:#6b7280; margin:0 0 2px;">Cuartos Oscuros</p>
    <p style="font-size:18px; font-weight:700; color:#1e40af; margin:0;">{{ $cuartosRO }}</p>
</div>
<div style="text-align:center;">
    <p style="font-size:11px; color:#6b7280; margin:0 0 2px;">Urnas</p>
    <p style="font-size:18px; font-weight:700; color:#1e40af; margin:0;">{{ $urnasRO }}</p>
</div>
<div style="text-align:center;">
    <p style="font-size:11px; color:#6b7280; margin:0 0 2px;">Tintas</p>
    <p style="font-size:18px; font-weight:700; color:#1e40af; margin:0;">{{ $tintasRO }}</p>
</div>
@endif
                </div>
            </div>
        @endif
        {{-- NOTA DEL ASESOR --}}
@if($entrada->detalleTecnico->nota_asesor)
<div style="margin-top:10px; background:#fef9c3; border:1px solid #fde047; border-radius:8px; padding:10px 14px; display:flex; gap:8px;">
    <svg width="15" height="15" fill="none" stroke="#854d0e" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0; margin-top:1px;">
        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
        <polyline points="14 2 14 8 20 8"/>
        <line x1="16" y1="13" x2="8" y2="13"/>
        <line x1="16" y1="17" x2="8" y2="17"/>
    </svg>
    <div>
        <p style="font-size:11px; font-weight:700; color:#854d0e; text-transform:uppercase; margin:0 0 4px;">Importante</p>
        <p style="font-size:13px; color:#713f12; margin:0;">{{ $entrada->detalleTecnico->nota_asesor }}</p>
    </div>
</div>
@endif
    </div>

    {{-- FORMULARIO EDITABLE ASESOR --}}
    <form id="asesor-form" method="POST" action="{{ route('tecnico.detalle_tecnico.saveAsesor', $entrada->id) }}"
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
                <input type="number" name="cantidad_listas" min="0" max="10"
                    value="{{ $entrada->detalleTecnico->cantidad_listas }}"
                    style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; background:#fff; box-sizing:border-box;">
            </div>
            <div>
                <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Cantidad de Papeletas</label>
                <input type="number" name="cantidad_papeletas" id="input_papeletas" min="0" max="10"
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
            $candidaturasTec = ['Presidente y Vicepresidentes','Presidente y Vicepresidente','Secretario General y Adjunto','Comisión Directiva','Miembros Titulares','Miembros Titulares y Suplentes','Vocales Titulares','Vocales Titulares y Suplentes','Tribunal Electoral Independiente','Junta Electoral','Colegio Electoral','Síndico','Comité Revisadora de Cuentas'];
            $sistemasTec = ['Lista Única','Lista Cerrada','Lista Desbloqueada','Lista Cerrada Bloqueada','Nominal'];
        @endphp

        <div style="margin-bottom:14px;">
            <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:8px; text-transform:uppercase; letter-spacing:0.5px;">Papeletas</label>
            <div id="papeletas-tec-container"></div>
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

{{-- ESTIMADO DE MATERIALES EDITABLE --}}
@php
    $mEstForm = $entrada->detalleTecnico->cantidad_mesas ?? 0;
    $pEstForm = $entrada->detalleTecnico->cantidad_papeletas ?? 0;
@endphp
<div style="background:#eff6ff; border:1px solid #bfdbfe; border-radius:8px; padding:12px 16px; margin-bottom:14px;">
    <p style="font-size:11px; font-weight:700; color:#1e40af; text-transform:uppercase; margin:0 0 10px;">Materiales a Entregar — podés editar los valores</p>
    <div style="display:grid; grid-template-columns:repeat(6,1fr); gap:8px;">
        <div style="text-align:center;">
            <p style="font-size:11px; color:#6b7280; margin:0 0 4px;">Papeletas</p>
            <input type="number" name="mat_final_papeletas" min="0"
                value="{{ old('mat_final_papeletas', $entrada->detalleTecnico->mat_final_papeletas ?? $entrada->detalleTecnico->cantidad_papeletas) }}"
                style="width:100%; border:1px solid #bfdbfe; border-radius:6px; padding:6px 4px; font-size:14px; font-weight:700; color:#1e40af; background:#fff; box-sizing:border-box; text-align:center; margin-bottom:4px;">
            <select name="mat_final_papeletas_formato" style="width:100%; border:1px solid #bfdbfe; border-radius:6px; padding:5px 4px; font-size:11px; color:#1e40af; background:#fff; box-sizing:border-box;">
                <option value="">Formato...</option>
                <option value="impreso" {{ old('mat_final_papeletas_formato', $entrada->detalleTecnico->mat_final_papeletas_formato) == 'impreso' ? 'selected' : '' }}>Impreso</option>
                <option value="digital" {{ old('mat_final_papeletas_formato', $entrada->detalleTecnico->mat_final_papeletas_formato) == 'digital' ? 'selected' : '' }}>Digital</option>
                <option value="sin_papeletas" {{ old('mat_final_papeletas_formato', $entrada->detalleTecnico->mat_final_papeletas_formato) == 'sin_papeletas' ? 'selected' : '' }}>Sin Papeletas</option>
            </select>
        </div>
        <div style="text-align:center;">
            <p style="font-size:11px; color:#6b7280; margin:0 0 4px;">Actas</p>
            <input type="number" name="mat_final_actas" min="0"
                value="{{ old('mat_final_actas', is_null($entrada->detalleTecnico->mat_final_actas) ? ($mEstForm * 3) : $entrada->detalleTecnico->mat_final_actas) }}"
                style="width:100%; border:1px solid #bfdbfe; border-radius:6px; padding:6px 4px; font-size:14px; font-weight:700; color:#1e40af; background:#fff; box-sizing:border-box; text-align:center; margin-bottom:4px;">
            <select name="mat_final_actas_formato" style="width:100%; border:1px solid #bfdbfe; border-radius:6px; padding:5px 4px; font-size:11px; color:#1e40af; background:#fff; box-sizing:border-box;">
                <option value="">Formato...</option>
                <option value="impreso" {{ old('mat_final_actas_formato', $entrada->detalleTecnico->mat_final_actas_formato) == 'impreso' ? 'selected' : '' }}>Impreso</option>
                <option value="digital" {{ old('mat_final_actas_formato', $entrada->detalleTecnico->mat_final_actas_formato) == 'digital' ? 'selected' : '' }}>Digital</option>
                <option value="sin_actas" {{ old('mat_final_actas_formato', $entrada->detalleTecnico->mat_final_actas_formato) == 'sin_actas' ? 'selected' : '' }}>Sin Actas</option>
            </select>
        </div>
      <div style="text-align:center;">
            <p style="font-size:11px; color:#6b7280; margin:0 0 4px;">Padrones</p>
            <input type="number" name="mat_final_padrones" min="0"
                value="{{ old('mat_final_padrones', is_null($entrada->detalleTecnico->mat_final_padrones) ? ($mEstForm * 3) : $entrada->detalleTecnico->mat_final_padrones) }}"
                style="width:100%; border:1px solid #bfdbfe; border-radius:6px; padding:6px 4px; font-size:14px; font-weight:700; color:#1e40af; background:#fff; box-sizing:border-box; text-align:center; margin-bottom:4px;">
            <select name="mat_final_padrones_formato" style="width:100%; border:1px solid #bfdbfe; border-radius:6px; padding:5px 4px; font-size:11px; color:#1e40af; background:#fff; box-sizing:border-box;">
                <option value="">Formato...</option>
                <option value="impreso" {{ old('mat_final_padrones_formato', $entrada->detalleTecnico->mat_final_padrones_formato) == 'impreso' ? 'selected' : '' }}>Impreso</option>
                <option value="digital" {{ old('mat_final_padrones_formato', $entrada->detalleTecnico->mat_final_padrones_formato) == 'digital' ? 'selected' : '' }}>Digital</option>
                <option value="sin_padron" {{ old('mat_final_padrones_formato', $entrada->detalleTecnico->mat_final_padrones_formato) == 'sin_padron' ? 'selected' : '' }}>Sin Padrón</option>
            </select>
        </div>
        <div style="text-align:center;">
            <p style="font-size:11px; color:#6b7280; margin:0 0 4px;">Cuartos Oscuros</p>
            <input type="number" name="mat_final_cuartos" min="0"
                value="{{ old('mat_final_cuartos', is_null($entrada->detalleTecnico->mat_final_cuartos) ? $mEstForm : $entrada->detalleTecnico->mat_final_cuartos) }}"
                style="width:100%; border:1px solid #bfdbfe; border-radius:6px; padding:6px 4px; font-size:14px; font-weight:700; color:#1e40af; background:#fff; box-sizing:border-box; text-align:center;">
        </div>
        <div style="text-align:center;">
            <p style="font-size:11px; color:#6b7280; margin:0 0 4px;">Urnas</p>
            <input type="number" name="mat_final_urnas" min="0"
                value="{{ old('mat_final_urnas', is_null($entrada->detalleTecnico->mat_final_urnas) ? ($mEstForm * $pEstForm) : $entrada->detalleTecnico->mat_final_urnas) }}"
                style="width:100%; border:1px solid #bfdbfe; border-radius:6px; padding:6px 4px; font-size:14px; font-weight:700; color:#1e40af; background:#fff; box-sizing:border-box; text-align:center;">
        </div>
        <div style="text-align:center;">
            <p style="font-size:11px; color:#6b7280; margin:0 0 4px;">Tintas</p>
            <input type="number" name="mat_final_tintas" min="0"
                value="{{ old('mat_final_tintas', is_null($entrada->detalleTecnico->mat_final_tintas) ? $mEstForm : $entrada->detalleTecnico->mat_final_tintas) }}"
                style="width:100%; border:1px solid #bfdbfe; border-radius:6px; padding:6px 4px; font-size:14px; font-weight:700; color:#1e40af; background:#fff; box-sizing:border-box; text-align:center;">
        </div>
    </div>
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
                <div style="display:flex; gap:8px; align-items:center;">
                    @if($entrada->detalleTecnico?->impreso)
                    <span style="display:inline-flex; align-items:center; gap:6px; background:#d1fae5; color:#065f46; padding:6px 14px; border-radius:8px; font-size:12px; font-weight:500;">
                        ✓ Impreso {{ $entrada->detalleTecnico->impreso_at?->format('d/m/Y H:i') }}
                    </span>
                    @endif
                    <button id="btn-editar-tec" onclick="activarEdicionTec()"
                            style="display:inline-flex; align-items:center; gap:6px; background:#f3f4f6; color:#374151; padding:6px 14px; border-radius:8px; font-size:12px; border:none; cursor:pointer; font-weight:500;">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                        </svg>
                        Editar
                    </button>
                </div>
            </div>

    @if(session('success'))
<div style="display:flex; align-items:center; gap:10px; background:#d1fae5; color:#065f46; padding:12px 16px; border-radius:10px; margin-bottom:14px; font-size:13px; border-left:4px solid #16a34a; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
    <svg width="18" height="18" fill="none" stroke="#16a34a" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;">
        <circle cx="12" cy="12" r="10"/><polyline points="9 12 11 14 15 10"/>
    </svg>
    {{ session('success') }}
</div>
@endif

            {{-- VISTA SOLO LECTURA --}}
<div id="tec-readonly" style="display:block;">

    {{-- MATERIALES ENTREGADOS --}}
    <div style="margin-bottom:16px;">
        <p style="font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase; margin:0 0 10px;">Materiales Entregados</p>
        @php
            $mesasRO = $entrada->detalleTecnico?->cantidad_mesas ?? 0;
            $defaultsRO = [
    'mat_mesas' => $entrada->detalleTecnico?->cantidad_mesas ?? $entrada->detalleTecnico?->mat_mesas ?? $mesasRO,
    'mat_actas_electorales'  => $entrada->detalleTecnico?->mat_final_actas ?? $entrada->detalleTecnico?->mat_actas_electorales ?? ($mesasRO * 3),
    'mat_padron'             => $entrada->detalleTecnico?->mat_final_padrones ?? $entrada->detalleTecnico?->mat_padron ?? ($mesasRO * 3),
    'mat_matriz_boletin'     => $entrada->detalleTecnico?->mat_final_papeletas ?? $entrada->detalleTecnico?->mat_matriz_boletin ?? ($entrada->detalleTecnico?->cantidad_papeletas ?? 0),
                'mat_actas_proclamacion' => $entrada->detalleTecnico?->mat_actas_proclamacion ?? 3,
                'mat_certificados'       => $entrada->detalleTecnico?->mat_certificados,
                'mat_cuenta_votos'       => $entrada->detalleTecnico?->mat_cuenta_votos,
                'mat_tintas' => $entrada->detalleTecnico?->mat_tintas ?? ($entrada->detalleTecnico?->cantidad_mesas ?? 0),
            ];
        @endphp
        <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:10px;">
            @foreach([
                ['mat_mesas', 'Mesa/s', false],
                ['mat_actas_electorales', 'Actas Electorales', 'mat_actas_electorales_formato'],
                ['mat_padron', 'Padrón Electoral', 'mat_padron_formato'],
                ['mat_matriz_boletin', 'Matriz de Boletín', 'mat_matriz_boletin_formato'],
                ['mat_actas_proclamacion', 'Actas de Proclamación', false],
                ['mat_certificados', 'Certificados de Resultados', false],
                ['mat_cuenta_votos', 'Cuenta Votos', false],
            ] as [$field, $label, $formatoField])
            <div style="background:#f9fafb; border:1px solid #e5e7eb; border-radius:8px; padding:10px;">
                <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px;">{{ $label }}</label>
                <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ $defaultsRO[$field] ?? '—' }}</p>
                @if($formatoField)
@php
   $fmtVal = match($formatoField) {
    'mat_actas_electorales_formato' => $entrada->detalleTecnico?->mat_final_actas_formato ?? $entrada->detalleTecnico?->mat_actas_electorales_formato,
    'mat_padron_formato'            => $entrada->detalleTecnico?->mat_final_padrones_formato ?? $entrada->detalleTecnico?->mat_padron_formato,
    'mat_matriz_boletin_formato'    => $entrada->detalleTecnico?->mat_final_papeletas_formato ?? $entrada->detalleTecnico?->mat_matriz_boletin_formato,
    default                         => null,
};
@endphp
@if($fmtVal)
<p style="font-size:11px; color:#6b7280; margin:2px 0 0;">{{ ucfirst($fmtVal) }}</p>
@endif
@endif
            </div>
            @endforeach
        </div>
    </div>

    {{-- PADRÓN --}}
    <div style="margin-bottom:16px;">
        <p style="font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase; margin:0 0 10px;">Padrón</p>
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-bottom:10px;">
            <div style="background:#f9fafb; border:1px solid #e5e7eb; border-radius:8px; padding:10px;">
                <p style="font-size:13px; font-weight:600; color:#111827; margin:0;">
                    {{ $entrada->detalleTecnico?->padron_definitivo ? '✓ Padrón Definitivo' : '✗ Sin Padrón Definitivo' }}
                </p>
            </div>
            <div style="background:#f9fafb; border:1px solid #e5e7eb; border-radius:8px; padding:10px;">
                <p style="font-size:13px; font-weight:600; color:#111827; margin:0;">
                    {{ $entrada->detalleTecnico?->padron_con_cedula ? '✓ Padrón con Cédula' : '✗ Sin Padrón con Cédula' }}
                </p>
            </div>
        </div>
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
            <div>
                <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase;">Cantidad de Electores</label>
                <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ $entrada->detalleTecnico?->cantidad_electores ?? '—' }}</p>
            </div>
            <div>
                <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase;">Electores sin C.I.</label>
                <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ $entrada->detalleTecnico?->cantidad_electores_sin_ci ?? '—' }}</p>
            </div>
        </div>
    </div>

    {{-- RESPONSABLES --}}
    <div>
        <p style="font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase; margin:0 0 10px;">Responsables</p>
        <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:10px;">
            @foreach([
                ['resp_actas_electorales', 'Actas Electorales'],
                ['resp_papeletas', 'Papeletas / Boletín'],
                ['resp_padron_electoral', 'Padrón Electoral'],
            ] as [$field, $label])
            <div>
                <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase;">{{ $label }}</label>
                <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ $entrada->detalleTecnico?->$field ?? '—' }}</p>
            </div>
            @endforeach
        </div>
    </div>
</div>

            {{-- FORMULARIO EDITABLE --}}
<form id="tec-form" method="POST" action="{{ route('tecnico.detalle_tecnico.saveTecnico', $entrada->id) }}" style="display:none;">
    @csrf

  @php
    $mesas          = $entrada->detalleTecnico?->cantidad_mesas ?? 0;
    $defaultMesas   = $entrada->detalleTecnico?->cantidad_mesas ?? $mesas;
    $defaultActas   = is_null($entrada->detalleTecnico?->mat_final_actas)    ? ($mesas * 3) : $entrada->detalleTecnico->mat_final_actas;
$defaultPadron  = is_null($entrada->detalleTecnico?->mat_final_padrones)  ? ($mesas * 3) : $entrada->detalleTecnico->mat_final_padrones;
$defaultBoletin = is_null($entrada->detalleTecnico?->mat_final_papeletas) ? ($entrada->detalleTecnico?->cantidad_papeletas ?? 0) : $entrada->detalleTecnico->mat_final_papeletas;
@endphp

    {{-- MATERIALES ENTREGADOS --}}
<div style="margin-bottom:20px;">
    <p style="font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase; margin:0 0 14px;">Materiales Entregados</p>
    <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:12px;">
        @foreach([
    ['mat_mesas', 'Mesa/s', false, $defaultMesas, null, null, null],
    ['mat_actas_electorales', 'Actas Electorales', true, $defaultActas, 'sin_actas', 'Sin Actas', $entrada->detalleTecnico?->mat_final_actas_formato],
    ['mat_padron', 'Padrón Electoral', true, $defaultPadron, 'sin_padron', 'Sin Padrón', $entrada->detalleTecnico?->mat_final_padrones_formato],
    ['mat_matriz_boletin', 'Matriz de Boletín', true, $defaultBoletin, 'sin_papeletas', 'Sin Papeletas', $entrada->detalleTecnico?->mat_final_papeletas_formato],
    ['mat_actas_proclamacion', 'Actas de Proclamación', false, $entrada->detalleTecnico?->mat_actas_proclamacion ?? 3, null, null, null],
    ['mat_certificados', 'Certificados de Resultados', false, null, null, null, null],
    ['mat_cuenta_votos', 'Cuenta Votos', false, null, null, null, null],
] as [$field, $label, $hasFormato, $default, $sinVal, $sinLabel, $defaultFormato])
        <div style="background:#f9fafb; border:1px solid #e5e7eb; border-radius:8px; padding:12px;">
            <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:6px;">{{ $label }}</label>
            <input type="number" name="{{ $field }}" min="0"
    value="{{ old($field, $default) }}"
    style="...">
@if($hasFormato)
<select name="{{ $field }}_formato" style="...">
    <option value="">Formato...</option>
    <option value="impreso" {{ old("{$field}_formato", $defaultFormato) == 'impreso' ? 'selected' : '' }}>Impreso</option>
    <option value="digital" {{ old("{$field}_formato", $defaultFormato) == 'digital' ? 'selected' : '' }}>Digital</option>
    @if($sinVal)
    <option value="{{ $sinVal }}" {{ old("{$field}_formato", $defaultFormato) == $sinVal ? 'selected' : '' }}>{{ $sinLabel }}</option>
    @endif
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
    <option value="Sin Actas">
    <option value="Sin Papeleta">
    <option value="Sin Padrón">
    <option value="Selica Gamarra">
    <option value="Cristhian Maidana">
    <option value="Marcos Ramírez">
    <option value="Santiago Acuña">
    <option value="Liliana López">
    <option value="David Cousirat">
    <option value="Lilian Martinez">
</datalist>
                </div>

                {{-- BOTONES FORM --}}
                <div style="display:flex; justify-content:flex-end; gap:8px;">
                    <button type="button" onclick="cancelarEdicionTec()"
                        style="display:inline-flex; align-items:center; gap:6px; background:#f3f4f6; color:#374151; padding:10px 20px; border-radius:8px; font-size:13px; border:none; cursor:pointer; font-weight:500;">
                        Cancelar
                    </button>
                    <button type="submit"
                        style="display:inline-flex; align-items:center; gap:6px; background:#2563eb; color:white; padding:10px 24px; border-radius:8px; font-size:13px; border:none; cursor:pointer; font-weight:500;">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                        Guardar
                    </button>
                </div>
            </form>

            {{-- BOTONES EXTERNOS --}}
            <div style="display:flex; gap:10px; margin-top:16px; padding-top:16px; border-top:1px solid #f3f4f6;">
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

                @if(!$entrada->detalleTecnico?->tec_realizado)
                <form method="POST" action="{{ route('tecnico.detalle_tecnico.realizado', $entrada->id) }}">
                    @csrf @method('PATCH')
                    <button type="submit" onclick="return confirm('¿Marcar trabajo técnico como realizado?')"
                        style="display:inline-flex; align-items:center; gap:6px; background:#16a34a; color:white; padding:10px 20px; border-radius:8px; font-size:13px; border:none; cursor:pointer; font-weight:500;">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                        Marcar como Realizado
                    </button>
                </form>
                @else
                <span style="display:inline-flex; align-items:center; gap:6px; background:#bbf7d0; color:#166534; padding:10px 20px; border-radius:8px; font-size:13px; font-weight:500;">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    Realizado
                </span>
                @endif
            </div>
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
@php
$savedDataTecPHP = [];
for ($p = 1; $p <= 10; $p++) {
    $savedDataTecPHP[$p] = [
        'sistema'     => $entrada->detalleTecnico?->{"pap_{$p}_sistema_eleccion"} ?? '',
        'candidatura' => $entrada->detalleTecnico?->{"pap_{$p}_lista_1_candidatura"} ?? '',
        'listas'      => [],
    ];
    for ($l = 1; $l <= 5; $l++) {
        $savedDataTecPHP[$p]['listas'][$l] = $entrada->detalleTecnico?->{"pap_{$p}_lista_{$l}_nombre"} ?? '';
    }
}
@endphp
<script>
const savedDataTec = @json($savedDataTecPHP);

const ordinalPapTec = ['Primera','Segunda','Tercera','Cuarta','Quinta','Sexta','Séptima','Octava','Novena','Décima'];
const ordinalLisTec = ['Primera','Segunda','Tercera','Cuarta','Quinta'];

function generarPapeletasTec() {
    const cantPap = parseInt(document.querySelector('#asesor-form [name="cantidad_papeletas"]')?.value) || 0;
    const cantLis = parseInt(document.querySelector('#asesor-form [name="cantidad_listas"]')?.value) || 0;
    const container = document.getElementById('papeletas-tec-container');
    if (!container) return;

    const valoresActuales = {};
    container.querySelectorAll('input').forEach(input => {
        if (input.name) valoresActuales[input.name] = input.value;
    });

    container.innerHTML = '';
    const marginTop = cantLis > 1 ? Math.round((cantLis - 1) * 29 / 2) : 0;

    for (let p = 1; p <= Math.min(cantPap, 10); p++) {
        const saved = savedDataTec[p] || {};
        let listasHTML = '';
        for (let l = 1; l <= Math.min(cantLis, 5); l++) {
            const key = `pap_${p}_lista_${l}_nombre`;
            const val = valoresActuales[key] !== undefined ? valoresActuales[key] : (saved.listas?.[l] || '');
            listasHTML += `<input type="text" name="${key}" value="${val}" placeholder="${ordinalLisTec[l-1]} Lista"
                style="width:100%; border:1px solid #d1d5db; border-radius:6px; padding:5px 7px; font-size:12px; color:#111827; background:#fff; box-sizing:border-box; margin-bottom:4px;">`;
        }
        const candKey = `pap_${p}_lista_1_candidatura`;
        const sisKey  = `pap_${p}_sistema_eleccion`;
        const candVal = valoresActuales[candKey] !== undefined ? valoresActuales[candKey] : (saved.candidatura || '');
        const sisVal  = valoresActuales[sisKey]  !== undefined ? valoresActuales[sisKey]  : (saved.sistema || '');

        container.innerHTML += `
        <div style="background:#f9fafb; border:1px solid #e5e7eb; border-radius:10px; padding:14px; margin-bottom:10px;">
            <p style="font-size:12px; font-weight:700; color:#374151; margin:0 0 10px;">${ordinalPapTec[p-1]} Papeleta</p>
            <div style="display:flex; gap:8px; align-items:flex-start;">
                <div style="flex:1; display:flex; flex-direction:column; gap:4px;">
                    <label style="font-size:11px; font-weight:600; color:#6b7280; text-transform:uppercase;">Lista</label>
                    ${listasHTML}
                </div>
                <div style="flex:1;">
                    <label style="font-size:11px; font-weight:600; color:#6b7280; text-transform:uppercase; display:block; margin-bottom:4px;">Candidatura</label>
                    <input type="text" name="${candKey}" value="${candVal}" list="candidaturas-tec-list" placeholder="Candidatura..."
                        style="width:100%; border:1px solid #d1d5db; border-radius:6px; padding:5px 7px; font-size:12px; color:#111827; background:#fff; box-sizing:border-box; margin-top:${marginTop}px;">
                </div>
                <div style="flex:1;">
                    <label style="font-size:11px; font-weight:600; color:#6b7280; text-transform:uppercase; display:block; margin-bottom:4px;">Sistema de Elección</label>
                    <input type="text" name="${sisKey}" value="${sisVal}" list="sistemas-tec-list" placeholder="Sistema..."
                        style="width:100%; border:1px solid #d1d5db; border-radius:6px; padding:5px 7px; font-size:12px; color:#111827; background:#fff; box-sizing:border-box; margin-top:${marginTop}px;">
                </div>
            </div>
        </div>`;
    }
}


function calcularMaterialesTec() {
    // Los valores vienen correctos desde PHP, no recalcular
}


function activarEdicionAsesor() {
    document.getElementById('asesor-readonly').style.display = 'none';
    document.getElementById('asesor-form').style.display = 'block';
    document.getElementById('btn-editar-asesor').style.display = 'none';
    generarPapeletasTec();
    // calcularMaterialesTec() ← ELIMINADO, ya no calcula al abrir

    document.querySelector('#asesor-form [name="cantidad_papeletas"]')?.addEventListener('input', () => { generarPapeletasTec(); });
    document.querySelector('#asesor-form [name="cantidad_listas"]')?.addEventListener('input', generarPapeletasTec);
    // cantidad_mesas ya no dispara recalculo automático
    document.querySelector('#asesor-form [name="mat_final_papeletas"]')?.addEventListener('input', function() {
        const val = parseInt(this.value) || 0;
        const inputCantPap = document.querySelector('#asesor-form [name="cantidad_papeletas"]');
        if (inputCantPap) {
            inputCantPap.value = val;
            generarPapeletasTec();
        }
    });
    document.querySelector('#asesor-form [name="mat_final_papeletas_formato"]')?.addEventListener('change', function() {
        if (this.value === 'sin_papeletas') document.querySelector('#asesor-form [name="mat_final_papeletas"]').value = 0;
    });
    document.querySelector('#asesor-form [name="mat_final_actas_formato"]')?.addEventListener('change', function() {
        if (this.value === 'sin_actas') document.querySelector('#asesor-form [name="mat_final_actas"]').value = 0;
    });
    document.querySelector('#asesor-form [name="mat_final_padrones_formato"]')?.addEventListener('change', function() {
        if (this.value === 'sin_padron') document.querySelector('#asesor-form [name="mat_final_padrones"]').value = 0;
    });
}


function cancelarEdicionAsesor() {
    document.getElementById('asesor-readonly').style.display = 'block';
    document.getElementById('asesor-form').style.display = 'none';
    document.getElementById('btn-editar-asesor').style.display = 'inline-flex';
}

function activarEdicionTec() {
    document.getElementById('tec-readonly').style.display = 'none';
    document.getElementById('tec-form').style.display = 'block';
    document.getElementById('btn-editar-tec').style.display = 'none';
    document.querySelector('#tec-form [name="mat_actas_electorales_formato"]')?.addEventListener('change', function() {
        if (this.value === 'sin_actas') document.querySelector('#tec-form [name="mat_actas_electorales"]').value = 0;
    });
    document.querySelector('#tec-form [name="mat_padron_formato"]')?.addEventListener('change', function() {
        if (this.value === 'sin_padron') document.querySelector('#tec-form [name="mat_padron"]').value = 0;
    });
    document.querySelector('#tec-form [name="mat_matriz_boletin_formato"]')?.addEventListener('change', function() {
        if (this.value === 'sin_papeletas') document.querySelector('#tec-form [name="mat_matriz_boletin"]').value = 0;
    });
}

function cancelarEdicionTec() {
    document.getElementById('tec-readonly').style.display = 'block';
    document.getElementById('tec-form').style.display = 'none';
    document.getElementById('btn-editar-tec').style.display = 'inline-flex';
}
</script>

<div id="banner-actualizacion" style="display:none; position:fixed; top:16px; left:50%; transform:translateX(-50%); z-index:9999; background:#fef3c7; border:1px solid #f59e0b; border-radius:10px; padding:12px 20px; font-size:13px; font-weight:500; color:#92400e; box-shadow:0 4px 12px rgba(0,0,0,0.15); align-items:center; gap:10px;">
    ⚠️ Hay cambios nuevos disponibles —
    <a href="javascript:location.reload()" style="color:#92400e; font-weight:700; text-decoration:underline;">recargá la página</a>
</div>

<script>
const entradaId = {{ $entrada->id }};
const timestampAsesor  = "{{ $entrada->detalleTecnico?->asesor_updated_at ?? '' }}";
const timestampTecnico = "{{ $entrada->detalleTecnico?->tecnico_updated_at ?? '' }}";

if (timestampAsesor || timestampTecnico) {
    setInterval(async function() {
        try {
            const r = await fetch('/tecnico/detalle/' + entradaId + '/check-update');
            const d = await r.json();
            if (
                (d.asesor_updated_at  && d.asesor_updated_at  !== timestampAsesor) ||
                (d.tecnico_updated_at && d.tecnico_updated_at !== timestampTecnico)
            ) {
                document.getElementById('banner-actualizacion').style.display = 'flex';
            }
        } catch(e) {}
    }, 30000);
}
</script>
</x-panel-layout>
