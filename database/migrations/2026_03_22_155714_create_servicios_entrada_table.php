<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('servicios_entrada', function (Blueprint $table) {
        $table->id();
        $table->foreignId('entrada_con_nota_id')->constrained('entradas_con_nota')->onDelete('cascade');
        $table->enum('tipo_servicio', [
            'asesoramiento_electoral',
            'parte_tecnica',
            'logistica',
            'charla_asesoramiento',
            'charla_mesa_receptora'
        ]);
        // Campos para charlas (nullable porque solo aplican a charlas)
        $table->enum('lugar_charla', ['oficina', 'fuera'])->nullable();
        $table->string('direccion_charla')->nullable();
        $table->dateTime('fecha_hora_charla')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicios_entrada');
    }
};
