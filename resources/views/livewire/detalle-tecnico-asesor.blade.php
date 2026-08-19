<div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:20px; margin-bottom:14px; box-shadow:0 1px 4px rgba(0,0,0,0.05);">

    @if($mensajeExito)
    <div style="display:flex; align-items:center; gap:10px; background:#d1fae5; color:#065f46; padding:12px 16px; border-radius:10px; margin-bottom:14px; font-size:13px; border-left:4px solid #16a34a; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
        <svg width="18" height="18" fill="none" stroke="#16a34a" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;">
            <circle cx="12" cy="12" r="10"/><polyline points="9 12 11 14 15 10"/>
        </svg>
        {{ $mensajeExito }}
    </div>
    @endif

    {{-- HEADER --}}
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px; padding-bottom:10px; border-bottom:1px solid #f3f4f6;">
        <h3 style="font-size:13px; font-weight:600; color:#374151; text-transform:uppercase; letter-spacing:0.5px; margin:0; display:flex; align-items:center; gap:8px;">
            Detalle Técnico
            @if($tieneDetalle)
                <span style="display:inline-flex; align-items:center; gap:4px; font-size:11px; font-weight:500; color:#6b7280; text-transform:none;">
                    <span style="width:9px; height:9px; border-radius:50%; background:{{ $tecRealizado ? '#16a34a' : '#eab308' }}; display:inline-block;"></span>
                    {{ $tecRealizado ? 'Realizado' : 'Pendiente' }}
                </span>
            @endif
        </h3>
        @if($tieneDetalle && !$editando)
        <button type="button" wire:click="activarEdicion"
                style="display:inline-flex; align-items:center; gap:6px; background:#f3f4f6; color:#374151; padding:6px 14px; border-radius:8px; font-size:12px; border:none; cursor:pointer; font-weight:500;">
            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
            </svg>
            Editar
        </button>
        @endif
    </div>

    @if(!$editando)
    {{-- ================= VISTA SOLO LECTURA ================= --}}
    <div>
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:12px;">
            <div>
                <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Órgano Electoral</label>
                <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ $organo_electoral ?? '—' }}</p>
            </div>
            <div>
                <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Cantidad de Listas</label>
                <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ $cantidad_listas ?? '—' }}</p>
            </div>
            <div>
                <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Cantidad de Papeletas</label>
                <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ $cantidad_papeletas ?? '—' }}</p>
            </div>
            <div>
                <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.5px;">Cantidad de Mesas</label>
                <p style="font-size:14px; font-weight:600; color:#111827; margin:0;">{{ $cantidad_mesas ?? '—' }}</p>
            </div>
        </div>

        @if((int) $cantidad_papeletas > 0)
        <div style="margin-bottom:12px;">
            <label style="display:block; font-size:11px; font-weight:600; color:#9ca3af; margin-bottom:8px; text-transform:uppercase; letter-spacing:0.5px;">Papeletas</label>
            @for($p = 1; $p <= min((int) $cantidad_papeletas, 10); $p++)
                @php
                    $listaNombres = array_filter($papeletas[$p]['listas'] ?? []);
                @endphp
                <div style="display:grid; grid-template-columns:auto minmax(0,2fr) minmax(0,1fr) minmax(0,1fr); gap:8px; align-items:center; padding:8px 12px; background:#f9fafb; border:1px solid #e5e7eb; border-radius:8px; margin-bottom:6px;">
                    <span style="font-size:12px; font-weight:700; color:#374151; white-space:nowrap;">{{ $this->ordinal($p) }} Papeleta</span>
                    @if(count($listaNombres))
                        <span style="font-size:11px; background:#e5e7eb; color:#374151; padding:2px 8px; border-radius:4px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;" title="{{ implode(', ', $listaNombres) }}">{{ implode(', ', $listaNombres) }}</span>
                    @else
                        <span></span>
                    @endif
                    <span style="font-size:13px; color:#111827; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;" title="{{ $papeletas[$p]['candidatura'] ?: '—' }}">{{ $papeletas[$p]['candidatura'] ?: '—' }}</span>
                    <span style="font-size:11px; color:#6b7280; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;" title="{{ $papeletas[$p]['sistema'] ?: '—' }}">{{ $papeletas[$p]['sistema'] ?: '—' }}</span>
                </div>
            @endfor
        </div>
        @endif

        @if((int) $cantidad_mesas > 0)
        <div style="background:#eff6ff; border:1px solid #bfdbfe; border-radius:8px; padding:12px 16px;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin:0 0 10px;">
                <p style="font-size:11px; font-weight:700; color:#1e40af; text-transform:uppercase; margin:0;">Materiales a Entregar</p>
            </div>
            <div style="display:grid; grid-template-columns:repeat(6,1fr); gap:8px;">
                <div style="text-align:center;">
                    <p style="font-size:11px; color:#6b7280; margin:0 0 2px;">Papeletas</p>
                    <p style="font-size:18px; font-weight:700; color:#1e40af; margin:0;">{{ $mat_final_papeletas ?? 0 }}</p>
                    @if($mat_final_papeletas_formato)
                    <p style="font-size:10px; color:#6b7280; margin:2px 0 0;">{{ ucfirst($mat_final_papeletas_formato) }}</p>
                    @endif
                </div>
                <div style="text-align:center;">
                    <p style="font-size:11px; color:#6b7280; margin:0 0 2px;">Actas</p>
                    <p style="font-size:18px; font-weight:700; color:#1e40af; margin:0;">{{ $mat_final_actas ?? 0 }}</p>
                    @if($mat_final_actas_formato)
                    <p style="font-size:10px; color:#6b7280; margin:2px 0 0;">{{ ucfirst($mat_final_actas_formato) }}</p>
                    @endif
                </div>
                <div style="text-align:center;">
                    <p style="font-size:11px; color:#6b7280; margin:0 0 2px;">Padrones</p>
                    <p style="font-size:18px; font-weight:700; color:#1e40af; margin:0;">{{ $mat_final_padrones ?? 0 }}</p>
                    @if($mat_final_padrones_formato)
                    <p style="font-size:10px; color:#6b7280; margin:2px 0 0;">{{ ucfirst($mat_final_padrones_formato) }}</p>
                    @endif
                </div>
                @if($entrada->asunto_log)
                <div style="text-align:center;">
                    <p style="font-size:11px; color:#6b7280; margin:0 0 2px;">Cuartos Oscuros</p>
                    <p style="font-size:18px; font-weight:700; color:#1e40af; margin:0;">{{ $mat_final_cuartos ?? 0 }}</p>
                </div>
                <div style="text-align:center;">
                    <p style="font-size:11px; color:#6b7280; margin:0 0 2px;">Urnas</p>
                    <p style="font-size:18px; font-weight:700; color:#1e40af; margin:0;">{{ $mat_final_urnas ?? 0 }}</p>
                </div>
                <div style="text-align:center;">
                    <p style="font-size:11px; color:#6b7280; margin:0 0 2px;">Tintas</p>
                    <p style="font-size:18px; font-weight:700; color:#1e40af; margin:0;">{{ $mat_final_tintas ?? 0 }}</p>
                </div>
                @endif
            </div>
        </div>
        @endif

        @if($nota_asesor)
        <div style="margin-top:10px; background:#fef9c3; border:1px solid #fde047; border-radius:8px; padding:10px 14px; display:flex; gap:8px;">
            <svg width="15" height="15" fill="none" stroke="#854d0e" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0; margin-top:1px;">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                <polyline points="14 2 14 8 20 8"/>
                <line x1="16" y1="13" x2="8" y2="13"/>
                <line x1="16" y1="17" x2="8" y2="17"/>
            </svg>
            <div>
                <p style="font-size:11px; font-weight:700; color:#854d0e; text-transform:uppercase; margin:0 0 4px;">Importante</p>
                <p style="font-size:13px; color:#713f12; margin:0;">{{ $nota_asesor }}</p>
            </div>
        </div>
        @endif
    </div>

    @else
    {{-- ================= FORMULARIO EDITABLE ================= --}}
    <style>
        @keyframes girar { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
        .spinner-guardar { animation: girar 0.7s linear infinite; }
    </style>
    <form
        x-data="{}"
        @submit.prevent="
            if (!$wire.mat_final_papeletas_formato || !$wire.mat_final_actas_formato || !$wire.mat_final_padrones_formato) {
                $wire.guardar();
            } else if (confirm('¿Confirmás guardar y enviar los datos técnicos?')) {
                $wire.guardar();
            }
        "
    >

        @if($errors->any())
        <div style="background:#fee2e2; border:1px solid #fecaca; color:#991b1b; padding:12px 16px; border-radius:10px; margin-bottom:14px; font-size:13px;">
            <ul style="margin:0; padding-left:18px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div style="margin-bottom:14px;">
            <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:8px; text-transform:uppercase; letter-spacing:0.5px;">Órgano Electoral</label>
            <div style="display:flex; gap:10px; flex-wrap:wrap;">
                @foreach(['TEI' => 'T.E.I.', 'JEI' => 'J.E.I.', 'CEI' => 'C.E.I.'] as $value => $label)
                <label style="display:flex; align-items:center; gap:8px; padding:8px 14px; border:1px solid #d1d5db; border-radius:8px; cursor:pointer; background:#fff;">
                    <input type="radio" wire:model="organo_electoral" value="{{ $value }}"
                        style="width:15px; height:15px; accent-color:#2563eb;">
                    <span style="font-size:13px; font-weight:600; color:#374151;">{{ $label }}</span>
                </label>
                @endforeach
            </div>
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:12px; margin-bottom:14px;">
            <div>
                <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Cantidad de Papeletas</label>
                <input type="number" wire:model.live.debounce.400ms="cantidad_papeletas" min="0" max="10"
                    style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; background:#fff; box-sizing:border-box;">
            </div>
            <div>
                <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Cantidad de Listas</label>
                <input type="number" wire:model.live.debounce.400ms="cantidad_listas" min="0"
                    style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; background:#fff; box-sizing:border-box;">
            </div>
            <div>
                <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:5px; text-transform:uppercase; letter-spacing:0.5px;">Cantidad de Mesas</label>
                <input type="number" wire:model.live.debounce.400ms="cantidad_mesas" min="1"
                    style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:7px 10px; font-size:13px; color:#374151; outline:none; background:#fff; box-sizing:border-box;">
            </div>
        </div>

        <div style="margin-bottom:14px;">
            <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; margin-bottom:8px; text-transform:uppercase; letter-spacing:0.5px;">Papeletas</label>

            @for($p = 1; $p <= min((int) $cantidad_papeletas, 10); $p++)
            <div wire:key="papeleta-{{ $p }}" style="background:#f9fafb; border:1px solid #e5e7eb; border-radius:10px; padding:14px; margin-bottom:10px;">
                <p style="font-size:12px; font-weight:700; color:#374151; margin:0 0 10px;">{{ $this->ordinal($p) }} Papeleta</p>
                <div style="display:flex; gap:8px; align-items:flex-start;">
                    <div style="flex:1; display:flex; flex-direction:column; gap:4px;">
                        <label style="font-size:11px; font-weight:600; color:#6b7280; text-transform:uppercase;">Lista</label>
                        @for($l = 1; $l <= min((int) $cantidad_listas, 5); $l++)
                        <input type="text" wire:model="papeletas.{{ $p }}.listas.{{ $l }}"
                            placeholder="{{ $this->ordinal($l) }} Lista"
                            style="width:100%; border:1px solid #d1d5db; border-radius:6px; padding:5px 7px; font-size:12px; color:#111827; background:#fff; box-sizing:border-box; margin-bottom:4px;">
                        @endfor
                    </div>
                    <div style="flex:1;">
                        <label style="font-size:11px; font-weight:600; color:#6b7280; text-transform:uppercase; display:block; margin-bottom:4px;">Candidatura</label>
                        <input type="text" wire:model="papeletas.{{ $p }}.candidatura"
                            list="candidaturas-asesor-list" placeholder="Candidatura..."
                            style="width:100%; border:1px solid #d1d5db; border-radius:6px; padding:5px 7px; font-size:12px; color:#111827; background:#fff; box-sizing:border-box;">
                    </div>
                    <div style="flex:1;">
                        <label style="font-size:11px; font-weight:600; color:#6b7280; text-transform:uppercase; display:block; margin-bottom:4px;">Sistema de Elección</label>
                        <select wire:model="papeletas.{{ $p }}.sistema"
                            style="width:100%; border:1px solid #d1d5db; border-radius:6px; padding:5px 7px; font-size:12px; color:#111827; background:#fff; box-sizing:border-box;">
                            <option value="">Sistema...</option>
                            @foreach($sistemasEleccion as $op)
                                <option value="{{ $op }}">{{ $op }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            @endfor

            <datalist id="candidaturas-asesor-list">
                @foreach($candidaturasSugeridas as $c)
                <option value="{{ $c }}">
                @endforeach
            </datalist>
        </div>

        <div style="margin-bottom:14px;">
            <p style="font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase; margin:0 0 10px;">*Campo Obligatorio* Cargar manualmente los Materiales a Entregar</p>
            <div style="background:#eff6ff; border:1px solid #bfdbfe; border-radius:10px; padding:16px;">
                <p style="font-size:11px; font-weight:600; color:#1e40af; margin:0 0 12px; text-transform:uppercase;">podés editar los valores  ej: una(1) mesa se imprime 3 actas y 3 padrones</p>
                <div style="display:grid; grid-template-columns:repeat(6,1fr); gap:12px;">
                    <div>
                        <label style="display:block; font-size:11px; font-weight:600; color:#1e40af; margin-bottom:6px; text-transform:uppercase;">Papeletas</label>
                        <input type="number" wire:model.live.debounce.400ms="mat_final_papeletas" min="0"
                            style="width:100%; border:1px solid #bfdbfe; border-radius:6px; padding:6px 8px; font-size:14px; font-weight:700; color:#1e40af; background:#fff; box-sizing:border-box; text-align:center; margin-bottom:4px;">
                        <select wire:model.live="mat_final_papeletas_formato" style="width:100%; border:1px solid {{ $errors->has('mat_final_papeletas_formato') ? '#f87171' : '#bfdbfe' }}; border-radius:6px; padding:5px 6px; font-size:11px; color:#1e40af; background:#fff; box-sizing:border-box;">
                            <option value="">Formato...</option>
                            <option value="impreso">Impreso</option>
                            <option value="digital">Digital</option>
                            <option value="sin_papeletas">Sin Papeletas</option>
                        </select>
                        @error('mat_final_papeletas_formato')
                        <p style="font-size:10px; color:#dc2626; margin:3px 0 0;">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label style="display:block; font-size:11px; font-weight:600; color:#1e40af; margin-bottom:6px; text-transform:uppercase;">Actas</label>
                        <input type="number" wire:model="mat_final_actas" min="0"
                            style="width:100%; border:1px solid #bfdbfe; border-radius:6px; padding:6px 8px; font-size:14px; font-weight:700; color:#1e40af; background:#fff; box-sizing:border-box; text-align:center; margin-bottom:4px;">
                        <select wire:model.live="mat_final_actas_formato" style="width:100%; border:1px solid {{ $errors->has('mat_final_actas_formato') ? '#f87171' : '#bfdbfe' }}; border-radius:6px; padding:5px 6px; font-size:11px; color:#1e40af; background:#fff; box-sizing:border-box;">
                            <option value="">Formato...</option>
                            <option value="impreso">Impreso</option>
                            <option value="digital">Digital</option>
                            <option value="sin_actas">Sin Actas</option>
                        </select>
                        @error('mat_final_actas_formato')
                        <p style="font-size:10px; color:#dc2626; margin:3px 0 0;">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label style="display:block; font-size:11px; font-weight:600; color:#1e40af; margin-bottom:6px; text-transform:uppercase;">Padrones</label>
                        <input type="number" wire:model="mat_final_padrones" min="0"
                            style="width:100%; border:1px solid #bfdbfe; border-radius:6px; padding:6px 8px; font-size:14px; font-weight:700; color:#1e40af; background:#fff; box-sizing:border-box; text-align:center; margin-bottom:4px;">
                        <select wire:model.live="mat_final_padrones_formato" style="width:100%; border:1px solid {{ $errors->has('mat_final_padrones_formato') ? '#f87171' : '#bfdbfe' }}; border-radius:6px; padding:5px 6px; font-size:11px; color:#1e40af; background:#fff; box-sizing:border-box;">
                            <option value="">Formato...</option>
                            <option value="impreso">Impreso</option>
                            <option value="digital">Digital</option>
                            <option value="sin_padron">Sin Padrón</option>
                        </select>
                        @error('mat_final_padrones_formato')
                        <p style="font-size:10px; color:#dc2626; margin:3px 0 0;">{{ $message }}</p>
                        @enderror
                    </div>
                    @if($entrada->asunto_log)
                    <div>
                        <label style="display:block; font-size:11px; font-weight:600; color:#1e40af; margin-bottom:6px; text-transform:uppercase;">Cuartos</label>
                        <input type="number" wire:model="mat_final_cuartos" min="0"
                            style="width:100%; border:1px solid #bfdbfe; border-radius:6px; padding:6px 8px; font-size:14px; font-weight:700; color:#1e40af; background:#fff; box-sizing:border-box; text-align:center;">
                    </div>
                    <div>
                        <label style="display:block; font-size:11px; font-weight:600; color:#1e40af; margin-bottom:6px; text-transform:uppercase;">Urnas</label>
                        <input type="number" wire:model="mat_final_urnas" min="0"
                            style="width:100%; border:1px solid #bfdbfe; border-radius:6px; padding:6px 8px; font-size:14px; font-weight:700; color:#1e40af; background:#fff; box-sizing:border-box; text-align:center;">
                    </div>
                    <div>
                        <label style="display:block; font-size:11px; font-weight:600; color:#1e40af; margin-bottom:6px; text-transform:uppercase;">Tintas</label>
                        <input type="number" wire:model="mat_final_tintas" min="0"
                            style="width:100%; border:1px solid #bfdbfe; border-radius:6px; padding:6px 8px; font-size:14px; font-weight:700; color:#1e40af; background:#fff; box-sizing:border-box; text-align:center;">
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div style="margin-top:14px;">
            <div style="display:flex; align-items:center; gap:8px; margin-bottom:8px;">
                <svg width="15" height="15" fill="none" stroke="#374151" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/>
                    <line x1="16" y1="17" x2="8" y2="17"/>
                    <polyline points="10 9 9 9 8 9"/>
                </svg>
                <label style="font-size:11px; font-weight:700; color:#374151; text-transform:uppercase; letter-spacing:0.5px;">Importante — Nota para Técnica</label>
            </div>
            <textarea wire:model="nota_asesor" rows="3"
                placeholder="Escribí acá cualquier detalle importante que técnica deba saber..."
                style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:8px 10px; font-size:13px; color:#374151; outline:none; box-sizing:border-box; resize:vertical;"></textarea>
        </div>

        <div style="display:flex; justify-content:flex-end; gap:8px; margin-top:14px;">
            @if($tieneDetalle)
            <button type="button" wire:click="cancelarEdicion"
                    wire:loading.attr="disabled" wire:target="guardar"
                    style="display:inline-flex; align-items:center; gap:6px; background:#f3f4f6; color:#374151; padding:8px 18px; border-radius:8px; font-size:13px; border:none; cursor:pointer; font-weight:500;">
                Cancelar
            </button>
            @endif
            <button type="submit"
                    wire:loading.attr="disabled" wire:target="guardar"
                    style="display:inline-flex; align-items:center; gap:6px; background:#2563eb; color:white; padding:8px 18px; border-radius:8px; font-size:13px; border:none; cursor:pointer; font-weight:500;">
                <span wire:loading.remove.inline-flex wire:target="guardar" style="align-items:center; gap:6px;">
                    Guardar y Enviar
                </span>
                <span wire:loading.inline-flex wire:target="guardar" style="align-items:center; gap:6px;">
                    <svg class="spinner-guardar" width="13" height="13" fill="none" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="9" stroke="rgba(255,255,255,0.35)" stroke-width="3"/>
                        <path d="M21 12a9 9 0 0 0-9-9" stroke="#fff" stroke-width="3" stroke-linecap="round"/>
                    </svg>
                    Enviando...
                </span>
            </button>
        </div>
    </form>
    @endif

    {{-- ESTADO ENVÍO A TÉCNICA --}}
    @if($enviadoTecnica)
    <div style="border-top:1px solid #f3f4f6; margin-top:16px; padding-top:16px;">
        <span style="font-size:11px; font-weight:600; color:#166534; background:#bbf7d0; padding:2px 8px; border-radius:6px;">
            ✓ Enviado a Técnica
            @if($enviadoTecnicaAt)
                — {{ $enviadoTecnicaAt->format('d/m/Y H:i') }}
            @endif
        </span>
    </div>
    @endif

</div>
