<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrioridadAsesor extends Model
{
    protected $table = 'prioridades_asesores';

    protected $fillable = [
        'entrada_con_nota_id',
        'user_id',
    ];

    public function entrada()
    {
        return $this->belongsTo(EntradaConNota::class, 'entrada_con_nota_id');
    }
}
