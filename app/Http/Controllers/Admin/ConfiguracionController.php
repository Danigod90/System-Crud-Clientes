<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Configuracion;
use Illuminate\Http\Request;

class ConfiguracionController extends Controller
{
    public function index()
    {
        $presidente = Configuracion::where('clave', 'presidente_actual')->first();
        return view('admin.configuracion.index', compact('presidente'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'valor' => 'required|string|max:255',
        ]);

        Configuracion::where('clave', 'presidente_actual')
            ->update(['valor' => $request->valor]);

        return redirect()->route('admin.configuracion.index')
            ->with('success', 'Presidente actualizado correctamente.');
    }
}
