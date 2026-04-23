<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use App\Models\EntradaConNota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentoController extends Controller
{
    public function store(Request $request, $entradaId)
    {
        $request->validate([
            'archivo' => 'required|file|max:10240|mimes:pdf,doc,docx,jpg,jpeg,png,gif,xls,xlsx',
            'nombre'  => 'nullable|string|max:255',
        ]);

        $entrada = EntradaConNota::findOrFail($entradaId);
        $archivo = $request->file('archivo');
        $extension = $archivo->getClientOriginalExtension();
        $nombre = $request->nombre ?: $archivo->getClientOriginalName();
        $ruta = $archivo->store("documentos/{$entradaId}", 'public');

        Documento::create([
            'entrada_con_nota_id' => $entradaId,
            'nombre'              => $nombre,
            'ruta'                => $ruta,
            'tipo'                => $archivo->getMimeType(),
            'extension'           => $extension,
            'tamanio'             => $archivo->getSize(),
            'user_id'             => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Documento subido correctamente.');
    }

    public function destroy($id)
    {
        $documento = Documento::findOrFail($id);
        Storage::disk('public')->delete($documento->ruta);
        $documento->delete();
        return redirect()->back()->with('success', 'Documento eliminado correctamente.');
    }

    public function show($id)
    {
        $documento = Documento::findOrFail($id);
        $path = Storage::disk('public')->path($documento->ruta);
        return response()->file($path, [
            'Content-Type' => $documento->tipo,
        ]);
    }
}
