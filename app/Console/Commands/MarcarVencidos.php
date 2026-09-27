<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Charla;
use App\Models\Observador;

class MarcarVencidos extends Command
{
    protected $signature   = 'estados:marcar-vencidos';
    protected $description = 'Marca como "vencida" las charlas y observadores pendientes cuya fecha ya pasó';

    public function handle()
    {
        $charlas = Charla::where('estado', 'pendiente')
            ->whereNotNull('fecha_hora')
            ->where('fecha_hora', '<', now())
            ->update(['estado' => 'vencida']);

        $observadores = Observador::where('estado', 'pendiente')
            ->whereNotNull('fecha_hora')
            ->where('fecha_hora', '<', now())
            ->update(['estado' => 'vencida']);

        $this->info("Charlas marcadas como vencidas: {$charlas}");
        $this->info("Observadores marcados como vencidos: {$observadores}");
    }
}
