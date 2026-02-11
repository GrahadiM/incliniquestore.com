<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Address;
use App\Models\Voucher;
use App\Models\BranchStore;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CheckoutController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $cartItems = Cart::with('product')
            ->where('user_id', $user->id)
            ->get();

        abort_if($cartItems->isEmpty(), 403, 'Cart kosong');

        $addresses = Address::where('user_id', $user->id)
            ->where('status', 'active')
            ->get();

        return view('frontend.checkout.index', compact(
            'cartItems',
            'addresses'
        ));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'address_id' => ['required', 'exists:addresses,id'],
            'voucher_code' => ['nullable', 'string'],
        ]);

        DB::transaction(function () use ($request, $user) {

            /** =============================
             * 1. AMBIL CART + LOCK PRODUCT
             * ============================= */
            $cartItems = Cart::with('product')
                ->where('user_id', $user->id)
                ->lockForUpdate()
                ->get();

            if ($cartItems->isEmpty()) {
                throw new \Exception('Cart kosong');
            }

            $subtotal = 0;

            foreach ($cartItems as $item) {
                if ($item->product->stock < $item->qty) {
                    throw new \Exception(
                        "Stok {$item->product->name} tidak mencukupi"
                    );
                }

                $subtotal += $item->qty * $item->product->price;
            }

            /** =============================
             * 2. VOUCHER VALIDATION
             * ============================= */
            $discount = 0;
            $voucher = null;

            if ($request->voucher_code) {
                $voucher = Voucher::where('code', $request->voucher_code)
                    ->where('status', 'active')
                    ->where(function ($q) use ($user) {
                        $q->whereNull('member_level_id')
                        ->orWhere('member_level_id', $user->member_level_id);
                    })
                    ->where(function ($q) {
                        $q->whereNull('start_date')
                        ->orWhere('start_date', '<=', now());
                    })
                    ->where(function ($q) {
                        $q->whereNull('end_date')
                        ->orWhere('end_date', '>=', now());
                    })
                    ->where(function ($q) {
                        $q->whereNull('quota')
                        ->orWhereColumn('used', '<', 'quota');
                    })
                    ->firstOrFail();

                if ($subtotal < $voucher->min_transaction) {
                    throw new \Exception('Minimal transaksi tidak terpenuhi');
                }

                $discount = $voucher->type === 'percent'
                    ? ($subtotal * $voucher->value / 100)
                    : $voucher->value;
            }

            /** =============================
             * 3. AUTO SELECT NEAREST STORE
             * ============================= */
            $address = Address::findOrFail($request->address_id);

            $store = BranchStore::selectRaw(
                "*, (
                    6371 * acos(
                        cos(radians(?)) *
                        cos(radians(latitude)) *
                        cos(radians(longitude) - radians(?)) +
                        sin(radians(?)) *
                        sin(radians(latitude))
                    )
                ) AS distance",
                [$address->latitude, $address->longitude, $address->latitude]
            )
            ->where('status', 'active')
            ->orderBy('distance')
            ->first();

            /** =============================
             * 4. CREATE ORDER
             * ============================= */
            $order = Order::create([
                'order_number' => 'ORD-' . now()->format('YmdHis') . rand(100,999),
                'user_id' => $user->id,
                'subtotal' => $subtotal,
                'shipping_cost' => 12000,
                'discount' => $discount,
                'grand_total' => ($subtotal + 12000) - $discount,
                'status' => 'pending',
                'payment_status' => 'unpaid',
            ]);

            /** =============================
             * 5. ORDER DETAILS + STOCK LOCK
             * ============================= */
            foreach ($cartItems as $item) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'qty' => $item->qty,
                    'price' => $item->product->price,
                    'subtotal' => $item->qty * $item->product->price,
                ]);

                // KURANGI STOK (LOCKED)
                $item->product->decrement('stock', $item->qty);
            }

            /** =============================
             * 6. VOUCHER USAGE
             * ============================= */
            if ($voucher) {
                $voucher->increment('used');
            }

            /** =============================
             * 7. CLEAR CART
             * ============================= */
            Cart::where('user_id', $user->id)->delete();
        });

        return response()->json([
            'success' => true,
            'redirect' => route('frontend.order.tracking.index')
        ]);
    }
}
