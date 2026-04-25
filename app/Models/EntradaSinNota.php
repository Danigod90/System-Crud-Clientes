<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntradaSinNota extends Model
{
    protected $table = 'entradas_sin_nota';

    protected $dates = ['created_at', 'updated_at'];

    protected $fillable = [
        'numero_entrada',
        'nombre_completo',
        'telefono',
        'tipo_charla',
        'asesor_id',
        'user_id',
        'fecha',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function asesor()
    {
        return $this->belongsTo(Asesor::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $year = date('Y');
            $ultimo = self::whereYear('created_at', $year)->count() + 1;
            $model->numero_entrada = 'SN-' . $year . '-' . str_pad($ultimo, 4, '0', STR_PAD_LEFT);
        });
    }
}
