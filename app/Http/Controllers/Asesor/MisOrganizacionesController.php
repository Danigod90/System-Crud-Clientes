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
            $query->where('asunto_' . request('asunto'), true);
        }
        if (request('mes_ingreso')) {
            $query->whereYear('created_at', substr(request('mes_ingreso'), 0, 4))
                  ->whereMonth('created_at', substr(request('mes_ingreso'), 5, 2));
        }

        $entradas = $query->latest()->paginate(15);

        return view('asesor.mis-organizaciones', compact('entradas', 'asesores'));
    }
}
