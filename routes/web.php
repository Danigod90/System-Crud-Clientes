<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    if (auth()->user()->hasRole('Admin')) {
        return redirect()->route('admin.users.index');
    }
    if (auth()->user()->hasRole('Secretaria Sin Nota')) {
        return redirect()->route('secretaria.sin-nota.index');
    }
    if (auth()->user()->hasRole('Secretaria Con Nota')) {
    return redirect()->route('panel.dashboard');
}
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:Admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserController::class)->only(['index', 'create', 'store', 'destroy']);
    Route::resource('asesores', \App\Http\Controllers\Admin\AsesorController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
});

Route::middleware(['auth', 'role:Secretaria Sin Nota|Secretaria Con Nota|Admin'])->prefix('secretaria')->name('secretaria.')->group(function () {
    Route::get('sin-nota/pdf', [\App\Http\Controllers\Secretaria\EntradaSinNotaController::class, 'exportPdf'])->name('sin-nota.pdf');
    Route::resource('sin-nota', \App\Http\Controllers\Secretaria\EntradaSinNotaController::class)
         ->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'])
         ->parameters(['sin-nota' => 'sinNota']);

    Route::resource('con-nota', \App\Http\Controllers\Secretaria\EntradaConNotaController::class)
        ->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'])
        ->parameters(['con-nota' => 'conNota']);

    Route::get('con-nota/{conNota}/nota-pdf', [\App\Http\Controllers\Secretaria\NotaPdfController::class, 'notaPresidente'])->name('con-nota.nota-pdf');
    Route::get('con-nota/{conNota}/recibo-logistica', [\App\Http\Controllers\Secretaria\NotaPdfController::class, 'reciboLogistica'])->name('con-nota.recibo-logistica');
    Route::patch('con-nota/{conNota}/entregar-log', [\App\Http\Controllers\Secretaria\EntradaConNotaController::class, 'entregarLog'])->name('con-nota.entregar-log');
});

Route::middleware(['auth'])->get('/panel/dashboard', [\App\Http\Controllers\Panel\DashboardController::class, 'index'])->name('panel.dashboard');

require __DIR__.'/auth.php';
