@extends('layouts.admin')

@section('admin-content')

    {{-- Back link --}}
    <div class="mb-6">
        <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-stone-500 hover:text-[#b86033]">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/></svg>
            Back to Orders
        </a>
    </div>

    @if (session('status'))
        <div class="mb-5 flex items-center gap-3 rounded-sm border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            <svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-5 rounded-sm border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            <ul class="list-inside list-disc space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

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

    <div class="grid gap-6 lg:grid-cols-3">

        {{-- LEFT — Order details (2/3) --}}
        <div class="space-y-5 lg:col-span-2">

            {{-- Order header card --}}
            <div class="overflow-hidden rounded-sm border border-[#d8c0ad] bg-white shadow-[0_8px_24px_rgba(0,0,0,0.05)]">
                <div class="flex items-center justify-between border-b border-[#ead7c9] bg-[#fff9f4] px-5 py-4">
                    <div>
                        <h2 class="font-display text-xl font-bold text-stone-900">Order #{{ $order->id }}</h2>
                        <p class="mt-0.5 text-xs text-stone-400">Placed {{ $order->created_at->format('d M Y \a\t H:i') }}</p>
                    </div>
                    <div class="flex items-center gap-3">
                        @if ($order->isDirectOrder())
                            <span class="rounded-full bg-stone-100 px-2.5 py-0.5 text-xs font-semibold text-stone-500">Direct Order</span>
                        @else
                            <span class="rounded-full bg-[#fff0e6] px-2.5 py-0.5 text-xs font-semibold text-[#b86033]">From Quote</span>
                        @endif
                        <span class="rounded-full border {{ $badge }} px-3 py-1 text-sm font-semibold">
                            {{ \App\Models\Order::statusLabel($order->order_status) }}
                        </span>
                    </div>
                </div>

                {{-- Totals row --}}
                <div class="grid grid-cols-2 divide-x divide-[#f0e8e1] sm:grid-cols-3">
                    <div class="px-5 py-4">
                        <p class="text-[10px] font-semibold uppercase tracking-widest text-stone-400">Quantity</p>
                        <p class="mt-1 text-2xl font-bold text-stone-900">
                            {{ $order->quantity
                                ? number_format($order->quantity)
                                : ($order->quotation?->bricks_required ? number_format($order->quotation->bricks_required) : '—') }}
                        </p>
                        <p class="text-xs text-stone-400">bricks</p>
                    </div>
                    <div class="px-5 py-4">
                        <p class="text-[10px] font-semibold uppercase tracking-widest text-stone-400">Total Amount</p>
                        <p class="mt-1 text-2xl font-bold text-stone-900">{{ number_format($order->total_amount) }}</p>
                        <p class="text-xs text-stone-400">UGX</p>
                    </div>
                    <div class="col-span-2 px-5 py-4 sm:col-span-1 bg-[#fff0e6]">
                        <p class="text-[10px] font-semibold uppercase tracking-widest text-[#b86033]">Last Updated</p>
                        <p class="mt-1 text-sm font-bold text-[#6e2f0e]">{{ $order->updated_at->format('d M Y') }}</p>
                        <p class="text-xs text-[#b86033]">{{ $order->updated_at->format('H:i') }}</p>
                    </div>
                </div>

                {{-- Delivery & notes --}}
                @if ($order->delivery_address || $order->notes)
                    <div class="border-t border-[#f0e8e1] divide-y divide-[#f0e8e1]">
                        @if ($order->delivery_address)
                            <div class="px-5 py-4">
                                <p class="text-[10px] font-semibold uppercase tracking-widest text-stone-400 mb-1">Delivery Address</p>
                                <p class="text-sm text-stone-700">{{ $order->delivery_address }}</p>
                            </div>
                        @endif
                        @if ($order->notes)
                            <div class="px-5 py-4">
                                <p class="text-[10px] font-semibold uppercase tracking-widest text-stone-400 mb-1">Client Notes</p>
                                <p class="text-sm text-stone-700">{{ $order->notes }}</p>
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            {{-- Product card --}}
            <div class="overflow-hidden rounded-sm border border-[#d8c0ad] bg-white shadow-[0_8px_24px_rgba(0,0,0,0.05)]">
                <div class="border-b border-[#ead7c9] bg-[#fff9f4] px-5 py-3">
                    <h3 class="text-xs font-semibold uppercase tracking-[0.18em] text-stone-500">Product</h3>
                </div>
                <div class="px-5 py-4">
                    @if ($product)
                        <div class="flex items-center gap-4">
                            @if ($product->image)
                                <img src="{{ Storage::disk('public')->url($product->image) }}" alt="{{ $product->name }}" class="h-16 w-16 rounded-sm object-cover border border-[#d8c0ad]">
                            @else
                                <div class="flex h-16 w-16 items-center justify-center rounded-sm bg-[#fff0e6] text-[#b86033]">
                                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.429 9.75 2.25 12l4.179 2.25m0-4.5 5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L21.75 12l-4.179 2.25m0 0 4.179 2.25L12 21.75 2.25 16.5l4.179-2.25m11.142 0-5.571 3-5.571-3"/></svg>
                                </div>
                            @endif
                            <div>
                                <p class="font-semibold text-stone-900">{{ $product->name }}</p>
                                @if ($product->sku)
                                    <p class="mt-0.5 text-xs text-stone-400">SKU: {{ $product->sku }}</p>
                                @endif
                                @if ($product->price_per_brick)
                                    <p class="mt-0.5 text-xs text-stone-500">UGX {{ number_format($product->price_per_brick) }} / brick</p>
                                @endif
                            </div>
                        </div>
                        @if (!$order->isDirectOrder() && $order->quotation)
                            <div class="mt-3 flex items-center gap-2 rounded-sm border border-[#ead7c9] bg-[#fff9f4] px-3 py-2">
                                <svg class="h-4 w-4 text-stone-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/></svg>
                                <p class="text-xs text-stone-600">Originated from
                                    <a href="{{ route('admin.quotations.show', $order->quotation) }}" class="font-semibold text-[#b86033] hover:underline">Quotation #{{ $order->quotation->id }}</a>
                                </p>
                            </div>
                        @endif
                    @else
                        <p class="text-sm italic text-stone-400">Product no longer available.</p>
                    @endif
                </div>
            </div>

            {{-- Tracking timeline --}}
            <div class="overflow-hidden rounded-sm border border-[#d8c0ad] bg-white shadow-[0_8px_24px_rgba(0,0,0,0.05)]">
                <div class="border-b border-[#ead7c9] bg-[#fff9f4] px-5 py-3">
                    <h3 class="text-xs font-semibold uppercase tracking-[0.18em] text-stone-500">Order Timeline</h3>
                </div>
                @if ($order->tracking->isEmpty())
                    <p class="px-5 py-8 text-center text-sm italic text-stone-400">No tracking events recorded yet.</p>
                @else
                    <div class="divide-y divide-[#f0e8e1]">
                        @foreach ($order->tracking as $event)
                            @php
                                $trackBadge = match ($event->status) {
                                    'pending'       => 'bg-amber-100 text-amber-700',
                                    'confirmed'     => 'bg-blue-100 text-blue-700',
                                    'in_production' => 'bg-indigo-100 text-indigo-700',
                                    'ready'         => 'bg-teal-100 text-teal-700',
                                    'delivered'     => 'bg-emerald-100 text-emerald-700',
                                    default         => 'bg-stone-100 text-stone-500',
                                };
                            @endphp
                            <div class="flex items-start gap-4 px-5 py-4">
                                <div class="mt-0.5 flex h-7 w-7 shrink-0 items-center justify-center rounded-full {{ $trackBadge }}">
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="flex flex-wrap items-center justify-between gap-2">
                                        <p class="font-semibold text-stone-900">{{ \App\Models\Order::statusLabel($event->status) }}</p>
                                        <time class="text-xs text-stone-400">{{ $event->created_at->format('d M Y, H:i') }}</time>
                                    </div>
                                    @if ($event->message)
                                        <p class="mt-0.5 text-sm text-stone-600">{{ $event->message }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>

        {{-- RIGHT — Client + actions (1/3) --}}
        <div class="space-y-5">

            {{-- Client --}}
            <div class="overflow-hidden rounded-sm border border-[#d8c0ad] bg-white shadow-[0_8px_24px_rgba(0,0,0,0.05)]">
                <div class="border-b border-[#ead7c9] bg-[#fff9f4] px-5 py-3">
                    <h3 class="text-xs font-semibold uppercase tracking-[0.18em] text-stone-500">Client</h3>
                </div>
                <div class="px-5 py-4 space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#fff0e6] text-sm font-bold text-[#b86033]">
                            {{ strtoupper(substr($order->user->name ?? 'U', 0, 1)) }}
                        </div>
                        <div class="min-w-0">
                            <p class="font-semibold text-stone-900">{{ $order->user->name ?? 'Unknown' }}</p>
                            <a href="mailto:{{ $order->user->email ?? '' }}" class="truncate text-xs text-[#b86033] hover:underline">{{ $order->user->email ?? '' }}</a>
                        </div>
                    </div>
                    @if ($order->user?->phone)
                        <p class="flex items-center gap-2 text-xs text-stone-500">
                            <svg class="h-3.5 w-3.5 text-stone-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z"/></svg>
                            {{ $order->user->phone }}
                        </p>
                    @endif
                    @if ($order->user?->organisation)
                        <p class="flex items-center gap-2 text-xs text-stone-500">
                            <svg class="h-3.5 w-3.5 text-stone-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/></svg>
                            {{ $order->user->organisation }}
                        </p>
                    @endif
                    @if ($order->user)
                        <a
                            href="{{ route('admin.users.show', $order->user) }}"
                            class="block w-full rounded-sm border border-[#d8c0ad] py-2 text-center text-xs font-semibold text-stone-600 transition hover:border-[#b86033] hover:text-[#b86033]"
                        >
                            View Client Profile
                        </a>
                    @endif
                </div>
            </div>

            {{-- Update Status --}}
            <div class="overflow-hidden rounded-sm border border-[#d8c0ad] bg-white shadow-[0_8px_24px_rgba(0,0,0,0.05)]">
                <div class="border-b border-[#ead7c9] bg-[#fff9f4] px-5 py-3">
                    <h3 class="text-xs font-semibold uppercase tracking-[0.18em] text-stone-500">Update Status</h3>
                </div>
                <form method="POST" action="{{ route('admin.orders.update-status', $order) }}" class="px-5 py-4 space-y-3">
                    @csrf
                    <div>
                        <label for="order_status" class="mb-1 block text-xs font-semibold text-stone-600">New Status</label>
                        <select
                            name="order_status"
                            id="order_status"
                            class="w-full rounded-sm border border-[#d8c0ad] bg-white px-3 py-2 text-sm text-stone-700 focus:border-[#b86033] focus:outline-none focus:ring-1 focus:ring-[#b86033]"
                        >
                            @foreach ($allStatuses as $s)
                                <option value="{{ $s }}" {{ $order->order_status === $s ? 'selected' : '' }}>
                                    {{ \App\Models\Order::statusLabel($s) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="note" class="mb-1 block text-xs font-semibold text-stone-600">Note <span class="text-stone-400 font-normal">(optional)</span></label>
                        <textarea
                            name="note"
                            id="note"
                            rows="3"
                            placeholder="Add a message explaining the status change…"
                            class="w-full resize-none rounded-sm border border-[#d8c0ad] px-3 py-2 text-sm text-stone-700 placeholder-stone-400 focus:border-[#b86033] focus:outline-none focus:ring-1 focus:ring-[#b86033]"
                        ></textarea>
                    </div>
                    <button
                        type="submit"
                        class="w-full rounded-sm bg-[#b86033] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#cd6e3a]"
                    >
                        Update Status
                    </button>
                </form>
            </div>

            {{-- Status pipeline --}}
            <div class="overflow-hidden rounded-sm border border-[#d8c0ad] bg-white shadow-[0_8px_24px_rgba(0,0,0,0.05)]">
                <div class="border-b border-[#ead7c9] bg-[#fff9f4] px-5 py-3">
                    <h3 class="text-xs font-semibold uppercase tracking-[0.18em] text-stone-500">Progress</h3>
                </div>
                <div class="divide-y divide-[#f0e8e1]">
                    @foreach ($allStatuses as $s)
                        @php
                            $statusOrder = array_flip($allStatuses);
                            $isDone    = $statusOrder[$s] < $statusOrder[$order->order_status];
                            $isCurrent = $order->order_status === $s;
                        @endphp
                        <div class="flex items-center gap-3 px-5 py-3">
                            <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full
                                {{ $isCurrent ? 'bg-[#b86033] text-white' : ($isDone ? 'bg-emerald-100 text-emerald-600' : 'bg-stone-100 text-stone-300') }}">
                                @if ($isDone)
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                                @elseif ($isCurrent)
                                    <svg class="h-3 w-3" viewBox="0 0 8 8" fill="currentColor"><circle cx="4" cy="4" r="3"/></svg>
                                @else
                                    <svg class="h-3 w-3" viewBox="0 0 8 8" fill="currentColor"><circle cx="4" cy="4" r="2"/></svg>
                                @endif
                            </div>
                            <span class="text-xs font-semibold {{ $isCurrent ? 'text-[#b86033]' : ($isDone ? 'text-emerald-600' : 'text-stone-400') }}">
                                {{ \App\Models\Order::statusLabel($s) }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

@endsection
