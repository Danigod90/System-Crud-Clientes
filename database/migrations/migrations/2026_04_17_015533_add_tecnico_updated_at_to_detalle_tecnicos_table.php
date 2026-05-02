<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('detalle_tecnico', function (Blueprint $table) {
        $table->timestamp('tecnico_updated_at')->nullable()->after('asesor_updated_at');
    });
}

public function down(): void
{
    Schema::table('detalle_tecnico', function (Blueprint $table) {
        $table->dropColumn('tecnico_updated_at');
    });
}
};
