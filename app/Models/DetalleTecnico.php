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
        'tec_realizado'      => 'boolean',
        'tec_realizado_at'   => 'datetime',
    ];

    protected $guarded = [];

    public function entrada()
    {
        return $this->belongsTo(EntradaConNota::class);
    }
}
