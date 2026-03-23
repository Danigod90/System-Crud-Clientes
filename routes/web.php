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
        return redirect()->route('secretaria.con-nota.index');
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
    Route::resource('sin-nota', \App\Http\Controllers\Secretaria\EntradaSinNotaController::class)
         ->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'])
    ->parameters(['sin-nota' => 'sinNota']);

    Route::resource('con-nota', \App\Http\Controllers\Secretaria\EntradaConNotaController::class)
        ->only(['index', 'create', 'store', 'show']);
});

require __DIR__.'/auth.php';
