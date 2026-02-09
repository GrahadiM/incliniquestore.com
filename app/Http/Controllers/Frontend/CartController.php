<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    public function index()
    {
        $data = Cart::with('product')->where('user_id', auth()->id())->get();

        $subtotal = $data->sum(fn ($item) => $item->product->price * $item->qty);

        $tax = $subtotal * 0.1; // 10% tax
        $shipping = 12000; // flat shipping rate

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
            'qty' => ['required', 'integer', 'min:1', 'max:100'],
        ]);

        // Cek Auth
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Silahkan login terlebih dahulu'
            ], 401);
        }

        // Cek stok produk
        $product = Product::findOrFail($request->product_id);
        if ($product->stock < $request->qty) {
            return response()->json([
                'success' => false,
                'message' => 'Stok produk tidak mencukupi. Stok tersedia: ' . $product->stock
            ], 422);
        }

        $cart = Cart::firstOrCreate(
            [
                'user_id' => auth()->id(),
                'product_id' => $request->product_id,
            ],
            ['qty' => 0]
        );

        // Cek apakah qty baru melebihi stok
        $newQty = $cart->qty + $request->qty;
        if ($newQty > $product->stock) {
            return response()->json([
                'success' => false,
                'message' => 'Jumlah melebihi stok tersedia. Stok tersedia: ' . $product->stock
            ], 422);
        }

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
            'qty' => ['required', 'integer', 'min:1', 'max:100']
        ]);

        // Cek stok produk
        if ($request->qty > $cart->product->stock) {
            return response()->json([
                'success' => false,
                'message' => 'Stok produk tidak mencukupi. Stok tersedia: ' . $cart->product->stock
            ], 422);
        }

        $cart->update(['qty' => $request->qty]);

        return $this->getCartSummary($cart);
    }

    public function destroy(Cart $cart)
    {
        abort_if($cart->user_id !== auth()->id(), 403);

        $cart->delete();

        return $this->getCartSummary($cart);
    }

    /**
     * Helper method untuk menghitung ringkasan keranjang
     */
    private function getCartSummary(?Cart $deletedCart = null)
    {
        $data = Cart::with('product')->where('user_id', auth()->id())->get();

        $subtotal = $data->sum(fn ($item) => $item->product->price * $item->qty);
        $tax = $subtotal * 0.1;
        $shipping = 12000;
        $total = $subtotal + $tax + $shipping;

        return response()->json([
            'success' => true,
            'qty' => $deletedCart ? 0 : ($data->firstWhere('id', $deletedCart ? null : 'id')?->qty ?? 0),
            'item_total' => $deletedCart ? 0 : ($deletedCart ? 0 : ($data->firstWhere('id', $deletedCart ? null : 'id')?->product->price * $deletedCart->qty ?? 0)),
            'subtotal' => $subtotal,
            'tax' => $tax,
            'shipping' => $shipping,
            'total' => $total,
            'cart_count' => $data->sum('qty'),
        ]);
    }
}
