<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    public function index()
    {
        $data = Cart::with('product')->where('user_id', auth()->id())->get();

        $subtotal = $data->sum(fn ($item) => $item->product->price * $item->qty);
        $tax = $data->count() ? $subtotal * 0.1 : 0; // tax 10%
        $shipping = $data->count() ? 12000 : 0; // flat shipping rate

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
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'redirect' => route('login'),
                'message' => 'Silakan login terlebih dahulu'
            ], 401);
        }

        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'qty' => ['required', 'integer', 'min:1'],
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($request->qty > $product->stock) {
            return response()->json([
                'success' => false,
                'message' => 'Stok tersedia hanya ' . $product->stock
            ], 422);
        }

        $cart = Cart::firstOrCreate(
            [
                'user_id' => auth()->id(),
                'product_id' => $product->id,
            ],
            ['qty' => 0]
        );

        if (($cart->qty + $request->qty) > $product->stock) {
            return response()->json([
                'success' => false,
                'message' => 'Jumlah melebihi stok'
            ], 422);
        }

        $cart->increment('qty', $request->qty);

        return $this->cartResponse($cart);
    }

    public function update(Request $request, Cart $cart)
    {
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'redirect' => route('login'),
                'message' => 'Silakan login terlebih dahulu'
            ], 401);
        }

        $request->validate([
            'qty' => ['required', 'integer', 'min:1'],
        ]);

        if ($request->qty > $cart->product->stock) {
            return response()->json([
                'success' => false,
                'message' => 'Stok tersedia hanya ' . $cart->product->stock
            ], 422);
        }

        $cart->update(['qty' => $request->qty]);

        return $this->cartResponse($cart);
    }

    public function destroy(Cart $cart)
    {
        abort_if($cart->user_id !== auth()->id(), 403);

        $cart->delete();

        return $this->cartResponse();
    }

    private function cartResponse(?Cart $cart = null)
    {
        $items = Cart::with('product')->where('user_id', auth()->id())->get();

        $subtotal = $items->sum(fn ($i) => $i->product->price * $i->qty);
        $tax = $subtotal > 0 ? $subtotal * 0.1 : 0;
        $shipping = $items->count() ? 12000 : 0;

        return response()->json([
            'success' => true,

            'item' => $cart ? [
                'id' => $cart->id,
                'qty' => $cart->qty,
                'item_total' => $cart->qty * $cart->product->price,
                'stock' => $cart->product->stock,
            ] : null,

            'subtotal' => $subtotal,
            'tax' => $tax,
            'shipping' => $shipping,
            'total' => $subtotal + $tax + $shipping,
            'cart_count' => $items->sum('qty'),
        ]);
    }
}
