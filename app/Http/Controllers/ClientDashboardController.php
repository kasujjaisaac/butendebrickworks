<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Quotation;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ClientDashboardController extends Controller
{
    public function __invoke(): View
    {
        $userId = Auth::id();

        $totalQuotations  = Quotation::where('user_id', $userId)->count();
        $pendingQuotations = Quotation::where('user_id', $userId)->where('status', 'pending')->count();
        $totalOrders      = Order::where('user_id', $userId)->count();
        $activeOrders     = Order::where('user_id', $userId)
                                 ->whereNotIn('order_status', ['delivered'])
                                 ->count();

        $recentQuotations = Quotation::with('product')
            ->where('user_id', $userId)
            ->latest()
            ->limit(3)
            ->get();

        $recentOrders = Order::with(['quotation.product', 'directProduct'])
            ->where('user_id', $userId)
            ->latest()
            ->limit(3)
            ->get();

        return view('portal.dashboard', compact(
            'totalQuotations',
            'pendingQuotations',
            'totalOrders',
            'activeOrders',
            'recentQuotations',
            'recentOrders',
        ));
    }
}
