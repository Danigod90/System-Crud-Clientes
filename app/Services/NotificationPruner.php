<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * Recorta las notificaciones de un usuario, dejando solo las más recientes.
 *
 * Antes esta lógica ("si tiene más de 8, borrar el resto") estaba repetida
 * en 10 lugares distintos del código, cada uno haciendo un count() y un
 * delete() por separado, sin ninguna protección contra ejecuciones
 * simultáneas. Cuando llegaban varias notificaciones casi al mismo tiempo
 * para el mismo usuario (por ejemplo varios asesores enviando a técnica
 * en pocos segundos), cada llamada calculaba "cuáles son las últimas 8"
 * en base a una foto de la base de datos que ya estaba desactualizada
 * cuando llegaba su turno de borrar. El resultado combinado de varias
 * llamadas así, corriendo casi en paralelo, podía borrar muchas más
 * notificaciones de las que cualquiera de ellas quería borrar por su
 * cuenta — en el peor caso, todas.
 *
 * Este método soluciona eso bloqueando brevemente al usuario mientras
 * decide qué conservar, de modo que dos llamadas para el mismo usuario
 * nunca se ejecuten en paralelo: la segunda espera a que la primera
 * termine y confirme sus cambios antes de leer el estado real.
 */
class NotificationPruner
{
    public static function prune(User $user, int $keep = 8): void
    {
        DB::transaction(function () use ($user, $keep) {
            // Bloquea la fila del usuario durante la transacción. Si otra
            // llamada a prune() para el mismo usuario está en curso, esta
            // espera acá hasta que la primera termine, en vez de leer datos
            // que están por cambiar.
            User::whereKey($user->getKey())->lockForUpdate()->first();

            $total = $user->notifications()->count();

            if ($total <= $keep) {
                return;
            }

            $idsAConservar = $user->notifications()
                ->orderByDesc('created_at')
                ->orderByDesc('id')
                ->limit($keep)
                ->pluck('id');

            $user->notifications()
                ->whereNotIn('id', $idsAConservar)
                ->delete();
        });
    }
}
