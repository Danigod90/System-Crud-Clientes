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
    Schema::create('entradas_sin_nota', function (Blueprint $table) {
        $table->id();
        $table->string('numero_entrada')->unique();
        $table->string('nombre');
        $table->string('apellido');
        $table->string('tipo_charla');
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entradas_sin_nota');
    }
};
