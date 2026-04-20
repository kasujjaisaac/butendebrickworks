<x-portal-layout>
    <x-slot name="header">
        <div>
            <p class="text-[10px] font-semibold uppercase tracking-[0.2em] text-stone-400">Orders</p>
            <h1 class="mt-0.5 text-[15px] font-semibold text-stone-800">Order #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</h1>
        </div>
    </x-slot>

    <div class="space-y-6 px-4 py-6 sm:px-6 max-w-3xl mx-auto">

        @if (session('success'))
            <div class="flex items-center gap-3 border border-emerald-200 bg-emerald-50 px-4 py-3 rounded-md">
                <svg class="h-5 w-5 shrink-0 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
                <p class="text-sm font-medium text-emerald-800">{{ session('success') }}</p>
            </div>
        @endif

        @php
            $product = $order->resolvedProduct;
            $statusBadge = match($order->order_status) {
                'pending'       => 'bg-amber-100 text-amber-700',
                'confirmed'     => 'bg-blue-100 text-blue-700',
                'in_production' => 'bg-violet-100 text-violet-700',
                'ready'         => 'bg-teal-100 text-teal-700',
                'delivered'     => 'bg-emerald-100 text-emerald-700',
                default         => 'bg-stone-100 text-stone-500',
            };
        @endphp

        {{-- Order summary card --}}
        <div class="border border-stone-200 bg-white shadow-sm overflow-hidden rounded-md">

            {{-- Header --}}
            <div class="bg-[#6e2f0e] px-6 py-5 flex items-center justify-between">
                <div>
                    <p class="text-[10px] font-semibold uppercase tracking-widest text-white/50">Order Number</p>
                    <p class="text-xl font-bold text-white">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>
                </div>
                <div class="flex items-center gap-3">
                    <span class="inline-flex rounded-sm px-2.5 py-1 text-[10px] font-bold {{ $order->isDirectOrder() ? 'bg-white/20 text-white' : 'bg-white/10 text-white/80' }}">
                        {{ $order->isDirectOrder() ? 'Direct Order' : 'Quoted Order' }}
                    </span>
                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold {{ $statusBadge }}">
                        {{ $order->status_label }}
                    </span>
                </div>
            </div>

            {{-- Details --}}
            <div class="px-6 py-5">
                <p class="text-[10px] font-semibold uppercase tracking-widest text-stone-400 mb-4">Order Details</p>
                <dl class="divide-y divide-stone-100">
                    <div class="flex items-center justify-between py-3">
                        <dt class="text-sm text-stone-500">Product</dt>
                        <dd class="text-sm font-semibold text-stone-900">{{ $product->name ?? '—' }}</dd>
                    </div>

                    @if ($order->isDirectOrder())
                        <div class="flex items-center justify-between py-3">
                            <dt class="text-sm text-stone-500">Quantity</dt>
                            <dd class="text-sm font-semibold text-stone-900">{{ number_format($order->quantity) }} units</dd>
                        </div>
                        @if ($order->delivery_address)
                            <div class="flex items-start justify-between py-3">
                                <dt class="text-sm text-stone-500">Delivery Address</dt>
                                <dd class="text-sm font-semibold text-stone-900 text-right max-w-xs">{{ $order->delivery_address }}</dd>
                            </div>
                        @endif
                        @if ($order->notes)
                            <div class="flex items-start justify-between py-3">
                                <dt class="text-sm text-stone-500">Notes</dt>
                                <dd class="text-sm text-stone-700 text-right max-w-xs">{{ $order->notes }}</dd>
                            </div>
                        @endif
                    @else
                        <div class="flex items-center justify-between py-3">
                            <dt class="text-sm text-stone-500">Area</dt>
                            <dd class="text-sm font-semibold text-stone-900">{{ number_format($order->quotation->square_metres, 2) }} m²</dd>
                        </div>
                        <div class="flex items-center justify-between py-3">
                            <dt class="text-sm text-stone-500">Units Required</dt>
                            <dd class="text-sm font-semibold text-stone-900">{{ number_format($order->quotation->bricks_required) }}</dd>
                        </div>
                    @endif

                    <div class="flex items-center justify-between py-3">
                        <dt class="text-sm text-stone-500">Date Placed</dt>
                        <dd class="text-sm font-semibold text-stone-900">{{ $order->created_at->format('d F Y, H:i') }}</dd>
                    </div>
                </dl>

                <div class="mt-4 bg-[#f9ede6] border border-[#e8c9b4] px-5 py-4 flex items-center justify-between rounded-sm">
                    <span class="text-sm font-bold text-[#6e2f0e]">Quantity Required</span>
                    <span class="text-xl font-extrabold text-[#6e2f0e]">
                        {{ $order->isDirectOrder() ? number_format($order->quantity) : number_format($order->quotation->bricks_required) }} units
                    </span>
                </div>
            </div>

            {{-- Footer actions --}}
            <div class="border-t border-stone-100 bg-stone-50 px-6 py-3.5 flex items-center justify-between">
                @if (!$order->isDirectOrder() && $order->quotation)
                    <a href="{{ route('quotation.show', $order->quotation) }}" class="text-sm text-[#b86033] hover:underline">
                        View Original Quotation
                    </a>
                @else
                    <span class="text-xs text-stone-400">Direct order — no quotation</span>
                @endif
                <a href="{{ route('orders.tracking', $order) }}" class="inline-flex items-center gap-1.5 border border-[#6e2f0e] px-4 py-2 text-sm font-semibold text-[#6e2f0e] transition hover:bg-[#6e2f0e] hover:text-white rounded-sm">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/>
                    </svg>
                    Track Order
                </a>
            </div>
        </div>

        {{-- Recent tracking events --}}
            @if ($order->tracking->isNotEmpty())
                <div class="border border-stone-200 bg-white shadow-sm overflow-hidden rounded-md">
                    <div class="px-6 py-4 border-b border-stone-100">
                        <h3 class="text-[13px] font-semibold text-stone-800">Recent Activity</h3>
                    </div>
                    <ul class="divide-y divide-stone-50 px-6">
                        @foreach ($order->tracking->take(3) as $event)
                            <li class="py-4 flex items-start gap-3">
                                <div class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-[#6e2f0e]/10">
                                    <div class="h-2 w-2 rounded-full bg-[#6e2f0e]"></div>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-stone-900">{{ \App\Models\Order::statusLabel($event->status) }}</p>
                                    @if ($event->message)
                                        <p class="text-sm text-stone-600">{{ $event->message }}</p>
                                    @endif
                                    <p class="mt-0.5 text-xs text-stone-400">{{ $event->created_at->diffForHumans() }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <div class="border-t border-stone-100 bg-stone-50 px-6 py-3">
                        <a href="{{ route('orders.tracking', $order) }}" class="text-sm text-[#b86033] hover:underline">
                            View full timeline &rarr;
                        </a>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-portal-layout>
