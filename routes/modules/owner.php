<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Owner\OwnerController;

Route::middleware(['auth', 'role:owner'])
    ->prefix('owner')
    ->name('owner.')
    ->group(function () {

        Route::get('/dashboard', [OwnerController::class, 'index'])
            ->name('dashboard');

        Route::post('/profil/update', [OwnerController::class, 'updateProfil'])
            ->name('profil.update');
    });