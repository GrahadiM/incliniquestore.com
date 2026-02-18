<?php

namespace App\Http\Controllers\Frontend;

use Carbon\Carbon;
use Midtrans\Snap;
use App\Models\Cart;
use Midtrans\Config;
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
        $addresses = Address::where('user_id', $user->id)->where('status', 'active')->orderByDesc('is_default')->get();
        $cartItems = Cart::with('product')->where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('frontend.cart.index')->with('error', 'Keranjang kosong, silahkan belanja terlebih dahulu!');
        }

        foreach ($cartItems as $item) {
            abort_if($item->product->stock < $item->qty, 409, 'Stok produk tidak mencukupi');
        }

        $subtotal = $cartItems->sum(fn($i) => $i->qty * $i->product->price);
        $tax = $subtotal * 0.1;
        $shipping = 12000;
        $total = $subtotal + $tax + $shipping;

        return view('frontend.checkout.index', [
            'cartItems' => $cartItems,
            'addresses' => $addresses,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'shipping' => $shipping,
            'total' => $total,
        ]);
    }

    public function payment(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Anda tidak diizinkan mengakses halaman ini.');
        }

        return view('frontend.checkout.payment', [
            'order' => $order,
            'orderDetails' => $order->orderDetails()->with('product')->get(),
            'store' => $order->branchStore,
        ]);
    }

    public function applyVoucher(Request $request)
    {
        $request->validate(['voucher' => 'required|string']);
        $user = auth()->user();
        $now = Carbon::now();

        $voucher = Voucher::where('code', $request->voucher)->where('status', 'active')->first();

        if (!$voucher) {
            return response()->json(['valid' => false, 'message' => 'Voucher tidak ditemukan']);
        }

        if ($voucher->member_level_id && $voucher->member_level_id !== $user->member_level_id) {
            return response()->json(['valid' => false, 'message' => 'Voucher tidak sesuai level member']);
        }

        if ($voucher->quota !== null && $voucher->used >= $voucher->quota) {
            return response()->json(['valid' => false, 'message' => 'Voucher sudah habis']);
        }

        if ($voucher->start_date && $now->lt($voucher->start_date)) {
            return response()->json(['valid' => false, 'message' => 'Voucher belum berlaku']);
        }

        if ($voucher->end_date && $now->gt($voucher->end_date)) {
            return response()->json(['valid' => false, 'message' => 'Voucher sudah kedaluwarsa']);
        }

        return response()->json([
            'valid' => true,
            'type' => $voucher->type,
            'value' => $voucher->value,
            'message' => 'Voucher berhasil digunakan'
        ]);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $user = auth()->user();

        $request->validate([
            'address_id' => 'required|exists:addresses,id',
            'voucher_code' => 'nullable|string'
        ]);

        $result = DB::transaction(function () use ($request, $user) {

            $cartItems = Cart::with('product')
                ->where('user_id', $user->id)
                ->lockForUpdate()
                ->get();

            abort_if($cartItems->isEmpty(), 403);

            $subtotal = 0;
            foreach ($cartItems as $item) {
                abort_if($item->product->stock < $item->qty, 409);
                $subtotal += $item->qty * $item->product->price;
            }

            $discount = 0;
            $voucher = null;

            if ($request->voucher_code) {
                $voucher = Voucher::where('code', $request->voucher_code)
                    ->where('status', 'active')
                    ->firstOrFail();

                $discount = $voucher->type === 'percent'
                    ? $subtotal * $voucher->value / 100
                    : $voucher->value;
            }

            $tax = $subtotal * 0.1;
            $shipping = 12000;

            $address = Address::where('id', $request->address_id)
                ->where('user_id', $user->id)
                ->firstOrFail();

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
            )->where('status', 'active')->orderBy('distance')->first();

            $order = Order::create([
                'order_number' => 'ORD-' . now()->format('YmdHis') . rand(100,999),
                'user_id' => $user->id,
                'branch_store_id' => $store?->id,
                'address_id' => $address->id,
                'subtotal' => $subtotal,
                'shipping_cost' => $shipping,
                'discount' => $discount,
                'grand_total' => ($subtotal + $tax + $shipping) - $discount,
                'status' => 'unpaid',
                'payment_status' => 'unpaid',
            ]);

            foreach ($cartItems as $item) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'qty' => $item->qty,
                    'price' => $item->product->price,
                    'subtotal' => $item->qty * $item->product->price,
                ]);

                $item->product->decrement('stock', $item->qty);
            }

            Cart::where('user_id', $user->id)->delete();

            Config::$serverKey = config('services.midtrans.server_key');
            Config::$isProduction = config('services.midtrans.is_production');
            Config::$isSanitized = true;
            Config::$is3ds = true;

            $snapToken = Snap::getSnapToken([
                'transaction_details' => [
                    'order_id' => $order->order_number,
                    'gross_amount' => $order->grand_total,
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->whatsapp,
                ],
                'item_details' => $order->orderDetails->map(function ($detail) {
                    return [
                        'id' => $detail->product_id,
                        'price' => $detail->price,
                        'quantity' => $detail->qty,
                        'name' => $detail->product->name,
                    ];
                 })->toArray(),
            ]);

            $order->update(['snap_token' => $snapToken]);

            return [
                'snap_token' => $snapToken,
                'order_id' => $order->id
            ];
        });

        return response()->json([
            'success' => true,
            'snap_token' => $result['snap_token'],
            'order_id' => $result['order_id']
        ]);
    }
}
