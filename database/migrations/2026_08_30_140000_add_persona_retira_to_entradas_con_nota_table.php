<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('entradas_con_nota', function (Blueprint $table) {
            $table->string('persona_retira')->nullable()->after('entregado_por');
            $table->string('telefono_retira')->nullable()->after('persona_retira');
        });
    }

    public function down(): void
    {
        Schema::table('entradas_con_nota', function (Blueprint $table) {
            $table->dropColumn(['persona_retira', 'telefono_retira']);
        });
    }
};
