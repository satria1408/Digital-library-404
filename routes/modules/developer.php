<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Developer\SuggestionController;

// --- Rute Publik (Kotak Saran) ---
Route::post('/saran/kirim', [SuggestionController::class, 'store'])->name('saran.store');
Route::post('/saran/cek', [SuggestionController::class, 'checkTicket'])->name('saran.check');

// --- Rute Internal Developer ---
Route::middleware(['auth', 'role:developer'])
    ->prefix('developer')
    ->name('developer.')
    ->group(function () {

        Route::get('/dashboard', [SuggestionController::class, 'dashboard'])
            ->name('dashboard');

        Route::get('/suggestions', [SuggestionController::class, 'indexForDeveloper'])
            ->name('suggestions.index');

        Route::get('/suggestions/export-excel', [SuggestionController::class, 'exportExcel'])
            ->name('suggestions.export');

        Route::post('/suggestions/{id}/reply', [SuggestionController::class, 'reply'])
            ->name('suggestions.reply');

        Route::delete('/suggestions/{id}', [SuggestionController::class, 'destroy'])
            ->name('suggestions.destroy');
    });