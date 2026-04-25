<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;

Route::get('/', function () {
    return redirect()->route('login');
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
    Route::resource('users', UserController::class)->only(['index', 'create', 'store', 'destroy', 'edit', 'update']);
    Route::resource('asesores', \App\Http\Controllers\Admin\AsesorController::class)
    ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
    ->parameters(['asesores' => 'asesor']);
    Route::get('configuracion', [\App\Http\Controllers\Admin\ConfiguracionController::class, 'index'])->name('configuracion.index');
    Route::patch('configuracion', [\App\Http\Controllers\Admin\ConfiguracionController::class, 'update'])->name('configuracion.update');
    Route::get('tipo-organizaciones', [\App\Http\Controllers\Admin\TipoOrganizacionController::class, 'index'])->name('tipo-organizaciones.index');
    Route::post('tipo-organizaciones', [\App\Http\Controllers\Admin\TipoOrganizacionController::class, 'store'])->name('tipo-organizaciones.store');
    Route::delete('tipo-organizaciones/{tipoOrganizacion}', [\App\Http\Controllers\Admin\TipoOrganizacionController::class, 'destroy'])->name('tipo-organizaciones.destroy');
});

Route::middleware(['auth', 'role:Secretaria Sin Nota|Secretaria Con Nota|Admin|Asesor'])->prefix('secretaria')->name('secretaria.')->group(function () {

    // ← Rutas específicas ANTES del resource
    Route::get('sin-nota/pdf', [\App\Http\Controllers\Secretaria\EntradaSinNotaController::class, 'exportPdf'])->name('sin-nota.pdf');
    Route::get('sin-nota/log', [\App\Http\Controllers\Secretaria\EntradaSinNotaController::class, 'log'])->name('sin-nota.log');
    Route::post('sin-nota/log/{id}/devolucion', [\App\Http\Controllers\Secretaria\EntradaSinNotaController::class, 'storeDevolucion'])->name('sin-nota.devolucion');
    Route::patch('con-nota/{conNota}/entregar-tec', [\App\Http\Controllers\Secretaria\EntradaConNotaController::class, 'entregarTec'])->name('con-nota.entregar-tec');
    Route::resource('sin-nota', \App\Http\Controllers\Secretaria\EntradaSinNotaController::class)
         ->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'])
         ->parameters(['sin-nota' => 'sinNota']);
    Route::get('sin-nota/log', [\App\Http\Controllers\Secretaria\EntradaSinNotaController::class, 'log'])->name('sin-nota.log');
    Route::post('sin-nota/log/{id}/devolucion', [\App\Http\Controllers\Secretaria\EntradaSinNotaController::class, 'storeDevolucion'])->name('sin-nota.devolucion');

    Route::resource('con-nota', \App\Http\Controllers\Secretaria\EntradaConNotaController::class)
        ->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'])
        ->parameters(['con-nota' => 'conNota']);

    Route::get('con-nota/{conNota}/nota-pdf', [\App\Http\Controllers\Secretaria\NotaPdfController::class, 'notaPresidente'])->name('con-nota.nota-pdf');
    Route::get('con-nota/{conNota}/recibo-logistica', [\App\Http\Controllers\Secretaria\NotaPdfController::class, 'reciboLogistica'])->name('con-nota.recibo-logistica');
    Route::patch('con-nota/{conNota}/entregar-log', [\App\Http\Controllers\Secretaria\EntradaConNotaController::class, 'entregarLog'])->name('con-nota.entregar-log');
    Route::patch('con-nota/{conNota}/ticker', [\App\Http\Controllers\Secretaria\EntradaConNotaController::class, 'toggleTicker'])->name('con-nota.toggle-ticker');
});
Route::middleware(['auth'])->prefix('documentos')->name('documentos.')->group(function () {
    Route::post('{entrada}', [\App\Http\Controllers\DocumentoController::class, 'store'])->name('store');
    Route::delete('{documento}', [\App\Http\Controllers\DocumentoController::class, 'destroy'])->name('destroy');
    Route::get('{documento}', [\App\Http\Controllers\DocumentoController::class, 'show'])->name('show');
});
Route::middleware(['auth'])->get('/panel/dashboard', [\App\Http\Controllers\Panel\DashboardController::class, 'index'])->name('panel.dashboard');

