<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Asesor;
use Illuminate\Http\Request;

class AsesorController extends Controller
{
    public function index()
    {
        $asesores = Asesor::latest()->paginate(10);
        return view('admin.asesores.index', compact('asesores'));
    }

    public function create()
    {
        return view('admin.asesores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'   => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'cargo'    => 'nullable|string|max:255',
        ]);

        Asesor::create([
            'nombre'   => $request->nombre,
            'apellido' => $request->apellido,
            'cargo'    => $request->cargo,
            'activo'   => true,
        ]);

        return redirect()->route('admin.asesores.index')
            ->with('success', 'Asesor creado correctamente.');
    }

    public function edit(Asesor $asesor)
    {
        return view('admin.asesores.edit', compact('asesor'));
    }

    public function update(Request $request, Asesor $asesor)
    {
        $request->validate([
            'nombre'   => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'cargo'    => 'nullable|string|max:255',
        ]);

        $asesor->update([
            'nombre'   => $request->nombre,
            'apellido' => $request->apellido,
            'cargo'    => $request->cargo,
            'activo'   => $request->has('activo'),
        ]);

        return redirect()->route('admin.asesores.index')
            ->with('success', 'Asesor actualizado correctamente.');
    }

    public function destroy(Asesor $asesor)
    {
        $asesor->delete();
        return redirect()->route('admin.asesores.index')
            ->with('success', 'Asesor eliminado correctamente.');
    }
}
