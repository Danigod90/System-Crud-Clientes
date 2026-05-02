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
    Schema::table('detalle_tecnico', function (Blueprint $table) {
        $table->string('mat_final_actas_formato')->nullable()->after('mat_final_actas');
        $table->string('mat_final_padrones_formato')->nullable()->after('mat_final_padrones');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('detalle_tecnico', function (Blueprint $table) {
        $table->dropColumn(['mat_final_actas_formato','mat_final_padrones_formato']);
    });
}
};
