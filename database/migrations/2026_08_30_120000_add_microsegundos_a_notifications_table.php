<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Le agrega precisión de microsegundos a created_at/updated_at de la tabla
     * notifications. Antes solo guardaban hasta el segundo, así que si dos
     * notificaciones se creaban en el mismo segundo, no había forma de saber
     * cuál era realmente la más nueva — y la limpieza automática que borra
     * las notificaciones viejas (deja solo las últimas 8) podía, en ese caso,
     * borrar la que en realidad era la más reciente en vez de una vieja.
     *
     * No borra ni modifica ningún dato existente, solo aumenta la precisión
     * para las notificaciones que se creen de ahora en adelante.
     */
    public function up(): void
    {
        DB::statement('ALTER TABLE notifications MODIFY created_at TIMESTAMP(6) NULL');
        DB::statement('ALTER TABLE notifications MODIFY updated_at TIMESTAMP(6) NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE notifications MODIFY created_at TIMESTAMP NULL');
        DB::statement('ALTER TABLE notifications MODIFY updated_at TIMESTAMP NULL');
    }
};
