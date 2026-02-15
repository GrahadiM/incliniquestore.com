<?php

namespace App\Http\Controllers\Customer;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $stats = [
            'total_orders' => Order::whereUserId($user->id)->count(),
            'active_orders' => Order::whereUserId($user->id)
                                    ->whereIn('status', ['pending', 'processing'])
                                    ->count(),
            'completed_orders' => Order::whereUserId($user->id)
                                        ->where('status', 'completed')
                                        ->count(),
            'total_spent' => Order::whereUserId($user->id)
                                  ->where('status', 'completed')
                                  ->sum('grand_total'),
        ];

        return view('customer.dashboard', [
            'user' => $user,
            'stats' => $stats,
        ]);
    }
}
