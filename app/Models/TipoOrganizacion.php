<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoOrganizacion extends Model
{
    protected $table = 'tipo_organizaciones';
    protected $fillable = ['nombre'];
}
