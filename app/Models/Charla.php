<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Charla extends Model
{
    protected $fillable = [
        'entrada_con_nota_id',
        'modalidad',
        'fecha_hora',
        'direccion',
        'estado',
    ];

    protected $casts = [
        'fecha_hora' => 'datetime',
    ];

    public function entrada()
    {
        return $this->belongsTo(EntradaConNota::class, 'entrada_con_nota_id');
    }
}
