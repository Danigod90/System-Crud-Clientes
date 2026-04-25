<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('entradas_sin_nota', function (Blueprint $table) {
            $table->string('nombre_completo')->nullable()->after('id');
        });

        // Copiar datos existentes
        DB::statement("UPDATE entradas_sin_nota SET nombre_completo = CONCAT(COALESCE(nombre, ''), ' ', COALESCE(apellido, ''))");

        Schema::table('entradas_sin_nota', function (Blueprint $table) {
            $table->dropColumn(['nombre', 'apellido']);
        });
    }

    public function down(): void
    {
        Schema::table('entradas_sin_nota', function (Blueprint $table) {
            $table->string('nombre')->nullable();
            $table->string('apellido')->nullable();
            $table->dropColumn('nombre_completo');
        });
    }
};