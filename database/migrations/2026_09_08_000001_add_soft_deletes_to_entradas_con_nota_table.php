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
        Schema::table('entradas_con_nota', function (Blueprint $table) {
            $table->softDeletes(); // deleted_at — la fila queda oculta pero no se borra de verdad
            $table->foreignId('eliminado_por_user_id')
                ->nullable()
                ->after('deleted_at')
                ->constrained('users')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('entradas_con_nota', function (Blueprint $table) {
            $table->dropConstrainedForeignId('eliminado_por_user_id');
            $table->dropSoftDeletes();
        });
    }
};
