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
    $carpeta = storage_path("app/public/documentos/{$entradaId}");

    if (!file_exists($carpeta)) {
        mkdir($carpeta, 0755, true);
    }

    $archivo->move($carpeta, $nombreArchivo);
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
    $path = Storage::disk('public')->path($documento->ruta);

    $mimes = [
        'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'xls'  => 'application/vnd.ms-excel',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'doc'  => 'application/msword',
        'pdf'  => 'application/pdf',
    ];
    $contentType = $mimes[$documento->extension] ?? $documento->tipo;

    $nombreDescarga = $documento->nombre;
    if (!str_ends_with(strtolower($nombreDescarga), '.' . strtolower($documento->extension))) {
        $nombreDescarga .= '.' . $documento->extension;
    }

    return response()->download($path, $nombreDescarga, [
        'Content-Type' => $contentType,
    ]);
}
}
