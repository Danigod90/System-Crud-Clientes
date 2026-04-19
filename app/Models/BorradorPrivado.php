<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BorradorPrivado extends Model
{
    protected $table = 'borrador_privado';

    protected $fillable = [
        'asesor_id',
        'nombre_organizacion',
        'tipo_organizacion',
        'nombre_representante',
        'telefono_representante',
        'notas_generales',
        'estado',
        'enviado_at',
    ];

    public function asesor()
    {
        return $this->belongsTo(Asesor::class);
    }

    public function tareas()
    {
        return $this->hasMany(BorradorTarea::class, 'borrador_id')->orderBy('fecha', 'desc');
    }
}
