<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatLectura extends Model
{
    protected $fillable = ['conversacion_id', 'user_id', 'leido_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
