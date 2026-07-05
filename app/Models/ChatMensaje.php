<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMensaje extends Model
{
    protected $fillable = ['conversacion_id', 'user_id', 'mensaje', 'archivo', 'archivo_nombre', 'archivo_tipo'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function conversacion()
    {
        return $this->belongsTo(ChatConversacion::class, 'conversacion_id');
    }
}
