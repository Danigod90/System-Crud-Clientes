<?php

namespace App\Http\Controllers\Asesor;

use App\Http\Controllers\Controller;
use App\Models\EntradaConNota;
use App\Models\Asesor;
use Illuminate\Support\Facades\Auth;

class MisOrganizacionesController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $asesores = Asesor::orderBy('nombre')->get();

        $query = EntradaConNota::where('asesor_asignado', $user->name);

        if (request('organizacion')) {
            $query->where('nombre_organizacion', 'like', '%' . request('organizacion') . '%');
        }
        if (request('asunto')) {
    $asunto = request('asunto');
    if (in_array($asunto, ['char_realizada', 'char_pendiente', 'char_suspendida', 'char_cancelada'])) {
        $estado = str_replace('char_', '', $asunto);
        $query->where('asunto_char', true)
              ->whereHas('charla', fn($q) => $q->where('estado', $estado));
    } else {
        $query->where('asunto_' . $asunto, true);
    }
}
        if (request('mes_ingreso')) {
            $query->whereYear('created_at', substr(request('mes_ingreso'), 0, 4))
                  ->whereMonth('created_at', substr(request('mes_ingreso'), 5, 2));
        }
        if (request('estado_charla')) {
            $query->whereHas('charla', fn($q) => $q->where('estado', request('estado_charla')));
        }

        $entradas = $query->latest()->paginate(15);

        return view('asesor.mis-organizaciones', compact('entradas', 'asesores'));
    }

    public function edit(EntradaConNota $entrada)
    {
        $entrada->load('charla');
        return view('asesor.edit', compact('entrada'));
    }
}
