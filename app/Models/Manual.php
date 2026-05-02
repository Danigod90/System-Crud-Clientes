<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Manual extends Model
{
    protected $table = 'manuales';

    protected $fillable = [
        'nombre',
        'ruta',
        'tipo',
        'extension',
        'tamanio',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
