<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Observador extends Model
{
    protected $table = 'observadores';

    protected $fillable = [
        'entrada_con_nota_id',
        'fecha_hora',
        'direccion',
        'observadores',
        'descripcion',
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
