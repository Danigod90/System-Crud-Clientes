<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('detalle_tecnico', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entrada_id')->constrained('entradas_con_nota')->onDelete('cascade');

            // ── DATOS DEL ASESOR ──
            $table->string('organo_electoral')->nullable();
            $table->integer('cantidad_listas')->nullable();
            $table->integer('cantidad_papeletas')->nullable();
            $table->string('sistema_eleccion_general')->nullable();
            $table->boolean('enviado_tecnica')->default(false);
            $table->timestamp('enviado_tecnica_at')->nullable();

            // ── PAPELETAS (10 papeletas x 5 listas) ──
for ($p = 1; $p <= 10; $p++) {
    for ($l = 1; $l <= 5; $l++) {
        $table->string("pap_{$p}_lista_{$l}_nombre", 100)->nullable();
        $table->string("pap_{$p}_lista_{$l}_candidatura", 100)->nullable();
    }
    $table->string("pap_{$p}_sistema_eleccion", 100)->nullable();
}

            // ── MATERIALES ENTREGADOS ──
            $table->integer('mat_mesas')->nullable();
            $table->integer('mat_actas_electorales')->nullable();
            $table->string('mat_actas_electorales_formato')->nullable();
            $table->integer('mat_padron')->nullable();
            $table->string('mat_padron_formato')->nullable();
            $table->integer('mat_matriz_boletin')->nullable();
            $table->string('mat_matriz_boletin_formato')->nullable();
            $table->integer('mat_actas_proclamacion')->nullable();
            $table->integer('mat_certificados')->nullable();
            $table->integer('mat_cuenta_votos')->nullable();

            // ── PADRÓN ──
            $table->boolean('padron_definitivo')->default(false);
            $table->boolean('padron_con_cedula')->default(false);
            $table->integer('cantidad_electores')->nullable();
            $table->integer('cantidad_electores_sin_ci')->nullable();

            // ── RESPONSABLES ──
            $table->string('resp_actas_electorales')->nullable();
            $table->string('resp_papeletas')->nullable();
            $table->string('resp_padron_electoral')->nullable();

            // ── IMPRESIÓN LOGÍSTICA ──
            $table->boolean('impreso')->default(false);
            $table->timestamp('impreso_at')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('detalle_tecnico');
    }
};
