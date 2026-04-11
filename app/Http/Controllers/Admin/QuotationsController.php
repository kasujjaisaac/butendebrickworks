<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderTracking;
use App\Models\Quotation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class QuotationsController extends Controller
{
    public function index(Request $request): View|StreamedResponse
    {
        $status = $request->query('status', 'all');

        $query = Quotation::with(['user', 'product'])->latest();

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('user', fn($q) => $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%"));
        }

        if ($request->query('export') === 'csv') {
            return $this->exportCsv($query->get());
        }

        return view('admin.quotations.index', [
            'pageTitle'  => 'Quotations',
            'quotations' => $query->paginate(20)->withQueryString(),
            'status'     => $status,
            'counts'     => [
                'all'      => Quotation::count(),
                'pending'  => Quotation::where('status', 'pending')->count(),
                'approved' => Quotation::where('status', 'approved')->count(),
                'rejected' => Quotation::where('status', 'rejected')->count(),
            ],
        ]);
    }

    public function show(Quotation $quotation): View
    {
        $quotation->load(['user', 'product', 'order']);

        return view('admin.quotations.show', [
            'pageTitle' => 'Quotation #' . $quotation->id,
            'quotation' => $quotation,
        ]);
    }

    public function approve(Quotation $quotation, Request $request): RedirectResponse
    {
        $request->validate([
            'price_per_brick' => ['required', 'numeric', 'min:0.01'],
        ]);

        $pricePerBrick = (float) $request->input('price_per_brick');
        $totalPrice    = round($pricePerBrick * $quotation->bricks_required, 2);

        $quotation->update([
            'status'         => 'approved',
            'price_per_brick' => $pricePerBrick,
            'total_price'    => $totalPrice,
        ]);

        return redirect()->route('admin.quotations.show', $quotation)
            ->with('status', 'Quotation #' . $quotation->id . ' approved successfully.');
    }

    public function reject(Quotation $quotation): RedirectResponse
    {
        $quotation->update(['status' => 'rejected']);

        return redirect()->route('admin.quotations.show', $quotation)
            ->with('status', 'Quotation #' . $quotation->id . ' has been rejected.');
    }

    public function convertToOrder(Quotation $quotation): RedirectResponse
    {
        if ($quotation->status !== 'approved') {
            return back()->with('error', 'Only approved quotations can be converted to an order.');
        }

        if ($quotation->hasOrder()) {
            return redirect()->route('admin.orders.show', $quotation->order)
                ->with('info', 'An order already exists for this quotation.');
        }

        $order = DB::transaction(function () use ($quotation): Order {
            $order = Order::create([
                'user_id'      => $quotation->user_id,
                'quotation_id' => $quotation->id,
                'total_amount' => $quotation->total_price,
                'order_status' => 'confirmed',
            ]);

            OrderTracking::create([
                'order_id'   => $order->id,
                'status'     => 'confirmed',
                'message'    => 'Order created from approved quotation by admin.',
                'created_at' => now(),
            ]);

            return $order;
        });

        return redirect()->route('admin.orders.show', $order)
            ->with('status', 'Order #' . $order->id . ' created from quotation.');
    }

    public function destroy(Quotation $quotation): RedirectResponse
    {
        $quotation->delete();

        return redirect()->route('admin.quotations.index')
            ->with('status', 'Quotation deleted.');
    }

    public function markAllRead(): RedirectResponse
    {
        return redirect()->route('admin.quotations.index');
    }

    private function exportCsv($quotations): StreamedResponse
    {
        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="quotations-' . now()->format('Y-m-d') . '.csv"',
        ];

        return response()->stream(function () use ($quotations) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Client', 'Email', 'Product', 'Area (m²)', 'Bricks Req.', 'Price/Brick', 'Total', 'Status', 'Created']);
            foreach ($quotations as $q) {
                fputcsv($handle, [
                    $q->id,
                    $q->user->name ?? '—',
                    $q->user->email ?? '—',
                    $q->product->name ?? '—',
                    $q->square_metres,
                    $q->bricks_required,
                    $q->price_per_brick,
                    $q->total_price,
                    $q->status,
                    $q->created_at->format('Y-m-d H:i'),
                ]);
            }
            fclose($handle);
        }, 200, $headers);
    }
}
