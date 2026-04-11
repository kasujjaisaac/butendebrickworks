<x-portal-layout>
    <x-slot name="header">
        <div>
            <p class="text-[10px] font-semibold uppercase tracking-[0.2em] text-stone-400">Orders</p>
            <h1 class="mt-0.5 text-[15px] font-semibold text-stone-800">My Orders</h1>
        </div>
    </x-slot>

    <div class="space-y-6 px-4 py-6 sm:px-6 max-w-5xl mx-auto">

        @if (session('success'))
            <div class="flex items-center gap-3 border border-emerald-200 bg-emerald-50 px-4 py-3 rounded-md">
                <svg class="h-5 w-5 shrink-0 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                <p class="text-sm font-medium text-emerald-800">{{ session('success') }}</p>
            </div>
        @endif

        @if (session('info'))
            <div class="flex items-center gap-3 border border-blue-200 bg-blue-50 px-4 py-3 rounded-md">
                <svg class="h-5 w-5 shrink-0 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z"/></svg>
                <p class="text-sm font-medium text-blue-800">{{ session('info') }}</p>
            </div>
        @endif

        {{-- ── Place a Direct Order ──────────────────────────────────── --}}
        <div x-data="orderForm()" class="border border-stone-200 bg-white shadow-sm overflow-hidden rounded-md">

            {{-- Section header --}}
            <div class="flex items-center gap-3 bg-[#6e2f0e] px-6 py-4">
                <div class="flex h-9 w-9 items-center justify-center rounded-sm bg-white/15">
                    <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z"/></svg>
                </div>
                <div>
                    <h2 class="text-[14px] font-bold text-white">Place a Direct Order</h2>
                    <p class="text-[11px] text-white/60">Order products directly — no quotation required</p>
                </div>
            </div>

            {{-- Error summary --}}
            @if ($errors->any())
                <div class="mx-6 mt-5 border border-rose-200 bg-rose-50 px-4 py-3 rounded-md">
                    <p class="text-xs font-semibold text-rose-700 mb-1">Please fix the following:</p>
                    <ul class="list-disc list-inside text-xs text-rose-600 space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('orders.storeDirect') }}" class="px-6 py-6 space-y-5">
                @csrf

                <div class="grid gap-5 sm:grid-cols-2">

                    {{-- Product --}}
                    <div>
                        <label for="brick_product_id" class="block text-xs font-semibold uppercase tracking-wide text-stone-500 mb-1.5">
                            Product <span class="text-rose-500">*</span>
                        </label>
                        <select
                            id="brick_product_id"
                            name="brick_product_id"
                            @change="updateProduct($event)"
                            class="w-full border border-stone-300 rounded-sm px-3 py-2.5 text-sm text-stone-900 bg-white focus:border-[#6e2f0e] focus:ring-2 focus:ring-[#6e2f0e]/20 focus:outline-none @error('brick_product_id') border-rose-400 bg-rose-50 @enderror"
                        >
                            <option value="">— Select a product —</option>
                            @foreach ($products as $p)
                                <option
                                    value="{{ $p->id }}"
                                    data-price="{{ $p->price_per_brick }}"
                                    data-name="{{ $p->name }}"
                                    {{ old('brick_product_id') == $p->id ? 'selected' : '' }}
                                >{{ $p->name }} — UGX {{ number_format($p->price_per_brick, 2) }} / unit</option>
                            @endforeach
                        </select>
                        @error('brick_product_id')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Quantity --}}
                    <div>
                        <label for="quantity" class="block text-xs font-semibold uppercase tracking-wide text-stone-500 mb-1.5">
                            Quantity (units) <span class="text-rose-500">*</span>
                        </label>
                        <input
                            type="number"
                            id="quantity"
                            name="quantity"
                            value="{{ old('quantity') }}"
                            min="1"
                            placeholder="e.g. 5000"
                            @input="updateTotal()"
                            class="w-full border border-stone-300 rounded-sm px-3 py-2.5 text-sm text-stone-900 focus:border-[#6e2f0e] focus:ring-2 focus:ring-[#6e2f0e]/20 focus:outline-none @error('quantity') border-rose-400 bg-rose-50 @enderror"
                        >
                        @error('quantity')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                {{-- Estimated total --}}
                <div x-show="total > 0" x-cloak class="flex items-center justify-between border border-amber-200 bg-amber-50 px-4 py-3 rounded-sm">
                    <span class="text-xs font-semibold uppercase tracking-wide text-amber-700">Estimated Total</span>
                    <span class="text-lg font-extrabold text-amber-900">UGX <span x-text="total.toLocaleString('en-UG', {minimumFractionDigits:2})"></span></span>
                </div>

                {{-- Delivery address --}}
                <div>
                    <label for="delivery_address" class="block text-xs font-semibold uppercase tracking-wide text-stone-500 mb-1.5">
                        Delivery Address <span class="text-rose-500">*</span>
                    </label>
                    <textarea
                        id="delivery_address"
                        name="delivery_address"
                        rows="2"
                        placeholder="Street, area, district…"
                        class="w-full border border-stone-300 rounded-sm px-3 py-2.5 text-sm text-stone-900 focus:border-[#6e2f0e] focus:ring-2 focus:ring-[#6e2f0e]/20 focus:outline-none resize-none @error('delivery_address') border-rose-400 bg-rose-50 @enderror"
                    >{{ old('delivery_address') }}</textarea>
                    @error('delivery_address')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Notes --}}
                <div>
                    <label for="notes" class="block text-xs font-semibold uppercase tracking-wide text-stone-500 mb-1.5">
                        Additional Notes <span class="text-stone-400 font-normal normal-case">(optional)</span>
                    </label>
                    <textarea
                        id="notes"
                        name="notes"
                        rows="2"
                        placeholder="Special requirements, preferred delivery date…"
                        class="w-full border border-stone-300 rounded-sm px-3 py-2.5 text-sm text-stone-900 focus:border-[#6e2f0e] focus:ring-2 focus:ring-[#6e2f0e]/20 focus:outline-none resize-none"
                    >{{ old('notes') }}</textarea>
                </div>

                <div class="flex justify-end pt-2">
                    <button
                        type="submit"
                        class="inline-flex items-center gap-2 bg-[#6e2f0e] px-6 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-[#5a2509] focus:outline-none focus:ring-2 focus:ring-[#6e2f0e] focus:ring-offset-2 rounded-sm"
                    >
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5"/></svg>
                        Place Order
                    </button>
                </div>
            </form>
        </div>

        {{-- ── My Orders Table ──────────────────────────────────────── --}}
        <div>
            <h2 class="text-xs font-semibold uppercase tracking-[0.18em] text-stone-400 mb-3">Order History</h2>

            @if ($orders->isEmpty())
                <div class="border border-dashed border-stone-300 bg-white px-8 py-14 text-center rounded-md">
                    <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-sm bg-[#f9ede6]">
                        <svg class="h-6 w-6 text-[#6e2f0e]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z"/></svg>
                    </div>
                    <h3 class="text-sm font-bold text-stone-900">No orders yet</h3>
                    <p class="mt-1 text-xs text-stone-500">Use the form above to place your first order.</p>
                </div>
            @else
                <div class="border border-stone-200 bg-white shadow-sm overflow-hidden rounded-md">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-stone-100 bg-stone-50">
                                <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide text-stone-500">Order #</th>
                                <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide text-stone-500">Product</th>
                                <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wide text-stone-500">Qty / Area</th>
                                <th class="px-5 py-3 text-right text-[11px] font-semibold uppercase tracking-wide text-stone-500">Total</th>
                                <th class="px-5 py-3 text-center text-[11px] font-semibold uppercase tracking-wide text-stone-500">Type</th>
                                <th class="px-5 py-3 text-center text-[11px] font-semibold uppercase tracking-wide text-stone-500">Status</th>
                                <th class="px-5 py-3 text-center text-[11px] font-semibold uppercase tracking-wide text-stone-500">Date</th>
                                <th class="px-5 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-50">
                            @foreach ($orders as $order)
                                @php
                                    $product = $order->resolvedProduct;
                                    $badgeClass = match($order->order_status) {
                                        'pending'       => 'bg-amber-100 text-amber-700',
                                        'confirmed'     => 'bg-blue-100 text-blue-700',
                                        'in_production' => 'bg-violet-100 text-violet-700',
                                        'ready'         => 'bg-teal-100 text-teal-700',
                                        'delivered'     => 'bg-emerald-100 text-emerald-700',
                                        default         => 'bg-stone-100 text-stone-500',
                                    };
                                @endphp
                                <tr class="hover:bg-stone-50/60 transition">
                                    <td class="px-5 py-3.5 font-mono text-[12px] font-semibold text-stone-800">
                                        #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
                                    </td>
                                    <td class="px-5 py-3.5 text-[13px] text-stone-700">
                                        {{ $product->name ?? '—' }}
                                    </td>
                                    <td class="px-5 py-3.5 text-[12px] text-stone-500">
                                        @if ($order->isDirectOrder())
                                            {{ number_format($order->quantity) }} units
                                        @else
                                            {{ number_format($order->quotation->square_metres, 1) }} m²
                                        @endif
                                    </td>
                                    <td class="px-5 py-3.5 text-right text-[13px] font-semibold text-stone-900">
                                        UGX {{ number_format($order->total_amount, 2) }}
                                    </td>
                                    <td class="px-5 py-3.5 text-center">
                                        <span class="inline-flex rounded-sm px-2 py-0.5 text-[10px] font-semibold {{ $order->isDirectOrder() ? 'bg-stone-100 text-stone-600' : 'bg-[#f9ede6] text-[#6e2f0e]' }}">
                                            {{ $order->isDirectOrder() ? 'Direct' : 'Quoted' }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3.5 text-center">
                                        <span class="inline-flex rounded-full px-2.5 py-0.5 text-[10.5px] font-semibold {{ $badgeClass }}">
                                            {{ $order->status_label }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3.5 text-center text-[11px] text-stone-400">
                                        {{ $order->created_at->format('d M Y') }}
                                    </td>
                                    <td class="px-5 py-3.5 text-right">
                                        <a href="{{ route('orders.show', $order) }}" class="text-[12px] font-semibold text-[#b86033] hover:underline">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if ($orders->hasPages())
                        <div class="border-t border-stone-100 px-5 py-4">
                            {{ $orders->links() }}
                        </div>
                    @endif
                </div>
            @endif
        </div>

    </div>

    @push('scripts')
    <script>
        function orderForm() {
            return {
                pricePerUnit: 0,
                quantity: 0,
                total: 0,
                updateProduct(event) {
                    const opt = event.target.options[event.target.selectedIndex];
                    this.pricePerUnit = parseFloat(opt.dataset.price || 0);
                    this.updateTotal();
                },
                updateTotal() {
                    const qty = parseInt(document.getElementById('quantity').value, 10) || 0;
                    this.quantity = qty;
                    this.total = qty > 0 && this.pricePerUnit > 0 ? qty * this.pricePerUnit : 0;
                },
            };
        }
    </script>
    @endpush

</x-portal-layout>
