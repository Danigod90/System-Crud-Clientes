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
    Schema::create('chat_conversaciones', function (Blueprint $table) {
        $table->id();
        $table->string('tipo'); // general, rol, directo
        $table->string('nombre')->nullable();
        $table->string('rol')->nullable(); // para tipo=rol
        $table->unsignedBigInteger('user1_id')->nullable(); // para directos
        $table->unsignedBigInteger('user2_id')->nullable(); // para directos
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_conversaciones');
    }
};
