<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Asesor;
use App\Services\WhatsAppService;
use Carbon\Carbon;

class PedirConfirmacion extends Command
{
    protected $signature   = 'recordatorios:confirmacion';
    protected $description = 'Pide a los asesores que confirmen con OK cada 3 días para mantener activa la conversación de WhatsApp';

    public function handle()
    {
        $whatsapp = new WhatsAppService();
        $limite   = Carbon::now()->subDays(3);

        $asesores = Asesor::whereNotNull('telefono')
            ->where(function ($q) use ($limite) {
                $q->whereNull('ultima_confirmacion_at')
                  ->orWhere('ultima_confirmacion_at', '<=', $limite);
            })->get();

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
