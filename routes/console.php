<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

// WhatsApp/Twilio descontinuado (bloqueado por el cortafuegos de la red) — desactivado
// para que no siga intentando y llenando el log de errores todos los días.
// Schedule::command('recordatorios:enviar')->dailyAt('08:00');
// Schedule::command('recordatorios:confirmacion')->dailyAt('09:00');

// Marca automáticamente como "vencida" las charlas y observadores pendientes
// cuya fecha ya pasó (sin que nadie las haya marcado manualmente como
// realizada/cancelada/suspendida).
Schedule::command('estados:marcar-vencidos')->dailyAt('00:05');

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
