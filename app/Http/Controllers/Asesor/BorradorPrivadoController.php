<?php

namespace App\Http\Controllers\Asesor;

use App\Http\Controllers\Controller;
use App\Models\BorradorPrivado;
use App\Models\BorradorTarea;
use App\Models\Asesor;
use App\Models\TipoOrganizacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorradorPrivadoController extends Controller
{
    private function getAsesor()
    {
        return Asesor::where('user_id', Auth::id())->firstOrFail();
    }

    public function index()
    {
        $asesor = $this->getAsesor();
        $borradores = BorradorPrivado::where('asesor_id', $asesor->id)
            ->orderBy('updated_at', 'desc')
            ->get();
        return view('panel.asesor.borrador.index', compact('borradores'));
    }

    public function create()
    {
        $tipos = TipoOrganizacion::orderBy('nombre')->get();
        return view('panel.asesor.borrador.create', compact('tipos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_organizacion' => 'required|string|max:255',
            'tipo_organizacion'   => 'nullable|string|max:255',
            'nombre_representante'=> 'nullable|string|max:255',
            'telefono_representante' => 'nullable|string|max:50',
            'notas_generales'     => 'nullable|string',
        ]);

        $asesor = $this->getAsesor();

        BorradorPrivado::create([
            'asesor_id'            => $asesor->id,
            'nombre_organizacion'  => $request->nombre_organizacion,
            'tipo_organizacion'    => $request->tipo_organizacion,
            'nombre_representante' => $request->nombre_representante,
            'telefono_representante' => $request->telefono_representante,
            'notas_generales'      => $request->notas_generales,
            'estado'               => 'activo',
        ]);

        return redirect()->route('asesor.borrador.index')
            ->with('success', 'Borrador creado correctamente.');
    }

    public function show($id)
    {
        $asesor = $this->getAsesor();
        $borrador = BorradorPrivado::where('asesor_id', $asesor->id)
            ->with('tareas')
            ->findOrFail($id);
        return view('panel.asesor.borrador.show', compact('borrador'));
    }

    public function storeTarea(Request $request, $id)
    {
        $request->validate([
            'tipo'  => 'required|string',
            'fecha' => 'required|date',
            'nota'  => 'required|string',
        ]);

        $asesor = $this->getAsesor();
        $borrador = BorradorPrivado::where('asesor_id', $asesor->id)->findOrFail($id);

        BorradorTarea::create([
            'borrador_id' => $borrador->id,
            'tipo'        => $request->tipo,
            'fecha'       => $request->fecha,
            'nota'        => $request->nota,
        ]);

        return redirect()->route('asesor.borrador.show', $id)
            ->with('success', 'Tarea registrada.');
    }

    public function enviarAMesaDeEntrada($id)
    {
        $asesor = $this->getAsesor();
        $borrador = BorradorPrivado::where('asesor_id', $asesor->id)->findOrFail($id);

        // Crear en mesa de entrada
        \App\Models\EntradaConNota::create([
            'nombre_organizacion'  => $borrador->nombre_organizacion,
            'tipo_organizacion'    => $borrador->tipo_organizacion ?? '',
            'nombre_representante' => $borrador->nombre_representante ?? '',
            'asesor_asignado'      => $asesor->nombre . ' ' . $asesor->apellido,
            'via_ingreso'          => 'presencial',
            'numero_entrada'       => 'AUTO-' . strtoupper(uniqid()),
            'user_id'              => Auth::id(),
        ]);

        // Marcar borrador como enviado
        $borrador->update([
            'estado'      => 'enviado',
            'enviado_at'  => now(),
        ]);

        return redirect()->route('asesor.borrador.show', $id)
            ->with('success', 'Organización enviada a Mesa de Entrada correctamente.');
    }

    public function destroy($id)
    {
        $asesor = $this->getAsesor();
        $borrador = BorradorPrivado::where('asesor_id', $asesor->id)->findOrFail($id);
        $borrador->delete();

        return redirect()->route('asesor.borrador.index')
            ->with('success', 'Borrador eliminado.');
    }
}
