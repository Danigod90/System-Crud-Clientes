<?php
namespace App\Http\Controllers\Secretaria;

use App\Http\Controllers\Controller;
use App\Models\EntradaSinNota;
use App\Models\Asesor;
use Illuminate\Http\Request;

class EntradaSinNotaController extends Controller
{
    public function index(Request $request)
{
    $query = EntradaSinNota::with('asesor');

    if ($request->filled('nombre')) {
        $query->where(function($q) use ($request) {
            $q->where('nombre', 'like', '%' . $request->nombre . '%')
              ->orWhere('apellido', 'like', '%' . $request->nombre . '%');
        });
    }

    if ($request->filled('asesor_id')) {
        $query->where('asesor_id', $request->asesor_id);
    }

    if ($request->filled('fecha_desde')) {
        $query->whereDate('created_at', '>=', $request->fecha_desde);
    }

    if ($request->filled('fecha_hasta')) {
        $query->whereDate('created_at', '<=', $request->fecha_hasta);
    }

    $entradas = $query->latest()->paginate(10)->withQueryString();
    $asesores = Asesor::where('activo', true)->get();

    return view('secretaria.sin_nota.index', compact('entradas', 'asesores'));
}

    public function create()
    {
        $asesores = Asesor::where('activo', true)->get();
        return view('secretaria.sin_nota.create', compact('asesores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'      => 'required|string|max:255',
            'apellido'    => 'required|string|max:255',
            'telefono'    => 'nullable|string|max:20',
            'tipo_charla' => 'required|string|max:255',
            'asesor_id'   => 'nullable|exists:asesores,id',
        ]);

        EntradaSinNota::create([
            'nombre'      => $request->nombre,
            'apellido'    => $request->apellido,
            'telefono'    => $request->telefono,
            'tipo_charla' => $request->tipo_charla,
            'asesor_id'   => $request->asesor_id,
            'user_id'     => auth()->id(),
        ]);

        return redirect()->route('secretaria.sin-nota.index')
            ->with('success', 'Entrada registrada correctamente.');
    }

    public function show(EntradaSinNota $sinNota)
    {
        $sinNota->load('asesor');
        return view('secretaria.sin_nota.show', compact('sinNota'));
    }

    public function edit(EntradaSinNota $sinNota)
    {
        $asesores = Asesor::where('activo', true)->get();
        return view('secretaria.sin_nota.edit', compact('sinNota', 'asesores'));
    }

    public function update(Request $request, EntradaSinNota $sinNota)
    {
        $request->validate([
            'nombre'      => 'required|string|max:255',
            'apellido'    => 'required|string|max:255',
            'telefono'    => 'nullable|string|max:20',
            'tipo_charla' => 'required|string|max:255',
            'asesor_id'   => 'nullable|exists:asesores,id',
        ]);

        $sinNota->update([
            'nombre'      => $request->nombre,
            'apellido'    => $request->apellido,
            'telefono'    => $request->telefono,
            'tipo_charla' => $request->tipo_charla,
            'asesor_id'   => $request->asesor_id,
        ]);

        return redirect()->route('secretaria.sin-nota.show', $sinNota)
            ->with('success', 'Entrada actualizada correctamente.');
    }

    public function destroy(EntradaSinNota $sinNota)
    {
        $sinNota->delete();
        return redirect()->route('secretaria.sin-nota.index')
            ->with('success', 'Entrada eliminada correctamente.');
    }
    public function exportPdf(Request $request)
{
    $query = EntradaSinNota::with('asesor');

    if ($request->filled('fecha_desde')) {
        $query->whereDate('created_at', '>=', $request->fecha_desde);
    }

    if ($request->filled('fecha_hasta')) {
        $query->whereDate('created_at', '<=', $request->fecha_hasta);
    }

    if ($request->filled('asesor_id')) {
        $query->where('asesor_id', $request->asesor_id);
    }

    if ($request->filled('nombre')) {
        $query->where(function($q) use ($request) {
            $q->where('nombre', 'like', '%' . $request->nombre . '%')
              ->orWhere('apellido', 'like', '%' . $request->nombre . '%');
        });
    }

    $entradas = $query->latest()->get();
    $fecha_desde = $request->fecha_desde ?? 'inicio';
    $fecha_hasta = $request->fecha_hasta ?? now()->format('Y-m-d');

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('secretaria.sin_nota.pdf', compact('entradas', 'fecha_desde', 'fecha_hasta'));

    return $pdf->stream('reporte-entradas-sin-nota.pdf');
}
}
