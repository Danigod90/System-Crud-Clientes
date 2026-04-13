<?php

namespace App\Http\Controllers;

use App\Models\DetalleTecnico;
use App\Models\EntradaConNota;
use Illuminate\Http\Request;

class DetalleTecnicoController extends Controller
{
    // ── PANEL ASESOR ──
    public function createAsesor($entrada_id)
    {
        $entrada = EntradaConNota::findOrFail($entrada_id);
        $detalle = DetalleTecnico::firstOrNew(['entrada_id' => $entrada_id]);
        return view('detalle_tecnico.asesor', compact('entrada', 'detalle'));
    }

    public function saveAsesor(Request $request, $entrada_id)
{
    $detalle = DetalleTecnico::firstOrNew(['entrada_id' => $entrada_id]);

    $detalle->entrada_id               = $entrada_id;
    $detalle->organo_electoral         = $request->organo_electoral;
    $detalle->cantidad_listas          = $request->cantidad_listas;
    $detalle->cantidad_papeletas       = $request->cantidad_papeletas;
    $detalle->cantidad_mesas           = $request->cantidad_mesas;
    $detalle->sistema_eleccion_general = null;

    // Papeletas — solo actualiza si vienen en el request
// Papeletas — solo actualiza si vienen en el request con valor
for ($p = 1; $p <= 10; $p++) {
    for ($l = 1; $l <= 5; $l++) {
        if ($request->has("pap_{$p}_lista_{$l}_nombre")) {
            $detalle->{"pap_{$p}_lista_{$l}_nombre"} = $request->{"pap_{$p}_lista_{$l}_nombre"} ?: null;
        }
        if ($request->has("pap_{$p}_lista_{$l}_candidatura")) {
            $detalle->{"pap_{$p}_lista_{$l}_candidatura"} = $request->{"pap_{$p}_lista_{$l}_candidatura"} ?: null;
        }
    }
    if ($request->has("pap_{$p}_sistema_eleccion")) {
        $detalle->{"pap_{$p}_sistema_eleccion"} = $request->{"pap_{$p}_sistema_eleccion"} ?: null;
    }
}

 $detalle->asesor_updated_at = now();
    $detalle->save();

    return redirect()->back()->with('success', 'Datos técnicos guardados correctamente.');
}

    public function enviarTecnica($entrada_id)
    {
        $detalle = DetalleTecnico::where('entrada_id', $entrada_id)->firstOrFail();
        $detalle->enviado_tecnica    = true;
        $detalle->enviado_tecnica_at = now();
        $detalle->asesor_updated_at = now();
        $detalle->save();

        return redirect()->back()->with('success', 'Enviado a técnica correctamente.');
    }

    // ── PANEL TÉCNICO ──
    public function createTecnico($entrada_id)
    {
        $entrada = EntradaConNota::findOrFail($entrada_id);
        $detalle = DetalleTecnico::firstOrNew(['entrada_id' => $entrada_id]);
        return view('detalle_tecnico.tecnico', compact('entrada', 'detalle'));
    }

    public function saveTecnico(Request $request, $entrada_id)
    {
        $detalle = DetalleTecnico::firstOrNew(['entrada_id' => $entrada_id]);
        $detalle->entrada_id = $entrada_id;

       // Papeletas — solo actualiza si vienen en el request
for ($p = 1; $p <= 10; $p++) {
    for ($l = 1; $l <= 5; $l++) {
        if ($request->has("pap_{$p}_lista_{$l}_nombre")) {
            $detalle->{"pap_{$p}_lista_{$l}_nombre"} = $request->{"pap_{$p}_lista_{$l}_nombre"} ?: null;
        }
        if ($request->has("pap_{$p}_lista_{$l}_candidatura")) {
            $detalle->{"pap_{$p}_lista_{$l}_candidatura"} = $request->{"pap_{$p}_lista_{$l}_candidatura"} ?: null;
        }
    }
    if ($request->has("pap_{$p}_sistema_eleccion")) {
        $detalle->{"pap_{$p}_sistema_eleccion"} = $request->{"pap_{$p}_sistema_eleccion"} ?: null;
    }
}


       // Materiales finales calculados
        $detalle->mat_final_actas    = $request->mat_final_actas;
        $detalle->mat_final_padrones = $request->mat_final_padrones;
        $detalle->mat_final_cuartos  = $request->mat_final_cuartos;
        $detalle->mat_final_urnas    = $request->mat_final_urnas;
        $mesas = $detalle->cantidad_mesas ?? 0;
        $detalle->mat_mesas                     = $request->mat_mesas ?? $detalle->mat_mesas ?? $mesas;
        $detalle->mat_actas_electorales         = $request->mat_actas_electorales ?? $detalle->mat_actas_electorales ?? ($mesas * 3);
        $detalle->mat_actas_electorales_formato = $request->mat_actas_electorales_formato;
        $detalle->mat_padron                    = $request->mat_padron ?? $detalle->mat_padron ?? ($mesas * 3);
        $detalle->mat_padron_formato            = $request->mat_padron_formato;
        $detalle->mat_matriz_boletin = $request->mat_matriz_boletin ?? $detalle->mat_matriz_boletin ?? $detalle->cantidad_papeletas;
        $detalle->mat_matriz_boletin_formato    = $request->mat_matriz_boletin_formato;
        $detalle->mat_actas_proclamacion        = $request->mat_actas_proclamacion;
        $detalle->mat_certificados              = $request->mat_certificados;
        $detalle->mat_cuenta_votos              = $request->mat_cuenta_votos;

        // Padrón
        $detalle->padron_definitivo         = $request->has('padron_definitivo') ? 1 : 0;
        $detalle->padron_con_cedula         = $request->has('padron_con_cedula') ? 1 : 0;
        $detalle->cantidad_electores        = $request->cantidad_electores;
        $detalle->cantidad_electores_sin_ci = $request->cantidad_electores_sin_ci;

        // Responsables
        $detalle->resp_actas_electorales = $request->resp_actas_electorales;
        $detalle->resp_papeletas         = $request->resp_papeletas;
        $detalle->resp_padron_electoral  = $request->resp_padron_electoral;

        $detalle->save();

        return redirect()->back()->with('success', 'Datos técnicos guardados correctamente.');
    }

    public function imprimirLogistica($entrada_id)
    {
        $detalle = DetalleTecnico::where('entrada_id', $entrada_id)->firstOrFail();
        $detalle->impreso    = true;
        $detalle->impreso_at = now();
        $detalle->save();

        return redirect()->back()->with('success', 'Marcado como impreso.');
    }
    public function marcarRealizado($entrada_id)
{
    $detalle = DetalleTecnico::where('entrada_id', $entrada_id)->firstOrFail();
    $detalle->tec_realizado    = true;
    $detalle->tec_realizado_at = now();
    $detalle->save();

    return redirect()->back()->with('success', 'Trabajo técnico marcado como realizado.');
}
public function checkAsesorUpdate($entrada_id)
{
    $detalle = DetalleTecnico::where('entrada_id', $entrada_id)->firstOrFail();
    return response()->json([
        'asesor_updated_at' => $detalle->asesor_updated_at
    ]);
}
}
