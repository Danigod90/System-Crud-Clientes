<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    protected $table = 'documentos';

    protected $fillable = [
        'entrada_con_nota_id',
        'nombre',
        'ruta',
        'tipo',
        'extension',
        'tamanio',
        'user_id',
    ];

    public function entrada()
    {
        return $this->belongsTo(EntradaConNota::class, 'entrada_con_nota_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
