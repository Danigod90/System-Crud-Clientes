<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicioEntrada extends Model
{
    protected $fillable = [
        'entrada_con_nota_id',
        'tipo_servicio',
        'lugar_charla',
        'direccion_charla',
        'fecha_hora_charla',
    ];

    protected $casts = [
        'fecha_hora_charla' => 'datetime',
    ];

    public function entradaConNota()
    {
        return $this->belongsTo(EntradaConNota::class, 'entrada_con_nota_id');
    }
}