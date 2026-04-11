@extends('layouts.admin')

@section('admin-content')

{{-- GREETING --}}
<div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <p class="text-[10px] font-semibold uppercase tracking-[0.22em] text-stone-400">{{ now()->format('l, d F Y') }}</p>
        <h2 class="mt-0.5 text-xl font-bold text-stone-900">Welcome back, {{ explode(' ', auth()->user()->name)[0] }}</h2>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('admin.messages.index') }}"
           class="inline-flex items-center gap-1.5 rounded-lg border border-stone-200 bg-white px-3 py-1.5 text-xs font-medium text-stone-700 transition hover:bg-stone-50">
            <svg class="h-3.5 w-3.5 text-[#6e2f0e]" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"/></svg>
            Inbox
        </a>
        <a href="{{ route('admin.home.edit') }}"
           class="inline-flex items-center gap-1.5 rounded-lg bg-[#6e2f0e] px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-[#8c3d12]">
            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z"/></svg>
            Edit Content
        </a>
    </div>
</div>

{{-- ROW 1 — KPI CARDS --}}
<div class="grid grid-cols-2 gap-3 md:grid-cols-3 xl:grid-cols-6">

    {{-- Messages --}}
    <article class="flex items-center gap-3 rounded-xl border border-stone-200 bg-white px-4 py-3">
        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-stone-100 text-stone-600">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"/></svg>
        </div>
        <div class="min-w-0">
            <p class="text-[10px] font-semibold uppercase tracking-widest text-stone-400">Messages</p>
            <p class="text-xl font-bold text-stone-900">{{ $totalMessages }}</p>
            <div class="flex flex-wrap gap-1 mt-0.5">
                <span class="rounded bg-emerald-50 px-1.5 py-0.5 text-[10px] font-semibold text-emerald-700">{{ $readMessages }} read</span>
                <span class="rounded {{ $unreadMessages > 0 ? 'bg-red-50 text-red-600' : 'bg-stone-100 text-stone-400' }} px-1.5 py-0.5 text-[10px] font-semibold">{{ $unreadMessages }} unread</span>
            </div>
        </div>
    </article>

    {{-- Quotations --}}
    <article class="flex items-center gap-3 rounded-xl border border-stone-200 bg-white px-4 py-3">
        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-amber-50 text-amber-600">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/></svg>
        </div>
        <div class="min-w-0">
            <p class="text-[10px] font-semibold uppercase tracking-widest text-stone-400">Quotations</p>
            <p class="text-xl font-bold text-stone-900">{{ $totalQuotations }}</p>
            <div class="flex flex-wrap gap-1 mt-0.5">
                <span class="rounded {{ $pendingQuotations > 0 ? 'bg-amber-50 text-amber-700' : 'bg-stone-100 text-stone-400' }} px-1.5 py-0.5 text-[10px] font-semibold">{{ $pendingQuotations }} pending</span>
                <span class="rounded bg-emerald-50 px-1.5 py-0.5 text-[10px] font-semibold text-emerald-700">{{ $approvedQuotations }} approved</span>
            </div>
        </div>
    </article>

    {{-- Orders --}}
    <article class="flex items-center gap-3 rounded-xl border border-stone-200 bg-white px-4 py-3">
        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-orange-50 text-orange-600">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007Z"/></svg>
        </div>
        <div class="min-w-0">
            <p class="text-[10px] font-semibold uppercase tracking-widest text-stone-400">Orders</p>
            <p class="text-xl font-bold text-stone-900">{{ $totalOrders }}</p>
            <div class="flex flex-wrap gap-1 mt-0.5">
                <span class="rounded {{ $pendingOrders > 0 ? 'bg-orange-50 text-orange-700' : 'bg-stone-100 text-stone-400' }} px-1.5 py-0.5 text-[10px] font-semibold">{{ $pendingOrders }} pending</span>
                <span class="rounded bg-sky-50 px-1.5 py-0.5 text-[10px] font-semibold text-sky-700">{{ $activeOrders }} active</span>
            </div>
        </div>
    </article>

    {{-- Clients --}}
    <article class="flex items-center gap-3 rounded-xl border border-stone-200 bg-white px-4 py-3">
        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/></svg>
        </div>
        <div class="min-w-0">
            <p class="text-[10px] font-semibold uppercase tracking-widest text-stone-400">Clients</p>
            <p class="text-xl font-bold text-stone-900">{{ $totalClients }}</p>
            <div class="flex flex-wrap gap-1 mt-0.5">
                <span class="rounded {{ $newClientsWeek > 0 ? 'bg-emerald-50 text-emerald-700' : 'bg-stone-100 text-stone-400' }} px-1.5 py-0.5 text-[10px] font-semibold">{{ $newClientsWeek }} new this wk</span>
            </div>
        </div>
    </article>

    {{-- Products --}}
    <article class="flex items-center gap-3 rounded-xl border border-stone-200 bg-white px-4 py-3">
        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-stone-100 text-stone-600">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z"/></svg>
        </div>
        <div class="min-w-0">
            <p class="text-[10px] font-semibold uppercase tracking-widest text-stone-400">Products</p>
            <p class="text-xl font-bold text-stone-900">{{ $productFamilies }} <span class="text-xs font-normal text-stone-400">families</span></p>
            <a href="{{ route('admin.products.index') }}" class="text-[10px] font-semibold text-stone-600 hover:underline">{{ $totalProducts }} profiles →</a>
        </div>
    </article>

    {{-- News --}}
    <article class="flex items-center gap-3 rounded-xl border border-stone-200 bg-white px-4 py-3">
        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-stone-100 text-stone-600">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5M6 7.5h3v3H6v-3Z"/></svg>
        </div>
        <div class="min-w-0">
            <p class="text-[10px] font-semibold uppercase tracking-widest text-stone-400">News</p>
            <p class="text-xl font-bold text-stone-900">{{ $totalNews }}</p>
            <div class="flex flex-wrap gap-1 mt-0.5">
                <span class="rounded bg-emerald-50 px-1.5 py-0.5 text-[10px] font-semibold text-emerald-700">{{ $publishedNews }} published</span>
                <span class="rounded bg-stone-100 px-1.5 py-0.5 text-[10px] font-semibold text-stone-500">{{ $draftNews }} draft</span>
            </div>
        </div>
    </article>
