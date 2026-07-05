<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatConversacion extends Model
{
    protected $table = 'chat_conversaciones';
    protected $fillable = ['tipo', 'nombre', 'rol', 'user1_id', 'user2_id'];

    public function mensajes()
    {
        return $this->hasMany(ChatMensaje::class, 'conversacion_id')->orderBy('created_at');
    }

    public function ultimoMensaje()
    {
        return $this->hasOne(ChatMensaje::class, 'conversacion_id')->latestOfMany();
    }

    public function lecturas()
    {
        return $this->hasMany(ChatLectura::class, 'conversacion_id');
    }
}