Route::middleware(['auth'])->prefix('asesor')->name('asesor.')->group(function () {
    Route::get('mis-organizaciones', [\App\Http\Controllers\Asesor\MisOrganizacionesController::class, 'index'])->name('mis-organizaciones');
    Route::get('organizacion/{entrada}/edit', [\App\Http\Controllers\Asesor\MisOrganizacionesController::class, 'edit'])->name('organizacion.edit');
    Route::post('charla/{entrada}', [\App\Http\Controllers\Asesor\CharlaController::class, 'store'])->name('charla.store');
    Route::patch('charla/{charla}/estado', [\App\Http\Controllers\Asesor\CharlaController::class, 'updateEstado'])->name('charla.estado');
    Route::delete('charla/{charla}', [\App\Http\Controllers\Asesor\CharlaController::class, 'destroy'])->name('charla.destroy');
    Route::post('observador/{entrada}', [\App\Http\Controllers\Asesor\ObservadorController::class, 'store'])->name('observador.store');
    Route::patch('observador/{observador}/estado', [\App\Http\Controllers\Asesor\ObservadorController::class, 'updateEstado'])->name('observador.estado');
    Route::post('prioridad/{entrada}', [\App\Http\Controllers\Asesor\PrioridadAsesorController::class, 'toggle'])->name('prioridad.toggle');

    // ── DETALLE TÉCNICO — PANEL ASESOR ──
    Route::get('detalle-tecnico/{entrada_id}', [\App\Http\Controllers\DetalleTecnicoController::class, 'createAsesor'])->name('detalle_tecnico.asesor');
    Route::post('detalle-tecnico/{entrada_id}', [\App\Http\Controllers\DetalleTecnicoController::class, 'saveAsesor'])->name('detalle_tecnico.saveAsesor');
    Route::post('detalle-tecnico/{entrada_id}/enviar', [\App\Http\Controllers\DetalleTecnicoController::class, 'enviarTecnica'])->name('detalle_tecnico.enviarTecnica');
    // ── BORRADOR PRIVADO ──
    Route::get('borrador/lista', [\App\Http\Controllers\Asesor\BorradorPrivadoController::class, 'index'])->name('borrador.index');
    Route::get('borrador/crear', [\App\Http\Controllers\Asesor\BorradorPrivadoController::class, 'create'])->name('borrador.create');
    Route::post('borrador/crear', [\App\Http\Controllers\Asesor\BorradorPrivadoController::class, 'store'])->name('borrador.store');
    Route::get('borrador/{id}', [\App\Http\Controllers\Asesor\BorradorPrivadoController::class, 'show'])->name('borrador.show');
    Route::post('borrador/{id}/tarea', [\App\Http\Controllers\Asesor\BorradorPrivadoController::class, 'storeTarea'])->name('borrador.storeTarea');
    Route::post('borrador/{id}/enviar', [\App\Http\Controllers\Asesor\BorradorPrivadoController::class, 'enviarAMesaDeEntrada'])->name('borrador.enviar');
    Route::delete('borrador/{id}', [\App\Http\Controllers\Asesor\BorradorPrivadoController::class, 'destroy'])->name('borrador.destroy');
});

// ── PANEL TÉCNICO ──
Route::middleware(['auth', 'role:Tecnico|Admin'])->prefix('tecnico')->name('tecnico.')->group(function () {
    Route::get('dashboard', [\App\Http\Controllers\Tecnico\TecnicoDashboardController::class, 'index'])->name('dashboard');
    Route::get('organizaciones', [\App\Http\Controllers\Tecnico\TecnicoOrganizacionesController::class, 'index'])->name('organizaciones');
    Route::get('organizacion/{entrada_id}/edit', [\App\Http\Controllers\Tecnico\TecnicoOrganizacionesController::class, 'edit'])->name('organizacion.edit');
    Route::post('detalle/{entrada_id}', [\App\Http\Controllers\DetalleTecnicoController::class, 'saveTecnico'])->name('detalle_tecnico.saveTecnico');
    Route::post('detalle/{entrada_id}/imprimir', [\App\Http\Controllers\DetalleTecnicoController::class, 'imprimirLogistica'])->name('detalle_tecnico.imprimir');
    Route::patch('detalle/{entrada_id}/realizado', [\App\Http\Controllers\DetalleTecnicoController::class, 'marcarRealizado'])->name('detalle_tecnico.realizado');
    Route::get('detalle/{entrada_id}/check-update', [\App\Http\Controllers\DetalleTecnicoController::class, 'checkAsesorUpdate'])->name('detalle_tecnico.checkUpdate');
    Route::post('detalle/{entrada_id}/asesor', [\App\Http\Controllers\DetalleTecnicoController::class, 'saveAsesor'])->name('detalle_tecnico.saveAsesor');
    Route::post('prioridad/{entrada}', [\App\Http\Controllers\Tecnico\PrioridadTecnicaController::class, 'toggle'])->name('prioridad.toggle');
});

Route::get('/test-borrador', function () {
    return 'funciona';
});

Route::get('/notificaciones/count', function() {
    return response()->json(['count' => auth()->user()->unreadNotifications->count()]);
})->middleware('auth');
Route::post('/notificaciones/leer', function() {
    auth()->user()->unreadNotifications->markAsRead();
    return response()->json(['ok' => true]);
})->middleware('auth');
Route::get('/notificaciones/lista', function() {
    $notifs = auth()->user()->notifications->take(8)->map(function($n) {
        return [
            'mensaje' => $n->data['mensaje'] ?? '',
            'seccion' => $n->data['seccion'] ?? '',
            'leida'   => !is_null($n->read_at),
            'hace'    => $n->created_at->diffForHumans(),
        ];
    });
    return response()->json(['notificaciones' => $notifs]);
})->middleware('auth');

require __DIR__.'/auth.php';


