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
    Schema::table('entradas_con_nota', function (Blueprint $table) {
        $table->boolean('asunto_inf')->default(false)->after('asunto_obs');
    });
}

public function down()
{
    Schema::table('entradas_con_nota', function (Blueprint $table) {
        $table->dropColumn('asunto_inf');
    });
}
};
