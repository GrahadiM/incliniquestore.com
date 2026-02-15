<?php

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;

protected function configureRateLimiting(): void
{
    /*
    |--------------------------------------------------------------------------
    | GLOBAL THROTTLE
    |--------------------------------------------------------------------------
    | Proteksi seluruh aplikasi (public routes)
    | 120 request / 1 menit / IP
    */
    RateLimiter::for('global', function (Request $request) {
        return Limit::perMinute(120)
            ->by($request->ip())
            ->response(function () {
                return response()->json([
                    'message' => 'Terlalu banyak request. Silakan coba beberapa saat lagi.'
                ], 429);
            });
    });

    /*
    |--------------------------------------------------------------------------
    | REGISTER (ANTI SPAM)
    |--------------------------------------------------------------------------
    */
    RateLimiter::for('register', function (Request $request) {
        return Limit::perMinutes(10, 5)->by($request->ip());
    });

    /*
    |--------------------------------------------------------------------------
    | LOGIN PROTECTION
    |--------------------------------------------------------------------------
    */
    RateLimiter::for('login', function (Request $request) {
        return Limit::perMinute(5)->by(
            $request->ip() . '|' . $request->input('email')
        );
    });
}
