@extends('layouts.site')

@section('content')
    {{-- HERO --}}
    <section class="relative overflow-hidden bg-[#6e2f0e] py-16 md:py-20">
        <div class="absolute inset-0 bg-[linear-gradient(135deg,#4a1e08_0%,#6e2f0e_50%,#8a3c12_100%)]"></div>
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(255,255,255,0.06),transparent_55%)]"></div>
        <div class="page-grid relative">
            {{-- Breadcrumb --}}
            <nav class="mb-6 flex items-center gap-2 text-xs text-white/55" aria-label="Breadcrumb">
                <a href="/" class="transition hover:text-white/90">Home</a>
                <svg class="h-3 w-3 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                <span class="text-white/90">About Us</span>
            </nav>
            <div class="max-w-2xl">
                <span class="inline-block rounded-sm border border-white/25 bg-white/10 px-3 py-1 text-[0.68rem] font-semibold uppercase tracking-[0.28em] text-white/80">About Us</span>
                <h1 class="mt-4 font-display text-3xl font-semibold leading-snug tracking-tight text-white md:text-4xl">
                    A factory story rooted in service, craft, and long-term regional value.
                </h1>
            </div>
        </div>
    </section>

    {{-- OUR BACKGROUND + CARDS --}}
    <section class="page-grid py-20 md:py-28">
        <div class="grid gap-14 lg:grid-cols-[1.1fr_0.9fr] lg:items-start">

            {{-- Left: Our Background --}}
            <div>
                <span class="eyebrow-light">Our background</span>
                <h2 class="mt-5 font-display text-[25px] font-semibold tracking-tight text-stone-950">From durable bricks for schools and churches to a broader clay product partner.</h2>
                <div class="mt-6 space-y-4 text-base leading-8 text-stone-600">
                    @foreach ($company['story'] as $paragraph)
                        <p>{{ $paragraph }}</p>
                    @endforeach
                </div>
            </div>

            {{-- Right: Mission, Vision, History cards --}}
            <div class="flex flex-col gap-5">
                <div class="rounded-sm border border-[#b86033]/20 bg-white p-6 shadow-sm">
                    <p class="text-[0.68rem] font-semibold uppercase tracking-[0.22em] text-[#b86033]">Mission</p>
                    <h3 class="mt-3 font-display text-lg font-semibold text-stone-900">Improve quality and output.</h3>
                    <p class="mt-3 text-sm leading-7 text-stone-500">{{ $company['mission'] }}</p>
                </div>
                <div class="rounded-sm border border-[#b86033]/20 bg-white p-6 shadow-sm">
                    <p class="text-[0.68rem] font-semibold uppercase tracking-[0.22em] text-[#b86033]">Vision</p>
                    <h3 class="mt-3 font-display text-lg font-semibold text-stone-900">Lead through commendable clay products.</h3>
                    <p class="mt-3 text-sm leading-7 text-stone-500">{{ $company['vision'] }}</p>
                </div>
                <div class="rounded-sm border border-[#b86033]/20 bg-white p-6 shadow-sm">
                    <p class="text-[0.68rem] font-semibold uppercase tracking-[0.22em] text-[#b86033]">History</p>
                    <h3 class="mt-3 font-display text-lg font-semibold text-stone-900">Built on a 1967 foundation.</h3>
                    <p class="mt-3 text-sm leading-7 text-stone-500">{{ $company['history'] }}</p>
                </div>
            </div>

        </div>
    </section>


@endsection
