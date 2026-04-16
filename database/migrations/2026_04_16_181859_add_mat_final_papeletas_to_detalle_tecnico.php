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
        $table->integer('mat_final_papeletas')->nullable()->after('mat_final_tintas');
        $table->string('mat_final_papeletas_formato')->nullable()->after('mat_final_papeletas');
    });
}


    /**
     * Reverse the migrations.
     */
   public function down(): void
{
    Schema::table('detalle_tecnico', function (Blueprint $table) {
        $table->dropColumn(['mat_final_papeletas', 'mat_final_papeletas_formato']);
    });
}
};
