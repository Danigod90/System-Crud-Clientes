<?php

namespace App\Http\Controllers\Secretaria;

use App\Http\Controllers\Controller;
use App\Models\EntradaConNota;
use App\Models\Asesor;
use Illuminate\Http\Request;

class EntradaConNotaController extends Controller
{
    public function index(Request $request)
{
    $asesores = Asesor::orderBy('nombre')->get();

    $entradas = EntradaConNota::with(['user', 'charla'])
        ->when($request->organizacion, fn($q) =>
            $q->where('nombre_organizacion', 'like', '%' . $request->organizacion . '%')
        )
        ->when($request->asesor, fn($q) =>
            $q->where('asesor_asignado', $request->asesor)
        )
        ->when($request->asunto, function($q) use ($request) {
            match($request->asunto) {
                'char' => $q->where('asunto_char', true),
                'log'  => $q->where('asunto_log', true),
                'tec'  => $q->where('asunto_tec', true),
            };
        })
        ->when($request->mes_ingreso, fn($q) =>
    $q->whereYear('created_at', substr($request->mes_ingreso, 0, 4))
      ->whereMonth('created_at', substr($request->mes_ingreso, 5, 2))
)
->when($request->mes_eleccion, fn($q) =>
    $q->whereYear('fecha_eleccion', substr($request->mes_eleccion, 0, 4))
      ->whereMonth('fecha_eleccion', substr($request->mes_eleccion, 5, 2))
)
        ->latest()
        ->paginate(10);

    return view('secretaria.con_nota.index', compact('entradas', 'asesores'));
}

 public function create()
{
    $asesores = Asesor::orderBy('nombre')->get();
    $tipos = \App\Models\TipoOrganizacion::orderBy('nombre')->get();
    return view('secretaria.con_nota.create', compact('asesores', 'tipos'));
}

public function store(Request $request)
    {
        $request->validate([
            'nombre_organizacion'   => 'required|string|max:255',
            'tipo_organizacion'     => 'required|string|max:255',
            'nombre_representante'  => 'required|string|max:255',
            'telefono_representante'=> 'nullable|string|max:50',
            'fecha_eleccion'        => 'nullable|date',
            'asesor_asignado'       => 'required|string|max:255',
            'via_ingreso'           => 'required|in:correo,presencial',
            'asunto'                => 'required|array|min:1',
            'asunto.*'              => 'in:char,log,tec',
        ]);


      EntradaConNota::create([
    'nombre_organizacion'    => $request->nombre_organizacion,
    'tipo_organizacion'      => $request->tipo_organizacion,
    'nombre_representante'   => $request->nombre_representante,
    'telefono_representante' => $request->telefono_representante,
    'fecha_eleccion'         => $request->fecha_eleccion,
    'asesor_asignado'        => $request->asesor_asignado,
    'via_ingreso'            => $request->via_ingreso,
    'asunto_char'            => in_array('char', $request->asunto),
    'asunto_log'             => in_array('log', $request->asunto),
    'asunto_tec'             => in_array('tec', $request->asunto),
    'log_urnas'              => in_array('log', $request->asunto) ? (int)$request->log_urnas : 0,
    'log_cuartos'            => in_array('log', $request->asunto) ? (int)$request->log_cuartos : 0,
    'log_tintas'             => in_array('log', $request->asunto) ? (int)$request->log_tintas : 0,
    'user_id'                => auth()->id(),
]);
        return redirect()->route('secretaria.con-nota.index')
            ->with('success', 'Mesa de entrada registrada correctamente.');
    }

    public function show(EntradaConNota $conNota)
    {
        return view('secretaria.con_nota.show', compact('conNota'));
    }

    public function edit(EntradaConNota $conNota)
{
    $asesores = Asesor::orderBy('nombre')->get();
    $tipos = \App\Models\TipoOrganizacion::orderBy('nombre')->get();
    return view('secretaria.con_nota.edit', compact('conNota', 'asesores', 'tipos'));
}

    public function update(Request $request, EntradaConNota $conNota)
    {
        $request->validate([
            'nombre_organizacion'    => 'required|string|max:255',
            'tipo_organizacion'      => 'required|string|max:255',
            'nombre_representante'   => 'required|string|max:255',
            'telefono_representante' => 'nullable|string|max:50',
            'fecha_eleccion'         => 'nullable|date',
            'asesor_asignado'        => 'required|string|max:255',
            'via_ingreso'            => 'required|in:correo,presencial',
            'asunto'                 => 'required|array|min:1',
            'asunto.*'               => 'in:char,log,tec',
        ]);

        $conNota->update([
            'nombre_organizacion'    => $request->nombre_organizacion,
            'tipo_organizacion'      => $request->tipo_organizacion,
            'nombre_representante'   => $request->nombre_representante,
            'telefono_representante' => $request->telefono_representante,
            'fecha_eleccion'         => $request->fecha_eleccion,
            'asesor_asignado'        => $request->asesor_asignado,
            'via_ingreso'            => $request->via_ingreso,
            'asunto_char'            => in_array('char', $request->asunto ?? []),
            'asunto_log'             => in_array('log', $request->asunto ?? []),
            'asunto_tec'             => in_array('tec', $request->asunto ?? []),
            'log_urnas'              => in_array('log', $request->asunto ?? []) ? (int)$request->log_urnas : 0,
            'log_cuartos'            => in_array('log', $request->asunto ?? []) ? (int)$request->log_cuartos : 0,
            'log_tintas'             => in_array('log', $request->asunto ?? []) ? (int)$request->log_tintas : 0,
        ]);

        return redirect()->route('secretaria.con-nota.index')
            ->with('success', 'Entrada actualizada correctamente.');
    }

    public function destroy(EntradaConNota $conNota)
{
    $nombre = $conNota->nombre_organizacion;
    $codigo = $conNota->codigo_org;
    $conNota->delete();
    return redirect()->route('secretaria.con-nota.index')
        ->with('error', 'Se elimino la entrada ' . $codigo . ' — ' . $nombre . '.');
}
public function entregarLog(EntradaConNota $conNota)
{
    $conNota->update(['log_estado' => 'entregada']);

    return redirect()->route('secretaria.con-nota.index')
        ->with('success', 'Logística entregada — ' . $conNota->codigo_org . ' — ' . $conNota->nombre_organizacion);
}
}
