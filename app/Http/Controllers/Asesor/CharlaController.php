<?php

namespace App\Http\Controllers\Asesor;

use App\Http\Controllers\Controller;
use App\Models\EntradaConNota;
use App\Models\Charla;
use Illuminate\Http\Request;

class CharlaController extends Controller
{
    public function store(Request $request, EntradaConNota $entrada)
{
    $request->validate([
        'charla_id'   => 'nullable|integer|exists:charlas,id',
        'modalidad'   => 'required|in:virtual,presencial_oficina,presencial_externa',
        'fecha_hora'  => 'nullable|date',
        'direccion'   => 'nullable|string|max:255',
        'descripcion' => 'nullable|string|max:1000',
        'char_tipo'   => 'nullable|in:proceso_electoral,mmrv,ambos',
    ]);

    $nuevosDatos = [
        'modalidad'   => $request->modalidad,
        'fecha_hora'  => $request->fecha_hora,
        'direccion'   => $request->modalidad === 'presencial_externa' ? $request->direccion : null,
        'descripcion' => $request->descripcion,
        'char_tipo'   => $request->char_tipo,
    ];

    if ($request->filled('charla_id')) {
        // Editar charla existente
        $charla = Charla::findOrFail($request->charla_id);
        $estadosQueResetean = ['suspendida', 'cancelada'];
        if (in_array($charla->estado, $estadosQueResetean) &&
            $charla->fecha_hora?->format('Y-m-d H:i') !== date('Y-m-d H:i', strtotime($request->fecha_hora))) {
            $nuevosDatos['estado'] = 'pendiente';
        }
        $charla->update($nuevosDatos);
    } else {
       // Nueva charla — máximo 2
        $totalCharlas = $entrada->charlas()->count();
        if ($totalCharlas >= 2) {
            return redirect()->back()->with('error', 'Solo se pueden agregar hasta 2 charlas por organización.');
        }
        $nuevosDatos['entrada_con_nota_id'] = $entrada->id;
        $nuevosDatos['estado'] = 'pendiente';
        Charla::create($nuevosDatos);
    }

    return redirect()->back()->with('success', 'Charla guardada correctamente.');
}

public function updateEstado(Request $request, Charla $charla)
{
    $request->validate([
        'estado' => 'required|in:pendiente,realizada,cancelada,suspendida',
    ]);

    $charla->update(['estado' => $request->estado]);

    return redirect()->back()->with('success', 'Estado actualizado correctamente.');
}
public function destroy(Charla $charla)
{
    $charla->delete();
    return redirect()->back()->with('success', 'Charla eliminada correctamente.');
}
}
