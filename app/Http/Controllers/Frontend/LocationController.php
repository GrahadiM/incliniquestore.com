<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function selected_store(Request $request)
    {
        session(['selected_store' => $request->all()]);
        return response()->json([
            'success' => true,
            'message' => 'Berhasil memilih lokasi',
            'data' => $request->all()
        ]);
    }
}
