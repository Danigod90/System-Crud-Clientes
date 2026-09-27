<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE observadores MODIFY COLUMN estado ENUM('pendiente','realizada','cancelada','suspendida','vencida') DEFAULT 'pendiente'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE observadores MODIFY COLUMN estado ENUM('pendiente','realizada','cancelada','suspendida') DEFAULT 'pendiente'");
    }
};
