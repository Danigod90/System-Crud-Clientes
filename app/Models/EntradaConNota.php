<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntradaConNota extends Model
{
    protected $table = 'entradas_con_nota';

    protected $fillable = [
        'codigo_org',
        'nombre_organizacion',
        'tipo_organizacion',
        'nombre_representante',
        'telefono_representante',
        'fecha_eleccion',
        'asesor_asignado',
        'via_ingreso',
        'asunto_char',
        'asunto_log',
        'asunto_tec',
        'user_id',
        'registrado_por',
        'log_urnas',
        'log_cuartos',
        'log_tintas',
        'log_estado',
    ];

    protected $casts = [
        'fecha_eleccion' => 'date',
        'asunto_char'    => 'boolean',
        'asunto_log'     => 'boolean',
        'asunto_tec'     => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function servicios()
    {
        return $this->hasMany(ServicioEntrada::class, 'entrada_con_nota_id');
    }

    // Genera codigo ORG automaticamente al crear
    protected static function boot()
{
    parent::boot();

    static::creating(function ($model) {
        $year = date('Y');
        do {
            $ultimo = self::max('id') + 1;
            $codigo = 'ORG-' . $year . '-' . str_pad($ultimo, 4, '0', STR_PAD_LEFT);
        } while (self::where('codigo_org', $codigo)->exists());

        $model->codigo_org     = $codigo;
        $model->registrado_por = auth()->user()->name ?? 'Sistema';
    });
}

    // Devuelve el asunto abreviado para mostrar en tabla
    public function getAsuntoTextoAttribute(): string
    {
        $partes = [];
        if ($this->asunto_char) $partes[] = 'Char';
        if ($this->asunto_log)  $partes[] = 'Log';
        if ($this->asunto_tec)  $partes[] = 'Tec';
        return implode(' · ', $partes) ?: '—';
    }
}
