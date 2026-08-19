<?php

namespace App\Livewire;

use App\Models\DetalleTecnico;
use App\Models\EntradaConNota;
use App\Models\User;
use App\Notifications\TrabajoPendienteNotification;
use Illuminate\Validation\Rule;
use Livewire\Component;

class DetalleTecnicoAsesor extends Component
{
    public EntradaConNota $entrada;

    // Controla si se muestra la vista de solo lectura o el formulario editable
    public bool $editando = false;

    // Campos principales
    public $organo_electoral = null;
    public $cantidad_listas = null;
    public $cantidad_papeletas = null;
    public $cantidad_mesas = null;

    // Papeletas dinámicas: [p => ['sistema' => .., 'candidatura' => .., 'listas' => [l => nombre]]]
    public array $papeletas = [];

    // Materiales a entregar
    public $mat_final_papeletas = null;
    public $mat_final_papeletas_formato = null;
    public $mat_final_actas = null;
    public $mat_final_actas_formato = null;
    public $mat_final_padrones = null;
    public $mat_final_padrones_formato = null;
    public $mat_final_cuartos = null;
    public $mat_final_urnas = null;
    public $mat_final_tintas = null;

    public $nota_asesor = null;

    // Solo lectura — reflejan el estado guardado en base, no se editan acá
    public bool $tieneDetalle = false;
    public bool $enviadoTecnica = false;
    public $enviadoTecnicaAt = null;
    public bool $tecRealizado = false;
    public $tecRealizadoAt = null;

    public ?string $mensajeExito = null;

    public array $candidaturasSugeridas = [
        'Presidente y Vicepresidentes',
        'Presidente y Vicepresidente',
        'Secretario General y Adjunto',
        'Comisión Directiva',
        'Miembros Titulares',
        'Miembros Titulares y Suplentes',
        'Vocales Titulares',
        'Vocales Titulares y Suplentes',
        'Tribunal Electoral Independiente',
        'Junta Electoral',
        'Colegio Electoral',
        'Síndico',
        'Comité Revisadora de Cuentas',
    ];

    public array $sistemasEleccion = [
        'Lista Única',
        'Lista Cerrada Mayoría Simple',
        'Lista Desbloqueada',
        'Lista Cerrada Bloqueada',
        'Sistema Nominal',
    ];

    private array $ordinales = ['Primera','Segunda','Tercera','Cuarta','Quinta','Sexta','Séptima','Octava','Novena','Décima'];

    public function mount(EntradaConNota $entrada): void
    {
        $this->entrada = $entrada;
        $this->cargarDatos($entrada->detalleTecnico);

        if (!$entrada->detalleTecnico) {
            $this->editando = true;
            $this->recalcularMateriales();
        }
    }

    private function cargarDatos(?DetalleTecnico $detalle): void
    {
        $this->organo_electoral   = $detalle?->organo_electoral;
        $this->cantidad_listas    = $detalle?->cantidad_listas;
        $this->cantidad_papeletas = $detalle?->cantidad_papeletas;
        $this->cantidad_mesas     = $detalle?->cantidad_mesas;

        $this->mat_final_papeletas         = $detalle?->mat_final_papeletas ?? $detalle?->cantidad_papeletas;
        $this->mat_final_papeletas_formato = $detalle?->mat_final_papeletas_formato;
        $this->mat_final_actas             = $detalle?->mat_final_actas;
        $this->mat_final_actas_formato     = $detalle?->mat_final_actas_formato;
        $this->mat_final_padrones          = $detalle?->mat_final_padrones;
        $this->mat_final_padrones_formato  = $detalle?->mat_final_padrones_formato;
        $this->mat_final_cuartos           = $detalle?->mat_final_cuartos;
        $this->mat_final_urnas             = $detalle?->mat_final_urnas;
        $this->mat_final_tintas            = $detalle?->mat_final_tintas;
        $this->nota_asesor                 = $detalle?->nota_asesor;

        $this->tieneDetalle     = (bool) $detalle;
        $this->enviadoTecnica   = (bool) ($detalle?->enviado_tecnica ?? false);
        $this->enviadoTecnicaAt = $detalle?->enviado_tecnica_at;
        $this->tecRealizado   = (bool) ($detalle?->tec_realizado ?? false);
        $this->tecRealizadoAt = $detalle?->tec_realizado_at;

        $this->papeletas = [];
        for ($p = 1; $p <= 10; $p++) {
            $this->papeletas[$p] = [
                'sistema'     => $detalle?->{"pap_{$p}_sistema_eleccion"} ?? '',
                'candidatura' => $detalle?->{"pap_{$p}_lista_1_candidatura"} ?? '',
                'listas'      => [],
            ];
            for ($l = 1; $l <= 5; $l++) {
                $this->papeletas[$p]['listas'][$l] = $detalle?->{"pap_{$p}_lista_{$l}_nombre"} ?? '';
            }
        }
    }

