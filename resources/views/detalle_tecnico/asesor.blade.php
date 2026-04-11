@extends('layouts.app')

@section('content')
<div style="padding:32px; max-width:900px; margin:0 auto;">

    {{-- ENCABEZADO --}}
    <div style="margin-bottom:24px;">
        <h2 style="font-size:18px; font-weight:800; color:#111827; margin:0 0 4px;">
            Detalle Técnico — Panel Asesor
        </h2>
        <p style="font-size:13px; color:#6b7280; margin:0;">
            {{ $entrada->organizacion->nombre ?? '—' }} &nbsp;·&nbsp; ORG-{{ str_pad($entrada->id, 4, '0', STR_PAD_LEFT) }}
        </p>
    </div>

    {{-- ALERTA --}}
    @if(session('success'))
    <div style="background:#d1fae5; border:1px solid #6ee7b7; border-radius:8px; padding:12px 16px; margin-bottom:20px; font-size:13px; color:#065f46;">
        {{ session('success') }}
    </div>
    @endif

    {{-- ESTADO ENVÍO --}}
    @if($detalle->enviado_tecnica)
    <div style="background:#eff6ff; border:1px solid #bfdbfe; border-radius:8px; padding:12px 16px; margin-bottom:20px; font-size:13px; color:#1e40af;">
        ✅ Enviado a Técnica el {{ $detalle->enviado_tecnica_at?->format('d/m/Y H:i') }}
    </div>
    @endif

    <form action="{{ route('asesor.detalle_tecnico.saveAsesor', $entrada->id) }}" method="POST">
        @csrf

        {{-- ÓRGANO ELECTORAL --}}
        <div style="background:#f9fafb; border:1px solid #e5e7eb; border-radius:12px; padding:20px; margin-bottom:20px;">
            <p style="font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase; margin:0 0 14px;">Órgano Electoral</p>
            <div style="display:flex; gap:16px; flex-wrap:wrap;">
                @foreach(['TEI' => 'T.E.I. — Tribunal Electoral Independiente', 'JEI' => 'J.E.I. — Junta Electoral Independiente', 'CEI' => 'C.E.I. — Colegio Electoral Independiente'] as $value => $label)
                <label style="display:flex; align-items:center; gap:10px; padding:10px 16px; border:1px solid #d1d5db; border-radius:8px; cursor:pointer; background:#fff;">
                    <input type="radio" name="organo_electoral" value="{{ $value }}"
                        {{ old('organo_electoral', $detalle->organo_electoral) == $value ? 'checked' : '' }}
                        style="width:16px; height:16px; accent-color:#2563eb;">
                    <span style="font-size:13px; font-weight:600; color:#374151;">{{ $label }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- CANTIDAD DE LISTAS Y PAPELETAS --}}
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:20px;">
            <div>
                <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:6px;">Cantidad de Listas</label>
                <input type="number" name="cantidad_listas" min="1" max="10"
                    value="{{ old('cantidad_listas', $detalle->cantidad_listas) }}"
                    style="width:100%; padding:10px 12px; border:1px solid #d1d5db; border-radius:8px; font-size:14px; color:#111827; background:#fff; box-sizing:border-box;">
            </div>
            <div>
                <label style="display:block; font-size:11px; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:6px;">Cantidad de Papeletas</label>
                <input type="number" name="cantidad_papeletas" min="1" max="10"
                    value="{{ old('cantidad_papeletas', $detalle->cantidad_papeletas) }}"
                    style="width:100%; padding:10px 12px; border:1px solid #d1d5db; border-radius:8px; font-size:14px; color:#111827; background:#fff; box-sizing:border-box;">
            </div>
        </div>

        {{-- SISTEMA DE ELECCIÓN --}}
        <div style="background:#f9fafb; border:1px solid #e5e7eb; border-radius:12px; padding:20px; margin-bottom:28px;">
            <p style="font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase; margin:0 0 14px;">Sistema de Elección</p>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                @foreach([
                    'Lista Única',
                    'Lista Cerrada',
                    'Lista Desbloqueada',
                    'Lista Cerrada Bloqueada',
                    'Nominal',
                ] as $opcion)
                <label style="display:flex; align-items:center; gap:10px; padding:10px 14px; border:1px solid #d1d5db; border-radius:8px; cursor:pointer; background:#fff;">
                    <input type="checkbox" name="sistema_eleccion_general[]" value="{{ $opcion }}"
                        {{ in_array($opcion, explode(',', $detalle->sistema_eleccion_general ?? '')) ? 'checked' : '' }}
                        style="width:16px; height:16px; accent-color:#2563eb;">
                    <span style="font-size:13px; font-weight:600; color:#374151;">{{ $opcion }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- BOTONES --}}
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <a href="{{ url()->previous() }}"
                style="background:#f3f4f6; color:#374151; font-size:13px; font-weight:600; padding:12px 24px; border-radius:8px; text-decoration:none;">
                ← Volver
            </a>
            <div style="display:flex; gap:12px;">
                <button type="submit"
                    style="background:#2563eb; color:#fff; font-size:13px; font-weight:700; padding:12px 28px; border:none; border-radius:8px; cursor:pointer;">
                    Guardar
                </button>
            </div>
        </div>

    </form>

    {{-- BOTÓN ENVIAR A TÉCNICA --}}
    <form action="{{ route('asesor.detalle_tecnico.enviarTecnica', $entrada->id) }}" method="POST" style="margin-top:16px; text-align:right;">
        @csrf
        <button type="submit"
            style="background:#16a34a; color:#fff; font-size:13px; font-weight:700; padding:12px 28px; border:none; border-radius:8px; cursor:pointer;">
            Enviar a Técnica ✓
        </button>
    </form>

</div>
@endsection
