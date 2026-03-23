<?php
namespace App\Http\Controllers\Secretaria;

use App\Http\Controllers\Controller;
use App\Models\EntradaConNota;
use App\Models\ServicioEntrada;
use Illuminate\Http\Request;

class EntradaConNotaController extends Controller
{
    public function index()
    {
        $entradas = EntradaConNota::with('servicios')->latest()->paginate(10);
        return view('secretaria.con_nota.index', compact('entradas'));
    }

    public function create()
    {
        return view('secretaria.con_nota.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_organizacion'  => 'required|string|max:255',
            'tipo_organizacion'    => 'required|string|max:255',
            'nombre_representante' => 'required|string|max:255',
            'asesor_asignado'      => 'nullable|string|max:255',
            'via_ingreso'          => 'required|in:correo,presencial',
            'servicios'            => 'required|array|min:1',
            'servicios.*'          => 'in:asesoramiento_electoral,parte_tecnica,logistica,charla_asesoramiento,charla_mesa_receptora',
        ]);

        $entrada = EntradaConNota::create([
            'nombre_organizacion'  => $request->nombre_organizacion,
            'tipo_organizacion'    => $request->tipo_organizacion,
            'nombre_representante' => $request->nombre_representante,
            'asesor_asignado'      => $request->asesor_asignado,
            'via_ingreso'          => $request->via_ingreso,
            'user_id'              => auth()->id(),
        ]);

        foreach ($request->servicios as $servicio) {
            ServicioEntrada::create([
                'entrada_con_nota_id' => $entrada->id,
                'tipo_servicio'       => $servicio,
                'lugar_charla'        => $request->input("lugar_charla_$servicio"),
                'direccion_charla'    => $request->input("direccion_charla_$servicio"),
                'fecha_hora_charla'   => $request->input("fecha_hora_charla_$servicio"),
            ]);
        }

        return redirect()->route('secretaria.con-nota.index')
            ->with('success', 'Entrada registrada correctamente.');
    }

    public function show(EntradaConNota $conNota)
    {
        $conNota->load('servicios');
        return view('secretaria.con_nota.show', compact('conNota'));
    }
}