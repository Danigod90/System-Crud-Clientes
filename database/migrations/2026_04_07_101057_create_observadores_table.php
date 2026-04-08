<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('observadores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entrada_con_nota_id')->constrained('entradas_con_nota')->onDelete('cascade');
            $table->dateTime('fecha_hora')->nullable();
            $table->string('direccion')->nullable();
            $table->text('observadores')->nullable();
            $table->text('descripcion')->nullable();
            $table->enum('estado', ['pendiente', 'realizada', 'cancelada', 'suspendida'])->default('pendiente');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('observadores');
    }
};
