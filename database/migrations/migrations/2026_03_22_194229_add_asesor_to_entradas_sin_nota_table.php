<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('entradas_sin_nota', function (Blueprint $table) {
            $table->foreignId('asesor_id')->nullable()->constrained('asesores')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('entradas_sin_nota', function (Blueprint $table) {
            $table->dropForeign(['asesor_id']);
            $table->dropColumn('asesor_id');
        });
    }
};
