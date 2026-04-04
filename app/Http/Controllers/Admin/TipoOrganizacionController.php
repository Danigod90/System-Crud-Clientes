<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TipoOrganizacion;
use Illuminate\Http\Request;

class TipoOrganizacionController extends Controller
{
    public function index()
    {
        $tipos = TipoOrganizacion::orderBy('nombre')->get();
        return view('admin.tipo_organizaciones.index', compact('tipos'));
    }

    public function store(Request $request)
    {
        $request->validate(['nombre' => 'required|string|max:255|unique:tipo_organizaciones,nombre']);
        TipoOrganizacion::create(['nombre' => $request->nombre]);
        return redirect()->route('admin.tipo-organizaciones.index')->with('success', 'Tipo agregado correctamente.');
    }

    public function destroy(TipoOrganizacion $tipoOrganizacion)
    {
        $tipoOrganizacion->delete();
        return redirect()->route('admin.tipo-organizaciones.index')->with('success', 'Tipo eliminado correctamente.');
    }
}
