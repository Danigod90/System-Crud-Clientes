<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('entradas_con_nota', function (Blueprint $table) {
            $table->boolean('asunto_obs')->default(false)->after('asunto_tec');
        });
    }

    public function down(): void
    {
        Schema::table('entradas_con_nota', function (Blueprint $table) {
            $table->dropColumn('asunto_obs');
        });
    }
};
