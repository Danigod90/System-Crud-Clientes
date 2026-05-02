<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('detalle_tecnico', function (Blueprint $table) {
        $table->integer('mat_final_tintas')->nullable()->after('mat_final_urnas');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('detalle_tecnico', function (Blueprint $table) {
        $table->dropColumn('mat_final_tintas');
    });
}
};
