@extends('layouts.site')

@section('content')

    {{-- ===== HERO ===== --}}
    <section class="relative overflow-hidden bg-[#6e2f0e] py-20 md:py-28">
        <div class="absolute inset-0 bg-[linear-gradient(135deg,#4a1e08_0%,#6e2f0e_50%,#8a3c12_100%)]"></div>
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(255,255,255,0.06),transparent_55%)]"></div>
        <div class="absolute inset-0 opacity-[0.03]" style="background-image:repeating-linear-gradient(0deg,#fff 0px,#fff 18px,transparent 18px,transparent 36px),repeating-linear-gradient(90deg,#fff 0px,#fff 1px,transparent 1px,transparent 60px);"></div>
        <div class="page-grid relative">
            <nav class="mb-8 flex items-center gap-2 text-xs text-white/50" aria-label="Breadcrumb">
                <a href="/" class="transition hover:text-white/80">Home</a>
                <svg class="h-3 w-3 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                <span class="text-white/80">News &amp; Publications</span>
            </nav>
            <div>
                <span class="inline-block rounded-sm border border-white/25 bg-white/10 px-3 py-1 text-[0.68rem] font-semibold uppercase tracking-[0.28em] text-white/80">From the yard</span>
                <h1 class="mt-5 font-display text-4xl font-semibold leading-tight tracking-tight text-white md:text-5xl">
                    News &amp; Publications
                </h1>
                <p class="mt-5 max-w-xl text-base leading-7 text-white/65">
                    Practical guides, design inspiration, industry perspectives, and company updates from the team behind Butende Brick Works.
                </p>
            </div>
        </div>
    </section>

    {{-- ===== POSTS ===== --}}
    <section class="py-14">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

            @php
                $catColors = [
                    'News'         => '#b86033',
                    'Publication'  => '#6e2f0e',
                    'Guide'        => '#4a1e08',
                    'Announcement' => '#1a5c3a',
                    'Design'       => '#2f4a6e',
                    'Industry'     => '#4e3b2a',
                ];
            @endphp

            {{-- Category filter pills --}}
            @if ($categories->isNotEmpty())
                <div class="mb-10 flex flex-wrap items-center gap-2">
                    <a href="{{ route('news.list') }}"
                       class="rounded-full px-4 py-1.5 text-xs font-semibold tracking-wide transition
                              {{ !$activeCategory ? 'bg-[#b86033] text-white shadow-sm' : 'border border-stone-200 bg-white text-stone-500 hover:border-stone-300 hover:text-stone-800' }}">All</a>
                    @foreach ($categories as $cat)
                        <a href="{{ route('news.list', ['category' => $cat]) }}"
                           class="rounded-full px-4 py-1.5 text-xs font-semibold tracking-wide transition
                                  {{ $activeCategory === $cat ? 'bg-[#b86033] text-white shadow-sm' : 'border border-stone-200 bg-white text-stone-500 hover:border-stone-300 hover:text-stone-800' }}">{{ $cat }}</a>
                    @endforeach
                </div>
            @endif

            @if ($posts->isEmpty())
                <div class="flex flex-col items-center justify-center rounded-xl border border-dashed border-stone-200 bg-white py-24 text-center">
                    <div class="inline-flex h-14 w-14 items-center justify-center rounded-full bg-stone-100 text-stone-400">
                        <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5M6 7.5h3v3H6v-3Z"/></svg>
                    </div>
                    <p class="mt-4 text-stone-500">No posts found. Check back soon.</p>
                </div>
            @else
                @php
                    $allItems   = collect($posts->items());
                    $featured   = $allItems->first();
                    $restItems  = $allItems->skip(1);
                    $showFeatured = !$activeCategory && $posts->currentPage() === 1 && $featured;
                @endphp

                {{-- ── Featured post (first page, no filter) ── --}}
                @if ($showFeatured)
                    <a href="{{ route('news.show', $featured->slug) }}"
                       class="group mb-10 flex min-h-[280px] overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm transition duration-300 hover:shadow-lg">

                        {{-- Large image panel --}}
                        <div class="relative w-[54%] shrink-0 overflow-hidden bg-stone-100">
                            @if ($featured->image)
                                <img src="{{ Storage::disk('public')->url($featured->image) }}"
                                     alt="{{ $featured->title }}"
                                     class="absolute inset-0 h-full w-full object-cover transition duration-700 group-hover:scale-[1.04]">
                            @else
                                <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-stone-100 to-stone-200">
                                    <svg class="h-16 w-16 text-stone-300" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"/></svg>
                                </div>
                            @endif
                        </div>

                        {{-- Content panel --}}
                        <div class="flex flex-1 flex-col justify-between p-8">
                            <div>
                                <div class="flex items-center gap-3">
                                    <span class="rounded-full px-3 py-1 text-[0.62rem] font-bold uppercase tracking-widest text-white"
                                          style="background-color: {{ $catColors[$featured->category] ?? '#b86033' }}">{{ $featured->category }}</span>
                                    <span class="text-xs text-stone-400">{{ $featured->published_at->format('d M Y') }}</span>
                                </div>
                                <h2 class="mt-4 font-display text-2xl font-bold leading-snug tracking-tight text-stone-900 transition group-hover:text-[#b86033] line-clamp-3">
                                    {{ $featured->title }}
                                </h2>
                                @if ($featured->excerpt)
                                    <p class="mt-3 text-sm leading-6 text-stone-500 line-clamp-4">{{ $featured->excerpt }}</p>
                                @endif
                            </div>
                            <div class="mt-6 flex items-center gap-1.5 text-xs font-bold uppercase tracking-widest text-[#b86033] transition-all group-hover:gap-2.5">
                                Read the full story
                                <svg class="h-3.5 w-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
                            </div>
                        </div>
                    </a>
                @endif

                {{-- ── Post grid ── --}}
                @php $gridPosts = $showFeatured ? $restItems : $allItems; @endphp
                @if ($gridPosts->isNotEmpty())
                    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($gridPosts as $post)
                            @php $color = $catColors[$post->category] ?? '#b86033'; @endphp
                            <a href="{{ route('news.show', $post->slug) }}"
                               class="group flex flex-col overflow-hidden rounded-xl border border-stone-200 bg-white shadow-sm transition duration-200 hover:shadow-md hover:border-stone-300">

                                {{-- Thumbnail --}}
                                <div class="aspect-video overflow-hidden bg-stone-100">
                                    @if ($post->image)
                                        <img src="{{ Storage::disk('public')->url($post->image) }}"
                                             alt="{{ $post->title }}"
                                             class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                                    @else
                                        <div class="flex h-full w-full items-center justify-center">
                                            <svg class="h-10 w-10 text-stone-300" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"/></svg>
                                        </div>
                                    @endif
                                </div>

                                {{-- Body --}}
                                <div class="flex flex-1 flex-col p-5">
                                    <div class="flex items-center gap-1.5">
                                        <span class="h-1.5 w-1.5 shrink-0 rounded-full" style="background-color: {{ $color }}"></span>
                                        <span class="text-[0.62rem] font-bold uppercase tracking-widest" style="color: {{ $color }}">{{ $post->category }}</span>
                                        <span class="text-[0.62rem] text-stone-400">&middot; {{ $post->published_at->format('d M Y') }}</span>
                                    </div>
                                    <h3 class="mt-2.5 font-display text-base font-semibold leading-snug tracking-tight text-stone-900 transition group-hover:text-[#b86033] line-clamp-2">
                                        {{ $post->title }}
                                    </h3>
                                    @if ($post->excerpt)
                                        <p class="mt-2 flex-1 text-xs leading-5 text-stone-500 line-clamp-3">{{ $post->excerpt }}</p>
                                    @endif
                                    <div class="mt-4 flex items-center gap-1 border-t border-stone-100 pt-3 text-[0.62rem] font-bold uppercase tracking-widest text-[#b86033] transition-all group-hover:gap-2">
                                        Read more
                                        <svg class="h-3 w-3 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif

                {{-- Pagination --}}
                @if ($posts->hasPages())
                    <div class="mt-12 flex items-center justify-center gap-1">
                        @if ($posts->onFirstPage())
                            <span class="inline-flex h-9 w-9 cursor-not-allowed items-center justify-center rounded-full border border-stone-200 text-stone-300">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/></svg>
                            </span>
                        @else
                            <a href="{{ $posts->previousPageUrl() }}" class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-stone-200 bg-white text-stone-600 transition hover:bg-stone-50">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/></svg>
                            </a>
                        @endif
                        @foreach ($posts->getUrlRange(max(1, $posts->currentPage() - 2), min($posts->lastPage(), $posts->currentPage() + 2)) as $page => $url)
                            @if ($page == $posts->currentPage())
                                <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-[#b86033] text-sm font-semibold text-white">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-stone-200 bg-white text-sm text-stone-600 transition hover:bg-stone-50">{{ $page }}</a>
                            @endif
                        @endforeach
                        @if ($posts->hasMorePages())
                            <a href="{{ $posts->nextPageUrl() }}" class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-stone-200 bg-white text-stone-600 transition hover:bg-stone-50">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                            </a>
                        @else
                            <span class="inline-flex h-9 w-9 cursor-not-allowed items-center justify-center rounded-full border border-stone-200 text-stone-300">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                            </span>
                        @endif
                    </div>
                @endif
            @endif

        </div>
    </section>

@endsection
