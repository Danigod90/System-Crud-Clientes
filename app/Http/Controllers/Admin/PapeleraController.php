<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EntradaConNota;

class PapeleraController extends Controller
{
    public function index()
    {
        $eliminadas = EntradaConNota::onlyTrashed()
            ->with('eliminadoPor')
            ->orderByDesc('deleted_at')
            ->paginate(10);

        return view('admin.papelera.index', compact('eliminadas'));
    }

    public function restore($id)
    {
        $conNota = EntradaConNota::onlyTrashed()->findOrFail($id);
        $conNota->restore();

        return redirect()->route('admin.papelera.index')
            ->with('success', 'Organización "' . $conNota->nombre_organizacion . '" restaurada correctamente.');
    }

    // Borrado definitivo desde la Papelera — esto sí es para siempre, no hay
    // otra papelera después de esta.
    public function forceDelete($id)
    {
        $conNota = EntradaConNota::onlyTrashed()->findOrFail($id);
        $nombre = $conNota->nombre_organizacion;
        $conNota->forceDelete();

        return redirect()->route('admin.papelera.index')
            ->with('success', 'Organización "' . $nombre . '" eliminada definitivamente.');
    }
}
