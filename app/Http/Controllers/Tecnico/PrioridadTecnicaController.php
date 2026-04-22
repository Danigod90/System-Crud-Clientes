<?php

namespace App\Http\Controllers\Tecnico;

use App\Http\Controllers\Controller;
use App\Models\PrioridadTecnica;
use App\Models\EntradaConNota;
use Illuminate\Http\Request;

class PrioridadTecnicaController extends Controller
{
    public function toggle($entradaId)
    {
        $existente = PrioridadTecnica::where('entrada_con_nota_id', $entradaId)->first();

        if ($existente) {
            $existente->delete();
            return response()->json(['activo' => false]);
        }

        $total = PrioridadTecnica::count();
        if ($total >= 5) {
            return response()->json(['error' => 'Máximo 5 organizaciones en prioridad'], 422);
        }

        PrioridadTecnica::create([
            'entrada_con_nota_id' => $entradaId,
            'user_id'             => auth()->id(),
            'orden'               => $total + 1,
        ]);

        return response()->json(['activo' => true]);
    }
}
