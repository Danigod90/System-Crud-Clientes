<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuracion extends Model
{
    protected $table = 'configuraciones';

    protected $fillable = ['clave', 'valor', 'descripcion'];

    public static function get(string $clave, string $default = ''): string
    {
        return self::where('clave', $clave)->value('valor') ?? $default;
    }
}
