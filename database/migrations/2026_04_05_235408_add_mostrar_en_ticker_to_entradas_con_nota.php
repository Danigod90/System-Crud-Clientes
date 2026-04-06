<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('entradas_con_nota', function (Blueprint $table) {
            $table->boolean('mostrar_en_ticker')->default(true)->after('log_estado');
        });
    }

    public function down(): void
    {
        Schema::table('entradas_con_nota', function (Blueprint $table) {
            $table->dropColumn('mostrar_en_ticker');
        });
    }
};