</div>

{{-- ROW 2 — PRODUCTS  +  MESSAGES BREAKDOWN --}}
<div class="mt-4 grid gap-4 lg:grid-cols-2">

    {{-- Products by category --}}
    <div class="overflow-hidden rounded-xl border border-stone-200 bg-white">
        <div class="flex items-center justify-between border-b border-stone-100 px-4 py-3">
            <p class="text-xs font-bold text-stone-900">Product Catalogue</p>
            <a href="{{ route('admin.products.index') }}" class="text-[11px] font-semibold text-[#6e2f0e] hover:underline">Manage →</a>
        </div>
        <div class="divide-y divide-stone-100">
            @foreach ($productBreakdown as $cat)
                @php
                    $pct = $totalProducts > 0 ? round(($cat['count'] / $totalProducts) * 100) : 0;
                    $barColors = [
                        'bricks'            => 'bg-[#6e2f0e]',
                        'floor-tiles'       => 'bg-[#8f4420]',
                        'decorative-bricks' => 'bg-[#a85a30]',
                        'ventilators'       => 'bg-[#c07040]',
                        'other-products'    => 'bg-[#d49060]',
                    ];
                    $barColor = $barColors[$cat['slug']] ?? 'bg-stone-400';
                @endphp
                <div class="flex items-center gap-3 px-4 py-2.5">
                    <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded {{ $barColor }} text-white">
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.429 9.75 2.25 12l4.179 2.25m0-4.5 5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L21.75 12l-4.179 2.25m0 0 4.179 2.25L12 21.75 2.25 16.5l4.179-2.25m11.142 0-5.571 3-5.571-3"/></svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="flex items-center justify-between gap-2">
                            <p class="truncate text-xs font-semibold text-stone-800">{{ $cat['name'] }}</p>
                            <span class="shrink-0 text-xs font-bold text-stone-900">{{ $cat['count'] }}</span>
                        </div>
                        <div class="mt-1 h-1 w-full overflow-hidden rounded-full bg-stone-100">
                            <div class="{{ $barColor }} h-full rounded-full" style="width: {{ $pct }}%"></div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="border-t border-stone-100 px-4 py-2 text-center">
            <p class="text-[10px] text-stone-400">{{ $totalProducts }} profiles · {{ $productFamilies }} families</p>
        </div>
    </div>

    {{-- Message Stats --}}
    <div class="overflow-hidden rounded-xl border border-stone-200 bg-white">
        <div class="flex items-center justify-between border-b border-stone-100 px-4 py-3">
            <p class="text-xs font-bold text-stone-900">Message Stats</p>
            <a href="{{ route('admin.messages.index') }}" class="text-[11px] font-semibold text-[#6e2f0e] hover:underline">Open inbox →</a>
        </div>
        <div class="px-4 py-4">
            @php
                $readPct   = $totalMessages > 0 ? round(($readMessages / $totalMessages) * 100) : 0;
                $unreadPct = 100 - $readPct;
            @endphp
            <div class="flex items-center gap-5">
                {{-- Donut --}}
                <div class="relative shrink-0">
                    <svg class="h-24 w-24 -rotate-90" viewBox="0 0 36 36">
                        <circle cx="18" cy="18" r="15.9155" fill="none" stroke="#f3f4f6" stroke-width="3"/>
                        @if ($totalMessages > 0)
                            <circle cx="18" cy="18" r="15.9155" fill="none" stroke="#6e2f0e" stroke-width="3"
                                stroke-dasharray="{{ $readPct }},{{ $unreadPct }}"
                                stroke-linecap="round"/>
                            @if ($unreadMessages > 0)
                            <circle cx="18" cy="18" r="15.9155" fill="none" stroke="#ef4444" stroke-width="3"
                                stroke-dasharray="{{ $unreadPct }},{{ $readPct }}"
                                stroke-dashoffset="{{ -$readPct }}"
                                stroke-linecap="round"/>
                            @endif
                        @endif
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-lg font-bold text-stone-900">{{ $totalMessages }}</span>
                        <span class="text-[9px] font-semibold uppercase tracking-wider text-stone-400">total</span>
                    </div>
                </div>
                {{-- Stats list --}}
                <div class="flex-1 space-y-2">
                    <div class="flex items-center justify-between text-xs">
                        <div class="flex items-center gap-1.5"><span class="h-2 w-2 rounded-full bg-[#6e2f0e]"></span><span class="text-stone-600">Read</span></div>
                        <span class="font-bold text-stone-900">{{ $readMessages }} <span class="font-normal text-stone-400">{{ $readPct }}%</span></span>
                    </div>
                    <div class="flex items-center justify-between text-xs">
                        <div class="flex items-center gap-1.5"><span class="h-2 w-2 rounded-full bg-red-500"></span><span class="text-stone-600">Unread</span></div>
                        <span class="font-bold text-stone-900">{{ $unreadMessages }} <span class="font-normal text-stone-400">{{ $unreadPct }}%</span></span>
                    </div>
                    <div class="flex items-center justify-between border-t border-stone-100 pt-2 text-xs">
                        <span class="text-stone-500">This week</span>
                        <span class="font-semibold text-stone-800">{{ $weekMessages }}</span>
                    </div>
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-stone-500">This month</span>
                        <span class="font-semibold text-stone-800">{{ $monthMessages }}</span>
                    </div>
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-stone-500">Today</span>
                        <span class="font-semibold {{ $todayMessages > 0 ? 'text-emerald-600' : 'text-stone-400' }}">{{ $todayMessages }}</span>
                    </div>
                </div>
            </div>
            <div class="mt-3 grid grid-cols-2 gap-2 border-t border-stone-100 pt-3">
                <a href="{{ route('admin.messages.index', ['filter' => 'unread']) }}"
                   class="flex items-center justify-center gap-1.5 rounded-lg border border-red-200 py-2 text-[11px] font-semibold text-red-600 transition hover:bg-red-50">
                    <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0"/></svg>
                    {{ $unreadMessages }} Unread
                </a>
                <a href="{{ route('admin.quotations.index') }}"
                   class="flex items-center justify-center gap-1.5 rounded-lg border border-stone-200 py-2 text-[11px] font-semibold text-stone-700 transition hover:bg-stone-50">
                    <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/></svg>
                    Quotations
                </a>
            </div>
        </div>
    </div>
</div>


@endsection
