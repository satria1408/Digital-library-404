<?php
date_default_timezone_set('Asia/Jakarta');

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {

        /*
        |--------------------------------------------------------------------------
        | Global Middleware
        |--------------------------------------------------------------------------
        | Middleware SQL Injection dijalankan untuk setiap request
        |--------------------------------------------------------------------------
        */
        $middleware->append(\App\Http\Middleware\SqlInjectionMiddleware::class);

        /*
        |--------------------------------------------------------------------------
        | Middleware Alias
        |--------------------------------------------------------------------------
        */
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
            'sql.injection' => \App\Http\Middleware\SqlInjectionMiddleware::class,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Redirect Guest
        |--------------------------------------------------------------------------
        */
        $middleware->redirectGuestsTo(fn() => route('login'));

        /*
        |--------------------------------------------------------------------------
        | Redirect User Berdasarkan Role
        |--------------------------------------------------------------------------
        */
        $middleware->redirectUsersTo(function ($request) {
            $user = auth()->user();

            // 1. Cek Role Developer
            if ($user?->role === 'developer') {
                return route('developer.dashboard');
            }

            // 2. Cek Role Admin
            if ($user?->role === 'admin') {
                return route('admin.dashboard');
            }

            // 3. Cek Role Siswa
            if ($user?->role === 'siswa') {
                return route('siswa.dashboard');
            }

            return '/';
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();