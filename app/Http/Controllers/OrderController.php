<?php

namespace App\Http\Controllers;

use App\Models\BrickProduct;
use App\Models\Order;
use App\Models\OrderTracking;
use App\Models\Quotation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        $orders = Order::with(['quotation.product', 'directProduct'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        $products = BrickProduct::where('is_active', true)->orderBy('name')->get();

        return view('orders.index', compact('orders', 'products'));
    }

    public function show(Order $order): View
    {
        $this->authorizeOwner($order->user_id);

        $order->load(['quotation.product', 'directProduct', 'tracking']);

        return view('orders.show', compact('order'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'quotation_id' => ['required', 'integer', 'exists:quotations,id'],
        ]);

        $quotation = Quotation::findOrFail($request->integer('quotation_id'));

        // Ensure the quotation belongs to the authenticated user
        abort_unless($quotation->user_id === Auth::id(), 403);

        // Prevent duplicate orders for the same quotation
        if ($quotation->hasOrder()) {
            return redirect()->route('orders.show', $quotation->order)
                ->with('info', 'An order already exists for this quotation.');
        }

        $order = DB::transaction(function () use ($quotation): Order {
            $order = Order::create([
                'user_id'      => Auth::id(),
                'quotation_id' => $quotation->id,
                'total_amount' => $quotation->total_price,
                'order_status' => 'pending',
            ]);

            OrderTracking::create([
                'order_id' => $order->id,
                'status'   => 'pending',
                'message'  => 'Your order has been received and is awaiting confirmation.',
            ]);

            return $order;
        });

        return redirect()->route('orders.show', $order)
            ->with('success', 'Your order has been placed successfully!');
    }

    public function storeDirect(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'brick_product_id' => ['required', 'integer', 'exists:brick_products,id'],
            'quantity'         => ['required', 'integer', 'min:1'],
            'delivery_address' => ['required', 'string', 'max:500'],
            'notes'            => ['nullable', 'string', 'max:1000'],
        ]);

        $product = BrickProduct::findOrFail($validated['brick_product_id']);

        $totalAmount = round($validated['quantity'] * (float) $product->price_per_brick, 2);

        $order = DB::transaction(function () use ($validated, $totalAmount): Order {
            $order = Order::create([
                'user_id'          => Auth::id(),
                'quotation_id'     => null,
                'brick_product_id' => $validated['brick_product_id'],
                'quantity'         => $validated['quantity'],
                'delivery_address' => $validated['delivery_address'],
                'notes'            => $validated['notes'] ?? null,
                'total_amount'     => $totalAmount,
                'order_status'     => 'pending',
            ]);

            OrderTracking::create([
                'order_id' => $order->id,
                'status'   => 'pending',
                'message'  => 'Your order has been received and is awaiting confirmation.',
            ]);

            return $order;
        });

        return redirect()->route('orders.show', $order)
            ->with('success', 'Your order has been placed successfully!');
    }

    private function authorizeOwner(int $ownerId): void
    {
        abort_unless(Auth::id() === $ownerId, 403);
    }
}
