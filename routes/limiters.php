<?php

use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Rate Limiters — Global
|--------------------------------------------------------------------------
| Semua definisi rate limiter aplikasi ditaruh di sini biar terpusat,
| gak numpuk di file route module masing-masing.
|--------------------------------------------------------------------------
*/

RateLimiter::for('login', function (Request $request) {
    return Limit::perMinute(5)->by($request->ip());
});

RateLimiter::for('pinjam', function (Request $request) {
    return Limit::perMinute(3)->by($request->user()?->id ?: $request->ip());
});