<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asesor extends Model
{
    protected $table = 'asesores';

    protected $fillable = [
    'nombre',
    'apellido',
    'cargo',
    'activo',
    'user_id',
];

    public function getNombreCompletoAttribute()
    {
        return $this->nombre . ' ' . $this->apellido;
    }
    public function user()
{
    return $this->belongsTo(\App\Models\User::class);
}
}
