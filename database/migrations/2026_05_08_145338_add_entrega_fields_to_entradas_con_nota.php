<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('entradas_con_nota', function (Blueprint $table) {
            $table->string('entregado_por')->nullable()->after('log_estado');
            $table->datetime('fecha_entrega')->nullable()->after('entregado_por');
        });
    }

    public function down(): void
    {
        Schema::table('entradas_con_nota', function (Blueprint $table) {
            $table->dropColumn(['entregado_por', 'fecha_entrega']);
        });
    }
};
