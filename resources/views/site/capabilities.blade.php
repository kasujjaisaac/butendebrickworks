@extends('layouts.site')

@section('content')

    {{-- ===== HERO ===== --}}
    <section class="relative overflow-hidden bg-[#6e2f0e] py-16 md:py-20">
        <div class="absolute inset-0 bg-[linear-gradient(135deg,#4a1e08_0%,#6e2f0e_50%,#8a3c12_100%)]"></div>
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(255,255,255,0.06),transparent_55%)]"></div>
        <div class="page-grid relative">
            <nav class="mb-6 flex items-center gap-2 text-xs text-white/55" aria-label="Breadcrumb">
                <a href="/" class="transition hover:text-white/90">Home</a>
                <svg class="h-3 w-3 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                <span class="text-white/90">Products Capabilities</span>
            </nav>
            <div class="max-w-2xl">
                <span class="inline-block rounded-sm border border-white/25 bg-white/10 px-3 py-1 text-[0.68rem] font-semibold uppercase tracking-[0.28em] text-white/80">Products Capabilities</span>
                <h1 class="mt-4 font-display text-3xl font-semibold leading-snug tracking-tight text-white md:text-4xl">
                    What our fired clay products have built.
                </h1>
            </div>
        </div>
    </section>

    {{-- ===== PRODUCTS IN USE ===== --}}
    @if($projectsInUse)
        @php $project = $projectsInUse[0]; @endphp
        <script type="application/json" id="projects-data">@json([$project])</script>

        <div
            x-data="projectGallery()"
            @keydown.escape.window="close()"
            @keydown.arrow-left.window="if(lightbox) step(-1)"
            @keydown.arrow-right.window="if(lightbox) step(1)"
        >

            {{-- Gallery section --}}
            <section class="bg-stone-50 py-16">
                <div class="page-grid">

                    {{-- Section heading --}}
                    <div class="max-w-2xl">
                        <span class="eyebrow-light">Products in use</span>
                        <h2 class="section-title mt-5">What our products have built.</h2>
                        <p class="mt-4 text-base leading-7 text-stone-600">Real projects across the Greater Masaka Region — homes, schools, churches, and community buildings constructed with Butende fired clay products.</p>
                    </div>

                    {{-- Single project display --}}
                    <div class="mt-8">
                        <article
                            class="group relative overflow-hidden rounded-sm bg-stone-200 cursor-pointer max-w-md mx-auto"
                            @click="openLightbox(0)"
                            @keydown.enter="openLightbox(0)"
                            role="button"
                            tabindex="0"
                            aria-label="View photo: {{ $project['caption'] }}"
                        >
                            <div class="aspect-[4/3] overflow-hidden">
                                <img
                                    src="{{ $project['image'] }}"
                                    alt="{{ $project['caption'] }}"
                                    class="h-full w-full object-cover transition duration-700 group-hover:scale-[1.04]"
                                    loading="lazy"
                                >
                            </div>

                            {{-- Product badge — top-left, always visible --}}
                            <span class="absolute left-0 top-0 rounded-br-sm bg-black/45 px-2.5 py-1 text-[0.58rem] font-semibold uppercase tracking-[0.16em] text-white backdrop-blur-[2px]">{{ $project['product'] }}</span>

                            {{-- Expand icon — top-right, on hover --}}
                            <div class="absolute right-2.5 top-2.5 rounded-sm bg-black/35 p-1.5 opacity-0 backdrop-blur-[2px] transition duration-200 group-hover:opacity-100" aria-hidden="true">
                                <svg class="h-3.5 w-3.5 text-white" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75h5.25m-5.25 0v5.25m0-5.25 5.25 5.25M20.25 20.25h-5.25m5.25 0v-5.25m0 5.25-5.25-5.25"/></svg>
                            </div>

                            {{-- Bottom caption strip --}}
                            <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent p-4 pt-10">
                                <div class="flex items-end justify-between gap-3">
                                    <p class="text-sm font-medium leading-snug text-white drop-shadow">{{ $project['caption'] }}</p>
                                    <span class="shrink-0 rounded-sm bg-[#b86033] px-2.5 py-1 text-[0.58rem] font-semibold uppercase tracking-[0.16em] text-white">{{ $project['tag'] }}</span>
                                </div>
                            </div>
                        </article>
                    </div>

                </div>
            </section>

            {{-- ===== LIGHTBOX ===== --}}
            <div
                x-cloak
                x-show="lightbox !== null"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 z-[100] flex flex-col bg-black/95"
                @click.self="close()"
                role="dialog"
                aria-modal="true"
                aria-label="Photo viewer"
            >
                {{-- Top bar: counter + close --}}
                <div class="flex shrink-0 items-center justify-between px-5 py-4">
                    <span class="text-xs font-medium text-white/40" x-text="lightbox ? lightbox.tag : ''"></span>
                    <button
                        @click="close()"
                        class="flex h-10 w-10 items-center justify-center rounded-full bg-white/10 text-white transition hover:bg-white/20 focus:outline-none"
                        aria-label="Close photo viewer"
                    >
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                {{-- Image — fills remaining space --}}
                <div class="relative flex flex-1 items-center justify-center overflow-hidden px-14">
                    <img
                        :src="lightbox ? lightbox.image : ''"
                        :alt="lightbox ? lightbox.caption : ''"
                        class="max-h-full max-w-full object-contain"
                    >
                </div>

                {{-- Caption bar --}}
                <div class="shrink-0 border-t border-white/10 px-6 py-5">
                    <div class="mx-auto flex max-w-3xl items-center justify-between gap-6">
                        <div>
                            <p class="text-sm font-semibold text-white" x-text="lightbox ? lightbox.caption : ''"></p>
                            <p class="mt-1 text-xs text-white/45" x-text="lightbox ? lightbox.product : ''"></p>
                        </div>
                        <span
                            class="shrink-0 rounded-sm bg-[#b86033] px-3 py-1.5 text-[0.62rem] font-semibold uppercase tracking-[0.18em] text-white"
                            x-text="lightbox ? lightbox.tag : ''"
                        ></span>
                    </div>
                </div>
            </div>

        </div>{{-- end x-data wrapper --}}
    @endif

    {{-- ===== CLOSING CTA ===== --}}
    <section class="bg-[#4a1e08] py-16">
        <div class="page-grid text-center">
            <span class="mx-auto inline-block rounded-sm border border-white/25 bg-white/10 px-3 py-1 text-[0.68rem] font-semibold uppercase tracking-[0.28em] text-white/80">Get started</span>
            <h2 class="section-title mx-auto mt-4 max-w-xl text-white">Ready to build with Butende?</h2>
            <p class="mx-auto mt-4 max-w-lg text-base leading-7 text-white/65">Talk to our team about your project — we supply direct from our kiln in Masaka to construction sites across Uganda.</p>
            <div class="mt-8 flex flex-wrap justify-center gap-4">
                <a href="/contact" class="cta-primary">Talk to us</a>
                <a href="/products" class="rounded-sm border border-white/30 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-white/10">Browse products</a>
            </div>
        </div>
    </section>

@endsection
