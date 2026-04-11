@extends('layouts.admin')

@section('admin-content')
    {{-- Back link --}}
    <div class="mb-6">
        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-stone-500 hover:text-[#b86033]">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/></svg>
            Back to Clients
        </a>
    </div>

    @if (session('status'))
        <div class="mb-5 flex items-center gap-3 rounded-sm border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            <svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
            {{ session('status') }}
        </div>
    @endif

    <div class="space-y-6">
        {{-- Profile card --}}
        <div class="rounded-sm border border-[#d8c0ad] bg-white p-6 shadow-[0_8px_24px_rgba(0,0,0,0.05)]">
            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-[#a25f38]">Client Profile</p>
            <dl class="mt-5 grid gap-4 text-sm sm:grid-cols-2 xl:grid-cols-4">
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-[0.18em] text-stone-400">Name</dt>
                    <dd class="mt-1 font-medium text-stone-900">{{ $user->name }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-[0.18em] text-stone-400">Email</dt>
                    <dd class="mt-1"><a href="mailto:{{ $user->email }}" class="text-[#b86033] hover:underline">{{ $user->email }}</a></dd>
                </div>
                @if ($user->phone)
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-[0.18em] text-stone-400">Phone</dt>
                        <dd class="mt-1 text-stone-700">{{ $user->phone }}</dd>
                    </div>
                @endif
                @if ($user->organisation)
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-[0.18em] text-stone-400">Organisation</dt>
                        <dd class="mt-1 text-stone-700">{{ $user->organisation }}</dd>
                    </div>
                @endif
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-[0.18em] text-stone-400">Registered</dt>
                    <dd class="mt-1 text-stone-700">{{ $user->created_at->format('d M Y') }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-[0.18em] text-stone-400">Email verified</dt>
                    <dd class="mt-1 text-stone-700">
                        @if ($user->email_verified_at)
                            <span class="inline-flex items-center gap-1 text-emerald-600">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                                {{ $user->email_verified_at->format('d M Y') }}
                            </span>
                        @else
                            <span class="text-amber-600">Not verified</span>
                        @endif
                    </dd>
                </div>
            </dl>
        </div>

        {{-- Quotations --}}
        <div class="rounded-sm border border-[#d8c0ad] bg-white shadow-[0_8px_24px_rgba(0,0,0,0.05)]">
            <div class="border-b border-[#ead7c9] px-6 py-4">
                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-[#a25f38]">Quotation History</p>
            </div>
            @if ($user->quotations->isEmpty())
                <p class="px-6 py-8 text-center text-sm text-stone-400">No quotations yet.</p>
            @else
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b border-[#ead7c9] bg-[#fff9f4]">
                            <th class="px-5 py-3.5 text-xs font-semibold uppercase tracking-[0.18em] text-stone-500">Product</th>
                            <th class="px-5 py-3.5 text-xs font-semibold uppercase tracking-[0.18em] text-stone-500">Sq m</th>
                            <th class="px-5 py-3.5 text-xs font-semibold uppercase tracking-[0.18em] text-stone-500">Bricks</th>
                            <th class="px-5 py-3.5 text-xs font-semibold uppercase tracking-[0.18em] text-stone-500">Total</th>
                            <th class="px-5 py-3.5 text-xs font-semibold uppercase tracking-[0.18em] text-stone-500">Status</th>
                            <th class="hidden px-5 py-3.5 text-xs font-semibold uppercase tracking-[0.18em] text-stone-500 lg:table-cell">Date</th>
                            <th class="px-5 py-3.5"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#f0e8e1]">
                        @foreach ($user->quotations as $quotation)
                            <tr class="transition hover:bg-[#fff7f2]">
                                <td class="px-5 py-4 font-medium text-stone-900">
                                    <a href="{{ route('admin.quotations.show', $quotation) }}" class="hover:text-[#b86033] hover:underline">
                                        {{ $quotation->product?->name ?? '—' }}
                                    </a>
                                </td>
                                <td class="px-5 py-4 text-stone-600">{{ number_format($quotation->square_metres, 2) }}</td>
                                <td class="px-5 py-4 text-stone-600">{{ number_format($quotation->bricks_required) }}</td>
                                <td class="px-5 py-4 text-stone-600">UGX {{ number_format($quotation->total_price) }}</td>
                                <td class="px-5 py-4">
                                    @php
                                        $statusColour = match($quotation->status) {
                                            'pending'  => 'border-amber-200 bg-amber-50 text-amber-700',
                                            'approved' => 'border-emerald-200 bg-emerald-50 text-emerald-700',
                                            'rejected' => 'border-red-200 bg-red-50 text-red-700',
                                            default    => 'border-stone-200 bg-stone-50 text-stone-500',
                                        };
                                    @endphp
                                    <span class="rounded-full border {{ $statusColour }} px-2.5 py-0.5 text-xs font-semibold capitalize">
                                        {{ $quotation->status }}
                                    </span>
                                </td>
                                <td class="hidden px-5 py-4 text-stone-500 lg:table-cell">{{ $quotation->created_at->format('d M Y') }}</td>
                                <td class="px-5 py-4 text-right">
                                    <a href="{{ route('admin.quotations.show', $quotation) }}" class="text-xs font-semibold text-[#b86033] hover:underline">View →</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        {{-- Orders --}}
        <div class="rounded-sm border border-[#d8c0ad] bg-white shadow-[0_8px_24px_rgba(0,0,0,0.05)]">
            <div class="border-b border-[#ead7c9] px-6 py-4">
                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-[#a25f38]">Order History</p>
            </div>
            @if ($user->orders->isEmpty())
                <p class="px-6 py-8 text-center text-sm text-stone-400">No orders yet.</p>
            @else
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b border-[#ead7c9] bg-[#fff9f4]">
                            <th class="px-5 py-3.5 text-xs font-semibold uppercase tracking-[0.18em] text-stone-500">Product</th>
                            <th class="px-5 py-3.5 text-xs font-semibold uppercase tracking-[0.18em] text-stone-500">Type</th>
                            <th class="px-5 py-3.5 text-xs font-semibold uppercase tracking-[0.18em] text-stone-500">Qty</th>
                            <th class="px-5 py-3.5 text-xs font-semibold uppercase tracking-[0.18em] text-stone-500">Total</th>
                            <th class="px-5 py-3.5 text-xs font-semibold uppercase tracking-[0.18em] text-stone-500">Status</th>
                            <th class="hidden px-5 py-3.5 text-xs font-semibold uppercase tracking-[0.18em] text-stone-500 lg:table-cell">Date</th>
                        <th class="px-5 py-3.5"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#f0e8e1]">
                        @foreach ($user->orders as $order)
                            <tr class="transition hover:bg-[#fff7f2]">
                                <td class="px-5 py-4 font-medium text-stone-900">{{ $order->resolved_product?->name ?? '—' }}</td>
                                <td class="px-5 py-4 text-stone-500">
                                    {{ $order->isDirectOrder() ? 'Direct' : 'From Quote' }}
                                </td>
                                <td class="px-5 py-4 text-stone-600">{{ number_format($order->quantity) }}</td>
                                <td class="px-5 py-4 text-stone-600">UGX {{ number_format($order->total_amount) }}</td>
                                <td class="px-5 py-4">
                                    @php
                                        $orderColour = match($order->order_status) {
                                            'pending'       => 'border-amber-200 bg-amber-50 text-amber-700',
                                            'confirmed'     => 'border-blue-200 bg-blue-50 text-blue-700',
                                            'in_production' => 'border-indigo-200 bg-indigo-50 text-indigo-700',
                                            'ready'         => 'border-teal-200 bg-teal-50 text-teal-700',
                                            'delivered'     => 'border-emerald-200 bg-emerald-50 text-emerald-700',
                                            default         => 'border-stone-200 bg-stone-50 text-stone-500',
                                        };
                                    @endphp
                                    <span class="rounded-full border {{ $orderColour }} px-2.5 py-0.5 text-xs font-semibold">
                                        {{ \App\Models\Order::statusLabel($order->order_status) }}
                                    </span>
                                </td>
                                <td class="hidden px-5 py-4 text-stone-500 lg:table-cell">{{ $order->created_at->format('d M Y') }}</td>
                                <td class="px-5 py-4 text-right">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="text-xs font-semibold text-[#b86033] hover:underline">View →</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection
