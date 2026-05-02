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
        Schema::create('log_devoluciones', function (Blueprint $table) {
    $table->id();
    $table->foreignId('entrada_id')->constrained('entradas_con_nota')->onDelete('cascade');
    $table->string('devuelto_por');
    $table->integer('urnas_devueltas')->default(0);
    $table->integer('cuartos_devueltos')->default(0);
    $table->integer('tintas_devueltas')->default(0);
    $table->text('observaciones')->nullable();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_devoluciones');
    }
};
