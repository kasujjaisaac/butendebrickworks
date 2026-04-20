@extends('layouts.site')

@section('content')
    {{-- HERO --}}
    <section class="relative overflow-hidden bg-[#6e2f0e] py-14 md:py-18">
        <div class="absolute inset-0 bg-[linear-gradient(135deg,#4a1e08_0%,#6e2f0e_50%,#8a3c12_100%)]"></div>
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(255,255,255,0.06),transparent_55%)]"></div>
        <div class="page-grid relative">
            <nav class="mb-5 flex items-center gap-2 text-xs text-white/55" aria-label="Breadcrumb">
                <a href="/" class="transition hover:text-white/90">Home</a>
                <svg class="h-3 w-3 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                <a href="{{ route('products.index') }}" class="transition hover:text-white/90">Products</a>
                <svg class="h-3 w-3 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                <span class="text-white/90">{{ $product->name }}</span>
            </nav>
            <div class="max-w-2xl">
                    @if ($product->category)
                        <span class="inline-block rounded-sm border border-white/25 bg-white/10 px-3 py-1 text-[0.68rem] font-semibold uppercase tracking-[0.28em] text-white/80">{{ $product->category }}</span>
                    @endif
                    <h1 class="mt-3 font-display text-3xl font-semibold leading-snug tracking-tight text-white md:text-4xl">
                        {{ $product->name }}
                    </h1>
                @if ($product->description)
                    <p class="mt-4 text-base leading-7 text-white/70">{{ $product->description }}</p>
                @endif

                {{-- Hero CTA --}}
                <div class="mt-7 flex flex-wrap gap-3">
                    @auth
                        <a href="{{ route('quotation.create', ['product_id' => $product->id]) }}"
                           class="inline-flex items-center gap-2 rounded-sm bg-white px-5 py-2.5 text-sm font-semibold text-[#6e2f0e] shadow transition hover:bg-stone-50">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/></svg>
                            Request a Quote
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="inline-flex items-center gap-2 rounded-sm bg-white px-5 py-2.5 text-sm font-semibold text-[#6e2f0e] shadow transition hover:bg-stone-50">
                            Request a Quote
                        </a>
                    @endauth
                    <a href="{{ route('calculator') }}"
                       class="inline-flex items-center gap-2 rounded-sm border border-white/30 bg-white/10 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-white/20">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 15.75V18m-7.5-6.75h.008v.008H8.25v-.008Zm0 2.25h.008v.008H8.25V13.5Zm0 2.25h.008v.008H8.25v-.008Zm0 2.25h.008v.008H8.25V18Zm2.498-6.75h.007v.008h-.007v-.008Zm0 2.25h.007v.008h-.007V13.5Zm0 2.25h.007v.008h-.007v-.008Zm0 2.25h.007v.008h-.007V18Zm2.504-6.75h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V13.5Zm0 2.25h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V18Zm2.498-6.75h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V13.5ZM8.25 6h7.5v2.25h-7.5V6ZM12 2.25c-1.892 0-3.758.11-5.593.322C5.307 2.7 4.5 3.598 4.5 4.564v15.872c0 .966.807 1.864 1.907 1.992C8.242 22.34 10.108 22.5 12 22.5c1.892 0 3.758-.11 5.593-.322 1.1-.128 1.907-1.026 1.907-1.992V4.564c0-.966-.807-1.864-1.907-1.992A48.507 48.507 0 0 0 12 2.25Z"/></svg>
                        Calculate Quantities
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- MAIN CONTENT --}}
    <section class="page-grid py-14">
        <div class="grid gap-10 lg:grid-cols-5">

            {{-- LEFT: Image --}}
            <div class="lg:col-span-3">
                @if ($product->image)
                    <div class="overflow-hidden border border-stone-200 shadow-sm">
                            <img src="{{ asset('images/products/' . basename($product->image)) }}"
                                 alt="{{ $product->name }}"
                                 class="aspect-[4/3] w-full object-cover">
                    </div>
                @else
                    <div class="flex aspect-[4/3] w-full items-center justify-center border border-stone-200 bg-gradient-to-br from-stone-100 to-stone-200">
                        <svg class="h-20 w-20 text-stone-300" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"/></svg>
                    </div>
                @endif
            </div>

            {{-- RIGHT: Specs + CTA --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Specs card --}}
                <div class="overflow-hidden border border-stone-200 bg-white shadow-sm">
                    <div class="border-b border-stone-100 bg-stone-50 px-5 py-3.5">
                        <p class="text-xs font-bold uppercase tracking-widest text-stone-500">Specifications</p>
                    </div>
                    <dl class="divide-y divide-stone-100">
                        @if ($product->category)
                            <div class="flex items-center justify-between px-5 py-3">
                                <dt class="text-xs font-medium text-stone-500">Category</dt>
                                <dd class="text-xs font-semibold text-stone-900">{{ $product->category }}</dd>
                            </div>
                        @endif
                        @if ($product->dimensions_inch)
                            <div class="flex items-center justify-between px-5 py-3">
                                <dt class="text-xs font-medium text-stone-500">Dimensions</dt>
                                <dd class="font-mono text-xs font-semibold text-stone-900">{{ $product->formatted_dimensions }}</dd>
                            </div>
                        @endif
                        @if ($product->weight_kg)
                            <div class="flex items-center justify-between px-5 py-3">
                                <dt class="text-xs font-medium text-stone-500">Weight</dt>
                                <dd class="font-mono text-xs font-semibold text-stone-900">{{ $product->weight_kg }} kg</dd>
                            </div>
                        @endif
                        @if ($product->units_per_square_metre)
                            <div class="flex items-center justify-between px-5 py-3">
                                <dt class="text-xs font-medium text-stone-500">Units per m²</dt>
                                <dd class="font-mono text-xs font-semibold text-stone-900">{{ $product->units_per_square_metre }}</dd>
                            </div>
                        @endif
                        @if ($product->coverage > 0)
                            <div class="flex items-center justify-between px-5 py-3">
                                <dt class="text-xs font-medium text-stone-500">Coverage per unit</dt>
                                <dd class="font-mono text-xs font-semibold text-stone-900">{{ number_format($product->coverage, 4) }} m²</dd>
                            </div>
                        @endif
                        @if ($product->price_per_brick)
                            <div class="flex items-center justify-between bg-[#6e2f0e]/4 px-5 py-3">
                                <dt class="text-xs font-semibold text-stone-700">Price per unit</dt>
                                <dd class="text-sm font-bold text-[#6e2f0e]">UGX {{ number_format($product->price_per_brick, 0) }}</dd>
                            </div>
                        @else
                            <div class="flex items-center justify-between px-5 py-3">
                                <dt class="text-xs font-medium text-stone-500">Price</dt>
                                <dd class="text-xs text-stone-400 italic">Contact us for pricing</dd>
                            </div>
                        @endif
                    </dl>
                </div>

                {{-- CTA card --}}
                <div class="overflow-hidden border border-[#6e2f0e]/20 bg-[#6e2f0e]/5 p-5">
                    <p class="text-sm font-semibold text-stone-900">Ready to order or get a quote?</p>
                    <p class="mt-1 text-xs leading-5 text-stone-600">Use our calculator to estimate quantities, then request a formal quotation from our team.</p>
                    <div class="mt-4 flex flex-col gap-2">
                        @auth
                            <a href="{{ route('quotation.create', ['product_id' => $product->id]) }}"
                               class="flex w-full items-center justify-center gap-2 rounded-sm bg-[#6e2f0e] px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#8c3d12]">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/></svg>
                                Request a Quotation
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                               class="flex w-full items-center justify-center gap-2 rounded-sm bg-[#6e2f0e] px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#8c3d12]">
                                Sign in to Request a Quote
                            </a>
                        @endauth
                        <a href="{{ route('calculator') }}"
                           class="flex w-full items-center justify-center gap-2 rounded-sm border border-stone-300 bg-white px-4 py-2.5 text-sm font-medium text-stone-700 transition hover:bg-stone-50">
                            Calculate Quantities First
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- RELATED PRODUCTS --}}
    @if ($related->isNotEmpty())
        <section class="border-t border-stone-100 bg-stone-50 py-14">
            <div class="page-grid">
                <h2 class="mb-7 font-display text-xl font-semibold tracking-tight text-stone-900">More in {{ $product->category }}</h2>
                <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($related as $rel)
                        <article class="group flex flex-col overflow-hidden border border-stone-200 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-md">
                            <a href="{{ route('products.show', $rel) }}" class="block aspect-[4/3] overflow-hidden bg-stone-100">
                                @if ($rel->image)
                                    <img src="{{ Storage::url($rel->image) }}" alt="{{ $rel->name }}"
                                         class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.04]">
                                @else
                                    <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-stone-100 to-stone-200">
                                        <svg class="h-10 w-10 text-stone-300" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Z"/></svg>
                                    </div>
                                @endif
                            </a>
                            <div class="p-4">
                                <p class="font-semibold text-stone-900 text-sm leading-snug">
                                    <a href="{{ route('products.show', $rel) }}" class="hover:text-[#6e2f0e] transition">{{ $rel->name }}</a>
                                </p>
                                @if ($rel->price_per_brick)
                                    <p class="mt-1 text-xs text-stone-500">UGX {{ number_format($rel->price_per_brick, 0) }}/unit</p>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

@endsection
