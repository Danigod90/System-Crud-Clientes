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
            'archivo' => 'required|file|max:10240|extensions:pdf,doc,docx,jpg,jpeg,png,gif,xls,xlsx',
            'nombre'  => 'nullable|string|max:255',
        ]);

        $entrada = EntradaConNota::findOrFail($entradaId);
        $archivo = $request->file('archivo');
        $extension = strtolower($archivo->getClientOriginalExtension());
        $nombre = $request->nombre ?: $archivo->getClientOriginalName();
        $mimeType = $archivo->getMimeType();
        $tamanio = $archivo->getSize();

        $nombreArchivo = uniqid() . '_' . time() . '.' . $extension;

        $archivo->storeAs("documentos/{$entradaId}", $nombreArchivo, 'public');
        $ruta = "documentos/{$entradaId}/{$nombreArchivo}";

        Documento::create([
            'entrada_con_nota_id' => $entradaId,
            'nombre'              => $nombre,
            'ruta'                => $ruta,
            'tipo'                => $mimeType,
            'extension'           => $extension,
            'tamanio'             => $tamanio,
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

    // TODO: agregar verificación de permisos antes del redirect (Tarea #13)

    return redirect(Storage::disk('public')->url($documento->ruta));
}
}