    public function ordinal(int $p): string
    {
        return $this->ordinales[$p - 1] ?? '';
    }

    // Hook único y explícito — no depende de que Livewire adivine el nombre
    // del método a partir del nombre de la propiedad (esa "magia" automática
    // fue la causa del bug donde "Papeletas" no se sincronizaba).
    public function updated($property, $value): void
    {
        switch ($property) {
            case 'cantidad_papeletas':
                $this->mat_final_papeletas = (int) $value;
                $this->recalcularMateriales();
                break;

            case 'cantidad_mesas':
                $this->recalcularMateriales();
                break;

            case 'mat_final_papeletas':
                // Sincronización inversa: si lo cambiás acá, también se actualiza arriba
                $this->cantidad_papeletas = (int) $value;
                break;

            case 'mat_final_papeletas_formato':
                if ($value === 'sin_papeletas') {
                    $this->mat_final_papeletas = 0;
                }
                break;

            case 'mat_final_actas_formato':
                if ($value === 'sin_actas') {
                    $this->mat_final_actas = 0;
                }
                break;

            case 'mat_final_padrones_formato':
                if ($value === 'sin_padron') {
                    $this->mat_final_padrones = 0;
                }
                break;
        }
    }

    private function recalcularMateriales(): void
    {
        $mesas     = (int) $this->cantidad_mesas;
        $papeletas = (int) $this->cantidad_papeletas;

        // Solo completa los campos vacíos — nunca pisa un valor ya cargado a mano
        if ($this->mat_final_actas === null || $this->mat_final_actas === '') {
            $this->mat_final_actas = $mesas * 3;
        }
        if ($this->mat_final_padrones === null || $this->mat_final_padrones === '') {
            $this->mat_final_padrones = $mesas * 3;
        }
        if ($this->mat_final_cuartos === null || $this->mat_final_cuartos === '') {
            $this->mat_final_cuartos = $mesas;
        }
        if ($this->mat_final_urnas === null || $this->mat_final_urnas === '') {
            $this->mat_final_urnas = $mesas * $papeletas;
        }
        if ($this->mat_final_tintas === null || $this->mat_final_tintas === '') {
            $this->mat_final_tintas = $mesas;
        }
    }

    public function getMostrarEnviarTecnicaProperty(): bool
    {
        return ((int) $this->mat_final_papeletas > 0)
            || ((int) $this->mat_final_actas > 0)
            || ((int) $this->mat_final_padrones > 0);
    }

    public function activarEdicion(): void
    {
        $this->editando = true;
        $this->mensajeExito = null;
    }

    public function cancelarEdicion(): void
    {
        $this->cargarDatos($this->entrada->detalleTecnico()->first());
        $this->editando = false;
    }

