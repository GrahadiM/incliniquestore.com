<?php

namespace App\Exceptions;

use Exception;
use Throwable;
use Illuminate\Http\Exceptions\ThrottleRequestsException;

class Handler extends Exception
{
    public function render($request, Throwable $e)
    {
        if ($e instanceof ThrottleRequestsException) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Terlalu banyak permintaan. Silakan coba lagi nanti.'
                ], 429);
            }

            return back()->withErrors([
                'throttle' => 'Terlalu banyak permintaan. Silakan tunggu beberapa saat.'
            ]);
        }

        return parent::render($request, $e);
    }
}
