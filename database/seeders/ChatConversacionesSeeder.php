<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ChatConversacion;

class ChatConversacionesSeeder extends Seeder
{
    public function run(): void
    {
        // Canal general — todos
        ChatConversacion::firstOrCreate(
            ['tipo' => 'general'],
            ['nombre' => 'General', 'rol' => null, 'user1_id' => null, 'user2_id' => null]
        );

        // Canal por rol — Técnicos
        ChatConversacion::firstOrCreate(
            ['tipo' => 'rol', 'rol' => 'Tecnico'],
            ['nombre' => 'Técnicos', 'user1_id' => null, 'user2_id' => null]
        );
    }
}
