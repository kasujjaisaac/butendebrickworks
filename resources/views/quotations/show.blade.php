<x-portal-layout>
    <x-slot name="header">
        <div>
            <p class="text-[10px] font-semibold uppercase tracking-[0.2em] text-stone-400">Quotations</p>
            <h1 class="mt-0.5 text-[15px] font-semibold text-stone-800">Quotation #{{ str_pad($quotation->id, 6, '0', STR_PAD_LEFT) }}</h1>
        </div>
    </x-slot>

    <div class="space-y-6 px-4 py-6 sm:px-6 max-w-2xl mx-auto">

        @if (session('success'))
            <div class="flex items-start gap-3 border border-emerald-200 bg-emerald-50 px-4 py-3 rounded-md">
                <svg class="mt-0.5 h-5 w-5 shrink-0 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
                <div>
                    <p class="text-sm font-semibold text-emerald-800">Quotation Generated Successfully</p>
                    <p class="mt-0.5 text-xs text-emerald-700">Review the details below and confirm your order when ready.</p>
                </div>
            </div>
        @endif

            {{-- Quotation breakdown card --}}
            <div class="border border-stone-200 bg-white shadow-sm rounded-md overflow-hidden">
                <div class="bg-[#6e2f0e] px-6 py-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-widest text-white/70">Quotation Reference</p>
                            <p class="text-xl font-bold text-white">#{{ str_pad($quotation->id, 6, '0', STR_PAD_LEFT) }}</p>
                        </div>
                        <span class="rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-wide
                            {{ $quotation->status === 'approved' ? 'bg-green-100 text-green-800' :
                               ($quotation->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-white/20 text-white') }}">
                            {{ ucfirst($quotation->status) }}
                        </span>
                    </div>
                </div>

                <div class="px-6 py-6">
                    <p class="text-[10px] font-semibold uppercase tracking-widest text-stone-400 mb-4">Calculation Breakdown</p>

                    <dl class="divide-y divide-stone-100">
                        <div class="flex items-center justify-between py-3">
                            <dt class="text-sm text-gray-600">Product</dt>
                            <dd class="text-sm font-semibold text-gray-900">{{ $quotation->product->name }}</dd>
                        </div>
                        <div class="flex items-center justify-between py-3">
                            <dt class="text-sm text-gray-600">Area Entered</dt>
                            <dd class="text-sm font-semibold text-gray-900">{{ number_format($quotation->square_metres, 2) }} m²</dd>
                        </div>
                        <div class="flex items-center justify-between py-3">
                            <dt class="text-sm text-stone-500">Units per m²</dt>
                            <dd class="text-sm font-semibold text-stone-900">{{ $quotation->product->bricks_per_square_metre }}</dd>
                        </div>
                        <div class="flex items-center justify-between py-3">
                            <dt class="text-sm text-stone-500">Units Required</dt>
                            <dd class="text-sm font-bold text-[#6e2f0e]">{{ number_format($quotation->bricks_required) }} units</dd>
                        </div>
                    </dl>

                    <p class="mt-3 text-xs text-stone-400">
                        * {{ number_format($quotation->square_metres, 2) }} m² &times;
                        {{ $quotation->product->bricks_per_square_metre }} units/m²
                    </p>
                </div>

                {{-- CTA --}}
                @if (! $quotation->hasOrder())
                    <div class="border-t border-stone-100 bg-stone-50 px-6 py-5">
                        <p class="text-sm text-stone-600 mb-4">Happy with this quote? Confirm your order and we will get started.</p>
                        <form method="POST" action="{{ route('orders.store') }}">
                            @csrf
                            <input type="hidden" name="quotation_id" value="{{ $quotation->id }}">
                            <button
                                type="submit"
                                onclick="return confirm('Are you sure you want to place this order for {{ number_format($quotation->bricks_required) }} {{ $quotation->product->name }}?')"
                                class="w-full bg-[#6e2f0e] px-6 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-[#5a2509] focus:outline-none focus:ring-2 focus:ring-[#6e2f0e] focus:ring-offset-2 rounded-sm"
                            >
                                Confirm Order &rarr;
                            </button>
                        </form>
                    </div>
                @else
                    <div class="border-t border-stone-100 bg-stone-50 px-6 py-5 flex items-center justify-between">
                        <p class="text-sm text-stone-600">An order has already been placed for this quotation.</p>
                        <a
                            href="{{ route('orders.show', $quotation->order) }}"
                            class="border border-[#6e2f0e] px-5 py-2.5 text-sm font-semibold text-[#6e2f0e] transition hover:bg-[#6e2f0e] hover:text-white rounded-sm"
                        >
                            View Order
                        </a>
                    </div>
                @endif
            </div>

        <div class="flex justify-center">
            <a href="{{ route('quotation.create') }}" class="text-sm text-stone-400 hover:text-[#6e2f0e] transition">
                Request another quotation
            </a>
        </div>

    </div>
</x-portal-layout>
