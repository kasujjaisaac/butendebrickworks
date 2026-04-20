@extends('layouts.site')

@section('content')

    {{-- ===== HERO ===== --}}
    <section class="relative overflow-hidden bg-[#6e2f0e] py-20 md:py-28">
        <div class="absolute inset-0 bg-[linear-gradient(135deg,#4a1e08_0%,#6e2f0e_50%,#8a3c12_100%)]"></div>
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(255,255,255,0.06),transparent_55%)]"></div>
        {{-- Subtle brick-pattern watermark --}}
        <div class="absolute inset-0 opacity-[0.035]" style="background-image:repeating-linear-gradient(0deg,#fff 0px,#fff 18px,transparent 18px,transparent 36px),repeating-linear-gradient(90deg,#fff 0px,#fff 1px,transparent 1px,transparent 60px);"></div>
        <div class="page-grid relative">
            <nav class="mb-8 flex items-center gap-2 text-xs text-white/50" aria-label="Breadcrumb">
                <a href="/" class="transition hover:text-white/80">Home</a>
                <svg class="h-3 w-3 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                <span class="text-white/80">Opportunities</span>
            </nav>
            <div class="grid gap-10 lg:grid-cols-[1fr_auto] lg:items-end">
                <div class="max-w-2xl">
                    <span class="inline-block rounded-sm border border-white/25 bg-white/10 px-3 py-1 text-[0.68rem] font-semibold uppercase tracking-[0.28em] text-white/80">Join the team</span>
                    <h1 class="mt-5 font-display text-4xl font-semibold leading-tight tracking-tight text-white md:text-5xl">
                        Build with us<br class="hidden sm:block"> beyond the production line.
                    </h1>
                    <p class="mt-5 max-w-xl text-base leading-7 text-white/70">{{ $opportunities['intro'] }}</p>
                </div>
                {{-- Quick-stats strip --}}
                <div class="hidden lg:grid lg:grid-cols-2 lg:gap-px lg:rounded-sm lg:overflow-hidden lg:border lg:border-white/15">
                    @foreach ($opportunities['values'] as $v)
                        <div class="bg-white/8 px-6 py-4 text-center backdrop-blur-sm">
                            <p class="font-display text-2xl font-bold text-white">{{ $v['stat'] }}</p>
                            <p class="mt-0.5 text-[0.65rem] font-semibold uppercase tracking-widest text-white/50">{{ $v['label'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- ===== STATUS BANNER ===== --}}
    <div class="border-b border-stone-200 bg-stone-100">
        <div class="page-grid flex flex-wrap items-center gap-4 py-4 text-sm">
            <span class="flex items-center gap-2 font-medium text-stone-500">
                <span class="inline-block h-2 w-2 rounded-full bg-stone-400"></span>
                No current opportunities available
            </span>
            <span class="ml-auto text-stone-400">Last reviewed April 2026</span>
        </div>
    </div>

    {{-- ===== PARTNERSHIP PATHWAYS ===== --}}
    <section class="bg-stone-50 py-20">
        <div class="page-grid">
            <div class="mb-12 grid gap-6 lg:grid-cols-[1fr_auto] lg:items-end">
                <div class="max-w-xl">
                    <span class="eyebrow-light">Work with us</span>
                    <h2 class="section-title mt-4">Partnership pathways.</h2>
                    <p class="mt-4 text-base leading-7 text-stone-500">There is meaningful work to start even when employment openings are not live. If you build, design, or procure — there is a way to work with Butende.</p>
                </div>
                <a href="/contact" class="inline-flex items-center gap-2 self-end rounded-sm bg-[#b86033] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#a0532b]">
                    Start a conversation
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
                </a>
            </div>

            <div class="grid gap-5 md:grid-cols-3">
                @foreach ($opportunities['partnerships'] as $p)
                    <div class="group flex flex-col gap-5 rounded-sm border border-stone-200 bg-white p-7 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                        {{-- Icon circle --}}
                        <div class="flex h-12 w-12 items-center justify-center rounded-sm bg-[#b86033]/10">
                            @if ($p['icon'] === 'building')
                                <svg class="h-6 w-6 text-[#b86033]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z"/></svg>
                            @elseif ($p['icon'] === 'institution')
                                <svg class="h-6 w-6 text-[#b86033]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z"/></svg>
                            @else
                                <svg class="h-6 w-6 text-[#b86033]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/></svg>
                            @endif
                        </div>
                        <div>
                            <h3 class="font-display text-lg font-semibold text-stone-900">{{ $p['title'] }}</h3>
                            <p class="mt-2 text-sm leading-6 text-stone-500">{{ $p['body'] }}</p>
                        </div>
                        <a href="/contact" class="mt-auto inline-flex items-center gap-1.5 text-xs font-semibold uppercase tracking-wide text-[#b86033] transition hover:text-[#a0532b]">
                            Get in touch
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ===== CLOSING CTA ===== --}}
    <section class="bg-[#4a1e08] py-16">
        <div class="page-grid">
            <div class="grid gap-8 lg:grid-cols-[1fr_auto] lg:items-center">
                <div>
                    <span class="inline-block rounded-sm border border-white/25 bg-white/10 px-3 py-1 text-[0.68rem] font-semibold uppercase tracking-[0.28em] text-white/80">Stay connected</span>
                    <h2 class="mt-4 font-display text-2xl font-semibold text-white md:text-3xl">
                        Don't see a fit right now?
                    </h2>
                    <p class="mt-3 max-w-lg text-sm leading-7 text-white/65">Send us your details and we will reach out as soon as a relevant opportunity opens. We are always building.</p>
                </div>
                <div class="flex flex-wrap gap-4">
                    <a href="mailto:{{ $company['emails'][0] }}?subject=Opportunities%20Enquiry%20-%20Butende"
                       class="inline-flex items-center gap-2 rounded-sm bg-[#b86033] px-6 py-3 text-sm font-semibold text-white transition hover:bg-[#a0532b]">
                        Email us directly
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
                    </a>
                    <a href="/contact"
                       class="inline-flex items-center gap-2 rounded-sm border border-white/25 px-6 py-3 text-sm font-semibold text-white transition hover:bg-white/10">
                        Contact page
                    </a>
                </div>
            </div>
        </div>
    </section>

@endsection

