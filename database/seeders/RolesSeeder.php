<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'Admin',
            'Supervisor',
            'Secretaria Con Nota',
            'Secretaria Sin Nota',
            'Asesor',
            'Tecnico',
        ];

        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }
    }
}