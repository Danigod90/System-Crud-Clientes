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
        Schema::create('borrador_privado', function (Blueprint $table) {
    $table->id();
    $table->foreignId('asesor_id')->constrained('asesores')->onDelete('cascade');
    $table->string('nombre_organizacion');
    $table->string('tipo_organizacion')->nullable();
    $table->string('nombre_representante')->nullable();
    $table->string('telefono_representante')->nullable();
    $table->text('notas_generales')->nullable();
    $table->enum('estado', ['activo', 'enviado', 'archivado'])->default('activo');
    $table->timestamp('enviado_at')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrador_privado');
    }
};
