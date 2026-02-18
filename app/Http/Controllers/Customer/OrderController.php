<?php

namespace App\Http\Controllers\Customer;

use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    public function datatable()
    {
        $orders = Order::whereUserId(Auth::id())->latest();

        return DataTables::of($orders)
            ->addIndexColumn()
            ->editColumn('status', function ($order) {
                return match ($order->status) {
                    'unpaid' => '<span class="text-sm uppercase border border-yellow-800 text-yellow-700 bg-yellow-200 font-medium px-2 py-1 rounded">Unpaid</span>',
                    'paid' => '<span class="text-sm uppercase border border-indigo-800 text-indigo-700 bg-indigo-200 font-medium px-2 py-1 rounded">Paid</span>', // tambahkan ini
                    'processing' => '<span class="text-sm uppercase border border-blue-800 text-blue-700 bg-blue-200 font-medium px-2 py-1 rounded">Processing</span>',
                    'completed' => '<span class="text-sm uppercase border border-green-800 text-green-700 bg-green-200 font-medium px-2 py-1 rounded">Completed</span>',
                    'cancelled' => '<span class="text-sm uppercase border border-red-800 text-red-700 bg-red-200 font-medium px-2 py-1 rounded">Cancelled</span>',
                    default => '<span class="text-sm uppercase border border-gray-800 text-gray-700 bg-gray-200 font-medium px-2 py-1 rounded">Unknown</span>',
                };
            })
            ->editColumn('grand_total', function ($order) {
                return 'Rp ' . number_format($order->grand_total, 0, ',', '.');
            })
            ->addColumn('action', function ($order) {
                $buttons = '<div class="flex gap-2">';

                if ($order->status === 'unpaid') {
                    $buttons .= '<button
                                    onclick="payOrder('.$order->id.')"
                                    class="px-3 py-1 bg-primary-green hover:bg-green-700 text-white rounded-md text-sm font-medium transition">
                                    Bayar
                                </button>';
                }

                $buttons .= '<a href="'.route('customer.orders.detail', $order->id).'"
                                class="px-3 py-1 bg-primary-orange hover:bg-orange-600 text-white rounded-md text-sm font-medium transition">
                                Detail
                            </a>';

                $buttons .= '</div>';

                return $buttons;
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function index()
    {
        return view('customer.order.index');
    }

    public function generateSnapToken(Order $order)
    {
        // Pastikan user hanya bisa bayar order miliknya
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $user = Auth::user();
        $snapToken = $order->snap_token;

        return response()->json(['token' => $snapToken]);
    }
}
