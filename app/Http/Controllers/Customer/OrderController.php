<?php

namespace App\Http\Controllers\Customer;

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
                    'pending' => '<span class="text-yellow-600 font-medium">Pending</span>',
                    'processing' => '<span class="text-blue-600 font-medium">Processing</span>',
                    'completed' => '<span class="text-green-600 font-medium">Completed</span>',
                    'cancelled' => '<span class="text-red-600 font-medium">Cancelled</span>',
                };
            })
            ->editColumn('grand_total', function ($order) {
                return 'Rp ' . number_format($order->grand_total, 0, ',', '.');
            })
            ->addColumn('action', function ($order) {
                return '
                    <a href="#" class="text-primary-orange hover:underline text-sm">
                        Detail
                    </a>
                ';
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }
}
