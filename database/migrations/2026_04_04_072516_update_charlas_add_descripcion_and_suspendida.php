<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('charlas', function (Blueprint $table) {
            $table->text('descripcion')->nullable()->after('direccion');
        });

        DB::statement("ALTER TABLE charlas MODIFY COLUMN estado ENUM('pendiente','realizada','cancelada','vencida','suspendida') DEFAULT 'pendiente'");
    }

    public function down(): void
    {
        Schema::table('charlas', function (Blueprint $table) {
            $table->dropColumn('descripcion');
        });

        DB::statement("ALTER TABLE charlas MODIFY COLUMN estado ENUM('pendiente','realizada','cancelada','vencida') DEFAULT 'pendiente'");
    }
};
