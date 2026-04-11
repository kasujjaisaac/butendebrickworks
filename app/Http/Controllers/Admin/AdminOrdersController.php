<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderTracking;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminOrdersController extends Controller
{
    public function index(Request $request): View|StreamedResponse
    {
        $status = $request->query('status', 'all');

        $query = Order::with(['user', 'quotation.product', 'directProduct'])->latest();

        if ($status !== 'all') {
            $query->where('order_status', $status);
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('user', fn($q) => $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%"));
        }

        if ($request->query('export') === 'csv') {
            return $this->exportCsv($query->get());
        }

        $allStatuses = Order::allStatuses();

        return view('admin.orders.index', [
            'pageTitle'   => 'Orders',
            'orders'      => $query->paginate(20)->withQueryString(),
            'status'      => $status,
            'allStatuses' => $allStatuses,
            'counts'      => collect($allStatuses)->mapWithKeys(fn($s) => [$s => Order::where('order_status', $s)->count()])
                ->prepend(Order::count(), 'all')
                ->all(),
        ]);
    }

    public function show(Order $order): View
    {
        $order->load(['user', 'quotation.product', 'directProduct', 'tracking']);

        return view('admin.orders.show', [
            'pageTitle'   => 'Order #' . $order->id,
            'order'       => $order,
            'allStatuses' => Order::allStatuses(),
        ]);
    }

    public function updateStatus(Order $order, Request $request): RedirectResponse
    {
        $request->validate([
            'order_status' => ['required', 'in:' . implode(',', Order::allStatuses())],
            'note'         => ['nullable', 'string', 'max:500'],
        ]);

        $newStatus = $request->input('order_status');

        $order->update(['order_status' => $newStatus]);

        OrderTracking::create([
            'order_id'   => $order->id,
            'status'     => $newStatus,
            'message'    => $request->input('note') ?: 'Status updated to ' . Order::statusLabel($newStatus) . ' by admin.',
            'created_at' => now(),
        ]);

        return redirect()->route('admin.orders.show', $order)
            ->with('status', 'Order status updated to ' . Order::statusLabel($newStatus) . '.');
    }

    private function exportCsv($orders): StreamedResponse
    {
        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="orders-' . now()->format('Y-m-d') . '.csv"',
        ];

        return response()->stream(function () use ($orders) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Client', 'Email', 'Product', 'Quantity', 'Total (UGX)', 'Status', 'Type', 'Created']);
            foreach ($orders as $o) {
                $product = $o->resolved_product;
                fputcsv($handle, [
                    $o->id,
                    $o->user->name ?? '—',
                    $o->user->email ?? '—',
                    $product->name ?? '—',
                    $o->quantity ?? ($o->quotation?->bricks_required ?? '—'),
                    number_format($o->total_amount, 2),
                    Order::statusLabel($o->order_status),
                    $o->isDirectOrder() ? 'Direct' : 'From Quotation',
                    $o->created_at->format('Y-m-d H:i'),
                ]);
            }
            fclose($handle);
        }, 200, $headers);
    }
}
