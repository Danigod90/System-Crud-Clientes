<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('entradas_con_nota', function (Blueprint $table) {
    $table->timestamp('log_impreso_at')->nullable()->after('log_estado');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::table('entradas_con_nota', function (Blueprint $table) {
    $table->dropColumn('log_impreso_at');
});
    }
};
