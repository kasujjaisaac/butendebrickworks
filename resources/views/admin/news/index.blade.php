@extends('layouts.admin')

@section('admin-content')
    {{-- Header --}}
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <p class="text-sm text-stone-500">{{ $posts->total() }} post{{ $posts->total() !== 1 ? 's' : '' }} total</p>
        <a
            href="{{ route('admin.news.create') }}"
            class="inline-flex items-center gap-2 rounded-sm bg-[#b86033] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#cd6e3a]"
        >
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Write New Post
        </a>
    </div>

    @if (session('status'))
        <div class="mb-5 flex items-center gap-3 rounded-sm border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            <svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
            {{ session('status') }}
        </div>
    @endif

    <div class="overflow-hidden rounded-sm border border-[#d8c0ad] bg-white shadow-[0_8px_24px_rgba(0,0,0,0.05)]">
        @if ($posts->isEmpty())
            <div class="flex flex-col items-center justify-center px-8 py-20 text-center">
                <div class="inline-flex h-14 w-14 items-center justify-center rounded-full bg-[#fff0e6] text-[#b86033]">
                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5M6 7.5h3v3H6v-3Z"/></svg>
                </div>
                <p class="mt-4 font-display text-xl font-semibold text-stone-900">No posts yet</p>
                <p class="mt-2 text-sm text-stone-500">Get started by writing your first post.</p>
                <a href="{{ route('admin.news.create') }}" class="mt-5 inline-flex items-center gap-2 rounded-sm bg-[#b86033] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#cd6e3a]">
                    Write New Post
                </a>
            </div>
        @else
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-[#ead7c9] bg-[#fff9f4]">
                        <th class="px-5 py-3.5 text-xs font-semibold uppercase tracking-[0.18em] text-stone-500">Title</th>
                        <th class="hidden px-5 py-3.5 text-xs font-semibold uppercase tracking-[0.18em] text-stone-500 md:table-cell">Status</th>
                        <th class="hidden px-5 py-3.5 text-xs font-semibold uppercase tracking-[0.18em] text-stone-500 lg:table-cell">Published</th>
                        <th class="hidden px-5 py-3.5 text-xs font-semibold uppercase tracking-[0.18em] text-stone-500 lg:table-cell">Created</th>
                        <th class="px-5 py-3.5"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f0e8e1]">
                    @foreach ($posts as $post)
                        <tr class="transition hover:bg-[#fff7f2]">
                            <td class="px-5 py-4">
                                <p class="font-medium text-stone-900">{{ $post->title }}</p>
                                @if ($post->excerpt)
                                    <p class="mt-0.5 line-clamp-1 text-xs text-stone-400">{{ $post->excerpt }}</p>
                                @endif
                            </td>
                            <td class="hidden px-5 py-4 md:table-cell">
                                @if ($post->is_published)
                                    <span class="rounded-full border border-emerald-200 bg-emerald-50 px-2.5 py-0.5 text-xs font-semibold text-emerald-700">Published</span>
                                @else
                                    <span class="rounded-full border border-stone-200 bg-stone-50 px-2.5 py-0.5 text-xs font-semibold text-stone-500">Draft</span>
                                @endif
                            </td>
                            <td class="hidden px-5 py-4 text-stone-500 lg:table-cell">
                                {{ $post->published_at?->format('d M Y') ?? '—' }}
                            </td>
                            <td class="hidden px-5 py-4 text-stone-500 lg:table-cell">
                                {{ $post->created_at->format('d M Y') }}
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    <a
                                        href="{{ route('admin.news.edit', $post) }}"
                                        class="inline-flex items-center gap-1 rounded-sm border border-[#d8c0ad] px-3 py-1.5 text-xs font-medium text-stone-700 transition hover:bg-[#fff0e6] hover:text-[#b86033]"
                                    >
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.news.destroy', $post) }}" onsubmit="return confirm('Delete this post?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1 rounded-sm border border-red-200 px-3 py-1.5 text-xs font-medium text-red-600 transition hover:bg-red-50">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if ($posts->hasPages())
                <div class="border-t border-[#ead7c9] px-5 py-4">
                    {{ $posts->links() }}
                </div>
            @endif
        @endif
    </div>
@endsection
