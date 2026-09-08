<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class OrganizacionEliminadaNotification extends Notification
{
    use Queueable;

    public function __construct(
        public string $mensaje,
        public ?int $entradaId = null
    ) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'mensaje'    => $this->mensaje,
            'seccion'    => 'Papelera',
            'tipo'       => 'eliminacion', // el front-end la pinta distinto (rojo pálido) gracias a esto
            'entrada_id' => $this->entradaId,
        ];
    }
}
