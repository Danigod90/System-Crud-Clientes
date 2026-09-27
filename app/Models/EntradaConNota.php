<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EntradaConNota extends Model
{
    use SoftDeletes;

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
        'mostrar_en_ticker',
        'asunto_obs',
        'asunto_inf',
        'log_impreso_at',
        'supervisor_cargado',
        'supervisor_cargado_at',
        'entregado_por',   // nuevo
        'fecha_entrega',   // nuevo
        'persona_retira',
        'telefono_retira',
        'direccion',
        'eleccion_suspendida',
        'eleccion_suspendida_at',
        'eliminado_por_user_id',
    ];

    protected $casts = [
        'fecha_eleccion'     => 'date',
        'asunto_char'        => 'boolean',
        'asunto_log'         => 'boolean',
        'asunto_tec'         => 'boolean',
        'mostrar_en_ticker'  => 'boolean',
        'asunto_obs'         => 'boolean',
        'asunto_inf'         => 'boolean',
        'log_impreso_at'     => 'datetime',
        'fecha_entrega'      => 'datetime', //
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function servicios()
    {
        return $this->hasMany(ServicioEntrada::class, 'entrada_con_nota_id');
    }

    public function charla()
    {
        return $this->hasOne(Charla::class, 'entrada_con_nota_id')->oldest();
    }

    public function charlas()
    {
        return $this->hasMany(Charla::class, 'entrada_con_nota_id')->oldest();
    }

    /**
     * Para el tinker: si hay más de una charla cargada (máximo 2), muestra la
     * que sigue pendiente o vencida en vez de siempre la más vieja — evita
     * mostrar una charla ya realizada mientras hay otra esperando fecha. Entre
     * las activas, prioriza: 1) pendiente con fecha (la más próxima primero),
     * 2) vencida, 3) pendiente sin fecha cargada todavía.
     */
    public function getCharlaRelevanteAttribute()
    {
        $charlas = $this->relationLoaded('charlas') ? $this->charlas : $this->charlas()->get();
        $activas = $charlas->filter(fn($c) => in_array($c->estado, ['pendiente', 'vencida']));

        if ($activas->isNotEmpty()) {
            return $activas->sortBy(function($c) {
                $grupo = $c->estado === 'vencida' ? 1 : ($c->fecha_hora ? 0 : 2);
                $ts = $c->fecha_hora ? $c->fecha_hora->timestamp : PHP_INT_MAX;
                return $grupo * 10000000000 + $ts;
            })->first();
        }

        return $charlas->first();
    }

    public function observador()
    {
        return $this->hasOne(Observador::class, 'entrada_con_nota_id');
    }

    public function detalleTecnico()
    {
        return $this->hasOne(DetalleTecnico::class, 'entrada_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $year = date('Y');
            do {
                // withTrashed(): con el soft-delete, una organización borrada
                // no debe "liberar" su código — si no, se lo podríamos volver
                // a asignar a una nueva y chocar con la restricción de único.
                $ultimo = self::withTrashed()->max('id') + 1;
                $codigo = 'ORG-' . $year . '-' . str_pad($ultimo, 4, '0', STR_PAD_LEFT);
            } while (self::withTrashed()->where('codigo_org', $codigo)->exists());

            $model->codigo_org     = $codigo;
            $model->registrado_por = auth()->user()->name ?? 'Sistema';
        });
    }

    public function getAsuntoTextoAttribute(): string
{
    $partes = [];
    if ($this->asunto_char) $partes[] = 'Char';
    if ($this->asunto_log)  $partes[] = 'Log';
    if ($this->asunto_tec)  $partes[] = 'Tec';
    if ($this->asunto_obs)  $partes[] = 'Obs';
    if ($this->asunto_inf)  $partes[] = 'Inf';
    return implode(' · ', $partes) ?: '—';
}

    public function logDevolucion()
    {
        return $this->hasOne(LogDevolucion::class, 'entrada_id');
    }

    public function documentos()
    {
        return $this->hasMany(\App\Models\Documento::class, 'entrada_con_nota_id')->latest();
    }

    public function eliminadoPor()
    {
        return $this->belongsTo(User::class, 'eliminado_por_user_id');
    }
}
