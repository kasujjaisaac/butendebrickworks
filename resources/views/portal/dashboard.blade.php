<x-portal-layout>

    {{-- Page topbar header slot --}}
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-[10px] font-semibold uppercase tracking-[0.2em] text-stone-400">{{ now()->format('l, d F Y') }}</p>
                <h1 class="mt-0.5 text-[15px] font-semibold text-stone-800">
                    Welcome back, {{ explode(' ', Auth::user()->name)[0] }}
                </h1>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6 px-4 py-6 sm:px-6 max-w-5xl mx-auto">

        @if (session('success'))
            <div class="flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3">
                <svg class="h-5 w-5 shrink-0 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                <p class="text-sm font-medium text-emerald-800">{{ session('success') }}</p>
            </div>
        @endif

        {{-- Welcome banner --}}
        <div class="relative overflow-hidden rounded-md bg-[#6e2f0e] px-6 py-7 shadow-md">
            <div class="pointer-events-none absolute inset-0 opacity-[0.06]"
                 style="background-image:url(\"data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23fff'%3E%3Crect x='0' y='0' width='20' height='10'/%3E%3Crect x='20' y='10' width='20' height='10'/%3E%3Crect x='0' y='20' width='20' height='10'/%3E%3Crect x='20' y='30' width='20' height='10'/%3E%3C/g%3E%3C/svg%3E\")"></div>
            <div class="relative flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-widest text-white/50">Client Dashboard</p>
                    <h2 class="mt-1 text-xl font-bold text-white">Good to have you, {{ explode(' ', Auth::user()->name)[0] }}.</h2>
                    <p class="mt-1 text-sm text-white/60">Manage your quotations, track orders, and use our tools.</p>
                </div>
                <div class="flex shrink-0 gap-2.5">
                    <a href="{{ route('quotation.create') }}"
                       class="inline-flex items-center gap-1.5 rounded-lg bg-white px-4 py-2.5 text-xs font-semibold text-[#6e2f0e] shadow transition hover:bg-stone-100">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        New Quotation
                    </a>
                    <a href="{{ route('calculator') }}"
                       class="inline-flex items-center rounded-lg bg-white/15 px-4 py-2.5 text-xs font-semibold text-white transition hover:bg-white/25">
                        Calculator
                    </a>
                </div>
            </div>
        </div>

        {{-- KPI row --}}
        <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">

            <div class="rounded-md border border-stone-200 bg-white p-5 shadow-sm transition hover:shadow-md">
                <div class="flex h-9 w-9 items-center justify-center rounded-md bg-[#f9ede6]">
                    <svg class="h-5 w-5 text-[#6e2f0e]" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z"/></svg>
                </div>
                <p class="mt-4 text-2xl font-bold text-stone-900">{{ $totalQuotations }}</p>
                <p class="mt-0.5 text-xs font-medium text-stone-500">Total Quotations</p>
                <a href="{{ route('quotation.index') }}" class="mt-3 inline-flex items-center gap-1 text-[11px] font-semibold text-[#b86033] hover:underline">View all &rarr;</a>
            </div>

            <div class="rounded-md border border-stone-200 bg-white p-5 shadow-sm transition hover:shadow-md">
                <div class="flex h-9 w-9 items-center justify-center rounded-md {{ $pendingQuotations > 0 ? 'bg-amber-50' : 'bg-stone-50' }}">
                    <svg class="h-5 w-5 {{ $pendingQuotations > 0 ? 'text-amber-500' : 'text-stone-400' }}" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                </div>
                <p class="mt-4 text-2xl font-bold {{ $pendingQuotations > 0 ? 'text-amber-600' : 'text-stone-900' }}">{{ $pendingQuotations }}</p>
                <p class="mt-0.5 text-xs font-medium text-stone-500">Pending Review</p>
                <a href="{{ route('quotation.create') }}" class="mt-3 inline-flex items-center gap-1 text-[11px] font-semibold text-[#b86033] hover:underline">Submit new &rarr;</a>
            </div>

            <div class="rounded-md border border-stone-200 bg-white p-5 shadow-sm transition hover:shadow-md">
                <div class="flex h-9 w-9 items-center justify-center rounded-md bg-blue-50">
                    <svg class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z"/></svg>
                </div>
                <p class="mt-4 text-2xl font-bold text-stone-900">{{ $totalOrders }}</p>
                <p class="mt-0.5 text-xs font-medium text-stone-500">Total Orders</p>
                <a href="{{ route('orders.index') }}" class="mt-3 inline-flex items-center gap-1 text-[11px] font-semibold text-[#b86033] hover:underline">View all &rarr;</a>
            </div>

            <div class="rounded-md border border-stone-200 bg-white p-5 shadow-sm transition hover:shadow-md">
                <div class="flex h-9 w-9 items-center justify-center rounded-md {{ $activeOrders > 0 ? 'bg-emerald-50' : 'bg-stone-50' }}">
                    <svg class="h-5 w-5 {{ $activeOrders > 0 ? 'text-emerald-500' : 'text-stone-400' }}" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/></svg>
                </div>
                <p class="mt-4 text-2xl font-bold {{ $activeOrders > 0 ? 'text-emerald-600' : 'text-stone-900' }}">{{ $activeOrders }}</p>
                <p class="mt-0.5 text-xs font-medium text-stone-500">Active Orders</p>
                <a href="{{ route('orders.index') }}" class="mt-3 inline-flex items-center gap-1 text-[11px] font-semibold text-[#b86033] hover:underline">Track &rarr;</a>
            </div>

        </div>

        {{-- Quick actions --}}
        <div class="grid gap-3 sm:grid-cols-3">
            <a href="{{ route('calculator') }}"
               class="group flex items-center gap-3.5 rounded-md border border-stone-200 bg-white px-4 py-3.5 shadow-sm transition hover:border-[#6e2f0e]/30 hover:shadow-md">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-md bg-[#f9ede6] text-[#6e2f0e] transition group-hover:bg-[#6e2f0e] group-hover:text-white">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 15.75V18m-7.5-6.75h.008v.008H8.25v-.008Zm0 2.25h.008v.008H8.25V13.5Zm0 2.25h.008v.008H8.25v-.008Zm0 2.25h.008v.008H8.25V18Zm2.498-6.75h.007v.008h-.007v-.008Zm0 2.25h.007v.008h-.007V13.5Zm0 2.25h.007v.008h-.007v-.008Zm0 2.25h.007v.008h-.007V18Zm2.504-6.75h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V13.5Zm0 2.25h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V18Zm2.498-6.75h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V13.5ZM8.25 6h7.5v2.25h-7.5V6ZM12 2.25c-1.892 0-3.758.11-5.593.322C5.307 2.7 4.5 3.616 4.5 4.698V18a2.25 2.25 0 0 0 2.25 2.25h10.5A2.25 2.25 0 0 0 19.5 18V4.698c0-1.082-.807-1.998-1.907-2.126A48.32 48.32 0 0 0 12 2.25Z"/></svg>
                </div>
                <div>
                    <p class="text-[13px] font-semibold text-stone-800">Products Calculator</p>
                    <p class="text-[11px] text-stone-400 mt-0.5">Estimate quantities instantly</p>
                </div>
            </a>
            <a href="{{ route('quotation.create') }}"
               class="group flex items-center gap-3.5 rounded-md border border-stone-200 bg-white px-4 py-3.5 shadow-sm transition hover:border-[#6e2f0e]/30 hover:shadow-md">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-md bg-[#f9ede6] text-[#6e2f0e] transition group-hover:bg-[#6e2f0e] group-hover:text-white">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/></svg>
                </div>
                <div>
                    <p class="text-[13px] font-semibold text-stone-800">Request Quotation</p>
                    <p class="text-[11px] text-stone-400 mt-0.5">Get an official price quote</p>
                </div>
            </a>
            <a href="{{ route('orders.index') }}"
               class="group flex items-center gap-3.5 rounded-md border border-stone-200 bg-white px-4 py-3.5 shadow-sm transition hover:border-[#6e2f0e]/30 hover:shadow-md">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-md bg-[#f9ede6] text-[#6e2f0e] transition group-hover:bg-[#6e2f0e] group-hover:text-white">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/></svg>
                </div>
                <div>
                    <p class="text-[13px] font-semibold text-stone-800">Track Orders</p>
                    <p class="text-[11px] text-stone-400 mt-0.5">View delivery status</p>
                </div>
            </a>
        </div>

        {{-- Activity --}}
        @if ($recentQuotations->isNotEmpty() || $recentOrders->isNotEmpty())
            <div class="grid gap-6 lg:grid-cols-2">

                @if ($recentQuotations->isNotEmpty())
                    <div class="overflow-hidden rounded-md border border-stone-200 bg-white shadow-sm">
                        <div class="flex items-center justify-between border-b border-stone-100 px-5 py-3.5">
                            <div class="flex items-center gap-2">
                                <span class="h-2 w-2 rounded-full bg-[#6e2f0e]"></span>
                                <h3 class="text-[13px] font-semibold text-stone-800">Recent Quotations</h3>
                            </div>
                            <a href="{{ route('quotation.index') }}" class="text-[11px] font-semibold text-[#b86033] hover:underline">View all</a>
                        </div>
                        <ul class="divide-y divide-stone-50">
                            @foreach ($recentQuotations as $q)
                                <li class="flex items-center justify-between px-5 py-3.5 transition hover:bg-stone-50/60">
                                    <div class="min-w-0">
                                        <p class="truncate text-[13px] font-semibold text-stone-900">{{ $q->product->name ?? '—' }}</p>
                                        <p class="mt-0.5 text-[11px] text-stone-400">
                                            <span class="font-mono">#{{ str_pad($q->id, 5, '0', STR_PAD_LEFT) }}</span>
                                            &bull; {{ number_format($q->bricks_required) }} units
                                            &bull; {{ $q->created_at->format('d M Y') }}
                                        </p>
                                    </div>
                                    <div class="ml-3 flex shrink-0 items-center gap-3">
                                        <span @class([
                                            'inline-flex rounded-full px-2 py-0.5 text-[10.5px] font-semibold',
                                            'bg-emerald-100 text-emerald-700' => $q->status === 'approved',
                                            'bg-rose-100 text-rose-700'       => $q->status === 'rejected',
                                            'bg-amber-100 text-amber-700'     => $q->status === 'pending',
                                        ])>{{ ucfirst($q->status) }}</span>
                                        <a href="{{ route('quotation.show', $q) }}" class="text-stone-400 transition hover:text-[#6e2f0e]">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
                                        </a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if ($recentOrders->isNotEmpty())
                    <div class="overflow-hidden rounded-md border border-stone-200 bg-white shadow-sm">
                        <div class="flex items-center justify-between border-b border-stone-100 px-5 py-3.5">
                            <div class="flex items-center gap-2">
                                <span class="h-2 w-2 rounded-full bg-blue-500"></span>
                                <h3 class="text-[13px] font-semibold text-stone-800">Recent Orders</h3>
                            </div>
                            <a href="{{ route('orders.index') }}" class="text-[11px] font-semibold text-[#b86033] hover:underline">View all</a>
                        </div>
                        <ul class="divide-y divide-stone-50">
                            @foreach ($recentOrders as $o)
                                <li class="flex items-center justify-between px-5 py-3.5 transition hover:bg-stone-50/60">
                                    <div class="min-w-0">
                                        <p class="truncate text-[13px] font-semibold text-stone-900">{{ $o->quotation->product->name ?? '—' }}</p>
                                        <p class="mt-0.5 text-[11px] text-stone-400">
                                            <span class="font-mono">#{{ str_pad($o->id, 5, '0', STR_PAD_LEFT) }}</span>
                                            &bull; UGX {{ number_format($o->total_amount) }}
                                            &bull; {{ $o->created_at->format('d M Y') }}
                                        </p>
                                    </div>
                                    <div class="ml-3 flex shrink-0 items-center gap-3">
                                        @php
                                            $badge = match($o->order_status) {
                                                'pending'       => 'bg-amber-100 text-amber-700',
                                                'confirmed'     => 'bg-blue-100 text-blue-700',
                                                'in_production' => 'bg-violet-100 text-violet-700',
                                                'ready'         => 'bg-teal-100 text-teal-700',
                                                'delivered'     => 'bg-emerald-100 text-emerald-700',
                                                default         => 'bg-stone-100 text-stone-500',
                                            };
                                        @endphp
                                        <span class="inline-flex rounded-full px-2 py-0.5 text-[10.5px] font-semibold {{ $badge }}">{{ $o->status_label }}</span>
                                        <a href="{{ route('orders.show', $o) }}" class="text-stone-400 transition hover:text-[#6e2f0e]">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
                                        </a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

            </div>
        @else
            <div class="overflow-hidden rounded-md border border-dashed border-stone-300 bg-white px-8 py-14 text-center">
                <div class="mx-auto mb-5 flex h-14 w-14 items-center justify-center rounded-md bg-[#f9ede6]">
                    <svg class="h-7 w-7 text-[#6e2f0e]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z"/></svg>
                </div>
                <h3 class="text-base font-bold text-stone-900">Your portal is all set</h3>
                <p class="mt-2 text-sm text-stone-500 max-w-sm mx-auto leading-6">
                    Start by calculating the bricks your project needs, then request a formal quotation.
                </p>
                <div class="mt-6 flex flex-col items-center gap-3 sm:flex-row sm:justify-center">
                    <a href="{{ route('calculator') }}"
                       class="inline-flex items-center gap-2 rounded-lg bg-[#6e2f0e] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#5a2509]">
                        Open Products Calculator
                    </a>
                    <a href="{{ route('quotation.create') }}"
                       class="inline-flex items-center gap-2 rounded-lg border border-stone-300 bg-white px-5 py-2.5 text-sm font-semibold text-stone-700 transition hover:bg-stone-50">
                        Request Quotation
                    </a>
                </div>
            </div>
        @endif

    </div>

</x-portal-layout>
