<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogDevolucion extends Model
{
    protected $table = 'log_devoluciones';

    protected $fillable = [
        'entrada_id',
        'devuelto_por',
        'urnas_devueltas',
        'cuartos_devueltos',
        'tintas_devueltas',
        'observaciones',
        'user_id',
    ];

    public function entrada()
    {
        return $this->belongsTo(EntradaConNota::class, 'entrada_id');
    }
}
