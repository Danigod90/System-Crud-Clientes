<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    // Antes esto generaba el número en un evento "creating" suelto: leía el
    // máximo y calculaba +1 sin ningún bloqueo, así que si dos creaciones caían
    // cerca en el tiempo (esta pantalla y una entrega de logística/técnica que
    // también crea un registro acá) las dos podían calcular el mismo número y
    // una terminaba chocando con la restricción de único.
    //
    // Ahora el cálculo y el guardado quedan adentro de una misma transacción,
    // con lockForUpdate(): si dos llegan casi juntas, la segunda espera a que
    // la primera termine de guardar antes de calcular su propio número, así
    // nunca se pisan.
    public function save(array $options = [])
    {
        if (!$this->exists) {
            return DB::transaction(function () use ($options) {
                $year = date('Y');
                $ultimo = self::whereYear('created_at', $year)
                    ->lockForUpdate()
                    ->max(DB::raw('CAST(SUBSTRING_INDEX(numero_entrada, "-", -1) AS UNSIGNED)'));
                $siguiente = ($ultimo ?? 0) + 1;
                $this->numero_entrada = 'SN-' . $year . '-' . str_pad($siguiente, 4, '0', STR_PAD_LEFT);

                return parent::save($options);
            });
        }

        return parent::save($options);
    }
}
