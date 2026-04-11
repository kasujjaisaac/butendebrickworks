@extends('layouts.admin')

@section('admin-content')
    {{-- Header --}}
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <p class="text-sm text-stone-500">{{ $partners->total() }} partner{{ $partners->total() !== 1 ? 's' : '' }} listed on site</p>
        <a
            href="{{ route('admin.partners.create') }}"
            class="inline-flex items-center gap-2 rounded-sm bg-[#b86033] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#cd6e3a]"
        >
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Add Partner
        </a>
    </div>

    @if (session('status'))
        <div class="mb-5 flex items-center gap-3 rounded-sm border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            <svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
            {{ session('status') }}
        </div>
    @endif

    <div class="overflow-hidden rounded-sm border border-[#d8c0ad] bg-white shadow-[0_8px_24px_rgba(0,0,0,0.05)]">
        @if ($partners->isEmpty())
            <div class="flex flex-col items-center justify-center px-8 py-20 text-center">
                <div class="inline-flex h-14 w-14 items-center justify-center rounded-full bg-[#fff0e6] text-[#b86033]">
                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z"/></svg>
                </div>
                <p class="mt-4 font-display text-xl font-semibold text-stone-900">No partners yet</p>
                <p class="mt-2 text-sm text-stone-500">Add your first partner to display them on the site.</p>
                <a href="{{ route('admin.partners.create') }}" class="mt-5 inline-flex items-center gap-2 rounded-sm bg-[#b86033] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#cd6e3a]">
                    Add Partner
                </a>
            </div>
        @else
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-[#ead7c9] bg-[#fff9f4]">
                        <th class="w-16 px-5 py-3.5 text-xs font-semibold uppercase tracking-[0.18em] text-stone-500">Logo</th>
                        <th class="px-5 py-3.5 text-xs font-semibold uppercase tracking-[0.18em] text-stone-500">Name</th>
                        <th class="hidden px-5 py-3.5 text-xs font-semibold uppercase tracking-[0.18em] text-stone-500 md:table-cell">Type / Role</th>
                        <th class="px-5 py-3.5"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f0e8e1]">
                    @foreach ($partners as $index => $partner)
                        @php
                            $logoPath  = $partner['logo'] ?? null;
                            $logoExists = $logoPath && (
                                str_starts_with($logoPath, '/storage/')
                                    ? file_exists(public_path($logoPath))
                                    : file_exists(public_path($logoPath))
                            );
                            $initials = collect(preg_split('/[\s&]+/', $partner['name']))
                                ->filter()->map(fn($w) => strtoupper(substr($w,0,1)))->take(2)->implode('');
                        @endphp
                        <tr class="transition hover:bg-[#fff7f2]">
                            <td class="px-5 py-3">
                                @if ($logoExists)
                                    <img src="{{ $logoPath }}" alt="{{ $partner['name'] }}"
                                         class="h-12 w-12 rounded-md object-contain border border-stone-200 bg-white p-1">
                                @else
                                    <div class="flex h-12 w-12 items-center justify-center rounded-md border border-[#d8c0ad] bg-[#fff9f4] text-xs font-bold text-[#b86033]">
                                        {{ $initials }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-5 py-3">
                                <p class="font-semibold text-stone-900">{{ $partner['name'] }}</p>
                            </td>
                            <td class="hidden px-5 py-3 text-stone-500 md:table-cell">
                                {{ $partner['type'] ?? '—' }}
                            </td>
                            <td class="px-5 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    <a
                                        href="{{ route('admin.partners.edit', $index) }}"
                                        class="inline-flex items-center gap-1 rounded-sm border border-[#d8c0ad] px-3 py-1.5 text-xs font-medium text-stone-700 transition hover:bg-[#fff0e6] hover:text-[#b86033]"
                                    >
                                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z"/></svg>
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.partners.destroy', $index) }}" onsubmit="return confirm('Remove this partner?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1 rounded-sm border border-red-200 px-3 py-1.5 text-xs font-medium text-red-600 transition hover:bg-red-50">
                                            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/></svg>
                                            Remove
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if ($partners->hasPages())
                <div class="border-t border-[#ead7c9] px-5 py-4">
                    {{ $partners->links() }}
                </div>
            @endif
        @endif
    </div>
@endsection
