@extends('layouts.admin')

@section('admin-content')

    {{-- Header --}}
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <div class="flex flex-wrap items-center gap-3">
            <p class="text-sm text-stone-500">{{ $counts['all'] }} quotation{{ $counts['all'] !== 1 ? 's' : '' }} total</p>
            @if ($counts['pending'] > 0)
                <span class="rounded-full bg-amber-100 px-2.5 py-0.5 text-xs font-semibold text-amber-700">{{ $counts['pending'] }} pending</span>
            @endif
        </div>
        {{-- Export CSV --}}
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

    @if (session('error'))
        <div class="mb-5 flex items-center gap-3 rounded-sm border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            <svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/></svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- Filters --}}
    <div class="mb-4 flex flex-wrap items-center gap-3">
        {{-- Status tabs --}}
        <div class="flex items-center gap-1 rounded-sm border border-[#d8c0ad] bg-white p-1">
            @foreach ([
                'all'      => 'All (' . $counts['all'] . ')',
                'pending'  => 'Pending (' . $counts['pending'] . ')',
                'approved' => 'Approved (' . $counts['approved'] . ')',
                'rejected' => 'Rejected (' . $counts['rejected'] . ')',
            ] as $key => $label)
                <a
                    href="{{ route('admin.quotations.index', array_merge(request()->query(), ['status' => $key])) }}"
                    class="rounded px-3 py-1.5 text-xs font-semibold transition {{ $status === $key ? 'bg-[#b86033] text-white' : 'text-stone-500 hover:bg-[#fff0e6] hover:text-[#b86033]' }}"
                >{{ $label }}</a>
            @endforeach
        </div>

        {{-- Search --}}
        <form method="GET" action="{{ route('admin.quotations.index') }}" class="flex items-center gap-2 ml-auto">
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
                <a href="{{ route('admin.quotations.index', ['status' => $status]) }}" class="text-xs font-semibold text-stone-400 hover:text-stone-600">Clear</a>
            @endif
        </form>
    </div>

    {{-- Table card --}}
    <div class="overflow-hidden rounded-sm border border-[#d8c0ad] bg-white shadow-[0_8px_24px_rgba(0,0,0,0.05)]">
        @if ($quotations->isEmpty())
            <div class="flex flex-col items-center justify-center px-8 py-20 text-center">
                <div class="inline-flex h-14 w-14 items-center justify-center rounded-full bg-[#fff0e6] text-[#b86033]">
                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/></svg>
                </div>
                <p class="mt-4 font-display text-xl font-semibold text-stone-900">No quotations found</p>
                <p class="mt-2 text-sm text-stone-500">Quotations submitted by clients will appear here.</p>
            </div>
        @else
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-[#ead7c9] bg-[#fff9f4]">
                        <th class="px-4 py-3.5 text-xs font-semibold uppercase tracking-[0.18em] text-stone-500">#</th>
                        <th class="px-4 py-3.5 text-xs font-semibold uppercase tracking-[0.18em] text-stone-500">Client</th>
                        <th class="hidden px-4 py-3.5 text-xs font-semibold uppercase tracking-[0.18em] text-stone-500 md:table-cell">Product</th>
                        <th class="hidden px-4 py-3.5 text-xs font-semibold uppercase tracking-[0.18em] text-stone-500 md:table-cell">Area (m²)</th>
                        <th class="hidden px-4 py-3.5 text-xs font-semibold uppercase tracking-[0.18em] text-stone-500 lg:table-cell">Bricks</th>
                        <th class="hidden px-4 py-3.5 text-xs font-semibold uppercase tracking-[0.18em] text-stone-500 lg:table-cell">Total (UGX)</th>
                        <th class="px-4 py-3.5 text-xs font-semibold uppercase tracking-[0.18em] text-stone-500">Status</th>
                        <th class="hidden px-4 py-3.5 text-xs font-semibold uppercase tracking-[0.18em] text-stone-500 md:table-cell">Date</th>
                        <th class="px-4 py-3.5"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f0e8e1]">
                    @foreach ($quotations as $quotation)
                        <tr class="transition hover:bg-[#fff7f2]">

                            {{-- ID --}}
                            <td class="px-4 py-3">
                                <span class="font-mono text-xs font-semibold text-stone-400">#{{ $quotation->id }}</span>
                            </td>

                            {{-- Client --}}
                            <td class="px-4 py-3">
                                <p class="font-semibold text-stone-900">{{ $quotation->user->name ?? '—' }}</p>
                                <p class="mt-0.5 text-xs text-stone-400">{{ $quotation->user->email ?? '' }}</p>
                            </td>

                            {{-- Product --}}
                            <td class="hidden px-4 py-3 md:table-cell">
                                <p class="text-stone-700">{{ $quotation->product->name ?? '—' }}</p>
                            </td>

                            {{-- Area --}}
                            <td class="hidden px-4 py-3 md:table-cell">
                                <span class="text-stone-700">{{ number_format($quotation->square_metres, 1) }}</span>
                            </td>

                            {{-- Bricks --}}
                            <td class="hidden px-4 py-3 lg:table-cell">
                                <span class="text-stone-700">{{ number_format($quotation->bricks_required) }}</span>
                            </td>

                            {{-- Total --}}
                            <td class="hidden px-4 py-3 lg:table-cell">
                                <span class="font-semibold text-stone-900">{{ number_format($quotation->total_price) }}</span>
                            </td>

                            {{-- Status --}}
                            <td class="px-4 py-3">
                                @php
                                    $badge = match ($quotation->status) {
                                        'approved' => 'border-emerald-200 bg-emerald-50 text-emerald-700',
                                        'rejected' => 'border-red-200 bg-red-50 text-red-600',
                                        default    => 'border-amber-200 bg-amber-50 text-amber-700',
                                    };
                                @endphp
                                <span class="rounded-full border {{ $badge }} px-2.5 py-0.5 text-xs font-semibold capitalize">
                                    {{ $quotation->status }}
                                </span>
                                @if ($quotation->hasOrder())
                                    <span class="mt-1 block rounded-full border border-blue-200 bg-blue-50 px-2.5 py-0.5 text-xs font-semibold text-blue-700">
                                        Order #{{ $quotation->order->id }}
                                    </span>
                                @endif
                            </td>

                            {{-- Date --}}
                            <td class="hidden px-4 py-3 text-xs text-stone-400 md:table-cell">
                                {{ $quotation->created_at->format('d M Y') }}
                            </td>

                            {{-- Actions --}}
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    <a
                                        href="{{ route('admin.quotations.show', $quotation) }}"
                                        class="inline-flex items-center gap-1.5 rounded-sm border border-[#d8c0ad] bg-white px-3 py-1.5 text-xs font-semibold text-stone-700 transition hover:border-[#b86033] hover:text-[#b86033]"
                                    >
                                        View
                                    </a>
                                </div>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Pagination --}}
            @if ($quotations->hasPages())
                <div class="border-t border-[#ead7c9] bg-[#fff9f4] px-4 py-3">
                    {{ $quotations->links() }}
                </div>
            @endif
        @endif
    </div>

@endsection
