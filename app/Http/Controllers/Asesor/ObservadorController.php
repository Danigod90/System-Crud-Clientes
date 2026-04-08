<?php

namespace App\Http\Controllers\Asesor;

use App\Http\Controllers\Controller;
use App\Models\EntradaConNota;
use App\Models\Observador;
use Illuminate\Http\Request;

class ObservadorController extends Controller
{
    public function store(Request $request, EntradaConNota $entrada)
    {
        $request->validate([
            'fecha_hora'   => 'nullable|date',
            'direccion'    => 'nullable|string|max:255',
            'observadores' => 'nullable|string',
            'descripcion'  => 'nullable|string|max:1000',
        ]);

        $obsExistente = $entrada->observador;
        $nuevosDatos = [
            'fecha_hora'   => $request->fecha_hora,
            'direccion'    => $request->direccion,
            'observadores' => $request->observadores,
            'descripcion'  => $request->descripcion,
        ];

        $estadosQueResetean = ['suspendida', 'cancelada'];
        if ($obsExistente && in_array($obsExistente->estado, $estadosQueResetean) &&
            $obsExistente->fecha_hora?->format('Y-m-d H:i') !== date('Y-m-d H:i', strtotime($request->fecha_hora))) {
            $nuevosDatos['estado'] = 'pendiente';
        }

        Observador::updateOrCreate(
            ['entrada_con_nota_id' => $entrada->id],
            $nuevosDatos
        );

        return redirect()->back()->with('success', 'Observadores guardado correctamente.');
    }

    public function updateEstado(Request $request, Observador $observador)
    {
        $request->validate([
            'estado' => 'required|in:pendiente,realizada,cancelada,suspendida',
        ]);

        $observador->update(['estado' => $request->estado]);

        return redirect()->back()->with('success', 'Estado actualizado correctamente.');
    }
}
