<x-portal-layout>
    <x-slot name="header">
        <div>
            <p class="text-[10px] font-semibold uppercase tracking-[0.2em] text-stone-400">Quotations</p>
            <h1 class="mt-0.5 text-[15px] font-semibold text-stone-800">My Quotations</h1>
        </div>
    </x-slot>

    <div class="space-y-6 px-4 py-6 sm:px-6 max-w-5xl mx-auto">

            @if ($quotations->isEmpty())
                <div class="border border-dashed border-stone-300 bg-white rounded-md px-8 py-16 text-center">
                    <svg class="mx-auto h-12 w-12 text-stone-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z"/>
                    </svg>
                    <h3 class="mt-4 text-base font-semibold text-gray-900">No quotations yet</h3>
                    <p class="mt-2 text-sm text-gray-500">Use the calculator or click below to request your first quotation.</p>
                    <div class="mt-6 flex flex-col items-center gap-3 sm:flex-row sm:justify-center">
                        <a href="{{ route('quotation.create') }}"
                           class="inline-flex items-center gap-1.5 rounded-sm bg-[#6e2f0e] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#5a2509]">
                            Get a Quotation
                        </a>
                        <a href="{{ route('calculator') }}"
                           class="inline-flex items-center gap-1.5 rounded-sm border border-stone-300 bg-white px-5 py-2.5 text-sm font-semibold text-stone-700 transition hover:bg-stone-50">
                            Use Products Calculator
                        </a>
                    </div>
                </div>
            @else
                <div class="border border-stone-200 bg-white shadow-sm rounded-md overflow-hidden">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-stone-100 bg-stone-50">
                                <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Ref #</th>
                                <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Product</th>
                                <th class="hidden px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 sm:table-cell">Area</th>
                                <th class="hidden px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 md:table-cell">Units</th>
                                <th class="px-6 py-3.5 text-center text-xs font-semibold uppercase tracking-wide text-gray-500">Status</th>
                                <th class="px-6 py-3.5 text-center text-xs font-semibold uppercase tracking-wide text-gray-500">Date</th>
                                <th class="px-6 py-3.5"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-50">
                            @foreach ($quotations as $quotation)
                                <tr class="hover:bg-stone-50 transition">
                                    <td class="px-6 py-4 font-mono font-semibold text-gray-900">
                                        #{{ str_pad($quotation->id, 6, '0', STR_PAD_LEFT) }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-700">
                                        {{ $quotation->product->name ?? '—' }}
                                    </td>
                                    <td class="hidden px-6 py-4 text-gray-700 sm:table-cell">
                                        {{ number_format($quotation->square_metres, 2) }} m²
                                    </td>
                                    <td class="hidden px-6 py-4 text-gray-700 md:table-cell">
                                        {{ number_format($quotation->bricks_required) }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @php
                                            $badge = match($quotation->status) {
                                                'approved' => 'bg-green-100 text-green-800',
                                                'rejected' => 'bg-red-100 text-red-800',
                                                default    => 'bg-yellow-100 text-yellow-800',
                                            };
                                        @endphp
                                        <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $badge }}">
                                            {{ ucfirst($quotation->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center text-gray-500 text-xs">
                                        {{ $quotation->created_at->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('quotation.show', $quotation) }}"
                                           class="text-[#b86033] hover:underline font-medium text-xs">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if ($quotations->hasPages())
                        <div class="border-t border-stone-100 px-6 py-4">
                            {{ $quotations->links() }}
                        </div>
                    @endif
                </div>
            @endif

    </div>
</x-portal-layout>
