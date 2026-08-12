<?php

namespace App\Http\Controllers\Asesor;

use App\Http\Controllers\Controller;
use App\Models\Manual;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ManualController extends Controller
{
    public function index()
    {
        $categoria = request()->routeIs('tecnico.manuales.*') ? 'tecnico' : 'general';
        $manuales = Manual::with('user')->where('categoria', $categoria)->orderBy('created_at', 'desc')->get();
        $charlasPendientes = auth()->user()->charlasPendientes ?? collect();
        $routePrefix = $categoria === 'tecnico' ? 'tecnico.manuales' : 'asesor.manuales';
        $titulo = $categoria === 'tecnico' ? 'Manuales Técnicos' : 'Manuales';
        $subtitulo = $categoria === 'tecnico' ? 'Documentos y recursos para técnicos' : 'Documentos y recursos para asesores';
        return view('asesor.utilidades.manuales', compact('manuales', 'charlasPendientes', 'routePrefix', 'titulo', 'subtitulo'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'archivo' => 'required|file|max:10240|mimes:pdf,doc,docx,jpg,jpeg,png,gif,xls,xlsx',
            'nombre'  => 'nullable|string|max:255',
        ]);

        $categoria = request()->routeIs('tecnico.manuales.*') ? 'tecnico' : 'general';
        $archivo   = $request->file('archivo');
        $extension = $archivo->getClientOriginalExtension();
        $nombre    = $request->nombre ?: $archivo->getClientOriginalName();
        $ruta      = $archivo->store('manuales', 'public');

        Manual::create([
            'nombre'    => $nombre,
            'ruta'      => $ruta,
            'tipo'      => $archivo->getMimeType(),
            'extension' => $extension,
            'tamanio'   => $archivo->getSize(),
            'user_id'   => auth()->id(),
            'categoria' => $categoria,
        ]);

        return redirect()->back()->with('success', 'Manual subido correctamente.');
    }

    public function update(Request $request, Manual $manual)
    {
        $request->validate(['nombre' => 'required|string|max:255']);
        $manual->update(['nombre' => $request->nombre]);
        return redirect()->back()->with('success', 'Nombre actualizado correctamente.');
    }

    public function destroy(Manual $manual)
    {
        Storage::disk('public')->delete($manual->ruta);
        $manual->delete();
        return redirect()->back()->with('success', 'Manual eliminado correctamente.');
    }

    public function show(Manual $manual)
    {
        $path = Storage::disk('public')->path($manual->ruta);
        return response()->file($path, ['Content-Type' => $manual->tipo]);
    }
}
