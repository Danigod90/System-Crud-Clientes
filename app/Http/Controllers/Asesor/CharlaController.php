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
    'modalidad'   => 'required|in:virtual,presencial_oficina,presencial_externa',
    'fecha_hora'  => 'nullable|date',
    'direccion'   => 'nullable|string|max:255',
    'descripcion' => 'nullable|string|max:1000',
]);

        $charlaExistente = $entrada->charla;
        $nuevosDatos = [
            'modalidad'  => $request->modalidad,
            'fecha_hora' => $request->fecha_hora,
            'direccion'  => $request->modalidad === 'presencial_externa' ? $request->direccion : null,
            'descripcion' => $request->descripcion,
        ];

 $estadosQueResetean = ['suspendida', 'cancelada'];
if ($charlaExistente && in_array($charlaExistente->estado, $estadosQueResetean) &&
    $charlaExistente->fecha_hora?->format('Y-m-d H:i') !== date('Y-m-d H:i', strtotime($request->fecha_hora))) {
    $nuevosDatos['estado'] = 'pendiente';
}

        Charla::updateOrCreate(
            ['entrada_con_nota_id' => $entrada->id],
            $nuevosDatos
        );

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
}
