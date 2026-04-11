@extends('layouts.admin')

@section('admin-content')
    {{-- Filters + Mark All Read bar --}}
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center gap-2 rounded-sm border border-[#d8c0ad] bg-white p-1 text-sm shadow-[0_4px_12px_rgba(0,0,0,0.04)]">
            @foreach (['all' => 'All (' . $totalCount . ')', 'unread' => 'Unread (' . $unreadCount . ')', 'read' => 'Read'] as $value => $label)
                <a
                    href="{{ route('admin.messages.index', ['filter' => $value]) }}"
                    class="{{ $filter === $value ? 'bg-[#b86033] text-white shadow-sm' : 'text-stone-600 hover:text-stone-900' }} rounded-[3px] px-4 py-2 font-medium transition"
                >
                    {{ $label }}
                </a>
            @endforeach
        </div>

        @if ($unreadCount > 0)
            <form method="POST" action="{{ route('admin.messages.mark-all-read') }}">
                @csrf
                <button type="submit" class="inline-flex items-center gap-2 rounded-sm border border-[#d8c0ad] bg-white px-4 py-2 text-sm font-medium text-stone-700 transition hover:bg-[#fff7f0] hover:text-[#b86033]">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                    Mark all as read
                </button>
            </form>
        @endif
    </div>

    {{-- Message table --}}
    <div class="overflow-hidden rounded-sm border border-[#d8c0ad] bg-white shadow-[0_8px_24px_rgba(0,0,0,0.05)]">
        @if ($messages->isEmpty())
            <div class="flex flex-col items-center justify-center px-8 py-20 text-center">
                <div class="inline-flex h-14 w-14 items-center justify-center rounded-full bg-[#fff0e6] text-[#b86033]">
                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"/></svg>
                </div>
                <p class="mt-4 font-display text-xl font-semibold text-stone-900">No enquiries found</p>
                <p class="mt-2 text-sm text-stone-500">
                    @if ($filter !== 'all') Try switching to "All" to see every message.
                    @else No contact or quote submissions have been received yet.
                    @endif
                </p>
            </div>
        @else
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-[#ead7c9] bg-[#fff9f4]">
                        <th class="px-5 py-3.5 text-xs font-semibold uppercase tracking-[0.18em] text-stone-500">Status</th>
                        <th class="px-5 py-3.5 text-xs font-semibold uppercase tracking-[0.18em] text-stone-500">Sender</th>
                        <th class="px-5 py-3.5 text-xs font-semibold uppercase tracking-[0.18em] text-stone-500">Subject</th>
                        <th class="hidden px-5 py-3.5 text-xs font-semibold uppercase tracking-[0.18em] text-stone-500 md:table-cell">Contact</th>
                        <th class="hidden px-5 py-3.5 text-xs font-semibold uppercase tracking-[0.18em] text-stone-500 lg:table-cell">Received</th>
                        <th class="px-5 py-3.5"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f0e8e1]">
                    @foreach ($messages as $msg)
                        <tr class="{{ $msg->is_read ? '' : 'bg-[#fffaf6]' }} transition hover:bg-[#fff7f2]">
                            <td class="px-5 py-4">
                                @if ($msg->is_read)
                                    <span class="inline-block h-2 w-2 rounded-full bg-stone-300" title="Read"></span>
                                @else
                                    <span class="inline-block h-2.5 w-2.5 rounded-full bg-[#b86033]" title="Unread"></span>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                <p class="{{ $msg->is_read ? 'font-medium text-stone-700' : 'font-semibold text-stone-950' }}">{{ $msg->name }}</p>
                            </td>
                            <td class="px-5 py-4">
                                <a href="{{ route('admin.messages.show', $msg) }}" class="{{ $msg->is_read ? 'text-stone-600' : 'font-semibold text-stone-900' }} hover:text-[#b86033] hover:underline">
                                    {{ $msg->subject }}
                                </a>
                            </td>
                            <td class="hidden px-5 py-4 text-stone-600 md:table-cell">
                                <a href="mailto:{{ $msg->email }}" class="hover:text-[#b86033] hover:underline">{{ $msg->email }}</a>
                                @if ($msg->phone)
                                    <p class="mt-0.5 text-xs text-stone-400">{{ $msg->phone }}</p>
                                @endif
                            </td>
                            <td class="hidden px-5 py-4 text-stone-500 lg:table-cell">
                                <time datetime="{{ $msg->created_at->toIso8601String() }}" title="{{ $msg->created_at->format('d M Y, g:ia') }}">
                                    {{ $msg->created_at->diffForHumans() }}
                                </time>
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('admin.messages.show', $msg) }}" class="text-xs font-medium text-[#b86033] hover:underline">View</a>
                                    <form method="POST" action="{{ route('admin.messages.destroy', $msg) }}" onsubmit="return confirm('Delete this enquiry permanently?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-xs font-medium text-stone-400 hover:text-rose-600 hover:underline">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if ($messages->hasPages())
                <div class="border-t border-[#ead7c9] px-5 py-4">
                    {{ $messages->links() }}
                </div>
            @endif
        @endif
    </div>
@endsection
