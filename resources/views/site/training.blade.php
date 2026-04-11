@extends('layouts.site')

@section('content')
    {{-- HERO --}}
    <section class="relative overflow-hidden bg-[#6e2f0e] py-16 md:py-20">
        <div class="absolute inset-0 bg-[linear-gradient(135deg,#4a1e08_0%,#6e2f0e_50%,#8a3c12_100%)]"></div>
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(255,255,255,0.06),transparent_55%)]"></div>
        <div class="page-grid relative">
            <nav class="mb-6 flex items-center gap-2 text-xs text-white/55" aria-label="Breadcrumb">
                <a href="/" class="transition hover:text-white/90">Home</a>
                <svg class="h-3 w-3 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                <a href="/opportunities" class="transition hover:text-white/90">Opportunities</a>
                <svg class="h-3 w-3 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                <span class="text-white/90">Training</span>
            </nav>
            <div class="max-w-2xl">
                <span class="inline-block rounded-sm border border-white/25 bg-white/10 px-3 py-1 text-[0.68rem] font-semibold uppercase tracking-[0.28em] text-white/80">Training &amp; Internship</span>
                <h1 class="mt-4 font-display text-3xl font-semibold leading-snug tracking-tight text-white md:text-4xl">
                    We have no current training opening.
                </h1>
            </div>
        </div>
    </section>

    <section class="page-grid mt-16 pb-8">
        <div class="grid gap-6 lg:grid-cols-[1.2fr_0.8fr]">
            <article class="surface-panel p-8">
                <span class="eyebrow">Current status</span>
                <h2 class="mt-5 font-display text-3xl font-semibold text-white">Closed for now, ready for future updates.</h2>
                <p class="mt-5 text-base leading-8 text-stone-300">
                    We have no current training opening. Please keep checking the website for future opportunities.
                </p>
                <p class="mt-4 text-base leading-8 text-stone-300">
                    When the business is ready to promote training placements again, this Laravel structure gives us a focused landing page and a better update path.
                </p>
            </article>

            <article class="surface-panel p-8">
                <span class="eyebrow">Useful next step</span>
                <p class="mt-5 text-sm leading-7 text-stone-300">
                    If you want to express interest or confirm current status, reach out through the contact channels below.
                </p>
                <div class="mt-5 space-y-3 text-sm text-stone-300">
                    <a href="mailto:{{ $company['emails'][0] }}" class="block transition hover:text-white">{{ $company['emails'][0] }}</a>
                    <a href="tel:{{ $company['primary_phone_href'] }}" class="block transition hover:text-white">{{ $company['phones'][0] }}</a>
                    <p>{{ $company['address'] }}</p>
                </div>
            </article>
        </div>
    </section>
@endsection
