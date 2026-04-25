<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TrabajoPendienteNotification extends Notification
{
    use Queueable;

    public function __construct(
        public string $mensaje,
        public string $seccion = '',
        public ?int $entradaId = null
    ) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'mensaje'   => $this->mensaje,
            'seccion'   => $this->seccion,
            'entrada_id' => $this->entradaId,
        ];
    }
}
