<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('configuracion');
    }

    public function down(): void
    {
        Schema::create('configuracion', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
    }
};
