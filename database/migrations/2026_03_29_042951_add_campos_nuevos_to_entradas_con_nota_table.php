<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('entradas_con_nota', function (Blueprint $table) {
            // Codigo ORG unico (reemplaza numero_entrada)
            $table->string('codigo_org')->unique()->nullable()->after('id');

            // Telefono del representante
            $table->string('telefono_representante')->nullable()->after('nombre_representante');

            // Fecha de eleccion
            $table->date('fecha_eleccion')->nullable()->after('telefono_representante');

            // Asunto — disparador del sistema (puede ser combinacion)
            $table->boolean('asunto_char')->default(false)->after('via_ingreso');
            $table->boolean('asunto_log')->default(false)->after('asunto_char');
            $table->boolean('asunto_tec')->default(false)->after('asunto_log');

            // Quien registro la entrada (asesor o secretaria)
            $table->string('registrado_por')->nullable()->after('user_id');
        });
    }

    public function down(): void
    {
        Schema::table('entradas_con_nota', function (Blueprint $table) {
            $table->dropColumn([
                'codigo_org',
                'telefono_representante',
                'fecha_eleccion',
                'asunto_char',
                'asunto_log',
                'asunto_tec',
                'registrado_por',
            ]);
        });
    }
};
