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
        $items = Cart::with('product')->where('user_id', auth()->id())->get();

        foreach ($items as $item) {
            // Jika produk dihapus / stok 0 → hapus cart
            if (!$item->product || $item->product->stock <= 0) {
                $item->delete();
                continue;
            }

            // Jika qty > stok → set ke stok maksimal
            if ($item->qty > $item->product->stock) {
                $item->update([
                    'qty' => $item->product->stock
                ]);
            }
        }

        // Reload setelah sync
        $data = Cart::with('product')->where('user_id', auth()->id())->get();

        $subtotal = $data->sum(fn ($item) => $item->product->price * $item->qty);
        // Pajak 10%
        $tax = $data->count() ? $subtotal * 0.1 : 0;
        // Biaya pengiriman
        $shipping = $data->count() ? 12000 : 0;
        // Total
        $total = $subtotal + $tax + $shipping;

        return view('frontend.cart.index', [
            'data' => $data,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'shipping' => $shipping,
            'total' => $total,
        ]);
    }

    public function add(Request $request)
    {
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'redirect' => route('login'),
                'message' => 'Silakan login terlebih dahulu'
            ], 403);
        }

        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'qty' => ['required', 'integer', 'min:1'],
        ]);

        $product = Product::findOrFail($request->product_id);

        // STOK HABIS → TOLAK
        if ($product->stock <= 0) {
            Cart::where('user_id', auth()->id())
                ->where('product_id', $product->id)
                ->delete();

            return response()->json([
                'success' => false,
                'message' => 'Produk sedang habis'
            ], 422);
        }

        $cart = Cart::firstOrCreate(
            [
                'user_id' => auth()->id(),
                'product_id' => $product->id,
            ],
            ['qty' => 0]
        );

        $newQty = $cart->qty + $request->qty;

        // JIKA MELEBIHI STOK → SET KE STOK MAKS
        if ($newQty > $product->stock) {
            $newQty = $product->stock;
        }

        $cart->update([
            'qty' => $newQty
        ]);

        return $this->cartResponse($cart);
    }

    public function update(Cart $cart, Request $request)
    {
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'redirect' => route('login'),
                'message' => 'Silakan login terlebih dahulu'
            ], 403);
        }

        $request->validate([
            'qty' => ['required', 'integer', 'min:1'],
        ]);

        $product = $cart->product;

        // PRODUK HILANG / STOK 0 → HAPUS CART
        if (!$product || $product->stock <= 0) {
            $cart->delete();
            return $this->cartResponse();
        }

        $qty = min($request->qty, $product->stock);

        $cart->update([
            'qty' => $qty
        ]);

        return $this->cartResponse($cart);
    }

    public function destroy(Cart $cart)
    {
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'redirect' => route('login'),
                'message' => 'Silakan login terlebih dahulu'
            ], 403);
        }

        $cart->delete();

        return $this->cartResponse();
    }

    private function cartResponse(?Cart $cart = null)
    {
        $items = Cart::with('product')->where('user_id', auth()->id())->get()->filter(fn ($i) => $i->product && $i->product->stock > 0);

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
