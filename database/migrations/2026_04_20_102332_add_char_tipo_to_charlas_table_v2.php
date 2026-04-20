<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('charlas', function (Blueprint $table) {
            $table->string('char_tipo')->nullable()->after('modalidad');
        });
    }

    public function down(): void
    {
        Schema::table('charlas', function (Blueprint $table) {
            $table->dropColumn('char_tipo');
        });
    }
};
