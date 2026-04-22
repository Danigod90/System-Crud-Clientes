<?php

namespace App\Http\Controllers\Asesor;

use App\Http\Controllers\Controller;
use App\Models\PrioridadAsesor;
use Illuminate\Http\Request;

class PrioridadAsesorController extends Controller
{
    public function toggle($entradaId)
    {
        $existente = PrioridadAsesor::where('entrada_con_nota_id', $entradaId)
            ->where('user_id', auth()->id())
            ->first();

        if ($existente) {
            $existente->delete();
            return response()->json(['activo' => false]);
        }

        PrioridadAsesor::create([
            'entrada_con_nota_id' => $entradaId,
            'user_id'             => auth()->id(),
        ]);

        return response()->json(['activo' => true]);
    }
}
