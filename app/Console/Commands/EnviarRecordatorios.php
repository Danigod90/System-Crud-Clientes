<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Charla;
use App\Models\EntradaConNota;
use App\Models\Asesor;
use App\Services\WhatsAppService;
use Carbon\Carbon;

class EnviarRecordatorios extends Command
{
    protected $signature   = 'recordatorios:enviar';
    protected $description = 'Envía recordatorios de charlas y observadores por WhatsApp';

    public function handle()
    {
        $whatsapp = new WhatsAppService();
        $manana   = Carbon::tomorrow()->toDateString();

        // Recordatorios de charlas
        $charlas = Charla::with('entrada')
            ->whereDate('fecha_hora', $manana)
            ->where('estado', 'pendiente')
            ->get();

        foreach ($charlas as $charla) {
            $entrada = $charla->entrada;
            if (!$entrada) continue;

            $asesor = Asesor::whereRaw("CONCAT(nombre, ' ', apellido) = ?", [$entrada->asesor_asignado])->first();
            if (!$asesor || !$asesor->telefono) continue;

$fecha = Carbon::parse($charla->fecha_hora)->locale('es')->isoFormat('D [de] MMMM');

$whatsapp->enviar(
    $asesor->telefono,
    "🔔 *Recordatorio de Charla*\n" .
    "🏢 *Organización:* {$entrada->nombre_organizacion}\n" .
    "📅 Tenés una charla mañana {$fecha}\n\n" .
    "_Sistema de Gestión Electoral_"
);

            $this->info("Recordatorio charla enviado: {$entrada->nombre_organizacion}");
        }

        // Recordatorios de observadores
        $observadores = EntradaConNota::with('observador')
    ->where('asunto_obs', true)
    ->whereHas('observador', fn($q) =>
        $q->whereDate('fecha_hora', $manana)
          ->where('estado', 'pendiente')
    )->get();

        foreach ($observadores as $entrada) {
            $asesor = Asesor::whereRaw("CONCAT(nombre, ' ', apellido) = ?", [$entrada->asesor_asignado])->first();
            if (!$asesor || !$asesor->telefono) continue;

           $fecha = Carbon::parse($entrada->observador->fecha_hora)->locale('es')->isoFormat('D [de] MMMM');

$whatsapp->enviar(
    $asesor->telefono,
    "👁️ *Recordatorio de Observador*\n" .
    "🏢 *Organización:* {$entrada->nombre_organizacion}\n" .
    "📅 Tenés observador mañana {$fecha}\n\n" .
    "_Sistema de Gestión Electoral_"
);

            $this->info("Recordatorio observador enviado: {$entrada->nombre_organizacion}");
        }

        $this->info('Recordatorios enviados correctamente.');
    }
}
