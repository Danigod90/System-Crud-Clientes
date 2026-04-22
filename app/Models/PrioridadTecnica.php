<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrioridadTecnica extends Model
{
    protected $table = 'prioridades_tecnicas';

    protected $fillable = [
        'entrada_con_nota_id',
        'user_id',
        'orden',
    ];

    public function entrada()
    {
        return $this->belongsTo(EntradaConNota::class, 'entrada_con_nota_id');
    }
}
