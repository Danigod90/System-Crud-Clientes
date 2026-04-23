<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entrada_con_nota_id')->constrained('entradas_con_nota')->onDelete('cascade');
            $table->string('nombre');
            $table->string('ruta');
            $table->string('tipo')->nullable();
            $table->string('extension')->nullable();
            $table->bigInteger('tamanio')->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documentos');
    }
};
