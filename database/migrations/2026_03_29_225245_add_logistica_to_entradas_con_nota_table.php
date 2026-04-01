<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('entradas_con_nota', function (Blueprint $table) {
            $table->integer('log_urnas')->default(0)->after('asunto_tec');
            $table->integer('log_cuartos')->default(0)->after('log_urnas');
            $table->integer('log_tintas')->default(0)->after('log_cuartos');
        });
    }

    public function down(): void
    {
        Schema::table('entradas_con_nota', function (Blueprint $table) {
            $table->dropColumn(['log_urnas', 'log_cuartos', 'log_tintas']);
        });
    }
};
