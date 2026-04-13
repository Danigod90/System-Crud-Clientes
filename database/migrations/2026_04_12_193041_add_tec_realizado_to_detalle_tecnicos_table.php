<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('detalle_tecnico', function (Blueprint $table) {
        $table->boolean('tec_realizado')->default(false);
        $table->timestamp('tec_realizado_at')->nullable();
    });
}

public function down(): void
{
    Schema::table('detalle_tecnico', function (Blueprint $table) {
        $table->dropColumn(['tec_realizado', 'tec_realizado_at']);
    });
}
};
