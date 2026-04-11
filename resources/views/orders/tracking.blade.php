<x-portal-layout>
    <x-slot name="header">
        <div>
            <p class="text-[10px] font-semibold uppercase tracking-[0.2em] text-stone-400">Orders</p>
            <h1 class="mt-0.5 text-[15px] font-semibold text-stone-800">Tracking — Order #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</h1>
        </div>
    </x-slot>

    <div class="space-y-6 px-4 py-6 sm:px-6 max-w-2xl mx-auto">

        @php $product = $order->resolvedProduct; @endphp

        {{-- Product / amount summary --}}
        <div class="border border-stone-200 bg-white shadow-sm rounded-md px-6 py-5 flex items-center justify-between">
            <div>
                <p class="text-[10px] font-semibold uppercase tracking-wide text-stone-400">Product</p>
                <p class="mt-0.5 text-sm font-semibold text-stone-900">{{ $product->name ?? '—' }}</p>
                @if ($order->isDirectOrder())
                    <p class="text-xs text-stone-400 mt-0.5">{{ number_format($order->quantity) }} units &bull; Direct Order</p>
                @else
                    <p class="text-xs text-stone-400 mt-0.5">{{ number_format($order->quotation->square_metres, 1) }} m² &bull; Quoted Order</p>
                @endif
            </div>
            <div class="text-right">
                <p class="text-[10px] font-semibold uppercase tracking-wide text-stone-400">Total</p>
                <p class="mt-0.5 text-sm font-bold text-[#6e2f0e]">UGX {{ number_format($order->total_amount, 2) }}</p>
            </div>
        </div>

        {{-- Progress timeline --}}
        <div class="border border-stone-200 bg-white shadow-sm rounded-md overflow-hidden">
            <div class="bg-[#6e2f0e] px-6 py-4">
                <h3 class="text-sm font-bold text-white">Order Status Timeline</h3>
            </div>

            <div class="px-6 py-8">
                    @php
                        $statusIndex = array_search($order->order_status, $statuses);
                    @endphp

                    <ol class="relative">
                        @foreach ($statuses as $i => $status)
                            @php
                                $isCompleted = $i < $statusIndex;
                                $isCurrent   = $i === $statusIndex;
                                $isPending   = $i > $statusIndex;
                                $isLast      = $i === count($statuses) - 1;
                            @endphp
                            <li class="relative flex items-start gap-5 {{ ! $isLast ? 'pb-8' : '' }}">
                                {{-- Vertical connector line --}}
                                @if (! $isLast)
                                    <div class="absolute left-[19px] top-8 w-px {{ $isCompleted ? 'bg-[#6e2f0e]' : 'bg-stone-200' }}" style="height: calc(100% - 8px)"></div>
                                @endif

                                {{-- Step indicator --}}
                                <div class="relative z-10 flex h-10 w-10 shrink-0 items-center justify-center rounded-full border-2
                                    {{ $isCompleted ? 'border-[#6e2f0e] bg-[#6e2f0e]' :
                                       ($isCurrent  ? 'border-[#6e2f0e] bg-white' : 'border-stone-200 bg-white') }}">
                                    @if ($isCompleted)
                                        <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                        </svg>
                                    @elseif ($isCurrent)
                                        <div class="h-3 w-3 rounded-full bg-[#b86033]"></div>
                                    @else
                                        <div class="h-2.5 w-2.5 rounded-full bg-stone-300"></div>
                                    @endif
                                </div>

                                {{-- Step label --}}
                                <div class="pt-1.5 min-w-0 flex-1">
                                    <p class="text-sm font-semibold
                                        {{ $isCompleted ? 'text-[#6e2f0e]' :
                                           ($isCurrent  ? 'text-stone-900' : 'text-stone-400') }}">
                                        {{ \App\Models\Order::statusLabel($status) }}
                                        @if ($isCurrent)
                                            <span class="ml-2 inline-flex rounded-sm bg-[#6e2f0e] px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider text-white">Current</span>
                                        @endif
                                    </p>

                                    {{-- Show tracking events for this status --}}
                                    @php
                                        $events = $order->tracking->where('status', $status)->sortByDesc('created_at');
                                    @endphp
                                    @foreach ($events as $event)
                                        <p class="mt-0.5 text-xs text-gray-500">
                                            @if ($event->message) {{ $event->message }} &mdash; @endif
                                            {{ $event->created_at->format('d M Y, H:i') }}
                                        </p>
                                    @endforeach
                                </div>
                            </li>
                        @endforeach
                    </ol>
            </div>
        </div>

        {{-- Full event log --}}
        @if ($order->tracking->isNotEmpty())
            <div class="border border-stone-200 bg-white shadow-sm rounded-md overflow-hidden">
                <div class="flex items-center justify-between px-6 py-4 border-b border-stone-100">
                    <h3 class="text-[13px] font-semibold text-stone-800">Full History</h3>
                    <span class="text-xs text-stone-400">{{ $order->tracking->count() }} event(s)</span>
                </div>
                <ul class="divide-y divide-stone-50">
                    @foreach ($order->tracking as $event)
                        <li class="px-6 py-4 flex items-start gap-3">
                            <div class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-[#6e2f0e]/10">
                                <div class="h-2 w-2 rounded-full bg-[#6e2f0e]"></div>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-stone-900">{{ \App\Models\Order::statusLabel($event->status) }}</p>
                                @if ($event->message)
                                    <p class="text-sm text-stone-600">{{ $event->message }}</p>
                                @endif
                                <p class="mt-0.5 text-xs text-stone-400">{{ $event->created_at->format('d M Y, H:i:s') }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

    </div>
</x-portal-layout>
