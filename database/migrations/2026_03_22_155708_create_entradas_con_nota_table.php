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
    Schema::create('entradas_con_nota', function (Blueprint $table) {
        $table->id();
        $table->string('numero_entrada')->unique();
        $table->string('nombre_organizacion');
        $table->string('tipo_organizacion');
        $table->string('nombre_representante');
        $table->string('asesor_asignado')->nullable();
        $table->enum('via_ingreso', ['correo', 'presencial']);
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entradas_con_nota');
    }
};
