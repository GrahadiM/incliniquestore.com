<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MidtransCallbackController extends Controller
{
    public function handle(Request $request)
    {
        $notif = $request->all();
        $order = Order::where('order_number', $notif['order_id'])->firstOrFail();

        if ($notif['transaction_status'] === 'capture' || $notif['transaction_status'] === 'settlement') {
            $order->update([
                'payment_status' => 'paid',
                'status' => 'processing'
            ]);
        } elseif ($notif['transaction_status'] === 'pending') {
            $order->update(['payment_status' => 'pending']);
        } else {
            $order->update(['payment_status' => 'failed']);
        }

        return response()->json(['status' => 'ok']);
    }
}
