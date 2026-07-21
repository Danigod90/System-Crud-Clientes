<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Asesor;
use App\Services\WhatsAppService;
use Carbon\Carbon;

class PedirConfirmacion extends Command
{
    protected $signature   = 'recordatorios:confirmacion {asesor_id?}';
    protected $description = 'Pide a los asesores que confirmen con OK cada 3 días. Opcionalmente, a uno solo pasando su ID.';

    public function handle()
    {
        $whatsapp = new WhatsAppService();
        $limite   = Carbon::now()->subDays(3);
        $asesorId = $this->argument('asesor_id');

        $query = Asesor::whereNotNull('telefono');

        if ($asesorId) {
            $query->where('id', $asesorId);
        } else {
            $query->where(function ($q) use ($limite) {
                $q->whereNull('ultima_confirmacion_at')
                  ->orWhere('ultima_confirmacion_at', '<=', $limite);
            });
        }

        $asesores = $query->get();

        if ($asesores->isEmpty()) {
            $this->info('No hay asesores que necesiten confirmación en este momento.');
            return;
        }

        foreach ($asesores as $asesor) {
            $enviado = $whatsapp->enviar(
                $asesor->telefono,
                "👋 Hola {$asesor->nombre}, para seguir recibiendo tus recordatorios por WhatsApp, respondé *OK* a este mensaje.\n\n_Sistema de Gestión Electoral_"
            );

            if ($enviado) {
                $asesor->ultima_confirmacion_at = now();
                $asesor->save();
                $this->info("Confirmación pedida a: {$asesor->nombre} {$asesor->apellido}");
            } else {
                $this->error("Error al pedir confirmación a: {$asesor->nombre} {$asesor->apellido}");
            }
        }

        $this->info('Proceso de confirmación finalizado.');
    }
}
