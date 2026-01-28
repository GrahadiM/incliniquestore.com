<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    public function index()
    {
        $data = Cart::with('product')
            ->where('user_id', auth()->id())
            ->get();

        $subtotal = $data->sum(fn ($item) =>
            $item->product->price * $item->qty
        );

        return view('frontend.cart.index', [
            'data' => $data,
            'subtotal' => $subtotal,
        ]);
    }

    public function add(Request $request)
{
        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'qty' => ['required', 'integer', 'min:1'],
        ]);

        $cart = Cart::firstOrCreate(
            [
                'user_id' => auth()->id(),
                'product_id' => $request->product_id,
            ],
            ['qty' => 0]
        );

        $cart->increment('qty', $request->qty);

        $cartCount = Cart::where('user_id', auth()->id())->sum('qty');

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan ke keranjang',
            'cart_count' => $cartCount
        ]);
    }
}
