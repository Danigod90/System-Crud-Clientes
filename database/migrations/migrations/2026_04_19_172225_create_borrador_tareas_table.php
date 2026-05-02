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
        Schema::create('borrador_tareas', function (Blueprint $table) {
    $table->id();
    $table->foreignId('borrador_id')->constrained('borrador_privado')->onDelete('cascade');
    $table->string('tipo'); // charla, asesoramiento, visita, reunion, otro
    $table->date('fecha');
    $table->text('nota');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrador_tareas');
    }
};
