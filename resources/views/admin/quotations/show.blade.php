@extends('layouts.admin')

@section('admin-content')

    {{-- Back link --}}
    <div class="mb-6">
        <a href="{{ route('admin.quotations.index') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-stone-500 hover:text-[#b86033]">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/></svg>
            Back to Quotations
        </a>
    </div>

    @if (session('status'))
        <div class="mb-5 flex items-center gap-3 rounded-sm border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            <svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
            {{ session('status') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-5 flex items-center gap-3 rounded-sm border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            <svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/></svg>
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-5 rounded-sm border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            <p class="font-semibold mb-1">Please correct the following:</p>
            <ul class="list-disc list-inside space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid gap-6 lg:grid-cols-3">

        {{-- LEFT — Quotation details (2/3 width) --}}
        <div class="space-y-5 lg:col-span-2">

            {{-- Header card --}}
            <div class="overflow-hidden rounded-sm border border-[#d8c0ad] bg-white shadow-[0_8px_24px_rgba(0,0,0,0.05)]">
                <div class="flex items-center justify-between border-b border-[#ead7c9] bg-[#fff9f4] px-5 py-4">
                    <div>
                        <h2 class="font-display text-xl font-bold text-stone-900">Quotation #{{ $quotation->id }}</h2>
                        <p class="mt-0.5 text-xs text-stone-400">Submitted {{ $quotation->created_at->format('d M Y \a\t H:i') }}</p>
                    </div>
                    @php
                        $badge = match ($quotation->status) {
                            'approved' => 'border-emerald-200 bg-emerald-50 text-emerald-700',
                            'rejected' => 'border-red-200 bg-red-50 text-red-600',
                            default    => 'border-amber-200 bg-amber-50 text-amber-700',
                        };
                    @endphp
                    <span class="rounded-full border {{ $badge }} px-3 py-1 text-sm font-semibold capitalize">
                        {{ $quotation->status }}
                    </span>
                </div>

                {{-- Calculation summary --}}
                <div class="grid grid-cols-2 divide-x divide-[#f0e8e1] sm:grid-cols-4">
                    <div class="px-5 py-4">
                        <p class="text-[10px] font-semibold uppercase tracking-widest text-stone-400">Area</p>
                        <p class="mt-1 text-2xl font-bold text-stone-900">{{ number_format($quotation->square_metres, 1) }}</p>
                        <p class="text-xs text-stone-400">m²</p>
                    </div>
                    <div class="px-5 py-4">
                        <p class="text-[10px] font-semibold uppercase tracking-widest text-stone-400">Bricks Req.</p>
                        <p class="mt-1 text-2xl font-bold text-stone-900">{{ number_format($quotation->bricks_required) }}</p>
                        <p class="text-xs text-stone-400">units</p>
                    </div>
                    <div class="px-5 py-4">
                        <p class="text-[10px] font-semibold uppercase tracking-widest text-stone-400">Price / Brick</p>
                        <p class="mt-1 text-2xl font-bold text-stone-900">{{ number_format($quotation->price_per_brick) }}</p>
                        <p class="text-xs text-stone-400">UGX</p>
                    </div>
                    <div class="px-5 py-4 bg-[#fff0e6]">
                        <p class="text-[10px] font-semibold uppercase tracking-widest text-[#b86033]">Total</p>
                        <p class="mt-1 text-2xl font-bold text-[#6e2f0e]">{{ number_format($quotation->total_price) }}</p>
                        <p class="text-xs text-[#b86033]">UGX</p>
                    </div>
                </div>
            </div>

            {{-- Product --}}
            <div class="overflow-hidden rounded-sm border border-[#d8c0ad] bg-white shadow-[0_8px_24px_rgba(0,0,0,0.05)]">
                <div class="border-b border-[#ead7c9] bg-[#fff9f4] px-5 py-3">
                    <h3 class="text-xs font-semibold uppercase tracking-[0.18em] text-stone-500">Selected Product</h3>
                </div>
                <div class="px-5 py-4">
                    @if ($quotation->product)
                        <div class="flex items-center gap-4">
                            @if ($quotation->product->image)
                                <img src="{{ Storage::disk('public')->url($quotation->product->image) }}" alt="{{ $quotation->product->name }}" class="h-16 w-16 rounded-sm object-cover border border-[#d8c0ad]">
                            @else
                                <div class="flex h-16 w-16 items-center justify-center rounded-sm bg-[#fff0e6] text-[#b86033]">
                                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.429 9.75 2.25 12l4.179 2.25m0-4.5 5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L21.75 12l-4.179 2.25m0 0 4.179 2.25L12 21.75 2.25 16.5l4.179-2.25m11.142 0-5.571 3-5.571-3"/></svg>
                                </div>
                            @endif
                            <div>
                                <p class="font-semibold text-stone-900">{{ $quotation->product->name }}</p>
                                @if ($quotation->product->sku)
                                    <p class="mt-0.5 text-xs text-stone-400">SKU: {{ $quotation->product->sku }}</p>
                                @endif
                                @if ($quotation->product->category)
                                    <span class="mt-1 inline-block rounded-full bg-[#fff0e6] px-2 py-px text-[0.65rem] font-semibold text-[#b86033]">{{ ucfirst(str_replace('-', ' ', $quotation->product->category)) }}</span>
                                @endif
                            </div>
                        </div>
                    @else
                        <p class="text-sm text-stone-400 italic">Product no longer available.</p>
                    @endif
                </div>
            </div>

            {{-- Linked Order (if any) --}}
            @if ($quotation->hasOrder())
                <div class="overflow-hidden rounded-sm border border-blue-200 bg-blue-50/30 shadow-[0_8px_24px_rgba(0,0,0,0.05)]">
                    <div class="border-b border-blue-200 px-5 py-3">
                        <h3 class="text-xs font-semibold uppercase tracking-[0.18em] text-blue-600">Linked Order</h3>
                    </div>
                    <div class="flex items-center justify-between px-5 py-4">
                        <div>
                            <p class="font-semibold text-stone-900">Order #{{ $quotation->order->id }}</p>
                            <p class="mt-0.5 text-xs text-stone-400 capitalize">Status: {{ str_replace('_', ' ', $quotation->order->order_status) }}</p>
                        </div>
                        <a
                            href="{{ route('admin.orders.show', $quotation->order) }}"
                            class="inline-flex items-center gap-1.5 rounded-sm border border-blue-300 bg-white px-3 py-1.5 text-xs font-semibold text-blue-700 transition hover:bg-blue-50"
                        >
                            View Order
                        </a>
                    </div>
                </div>
            @endif

        </div>

        {{-- RIGHT — Client info + actions (1/3) --}}
        <div class="space-y-5">

            {{-- Client details --}}
            <div class="overflow-hidden rounded-sm border border-[#d8c0ad] bg-white shadow-[0_8px_24px_rgba(0,0,0,0.05)]">
                <div class="border-b border-[#ead7c9] bg-[#fff9f4] px-5 py-3">
                    <h3 class="text-xs font-semibold uppercase tracking-[0.18em] text-stone-500">Client</h3>
                </div>
                <div class="px-5 py-4 space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#fff0e6] text-sm font-bold text-[#b86033]">
                            {{ strtoupper(substr($quotation->user->name ?? 'U', 0, 1)) }}
                        </div>
                        <div class="min-w-0">
                            <p class="font-semibold text-stone-900">{{ $quotation->user->name ?? 'Unknown' }}</p>
                            <p class="truncate text-xs text-stone-400">{{ $quotation->user->email ?? '' }}</p>
                        </div>
                    </div>
                    @if ($quotation->user)
                        <a
                            href="{{ route('admin.users.show', $quotation->user) }}"
                            class="block w-full rounded-sm border border-[#d8c0ad] py-2 text-center text-xs font-semibold text-stone-600 transition hover:border-[#b86033] hover:text-[#b86033]"
                        >
                            View Client Profile
                        </a>
                    @endif
                </div>
            </div>

            {{-- Actions --}}
            <div class="overflow-hidden rounded-sm border border-[#d8c0ad] bg-white shadow-[0_8px_24px_rgba(0,0,0,0.05)]">
                <div class="border-b border-[#ead7c9] bg-[#fff9f4] px-5 py-3">
                    <h3 class="text-xs font-semibold uppercase tracking-[0.18em] text-stone-500">Actions</h3>
                </div>
                <div class="space-y-3 px-5 py-4">

                    @if ($quotation->status === 'pending')
                        {{-- Approve form --}}
                        <form method="POST" action="{{ route('admin.quotations.approve', $quotation) }}">
                            @csrf
                            <div class="mb-2">
                                <label for="price_per_brick" class="mb-1 block text-xs font-semibold text-stone-600">Price per Brick (UGX)</label>
                                <input
                                    type="number"
                                    name="price_per_brick"
                                    id="price_per_brick"
                                    value="{{ old('price_per_brick', $quotation->price_per_brick) }}"
                                    step="1"
                                    min="1"
                                    class="w-full rounded-sm border border-[#d8c0ad] px-3 py-2 text-sm text-stone-700 focus:border-[#b86033] focus:outline-none focus:ring-1 focus:ring-[#b86033]"
                                    placeholder="e.g. 850"
                                >
                            </div>
                            <button
                                type="submit"
                                class="w-full rounded-sm bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-700"
                                onclick="return confirm('Approve this quotation with the entered price?')"
                            >
                                Approve Quotation
                            </button>
                        </form>

                        {{-- Reject --}}
                        <form method="POST" action="{{ route('admin.quotations.reject', $quotation) }}">
                            @csrf
                            <button
                                type="submit"
                                class="w-full rounded-sm border border-red-300 bg-red-50 px-4 py-2.5 text-sm font-semibold text-red-600 transition hover:bg-red-100"
                                onclick="return confirm('Reject this quotation?')"
                            >
                                Reject Quotation
                            </button>
                        </form>

                    @elseif ($quotation->status === 'approved' && !$quotation->hasOrder())
                        {{-- Convert to order --}}
                        <form method="POST" action="{{ route('admin.quotations.convert-to-order', $quotation) }}">
                            @csrf
                            <button
                                type="submit"
                                class="w-full rounded-sm bg-[#b86033] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#cd6e3a]"
                                onclick="return confirm('Convert this quotation into an order?')"
                            >
                                Convert to Order
                            </button>
                        </form>

                    @elseif ($quotation->status === 'approved' && $quotation->hasOrder())
                        <div class="rounded-sm border border-emerald-200 bg-emerald-50 px-4 py-3 text-xs font-semibold text-emerald-700 text-center">
                            Order #{{ $quotation->order->id }} already created
                        </div>

                    @elseif ($quotation->status === 'rejected')
                        <div class="rounded-sm border border-red-200 bg-red-50 px-4 py-3 text-xs font-semibold text-red-600 text-center">
                            This quotation has been rejected
                        </div>
                    @endif

                    {{-- Delete --}}
                    @if (!$quotation->hasOrder())
                        <form method="POST" action="{{ route('admin.quotations.destroy', $quotation) }}" class="mt-2">
                            @csrf
                            @method('DELETE')
                            <button
                                type="submit"
                                class="w-full rounded-sm border border-stone-200 px-4 py-2 text-xs font-semibold text-stone-400 transition hover:border-red-300 hover:bg-red-50 hover:text-red-500"
                                onclick="return confirm('Permanently delete this quotation? This cannot be undone.')"
                            >
                                Delete Quotation
                            </button>
                        </form>
                    @endif

                </div>
            </div>

            {{-- Meta --}}
            <div class="overflow-hidden rounded-sm border border-[#d8c0ad] bg-white shadow-[0_8px_24px_rgba(0,0,0,0.05)]">
                <div class="border-b border-[#ead7c9] bg-[#fff9f4] px-5 py-3">
                    <h3 class="text-xs font-semibold uppercase tracking-[0.18em] text-stone-500">Timeline</h3>
                </div>
                <div class="divide-y divide-[#f0e8e1] px-5">
                    <div class="flex items-center justify-between py-3">
                        <span class="text-xs text-stone-500">Submitted</span>
                        <span class="text-xs font-semibold text-stone-700">{{ $quotation->created_at->format('d M Y H:i') }}</span>
                    </div>
                    <div class="flex items-center justify-between py-3">
                        <span class="text-xs text-stone-500">Last updated</span>
                        <span class="text-xs font-semibold text-stone-700">{{ $quotation->updated_at->format('d M Y H:i') }}</span>
                    </div>
                    @if ($quotation->hasOrder())
                        <div class="flex items-center justify-between py-3">
                            <span class="text-xs text-stone-500">Order created</span>
                            <span class="text-xs font-semibold text-stone-700">{{ $quotation->order->created_at->format('d M Y H:i') }}</span>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

@endsection
