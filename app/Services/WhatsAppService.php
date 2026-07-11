<?php

namespace App\Services;

use Twilio\Rest\Client;

class WhatsAppService
{
    protected $client;
    protected $from;

    public function __construct()
    {
        $this->client = new Client(
            config('services.twilio.sid'),
            config('services.twilio.token')
        );
        $this->from = config('services.twilio.whatsapp_from');
    }

    public function enviar(string $numero, string $mensaje): bool
    {
        try {
            $this->client->messages->create(
                'whatsapp:+595' . $numero,
                [
                    'from' => $this->from,
                    'body' => $mensaje,
                ]
            );
            return true;
        } catch (\Exception $e) {
            \Log::error('WhatsApp error: ' . $e->getMessage());
            return false;
        }
    }
}
