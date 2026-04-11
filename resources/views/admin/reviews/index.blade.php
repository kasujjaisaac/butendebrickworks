@extends('layouts.admin')

@section('admin-content')

    {{-- Header --}}
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <div class="flex flex-wrap items-center gap-3">
            <p class="text-sm text-stone-500">{{ $reviews->total() }} review{{ $reviews->total() !== 1 ? 's' : '' }} total</p>
            @if ($pending > 0)
                <span class="rounded-full bg-amber-100 px-2.5 py-0.5 text-xs font-semibold text-amber-700">{{ $pending }} pending</span>
            @endif
            @if ($featured > 0)
                <span class="rounded-full bg-[#fff0e6] px-2.5 py-0.5 text-xs font-semibold text-[#b86033]">{{ $featured }} featured</span>
            @endif
        </div>
        <a
            href="{{ route('admin.reviews.create') }}"
            class="inline-flex items-center gap-2 rounded-sm bg-[#b86033] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#cd6e3a]"
        >
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Add Review
        </a>
    </div>

    @if (session('status'))
        <div class="mb-5 flex items-center gap-3 rounded-sm border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            <svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
            {{ session('status') }}
        </div>
    @endif

    <div class="overflow-hidden rounded-sm border border-[#d8c0ad] bg-white shadow-[0_8px_24px_rgba(0,0,0,0.05)]">
        @if ($reviews->isEmpty())
            <div class="flex flex-col items-center justify-center px-8 py-20 text-center">
                <div class="inline-flex h-14 w-14 items-center justify-center rounded-full bg-[#fff0e6] text-[#b86033]">
                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z"/></svg>
                </div>
                <p class="mt-4 font-display text-xl font-semibold text-stone-900">No reviews yet</p>
                <p class="mt-2 text-sm text-stone-500">Add the first customer review to display it on the website.</p>
                <a href="{{ route('admin.reviews.create') }}" class="mt-5 inline-flex items-center gap-2 rounded-sm bg-[#b86033] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#cd6e3a]">
                    Add Review
                </a>
            </div>
        @else
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-[#ead7c9] bg-[#fff9f4]">
                        <th class="w-14 px-4 py-3.5 text-xs font-semibold uppercase tracking-[0.18em] text-stone-500"></th>
                        <th class="px-4 py-3.5 text-xs font-semibold uppercase tracking-[0.18em] text-stone-500">Reviewer</th>
                        <th class="hidden px-4 py-3.5 text-xs font-semibold uppercase tracking-[0.18em] text-stone-500 md:table-cell">Rating</th>
                        <th class="hidden px-4 py-3.5 text-xs font-semibold uppercase tracking-[0.18em] text-stone-500 lg:table-cell">Review</th>
                        <th class="hidden px-4 py-3.5 text-xs font-semibold uppercase tracking-[0.18em] text-stone-500 md:table-cell">Status</th>
                        <th class="px-4 py-3.5"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f0e8e1]">
                    @foreach ($reviews as $review)
                        <tr class="transition hover:bg-[#fff7f2] {{ !$review->is_approved ? 'opacity-60' : '' }}">

                            {{-- Avatar --}}
                            <td class="px-4 py-3">
                                @if ($review->photo)
                                    <img
                                        src="{{ Storage::disk('public')->url($review->photo) }}"
                                        alt="{{ $review->reviewer_name }}"
                                        class="h-10 w-10 rounded-full object-cover border border-[#d8c0ad]"
                                    >
                                @else
                                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-[#fff0e6] text-sm font-bold text-[#b86033]">
                                        {{ strtoupper(substr($review->reviewer_name, 0, 1)) }}
                                    </div>
                                @endif
                            </td>

                            {{-- Name + role --}}
                            <td class="px-4 py-3">
                                <p class="font-semibold text-stone-900">{{ $review->reviewer_name }}</p>
                                @if ($review->position || $review->company)
                                    <p class="mt-0.5 text-xs text-stone-400">
                                        {{ implode(', ', array_filter([$review->position, $review->company])) }}
                                    </p>
                                @endif
                                @if ($review->is_featured)
                                    <span class="mt-1 inline-block rounded-full bg-[#fff0e6] px-2 py-px text-[0.6rem] font-semibold uppercase tracking-wide text-[#b86033]">Featured</span>
                                @endif
                            </td>

                            {{-- Stars --}}
                            <td class="hidden px-4 py-3 md:table-cell">
                                <div class="flex items-center gap-0.5">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <svg class="h-4 w-4 {{ $i <= $review->rating ? 'text-amber-400' : 'text-stone-200' }}" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 0 0 .95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 0 0-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 0 0-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 0 0-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 0 0 .951-.69l1.07-3.292Z"/>
                                        </svg>
                                    @endfor
                                </div>
                            </td>

                            {{-- Content snippet --}}
                            <td class="hidden px-4 py-3 lg:table-cell">
                                <p class="line-clamp-2 max-w-xs text-xs text-stone-500">{{ $review->content }}</p>
                            </td>

                            {{-- Status badges --}}
                            <td class="hidden px-4 py-3 md:table-cell">
                                <div class="flex flex-col gap-1.5">
                                    @if ($review->is_approved)
                                        <span class="rounded-full border border-emerald-200 bg-emerald-50 px-2.5 py-0.5 text-xs font-semibold text-emerald-700">Approved</span>
                                    @else
                                        <span class="rounded-full border border-amber-200 bg-amber-50 px-2.5 py-0.5 text-xs font-semibold text-amber-700">Pending</span>
                                    @endif
                                </div>
                            </td>

                            {{-- Actions --}}
                            <td class="px-4 py-3">
                                <div class="flex flex-wrap items-center justify-end gap-1.5">

                                    {{-- Approve / Unapprove --}}
                                    <form method="POST" action="{{ route('admin.reviews.approve', $review) }}">
                                        @csrf @method('PATCH')
                                        <button type="submit"
                                            title="{{ $review->is_approved ? 'Unapprove' : 'Approve' }}"
                                            class="inline-flex items-center gap-1 rounded-sm border px-2.5 py-1.5 text-xs font-medium transition
                                                {{ $review->is_approved
                                                    ? 'border-stone-200 text-stone-500 hover:bg-stone-50'
                                                    : 'border-emerald-300 text-emerald-700 hover:bg-emerald-50' }}"
                                        >
                                            @if ($review->is_approved)
                                                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg>
                                                Unapprove
                                            @else
                                                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                                                Approve
                                            @endif
                                        </button>
                                    </form>

                                    {{-- Feature / Unfeature --}}
                                    <form method="POST" action="{{ route('admin.reviews.featured', $review) }}">
                                        @csrf @method('PATCH')
                                        <button type="submit"
                                            title="{{ $review->is_featured ? 'Remove from featured' : 'Mark as featured' }}"
                                            class="inline-flex items-center gap-1 rounded-sm border px-2.5 py-1.5 text-xs font-medium transition
                                                {{ $review->is_featured
                                                    ? 'border-[#d8c0ad] bg-[#fff0e6] text-[#b86033]'
                                                    : 'border-[#d8c0ad] text-stone-600 hover:bg-[#fff0e6] hover:text-[#b86033]' }}"
                                        >
                                            <svg class="h-3 w-3" viewBox="0 0 20 20" fill="{{ $review->is_featured ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="{{ $review->is_featured ? 0 : 1.5 }}">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 0 0 .95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 0 0-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 0 0-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 0 0-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 0 0 .951-.69l1.07-3.292Z"/>
                                            </svg>
                                            {{ $review->is_featured ? 'Featured' : 'Feature' }}
                                        </button>
                                    </form>

                                    {{-- Edit --}}
                                    <a
                                        href="{{ route('admin.reviews.edit', $review) }}"
                                        class="inline-flex items-center gap-1 rounded-sm border border-[#d8c0ad] px-2.5 py-1.5 text-xs font-medium text-stone-700 transition hover:bg-[#fff0e6] hover:text-[#b86033]"
                                    >
                                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z"/></svg>
                                        Edit
                                    </a>

                                    {{-- Delete --}}
                                    <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}" onsubmit="return confirm('Delete this review?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1 rounded-sm border border-red-200 px-2.5 py-1.5 text-xs font-medium text-red-600 transition hover:bg-red-50">
                                            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/></svg>
                                            Delete
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if ($reviews->hasPages())
                <div class="border-t border-[#f0e8e1] px-5 py-4">
                    {{ $reviews->links() }}
                </div>
            @endif
        @endif
    </div>

@endsection
