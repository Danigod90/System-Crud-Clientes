<?php

namespace App\Http\Controllers\Asesor;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UtilidadesController extends Controller
{
    public function dhondt()
    {
        $user = Auth::user();
        $charlasPendientes = $user->charlasPendientes ?? collect();

        return view('asesor.utilidades.dhondt', compact('charlasPendientes'));
    }
}
