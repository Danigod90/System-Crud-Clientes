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
    ];

    public function getNombreCompletoAttribute()
    {
        return $this->nombre . ' ' . $this->apellido;
    }
}
