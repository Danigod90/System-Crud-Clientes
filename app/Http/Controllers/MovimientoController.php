<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Movimiento;
use App\Models\MovimientoGrupo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class MovimientoController extends Controller
{
    protected function obtenerGrupoAbierto(Cliente $cliente): ?MovimientoGrupo
    {
        return $cliente->grupos()->where('cerrado', false)->latest('created_at')->first();
    }

    protected function obtenerGrupoAbiertoPorFecha(Cliente $cliente, string $fecha): ?MovimientoGrupo
    {
        $grupoAbierto = $this->obtenerGrupoAbierto($cliente);

        if (! $grupoAbierto) {
            return null;
        }

        return $this->grupoCoincideConFecha($grupoAbierto, $fecha) ? $grupoAbierto : null;
    }

    protected function obtenerGrupoActivoParaMovimiento(Cliente $cliente, string $fecha): MovimientoGrupo
    {
        return $this->obtenerGrupoAbierto($cliente) ?? $this->obtenerOcrearGrupoPorFecha($cliente, $fecha);
    }

    protected function obtenerGrupoPorFecha(Cliente $cliente, string $fecha): ?MovimientoGrupo
    {
        $fechaCarbon = Carbon::parse($fecha);
        $meses = ['enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'];
        $nombre = 'Movimiento mes de ' . $meses[$fechaCarbon->month - 1] . ' ' . $fechaCarbon->year;

        return $cliente->grupos()
            ->where('nombre', $nombre)
            ->where('cerrado', false)
            ->latest('created_at')
            ->first();
    }

    protected function crearGrupoParaFecha(Cliente $cliente, string $fecha): MovimientoGrupo
    {
        $fechaCarbon = Carbon::parse($fecha);
        $meses = ['enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'];
        $nombre = 'Movimiento mes de ' . $meses[$fechaCarbon->month - 1] . ' ' . $fechaCarbon->year;

        return MovimientoGrupo::create([
            'cliente_id' => $cliente->id,
            'nombre'     => $nombre,
        ]);
    }

    protected function obtenerOcrearGrupoPorFecha(Cliente $cliente, string $fecha): MovimientoGrupo
    {
        return $this->obtenerGrupoPorFecha($cliente, $fecha) ?? $this->crearGrupoParaFecha($cliente, $fecha);
    }

    protected function eliminarGrupoAbiertoVacioSiNoCoincideConFecha(Cliente $cliente, string $fecha): void
    {
        $grupoAbierto = $this->obtenerGrupoAbierto($cliente);

        if (! $grupoAbierto) {
            return;
        }

        if ($grupoAbierto->movimientos()->count() === 0 && ! $this->grupoCoincideConFecha($grupoAbierto, $fecha)) {
            $grupoAbierto->delete();
        }
    }

    protected function grupoCoincideConFecha(MovimientoGrupo $grupo, string $fecha): bool
    {
        try {
            $fechaCarbon = Carbon::parse($fecha);
        } catch (\Exception $e) {
            return false;
        }

        if (preg_match('/Movimiento mes de ([[:alpha:]]+) (\d{4})/i', $grupo->nombre, $matches)) {
            $meses = ['enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'];
            $mesNombre = mb_strtolower($matches[1]);
            $anio = (int) $matches[2];
            $mesIndex = array_search($mesNombre, $meses, true);

            return $mesIndex !== false
                && $fechaCarbon->month === $mesIndex + 1
                && $fechaCarbon->year === $anio;
        }

        return false;
    }

    public function compra(Cliente $cliente)
    {
        $grupoAbierto = $this->obtenerGrupoAbierto($cliente);

        return view('movimientos.compra', compact('cliente', 'grupoAbierto'));
    }

    public function storeCompra(Request $request, Cliente $cliente)
    {
        $grupoAbierto = $this->obtenerGrupoAbierto($cliente);

if (!$grupoAbierto) {
    return redirect()->route('clientes.show', $cliente)
        ->with('error', 'No hay un movimiento activo. Creá un nuevo movimiento antes de registrar una compra.');
}
        $data = $request->validate([
            'monto'       => 'required|numeric|min:0.01',
            'descripcion' => 'nullable|string|max:500',
            'fecha'       => 'required|date',
        ]);

        if ($cliente->limite_credito > 0) {
            $nuevoSaldo = $cliente->saldo + $data['monto'];
            if ($nuevoSaldo > $cliente->limite_credito) {
                $disponible = $cliente->limite_credito - $cliente->saldo;
                return back()
                    ->withErrors(['monto' => "Supera el límite de crédito. Disponible: ₲" . number_format(max(0, $disponible), 0, ',', '.')])
                    ->withInput();
            }
        }

        $grupoAbierto = $this->obtenerGrupoAbierto($cliente)
    ?? $this->obtenerOcrearGrupoPorFecha($cliente, $data['fecha']);

        Movimiento::create([
            'cliente_id'          => $cliente->id,
            'movimiento_grupo_id' => $grupoAbierto->id,
            'user_id'             => Auth::id(),
            'tipo'                => 'compra',
            'monto'               => $data['monto'],
            'descripcion'         => $data['descripcion'],
            'fecha'               => $data['fecha'],
        ]);

        return redirect()->route('clientes.show', $cliente)
            ->with('success', 'Compra registrada correctamente.');
    }

    public function pago(Cliente $cliente)
    {
        $grupoAbierto = $this->obtenerGrupoAbierto($cliente);

        return view('movimientos.pago', compact('cliente', 'grupoAbierto'));
    }

    public function storePago(Request $request, Cliente $cliente)
    {
        $grupoAbierto = $this->obtenerGrupoAbierto($cliente);

if (!$grupoAbierto) {
    return redirect()->route('clientes.show', $cliente)
        ->with('error', 'No hay un movimiento activo. Creá un nuevo movimiento antes de registrar una compra.');
}
        $data = $request->validate([
            'monto'       => 'required|numeric|min:0.01',
            'descripcion' => 'nullable|string|max:500',
            'fecha'       => 'required|date',
        ]);

        $grupoAbierto = $this->obtenerGrupoAbierto($cliente)
    ?? $this->obtenerOcrearGrupoPorFecha($cliente, $data['fecha']);

        Movimiento::create([
            'cliente_id'          => $cliente->id,
            'movimiento_grupo_id' => $grupoAbierto->id,
            'user_id'             => Auth::id(),
            'tipo'                => 'pago',
            'monto'               => $data['monto'],
            'descripcion'         => $data['descripcion'],
            'fecha'               => $data['fecha'],
        ]);

        return redirect()->route('clientes.show', $cliente)
            ->with('success', 'Pago registrado correctamente.');
    }

    public function nuevoGrupo(Request $request, Cliente $cliente)
    {
        if ($cliente->grupos()->where('cerrado', false)->exists()) {
            return redirect()->route('clientes.show', $cliente)
                ->with('error', 'Ya existe un movimiento abierto. Finaliza ese movimiento antes de crear uno nuevo.');
        }

        $data = $request->validate([
            'mes'  => 'required|integer|between:1,12',
            'anio' => 'required|integer|min:2000|max:' . (now()->year + 1),
        ]);

        $meses = ['enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'];
        $nombre = 'Movimiento mes de ' . $meses[$data['mes'] - 1] . ' ' . $data['anio'];

        if ($cliente->grupos()->where('nombre', $nombre)->exists()) {
            return redirect()->route('clientes.show', $cliente)
                ->with('error', 'Ya existe un movimiento para ese mes y año.');
        }

        MovimientoGrupo::create([
            'cliente_id' => $cliente->id,
            'nombre'     => $nombre,
        ]);

        return redirect()->route('clientes.show', $cliente)
            ->with('success', "Se creó un nuevo movimiento: {$nombre}.");
    }

    public function actualizarGrupo(Request $request, MovimientoGrupo $grupo)
    {
        $data = $request->validate([
            'mes'  => 'required|integer|between:1,12',
            'anio' => 'required|integer|min:2000|max:' . (now()->year + 1),
        ]);

        $meses = ['enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'];
        $nombre = 'Movimiento mes de ' . $meses[$data['mes'] - 1] . ' ' . $data['anio'];

        if ($grupo->cliente->grupos()->where('nombre', $nombre)->where('id', '!=', $grupo->id)->exists()) {
            return back()->with('error', 'Ya existe otro movimiento con ese mes y año.');
        }

        $grupo->update(['nombre' => $nombre]);

        return back()->with('success', 'Fecha del movimiento actualizada correctamente.');
    }

    public function update(Request $request, Movimiento $movimiento)
    {
        $data = $request->validate([
            'monto'       => 'required|numeric|min:0.01',
            'descripcion' => 'nullable|string|max:500',
            'fecha'       => 'required|date',
        ]);

        $cliente = $movimiento->cliente;
        $grupoAnterior = $movimiento->grupo;
        $grupo = $this->obtenerGrupoActivoParaMovimiento($cliente, $data['fecha']);

        DB::transaction(function () use ($movimiento, $cliente, $grupoAnterior, $grupo, $data) {
            $movimiento->update([
                'monto'               => $data['monto'],
                'descripcion'         => $data['descripcion'],
                'fecha'               => $data['fecha'],
                'movimiento_grupo_id' => $grupo->id,
            ]);

            if ($grupoAnterior && ! $grupoAnterior->cerrado && $grupoAnterior->id !== $grupo->id) {
                $grupoAnterior->refresh();
                if ($grupoAnterior->movimientos()->count() === 0) {
                    $grupoAnterior->delete();
                }
            }
        });

        return redirect()->route('clientes.show', $cliente)
            ->with('success', 'Movimiento actualizado correctamente.')
            ->with('highlight_group', $grupo->id);
    }

    public function finalizarGrupo(MovimientoGrupo $grupo)
    {
        $grupo->update(['cerrado' => true]);

        return redirect()->route('clientes.show', $grupo->cliente)
            ->with('success', "Movimiento '{$grupo->nombre}' finalizado.");
    }

    public function destroy(Movimiento $movimiento)
    {
        $cliente = $movimiento->cliente;
        $tipo    = $movimiento->tipo;
        $movimiento->delete();

        return redirect()->route('clientes.show', $cliente)
            ->with('success', ucfirst($tipo) . ' cancelado/a correctamente.');
    }
}
