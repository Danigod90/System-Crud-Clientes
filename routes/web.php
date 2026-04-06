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
    Route::get('configuracion', [\App\Http\Controllers\Admin\ConfiguracionController::class, 'index'])->name('configuracion.index');
    Route::patch('configuracion', [\App\Http\Controllers\Admin\ConfiguracionController::class, 'update'])->name('configuracion.update');
    Route::get('tipo-organizaciones', [\App\Http\Controllers\Admin\TipoOrganizacionController::class, 'index'])->name('tipo-organizaciones.index');
    Route::post('tipo-organizaciones', [\App\Http\Controllers\Admin\TipoOrganizacionController::class, 'store'])->name('tipo-organizaciones.store');
    Route::delete('tipo-organizaciones/{tipoOrganizacion}', [\App\Http\Controllers\Admin\TipoOrganizacionController::class, 'destroy'])->name('tipo-organizaciones.destroy');
});

Route::middleware(['auth', 'role:Secretaria Sin Nota|Secretaria Con Nota|Admin|Asesor'])->prefix('secretaria')->name('secretaria.')->group(function () {
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
    Route::patch('con-nota/{conNota}/ticker', [\App\Http\Controllers\Secretaria\EntradaConNotaController::class, 'toggleTicker'])->name('con-nota.toggle-ticker');
});

Route::middleware(['auth'])->get('/panel/dashboard', [\App\Http\Controllers\Panel\DashboardController::class, 'index'])->name('panel.dashboard');
Route::middleware(['auth', 'role:Asesor|Secretaria Con Nota|Admin'])->prefix('asesor')->name('asesor.')->group(function () {
    Route::get('mis-organizaciones', [\App\Http\Controllers\Asesor\MisOrganizacionesController::class, 'index'])->name('mis-organizaciones');
    Route::get('organizacion/{entrada}/edit', [\App\Http\Controllers\Asesor\MisOrganizacionesController::class, 'edit'])->name('organizacion.edit');
    Route::post('charla/{entrada}', [\App\Http\Controllers\Asesor\CharlaController::class, 'store'])->name('charla.store');
    Route::patch('charla/{charla}/estado', [\App\Http\Controllers\Asesor\CharlaController::class, 'updateEstado'])->name('charla.estado');
});
require __DIR__.'/auth.php';
