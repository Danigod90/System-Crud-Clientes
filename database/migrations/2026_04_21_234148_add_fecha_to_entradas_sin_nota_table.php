<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('entradas_sin_nota', function (Blueprint $table) {
            $table->date('fecha')->nullable()->after('tipo_charla');
        });
    }

    public function down(): void
    {
        Schema::table('entradas_sin_ota', function (Blueprint $table) {
            $table->dropColumn('fecha');
        });
    }
};
