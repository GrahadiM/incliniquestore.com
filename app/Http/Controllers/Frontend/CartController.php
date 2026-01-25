<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        return view('frontend.cart.index');
    }

    public function add(Request $request)
    {
        // Logic to add item to cart would go here

        return response()->json(['message' => 'Item added to cart successfully.']);
    }
}
