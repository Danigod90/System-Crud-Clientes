<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntradaConNota extends Model
{
    protected $table = 'entradas_con_nota';

    protected $fillable = [
        'numero_entrada',
        'nombre_organizacion',
        'tipo_organizacion',
        'nombre_representante',
        'asesor_asignado',
        'via_ingreso',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function servicios()
    {
        return $this->hasMany(ServicioEntrada::class, 'entrada_con_nota_id');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $year = date('Y');
            $ultimo = self::whereYear('created_at', $year)->count() + 1;
            $model->numero_entrada = 'CN-' . $year . '-' . str_pad($ultimo, 4, '0', STR_PAD_LEFT);
        });
    }
}