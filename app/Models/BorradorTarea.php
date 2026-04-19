<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BorradorTarea extends Model
{
    protected $table = 'borrador_tareas';

    protected $fillable = [
        'borrador_id',
        'tipo',
        'fecha',
        'nota',
    ];

    public function borrador()
    {
        return $this->belongsTo(BorradorPrivado::class, 'borrador_id');
    }
}
