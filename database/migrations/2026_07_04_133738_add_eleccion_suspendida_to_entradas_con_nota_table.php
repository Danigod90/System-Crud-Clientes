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
    Schema::table('entradas_con_nota', function (Blueprint $table) {
        $table->boolean('eleccion_suspendida')->default(false)->after('asunto_obs');
        $table->timestamp('eleccion_suspendida_at')->nullable()->after('eleccion_suspendida');
    });
}

public function down(): void {
    Schema::table('entradas_con_nota', function (Blueprint $table) {
        $table->dropColumn(['eleccion_suspendida', 'eleccion_suspendida_at']);
    });
}
};
