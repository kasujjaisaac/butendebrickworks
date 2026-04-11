@extends('layouts.site')

@section('content')

    @php
        $catColors = [
            'News'         => '#b86033',
            'Publication'  => '#6e2f0e',
            'Guide'        => '#4a1e08',
            'Announcement' => '#1a5c3a',
            'Design'       => '#2f4a6e',
            'Industry'     => '#4e3b2a',
        ];
        $heroColor = $catColors[$post->category] ?? '#6e2f0e';
    @endphp

    {{-- ===== HERO ===== --}}
    <section class="relative overflow-hidden py-20 md:py-28" style="background: linear-gradient(135deg, {{ $heroColor }}f5 0%, {{ $heroColor }}cc 100%);">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(255,255,255,0.06),transparent_55%)]"></div>
        <div class="absolute inset-0 opacity-[0.03]" style="background-image:repeating-linear-gradient(0deg,#fff 0px,#fff 18px,transparent 18px,transparent 36px),repeating-linear-gradient(90deg,#fff 0px,#fff 1px,transparent 1px,transparent 60px);"></div>

        @if ($post->image)
            <img
                src="{{ Storage::disk('public')->url($post->image) }}"
                alt="{{ $post->title }}"
                class="absolute inset-0 h-full w-full object-cover opacity-20"
            >
        @endif

        <div class="page-grid relative">
            <nav class="mb-8 flex items-center gap-2 text-xs text-white/50" aria-label="Breadcrumb">
                <a href="/" class="transition hover:text-white/80">Home</a>
                <svg class="h-3 w-3 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                <a href="{{ route('news.list') }}" class="transition hover:text-white/80">News &amp; Publications</a>
                <svg class="h-3 w-3 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                <span class="line-clamp-1 text-white/80">{{ $post->title }}</span>
            </nav>

            <div class="max-w-3xl">
                <span class="inline-block rounded-sm border border-white/30 bg-white/15 px-3 py-1 text-[0.68rem] font-semibold uppercase tracking-[0.28em] text-white/90">
                    {{ $post->category }}
                </span>
                <h1 class="mt-5 font-display text-3xl font-semibold leading-tight tracking-tight text-white md:text-4xl lg:text-5xl">
                    {{ $post->title }}
                </h1>
                @if ($post->excerpt)
                    <p class="mt-5 text-base leading-7 text-white/70 max-w-2xl">
                        {{ $post->excerpt }}
                    </p>
                @endif
                <p class="mt-6 text-xs font-medium uppercase tracking-widest text-white/50">
                    Published {{ $post->published_at->format('d F Y') }}
                </p>
            </div>
        </div>
    </section>

    {{-- ===== ARTICLE BODY ===== --}}
    <section class="bg-white py-16">
        <div class="page-grid">
            <div class="mx-auto max-w-3xl">

                {{-- Featured image (if present) --}}
                @if ($post->image)
                    <div class="mb-10 overflow-hidden rounded-sm border border-stone-100 shadow-sm">
                        <img
                            src="{{ Storage::disk('public')->url($post->image) }}"
                            alt="{{ $post->title }}"
                            class="w-full object-cover"
                            style="max-height: 480px;"
                        >
                    </div>
                @endif

                {{-- Content --}}
                <div class="prose prose-stone prose-lg max-w-none
                            prose-headings:font-display prose-headings:font-semibold prose-headings:text-stone-900
                            prose-a:text-[#b86033] prose-a:underline-offset-2 hover:prose-a:text-[#6e2f0e]
                            prose-strong:text-stone-900
                            prose-blockquote:border-l-[#b86033] prose-blockquote:text-stone-500">
                    {!! nl2br(e($post->content)) !!}
                </div>

                {{-- Back link --}}
                <div class="mt-14 border-t border-stone-100 pt-8">
                    <a href="{{ route('news.list') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-[#b86033] transition hover:text-[#6e2f0e]">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/></svg>
                        Back to News &amp; Publications
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== RELATED POSTS ===== --}}
    @if ($related->isNotEmpty())
        <section class="bg-stone-50 py-16 border-t border-stone-100">
            <div class="page-grid">
                <div class="mb-8">
                    <span class="eyebrow-light">More to read</span>
                    <h2 class="section-title mt-3">Related Posts</h2>
                </div>

                <div class="grid gap-6 md:grid-cols-3">
                    @foreach ($related as $rel)
                        @php $color = $catColors[$rel->category] ?? '#b86033'; @endphp
                        <a href="{{ route('news.show', $rel->slug) }}" class="group flex flex-col overflow-hidden rounded-sm border border-stone-200 bg-white shadow-sm transition hover:shadow-md">
                            <div class="relative h-40 overflow-hidden" style="background: linear-gradient(135deg, {{ $color }}ee 0%, {{ $color }}88 100%);">
                                @if ($rel->image)
                                    <img src="{{ Storage::disk('public')->url($rel->image) }}" alt="{{ $rel->title }}" class="absolute inset-0 h-full w-full object-cover transition duration-500 group-hover:scale-105">
                                    <div class="absolute inset-0" style="background: linear-gradient(to top, {{ $color }}bb 0%, transparent 60%);"></div>
                                @endif
                                <div class="absolute bottom-3 left-4">
                                    <span class="rounded-sm border border-white/30 bg-white/20 px-2 py-0.5 text-[0.6rem] font-semibold uppercase tracking-widest text-white backdrop-blur-sm">{{ $rel->category }}</span>
                                </div>
                            </div>
                            <div class="flex flex-1 flex-col p-5">
                                <p class="text-[0.65rem] font-medium uppercase tracking-widest text-stone-400">{{ $rel->published_at->format('d M Y') }}</p>
                                <h3 class="mt-2 font-display text-sm font-semibold leading-snug text-stone-900 transition group-hover:text-[#b86033] line-clamp-2">{{ $rel->title }}</h3>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

@endsection
