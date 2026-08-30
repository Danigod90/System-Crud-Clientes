<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Permite que un usuario "cierre" un chat directo de su lista sin borrar
     * nada — ni los mensajes ni la conversación. Solo se marca como oculta
     * para ese usuario puntual, y vuelve a aparecer sola en cuanto llega un
     * mensaje nuevo.
     */
    public function up(): void
    {
        Schema::table('chat_lecturas', function (Blueprint $table) {
            $table->boolean('oculta')->default(false)->after('leido_at');
        });
    }

    public function down(): void
    {
        Schema::table('chat_lecturas', function (Blueprint $table) {
            $table->dropColumn('oculta');
        });
    }
};
