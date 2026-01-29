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
        $data = Cart::with('product')->where('user_id', auth()->id())->get();

        $subtotal = $data->sum(fn ($item) =>
            $item->product->price * $item->qty
        );

        $tax = $subtotal * 0.1; // Example: 10% tax
        $shipping = 12000; // Example: flat shipping rate

        return view('frontend.cart.index', [
            'data' => $data,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'shipping' => $shipping,
            'total' => $subtotal + $tax + $shipping,
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

    public function update(Request $request, Cart $cart)
    {
        abort_if($cart->user_id !== auth()->id(), 403);

        $request->validate([
            'qty' => ['required', 'integer', 'min:1']
        ]);

        $cart->update(['qty' => $request->qty]);

        $subtotal = Cart::where('user_id', auth()->id())
            ->with('product')
            ->get()
            ->sum(fn ($item) => $item->product->price * $item->qty);

        $tax = $subtotal * 0.1; // Example: 10% tax
        $shipping = 12000; // Example: flat shipping rate

        return response()->json([
            'success' => true,
            'qty' => $cart->qty,
            'item_total' => $cart->product->price * $cart->qty,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'shipping' => $shipping,
            'total' => $subtotal + $tax + $shipping,
            'cart_count' => Cart::where('user_id', auth()->id())->sum('qty'),
        ]);
    }

    public function destroy(Cart $cart)
    {
        abort_if($cart->user_id !== auth()->id(), 403);

        $cart->delete();

        $subtotal = Cart::where('user_id', auth()->id())
            ->with('product')
            ->get()
            ->sum(fn ($item) => $item->product->price * $item->qty);

        return response()->json([
            'success' => true,
            'subtotal' => $subtotal,
            'total' => $subtotal,
            'cart_count' => Cart::where('user_id', auth()->id())->sum('qty'),
        ]);
    }
}
