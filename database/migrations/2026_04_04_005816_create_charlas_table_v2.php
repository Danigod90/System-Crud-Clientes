<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('charlas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entrada_con_nota_id')->constrained('entradas_con_nota')->onDelete('cascade');
            $table->enum('modalidad', ['virtual', 'presencial_oficina', 'presencial_externa']);
            $table->dateTime('fecha_hora')->nullable();
            $table->string('direccion')->nullable();
            $table->enum('estado', ['pendiente', 'realizada', 'cancelada', 'vencida'])->default('pendiente');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('charlas');
    }
};
