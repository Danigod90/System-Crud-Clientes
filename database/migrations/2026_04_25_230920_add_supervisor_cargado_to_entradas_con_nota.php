<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('entradas_con_nota', function (Blueprint $table) {
            $table->boolean('supervisor_cargado')->default(false)->after('mostrar_en_ticker');
            $table->timestamp('supervisor_cargado_at')->nullable()->after('supervisor_cargado');
        });
    }

    public function down(): void
    {
        Schema::table('entradas_con_nota', function (Blueprint $table) {
            $table->dropColumn(['supervisor_cargado', 'supervisor_cargado_at']);
        });
    }
};