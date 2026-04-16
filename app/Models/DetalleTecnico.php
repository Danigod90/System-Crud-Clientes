<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleTecnico extends Model
{
    protected $table = 'detalle_tecnico';

    protected $casts = [
        'enviado_tecnica'    => 'boolean',
        'enviado_tecnica_at' => 'datetime',
        'padron_definitivo'  => 'boolean',
        'padron_con_cedula'  => 'boolean',
        'impreso'            => 'boolean',
        'impreso_at'         => 'datetime',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $fillable = [
            'entrada_id',
            'organo_electoral',
            'cantidad_listas',
            'cantidad_papeletas',
            'cantidad_mesas',
            'mat_final_actas',
            'mat_final_padrones',
            'mat_final_cuartos',
            'mat_final_urnas',
            'sistema_eleccion_general',
            'enviado_tecnica',
            'enviado_tecnica_at',
            'mat_mesas',
            'mat_actas_electorales',
            'mat_actas_electorales_formato',
            'mat_padron',
            'mat_padron_formato',
            'mat_matriz_boletin',
            'mat_matriz_boletin_formato',
            'mat_actas_proclamacion',
            'mat_certificados',
            'mat_cuenta_votos',
            'mat_tintas',
            'mat_final_tintas',
            'mat_final_actas_formato',
            'mat_final_padrones_formato',
            'mat_final_papeletas',
            'mat_final_papeletas_formato',
            'nota_asesor',
            'padron_definitivo',
            'padron_con_cedula',
            'cantidad_electores',
            'cantidad_electores_sin_ci',
            'resp_actas_electorales',
            'resp_papeletas',
            'resp_padron_electoral',
            'impreso',
            'impreso_at',
        ];

        for ($p = 1; $p <= 10; $p++) {
            for ($l = 1; $l <= 5; $l++) {
                $fillable[] = "pap_{$p}_lista_{$l}_nombre";
                $fillable[] = "pap_{$p}_lista_{$l}_candidatura";
            }
            $fillable[] = "pap_{$p}_sistema_eleccion";
        }

        $this->fillable = $fillable;
    }

    public function entrada()
    {
        return $this->belongsTo(Entrada::class);
    }
}
