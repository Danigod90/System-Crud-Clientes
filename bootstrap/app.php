<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
    $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e, $request) {
        if (auth()->check()) {
            $user = auth()->user();

            if ($user->hasRole('Admin')) {
                return redirect()->route('admin.users.index');
            }
            if ($user->hasRole('Supervisor')) {
                return redirect()->route('supervisor.dashboard');
            }
            if ($user->hasRole('Tecnico')) {
                return redirect()->route('tecnico.dashboard');
            }
            if ($user->hasRole('Asesor')) {
                return redirect()->route('asesor.mis-organizaciones');
            }
            if ($user->hasRole('Secretaria Con Nota')) {
                return redirect()->route('panel.dashboard');
            }
            if ($user->hasRole('Secretaria Sin Nota')) {
                return redirect()->route('secretaria.sin-nota.index');
            }

            return redirect()->route('dashboard');
        }

        return redirect()->route('login')->with('status', 'Tu sesión expiró por inactividad. Por favor iniciá sesión nuevamente.');
    });

   $exceptions->render(function (\Illuminate\Session\TokenMismatchException $e, $request) {
    return redirect()->route('login')->with('status', 'Tu sesión expiró por inactividad. Por favor iniciá sesión nuevamente.');
});
})->create();
