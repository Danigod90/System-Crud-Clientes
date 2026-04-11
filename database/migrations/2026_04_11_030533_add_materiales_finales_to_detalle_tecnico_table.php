<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('detalle_tecnico', function (Blueprint $table) {
            $table->integer('mat_final_actas')->nullable()->after('cantidad_mesas');
            $table->integer('mat_final_padrones')->nullable()->after('mat_final_actas');
            $table->integer('mat_final_cuartos')->nullable()->after('mat_final_padrones');
            $table->integer('mat_final_urnas')->nullable()->after('mat_final_cuartos');
        });
    }

    public function down()
    {
        Schema::table('detalle_tecnico', function (Blueprint $table) {
            $table->dropColumn(['mat_final_actas','mat_final_padrones','mat_final_cuartos','mat_final_urnas']);
        });
    }
};
