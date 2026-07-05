<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void {
    Schema::create('chat_mensajes', function (Blueprint $table) {
        $table->id();
        $table->foreignId('conversacion_id')->constrained('chat_conversaciones')->onDelete('cascade');
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->text('mensaje')->nullable();
        $table->string('archivo')->nullable();
        $table->string('archivo_nombre')->nullable();
        $table->string('archivo_tipo')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_mensajes');
    }
};
