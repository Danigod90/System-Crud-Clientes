<?php

namespace App\Http\Controllers;

use App\Models\ChatConversacion;
use App\Models\ChatMensaje;
use App\Models\ChatLectura;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ChatController extends Controller
{
    // Lista de conversaciones del usuario
    public function conversaciones()
    {
        $user = Auth::user();
        $conversaciones = [];

        // General
        $general = ChatConversacion::where('tipo', 'general')->first();
        if ($general) $conversaciones[] = $this->formatConversacion($general, $user);

        // Técnicos — solo si no es técnico, o si es técnico también lo ve
        $tecnicos = ChatConversacion::where('tipo', 'rol')->where('rol', 'Tecnico')->first();
        if ($tecnicos) $conversaciones[] = $this->formatConversacion($tecnicos, $user);

        // Directos
        $directos = ChatConversacion::where('tipo', 'directo')
            ->where(fn($q) => $q->where('user1_id', $user->id)->orWhere('user2_id', $user->id))
            ->get();

        $ocultasIds = ChatLectura::where('user_id', $user->id)->where('oculta', true)->pluck('conversacion_id');

        foreach ($directos as $d) {
            if ($ocultasIds->contains($d->id)) continue;
            $conversaciones[] = $this->formatConversacion($d, $user);
        }

        return response()->json($conversaciones);
    }

    // Ocultar (cerrar) un chat directo de la lista del usuario, sin borrar nada
    public function ocultar($id)
    {
        $user = Auth::user();
        $conv = ChatConversacion::findOrFail($id);

        if ($conv->tipo !== 'directo') {
            return response()->json(['ok' => false, 'error' => 'Solo se pueden cerrar chats directos.'], 422);
        }

        ChatLectura::updateOrCreate(
            ['conversacion_id' => $id, 'user_id' => $user->id],
            ['oculta' => true]
        );

        return response()->json(['ok' => true]);
    }

    // Todos los usuarios para iniciar chat directo
    public function usuarios()
    {
        $user = Auth::user();
        $usuarios = User::where('id', '!=', $user->id)
            ->orderBy('name')
            ->get()
            ->map(fn($u) => [
                'id'     => $u->id,
                'nombre' => $u->name,
                'rol'    => $u->roles->first()?->name ?? 'Sin rol',
                'online' => $u->last_seen_at && $u->last_seen_at->diffInMinutes(now()) < 2,
            ]);

        return response()->json($usuarios);
    }

    // Mensajes de una conversación
    public function mensajes($id)
    {
        $user = Auth::user();
        $conv = ChatConversacion::findOrFail($id);

        $mensajes = ChatMensaje::with('user')
            ->where('conversacion_id', $id)
            ->orderBy('created_at')
            ->get()
            ->map(fn($m) => [
                'id'             => $m->id,
                'user_id'        => $m->user_id,
                'nombre'         => $m->user->name,
                'mensaje'        => $m->mensaje,
                'archivo'        => $m->archivo ? Storage::url($m->archivo) : null,
                'archivo_nombre' => $m->archivo_nombre,
                'archivo_tipo'   => $m->archivo_tipo,
                'es_mio'         => $m->user_id === $user->id,
                'hace'           => $m->created_at->diffForHumans(),
                'hora'           => $m->created_at->format('H:i'),
            ]);

        // Marcar como leído
        ChatLectura::updateOrCreate(
            ['conversacion_id' => $id, 'user_id' => $user->id],
            ['leido_at' => now()]
        );

        return response()->json($mensajes);
    }

    // Enviar mensaje
    public function enviar(Request $request, $id)
    {
        $user = Auth::user();
        $conv = ChatConversacion::findOrFail($id);

        $archivo = null;
        $archivoNombre = null;
        $archivoTipo = null;

        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');
            $archivo = $file->store('chat', 'public');
            $archivoNombre = $file->getClientOriginalName();
            $archivoTipo = $file->getMimeType();
        }

        $mensaje = ChatMensaje::create([
            'conversacion_id' => $id,
            'user_id'         => $user->id,
            'mensaje'         => $request->mensaje,
            'archivo'         => $archivo,
            'archivo_nombre'  => $archivoNombre,
            'archivo_tipo'    => $archivoTipo,
        ]);

        // Si alguno de los dos había "cerrado" este chat, reaparece al llegar actividad nueva
        if ($conv->tipo === 'directo') {
            ChatLectura::where('conversacion_id', $id)
                ->whereIn('user_id', [$conv->user1_id, $conv->user2_id])
                ->update(['oculta' => false]);
        }

        return response()->json([
            'id'             => $mensaje->id,
            'user_id'        => $mensaje->user_id,
            'nombre'         => $user->name,
            'mensaje'        => $mensaje->mensaje,
            'archivo'        => $archivo ? Storage::url($archivo) : null,
            'archivo_nombre' => $archivoNombre,
            'archivo_tipo'   => $archivoTipo,
            'es_mio'         => true,
            'hora'           => $mensaje->created_at->format('H:i'),
        ]);
    }

    // Iniciar o encontrar chat directo
    public function iniciarDirecto($userId)
    {
        $user = Auth::user();
        $otro = User::findOrFail($userId);

        $conv = ChatConversacion::where('tipo', 'directo')
            ->where(fn($q) =>
                $q->where(fn($q2) => $q2->where('user1_id', $user->id)->where('user2_id', $userId))
                  ->orWhere(fn($q2) => $q2->where('user1_id', $userId)->where('user2_id', $user->id))
            )->first();

        if (!$conv) {
            $conv = ChatConversacion::create([
                'tipo'     => 'directo',
                'nombre'   => null,
                'user1_id' => $user->id,
                'user2_id' => $userId,
            ]);
        }

        return response()->json(['conversacion_id' => $conv->id]);
    }

    // No leídos totales
    public function noLeidos()
    {
        $user = Auth::user();
        $total = 0;

        $convIds = ChatConversacion::where('tipo', 'general')
            ->orWhere('tipo', 'rol')
            ->orWhere(fn($q) => $q->where('tipo', 'directo')
                ->where(fn($q2) => $q2->where('user1_id', $user->id)->orWhere('user2_id', $user->id)))
            ->pluck('id');

        foreach ($convIds as $convId) {
            $lectura = ChatLectura::where('conversacion_id', $convId)->where('user_id', $user->id)->first();
            $count = ChatMensaje::where('conversacion_id', $convId)
                ->where('user_id', '!=', $user->id)
                ->when($lectura, fn($q) => $q->where('created_at', '>', $lectura->leido_at))
                ->count();
            $total += $count;
        }

        return response()->json(['total' => $total]);
    }

    // Actualizar last_seen
    public function ping()
    {
        Auth::user()->update(['last_seen_at' => now()]);
        return response()->json(['ok' => true]);
    }

    private function formatConversacion($conv, $user)
    {
        $ultimo = $conv->ultimoMensaje?->load('user');
        $lectura = ChatLectura::where('conversacion_id', $conv->id)->where('user_id', $user->id)->first();
        $noLeidos = ChatMensaje::where('conversacion_id', $conv->id)
            ->where('user_id', '!=', $user->id)
            ->when($lectura, fn($q) => $q->where('created_at', '>', $lectura->leido_at))
            ->count();

        $nombre = $conv->nombre;
        if ($conv->tipo === 'directo') {
            $otroId = $conv->user1_id === $user->id ? $conv->user2_id : $conv->user1_id;
            $otro = User::find($otroId);
            $nombre = $otro?->name ?? 'Usuario';
        }

        return [
            'id'           => $conv->id,
            'tipo'         => $conv->tipo,
            'nombre'       => $nombre,
            'rol'          => $conv->rol,
            'no_leidos'    => $noLeidos,
            'ultimo'       => $ultimo ? ($ultimo->mensaje ?? '📎 Archivo') : null,
            'ultimo_user'  => $ultimo?->user?->name,
            'ultimo_hora'  => $ultimo?->created_at?->format('H:i'),
        ];
    }
}
