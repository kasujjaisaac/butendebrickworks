<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TrackingController extends Controller
{
    public function show(Order $order): View
    {
        abort_unless($order->user_id === Auth::id(), 403);

        $order->load(['quotation.product', 'tracking']);

        $statuses = Order::allStatuses();

        return view('orders.tracking', compact('order', 'statuses'));
    }
}
