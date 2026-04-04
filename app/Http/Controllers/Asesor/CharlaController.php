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
            'modalidad'  => 'required|in:virtual,presencial_oficina,presencial_externa',
            'fecha_hora' => 'required|date',
            'direccion'  => 'nullable|string|max:255',
        ]);

        Charla::updateOrCreate(
            ['entrada_con_nota_id' => $entrada->id],
            [
                'modalidad'  => $request->modalidad,
                'fecha_hora' => $request->fecha_hora,
                'direccion'  => $request->modalidad === 'presencial_externa' ? $request->direccion : null,
                'estado'     => 'pendiente',
            ]
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