    public function guardar(): void
    {
        $this->validate([
            'mat_final_papeletas_formato' => ['required'],
            'mat_final_actas_formato'     => ['required'],
            'mat_final_padrones_formato'  => ['required'],
        ], [
            'mat_final_papeletas_formato.required' => 'No seleccionaste el formato de Papeletas (Impreso o Digital).',
            'mat_final_actas_formato.required'     => 'No seleccionaste el formato de Actas (Impreso o Digital).',
            'mat_final_padrones_formato.required'  => 'No seleccionaste el formato de Padrones (Impreso o Digital).',
        ]);

        $detalle = DetalleTecnico::firstOrNew(['entrada_id' => $this->entrada->id]);
        $yaEstabaEnviado = (bool) $detalle->enviado_tecnica;

        $detalle->entrada_id               = $this->entrada->id;
        $detalle->organo_electoral         = $this->organo_electoral;
        $detalle->cantidad_listas          = $this->cantidad_listas;
        $detalle->cantidad_papeletas       = $this->cantidad_papeletas;
        $detalle->cantidad_mesas           = $this->cantidad_mesas;
        $detalle->sistema_eleccion_general = null;

        for ($p = 1; $p <= 10; $p++) {
            for ($l = 1; $l <= 5; $l++) {
                $valor = $this->papeletas[$p]['listas'][$l] ?? '';
                $detalle->{"pap_{$p}_lista_{$l}_nombre"} = $valor !== '' ? $valor : null;
            }
            $candidatura = $this->papeletas[$p]['candidatura'] ?? '';
            $detalle->{"pap_{$p}_lista_1_candidatura"} = $candidatura !== '' ? $candidatura : null;

            $sistema = $this->papeletas[$p]['sistema'] ?? '';
            $detalle->{"pap_{$p}_sistema_eleccion"} = $sistema !== '' ? $sistema : null;
        }

        $detalle->mat_final_actas             = (int) $this->mat_final_actas;
        $detalle->mat_final_padrones          = (int) $this->mat_final_padrones;
        $detalle->mat_final_cuartos           = (int) $this->mat_final_cuartos;
        $detalle->mat_final_urnas             = (int) $this->mat_final_urnas;
        $detalle->mat_final_tintas            = (int) $this->mat_final_tintas;
        $detalle->mat_final_papeletas         = (int) $this->mat_final_papeletas;
        $detalle->mat_matriz_boletin          = (int) $this->mat_final_papeletas;
        $detalle->mat_final_papeletas_formato = $this->mat_final_papeletas_formato;
        $detalle->mat_final_actas_formato     = $this->mat_final_actas_formato;
        $detalle->mat_final_padrones_formato  = $this->mat_final_padrones_formato;
        $detalle->nota_asesor                 = $this->nota_asesor;
        $detalle->asesor_updated_at           = now();
        $detalle->tecnico_updated_at          = now();
        $detalle->save();

        if ($this->mostrarEnviarTecnica && !$yaEstabaEnviado) {
            // Primer envío
            $this->marcarEnviadoYNotificar($detalle);
            $this->mensajeExito = 'Datos técnicos guardados y enviados a técnica correctamente.';
        } elseif ($yaEstabaEnviado) {
            // Ya se había enviado antes — esto es una corrección posterior
            $this->notificarCorreccion();
            $this->mensajeExito = 'Datos técnicos actualizados. Se avisó a técnica del cambio.';
        } else {
            $this->mensajeExito = 'Datos técnicos guardados correctamente.';
        }

        $this->tieneDetalle     = true;
        $this->enviadoTecnica   = (bool) $detalle->enviado_tecnica;
        $this->enviadoTecnicaAt = $detalle->enviado_tecnica_at;
        $this->editando = false;
    }

    private function marcarEnviadoYNotificar(DetalleTecnico $detalle): void
    {
        $detalle->enviado_tecnica    = true;
        $detalle->enviado_tecnica_at = now();
        $detalle->asesor_updated_at  = now();
        $detalle->save();

        $tecnicos = User::role('Tecnico')->get();
        foreach ($tecnicos as $tecnico) {
            $tecnico->notify(new TrabajoPendienteNotification(
                'Nuevo trabajo: ' . $this->entrada->nombre_organizacion . ' enviado a técnica por ' . $this->entrada->asesor_asignado,
                'Panel Técnico',
                $this->entrada->id
            ));
            if ($tecnico->notifications()->count() > 8) {
                $tecnico->notifications()->latest()->skip(8)->take(100)->delete();
            }
        }
    }

    private function notificarCorreccion(): void
    {
        $tecnicos = User::role('Tecnico')->get();
        foreach ($tecnicos as $tecnico) {
            $tecnico->notify(new TrabajoPendienteNotification(
                'El asesor editó nuevamente: ' . $this->entrada->nombre_organizacion,
                'Panel Técnico',
                $this->entrada->id
            ));
            if ($tecnico->notifications()->count() > 8) {
                $tecnico->notifications()->latest()->skip(8)->take(100)->delete();
            }
        }
    }

    public function render()
    {
        return view('livewire.detalle-tecnico-asesor');
    }
}
