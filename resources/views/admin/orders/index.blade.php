@extends('layouts.admin')

@section('admin-content')

    {{-- Header --}}
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <div class="flex flex-wrap items-center gap-3">
            <p class="text-sm text-stone-500">{{ $counts['all'] }} order{{ $counts['all'] !== 1 ? 's' : '' }} total</p>
            @if (($counts['pending'] ?? 0) > 0)
                <span class="rounded-full bg-amber-100 px-2.5 py-0.5 text-xs font-semibold text-amber-700">{{ $counts['pending'] }} pending</span>
            @endif
        </div>
        <a
            href="{{ request()->fullUrlWithQuery(['export' => 'csv']) }}"
            class="inline-flex items-center gap-2 rounded-sm border border-[#d8c0ad] bg-white px-4 py-2.5 text-sm font-semibold text-stone-700 transition hover:bg-[#fff7f2]"
        >
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
            Export CSV
        </a>
    </div>

    @if (session('status'))
        <div class="mb-5 flex items-center gap-3 rounded-sm border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            <svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
            {{ session('status') }}
        </div>
    @endif

    {{-- Filters --}}
    <div class="mb-4 flex flex-wrap items-center gap-3">
        {{-- Status tabs --}}
        <div class="flex flex-wrap items-center gap-1 rounded-sm border border-[#d8c0ad] bg-white p-1">
            <a
                href="{{ route('admin.orders.index', array_merge(request()->query(), ['status' => 'all'])) }}"
                class="rounded px-3 py-1.5 text-xs font-semibold transition {{ $status === 'all' ? 'bg-[#b86033] text-white' : 'text-stone-500 hover:bg-[#fff0e6] hover:text-[#b86033]' }}"
            >All ({{ $counts['all'] }})</a>
            @foreach ($allStatuses as $s)
                <a
                    href="{{ route('admin.orders.index', array_merge(request()->query(), ['status' => $s])) }}"
                    class="rounded px-3 py-1.5 text-xs font-semibold transition {{ $status === $s ? 'bg-[#b86033] text-white' : 'text-stone-500 hover:bg-[#fff0e6] hover:text-[#b86033]' }}"
                >{{ \App\Models\Order::statusLabel($s) }} ({{ $counts[$s] ?? 0 }})</a>
            @endforeach
        </div>

        {{-- Search --}}
        <form method="GET" action="{{ route('admin.orders.index') }}" class="ml-auto flex items-center gap-2">
            <input type="hidden" name="status" value="{{ $status }}">
            <input
                type="search"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search by client name or email…"
                class="w-64 rounded-sm border border-[#d8c0ad] bg-white px-3 py-2 text-sm text-stone-700 placeholder-stone-400 focus:border-[#b86033] focus:outline-none focus:ring-1 focus:ring-[#b86033]"
            >
            <button type="submit" class="rounded-sm bg-[#b86033] px-3 py-2 text-sm font-semibold text-white hover:bg-[#cd6e3a]">Search</button>
            @if (request('search'))
                <a href="{{ route('admin.orders.index', ['status' => $status]) }}" class="text-xs font-semibold text-stone-400 hover:text-stone-600">Clear</a>
            @endif
        </form>
    </div>

    {{-- Table card --}}
    <div class="overflow-hidden rounded-sm border border-[#d8c0ad] bg-white shadow-[0_8px_24px_rgba(0,0,0,0.05)]">
        @if ($orders->isEmpty())
            <div class="flex flex-col items-center justify-center px-8 py-20 text-center">
                <div class="inline-flex h-14 w-14 items-center justify-center rounded-full bg-[#fff0e6] text-[#b86033]">
                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007Z"/></svg>
                </div>
                <p class="mt-4 font-display text-xl font-semibold text-stone-900">No orders found</p>
                <p class="mt-2 text-sm text-stone-500">Orders placed by clients will appear here.</p>
            </div>
        @else
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-[#ead7c9] bg-[#fff9f4]">
                        <th class="px-4 py-3.5 text-xs font-semibold uppercase tracking-[0.18em] text-stone-500">#</th>
                        <th class="px-4 py-3.5 text-xs font-semibold uppercase tracking-[0.18em] text-stone-500">Client</th>
                        <th class="hidden px-4 py-3.5 text-xs font-semibold uppercase tracking-[0.18em] text-stone-500 md:table-cell">Product</th>
                        <th class="hidden px-4 py-3.5 text-xs font-semibold uppercase tracking-[0.18em] text-stone-500 md:table-cell">Type</th>
                        <th class="hidden px-4 py-3.5 text-xs font-semibold uppercase tracking-[0.18em] text-stone-500 lg:table-cell">Qty</th>
                        <th class="hidden px-4 py-3.5 text-xs font-semibold uppercase tracking-[0.18em] text-stone-500 lg:table-cell">Total (UGX)</th>
                        <th class="px-4 py-3.5 text-xs font-semibold uppercase tracking-[0.18em] text-stone-500">Status</th>
                        <th class="hidden px-4 py-3.5 text-xs font-semibold uppercase tracking-[0.18em] text-stone-500 md:table-cell">Date</th>
                        <th class="px-4 py-3.5"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f0e8e1]">
                    @foreach ($orders as $order)
                        @php
                            $product = $order->resolved_product;
                            $badge = match ($order->order_status) {
                                'pending'       => 'border-amber-200 bg-amber-50 text-amber-700',
                                'confirmed'     => 'border-blue-200 bg-blue-50 text-blue-700',
                                'in_production' => 'border-indigo-200 bg-indigo-50 text-indigo-700',
                                'ready'         => 'border-teal-200 bg-teal-50 text-teal-700',
                                'delivered'     => 'border-emerald-200 bg-emerald-50 text-emerald-700',
                                default         => 'border-stone-200 bg-stone-50 text-stone-500',
                            };
                        @endphp
                        <tr class="transition hover:bg-[#fff7f2]">

                            {{-- Order ID --}}
                            <td class="px-4 py-3">
                                <span class="font-mono text-xs font-semibold text-stone-400">#{{ $order->id }}</span>
                            </td>

                            {{-- Client --}}
                            <td class="px-4 py-3">
                                <p class="font-semibold text-stone-900">{{ $order->user->name ?? '—' }}</p>
                                <p class="mt-0.5 text-xs text-stone-400">{{ $order->user->email ?? '' }}</p>
                            </td>

                            {{-- Product --}}
                            <td class="hidden px-4 py-3 md:table-cell">
                                <p class="text-stone-700">{{ $product->name ?? '—' }}</p>
                            </td>

                            {{-- Type --}}
                            <td class="hidden px-4 py-3 md:table-cell">
                                @if ($order->isDirectOrder())
                                    <span class="rounded-full bg-stone-100 px-2.5 py-0.5 text-xs font-semibold text-stone-500">Direct</span>
                                @else
                                    <span class="rounded-full bg-[#fff0e6] px-2.5 py-0.5 text-xs font-semibold text-[#b86033]">From Quote</span>
                                @endif
                            </td>

                            {{-- Quantity --}}
                            <td class="hidden px-4 py-3 lg:table-cell text-stone-700">
                                {{ $order->quantity ? number_format($order->quantity) : ($order->quotation?->bricks_required ? number_format($order->quotation->bricks_required) : '—') }}
                            </td>

                            {{-- Total --}}
                            <td class="hidden px-4 py-3 lg:table-cell">
                                <span class="font-semibold text-stone-900">{{ number_format($order->total_amount) }}</span>
                            </td>

                            {{-- Status --}}
                            <td class="px-4 py-3">
                                <span class="rounded-full border {{ $badge }} px-2.5 py-0.5 text-xs font-semibold">
                                    {{ \App\Models\Order::statusLabel($order->order_status) }}
                                </span>
                            </td>

                            {{-- Date --}}
                            <td class="hidden px-4 py-3 text-xs text-stone-400 md:table-cell">
                                {{ $order->created_at->format('d M Y') }}
                            </td>

                            {{-- Action --}}
                            <td class="px-4 py-3">
                                <a
                                    href="{{ route('admin.orders.show', $order) }}"
                                    class="inline-flex items-center gap-1.5 rounded-sm border border-[#d8c0ad] bg-white px-3 py-1.5 text-xs font-semibold text-stone-700 transition hover:border-[#b86033] hover:text-[#b86033]"
                                >View</a>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Pagination --}}
            @if ($orders->hasPages())
                <div class="border-t border-[#ead7c9] bg-[#fff9f4] px-4 py-3">
                    {{ $orders->links() }}
                </div>
            @endif
        @endif
    </div>

@endsection
