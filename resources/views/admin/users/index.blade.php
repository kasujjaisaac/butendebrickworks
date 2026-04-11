@extends('layouts.admin')

@section('admin-content')
    {{-- Header bar --}}
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-sm text-stone-500">{{ $total }} client{{ $total !== 1 ? 's' : '' }} total</p>

        {{-- Search --}}
        <form method="GET" action="{{ route('admin.users.index') }}" class="flex items-center gap-2">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search by name, email or organisation…"
                class="w-64 rounded-sm border border-[#d8c0ad] bg-white px-3 py-2 text-sm text-stone-800 placeholder-stone-400 shadow-sm focus:border-[#b86033] focus:outline-none focus:ring-1 focus:ring-[#b86033]"
            >
            <button type="submit" class="rounded-sm bg-[#b86033] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#cd6e3a]">Search</button>
            @if (request('search'))
                <a href="{{ route('admin.users.index') }}" class="text-sm text-stone-500 hover:text-stone-800">Clear</a>
            @endif
        </form>
    </div>

    {{-- Table --}}
    <div class="overflow-hidden rounded-sm border border-[#d8c0ad] bg-white shadow-[0_8px_24px_rgba(0,0,0,0.05)]">
        @if ($users->isEmpty())
            <div class="flex flex-col items-center justify-center px-8 py-20 text-center">
                <div class="inline-flex h-14 w-14 items-center justify-center rounded-full bg-[#fff0e6] text-[#b86033]">
                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                    </svg>
                </div>
                <p class="mt-4 font-display text-xl font-semibold text-stone-900">No clients found</p>
                <p class="mt-2 text-sm text-stone-500">
                    @if (request('search'))
                        No clients match your search. <a href="{{ route('admin.users.index') }}" class="text-[#b86033] hover:underline">Clear search</a>
                    @else
                        No clients have registered yet.
                    @endif
                </p>
            </div>
        @else
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-[#ead7c9] bg-[#fff9f4]">
                        <th class="px-5 py-3.5 text-xs font-semibold uppercase tracking-[0.18em] text-stone-500">Name</th>
                        <th class="hidden px-5 py-3.5 text-xs font-semibold uppercase tracking-[0.18em] text-stone-500 md:table-cell">Organisation</th>
                        <th class="hidden px-5 py-3.5 text-xs font-semibold uppercase tracking-[0.18em] text-stone-500 lg:table-cell">Email</th>
                        <th class="px-5 py-3.5 text-xs font-semibold uppercase tracking-[0.18em] text-stone-500">Quotes</th>
                        <th class="px-5 py-3.5 text-xs font-semibold uppercase tracking-[0.18em] text-stone-500">Orders</th>
                        <th class="hidden px-5 py-3.5 text-xs font-semibold uppercase tracking-[0.18em] text-stone-500 lg:table-cell">Joined</th>
                        <th class="px-5 py-3.5"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f0e8e1]">
                    @foreach ($users as $user)
                        <tr class="transition hover:bg-[#fff7f2]">
                            <td class="px-5 py-4">
                                <p class="font-medium text-stone-900">{{ $user->name }}</p>
                                @if ($user->phone)
                                    <p class="mt-0.5 text-xs text-stone-400">{{ $user->phone }}</p>
                                @endif
                            </td>
                            <td class="hidden px-5 py-4 text-stone-600 md:table-cell">
                                {{ $user->organisation ?? '—' }}
                            </td>
                            <td class="hidden px-5 py-4 lg:table-cell">
                                <a href="mailto:{{ $user->email }}" class="text-[#b86033] hover:underline">{{ $user->email }}</a>
                            </td>
                            <td class="px-5 py-4 text-stone-600">{{ $user->quotations_count }}</td>
                            <td class="px-5 py-4 text-stone-600">{{ $user->orders_count }}</td>
                            <td class="hidden px-5 py-4 text-stone-500 lg:table-cell">
                                <time datetime="{{ $user->created_at->toIso8601String() }}" title="{{ $user->created_at->format('d M Y, g:ia') }}">
                                    {{ $user->created_at->format('d M Y') }}
                                </time>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <a
                                    href="{{ route('admin.users.show', $user) }}"
                                    class="inline-flex items-center gap-1 rounded-sm border border-[#d8c0ad] px-3 py-1.5 text-xs font-medium text-stone-700 transition hover:bg-[#fff0e6] hover:text-[#b86033]"
                                >
                                    View
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if ($users->hasPages())
                <div class="border-t border-[#ead7c9] px-5 py-4">
                    {{ $users->links() }}
                </div>
            @endif
        @endif
    </div>
@endsection
