@extends('layouts.site')

@section('content')
    {{-- HERO --}}
    <section class="relative overflow-hidden bg-[#6e2f0e] py-16 md:py-20">
        <div class="absolute inset-0 bg-[linear-gradient(135deg,#4a1e08_0%,#6e2f0e_50%,#8a3c12_100%)]"></div>
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(255,255,255,0.06),transparent_55%)]"></div>
        <div class="page-grid relative">
            <nav class="mb-6 flex items-center gap-2 text-xs text-white/55" aria-label="Breadcrumb">
                <a href="/" class="transition hover:text-white/90">Home</a>
                <svg class="h-3 w-3 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                <a href="{{ route('products.index') }}" class="transition hover:text-white/90">Products</a>
                <svg class="h-3 w-3 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                <span class="text-white/90">{{ $product['name'] }}</span>
            </nav>
            <div class="max-w-2xl">
                <span class="inline-block rounded-sm border border-white/25 bg-white/10 px-3 py-1 text-[0.68rem] font-semibold uppercase tracking-[0.28em] text-white/80">Product Family</span>
                <h1 class="mt-4 font-display text-3xl font-semibold leading-snug tracking-tight text-white md:text-4xl">
                    {{ $product['name'] }}
                </h1>
                <p class="mt-4 text-base leading-7 text-white/70">{{ $product['tagline'] }}</p>
                <div class="mt-7 flex flex-wrap gap-3">
                    <a href="{{ route('products.index') }}"
                       class="inline-flex items-center gap-2 rounded-lg bg-white px-5 py-2.5 text-sm font-semibold text-[#6e2f0e] shadow transition hover:bg-stone-50">
                        Browse Catalogue
                    </a>
                    <a href="{{ route('calculator') }}"
                       class="inline-flex items-center gap-2 rounded-lg border border-white/30 bg-white/10 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-white/20">
                        Calculate Quantities
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- PROFILES GRID --}}
    @if (! empty($product['profiles']))
        <section class="border-t border-stone-100 bg-stone-50 py-14">
            <div class="page-grid">
                <div class="mb-8">
                    <h2 class="font-display text-2xl font-semibold tracking-tight text-stone-900">{{ $product['name'] }} Profiles</h2>
                    <p class="mt-1.5 text-sm text-stone-500">{{ count($product['profiles']) }} profiles available in this family</p>
                </div>
                <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-5">
                    @foreach ($product['profiles'] as $profile)
                        <div class="group flex flex-col overflow-hidden rounded-xl border border-stone-200 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-md">
                            <div class="aspect-square overflow-hidden bg-stone-100">
                                <img
                                    src="{{ $profile['image'] ?? $product['image'] }}"
                                    alt="{{ $profile['name'] }}"
                                    class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.06]"
                                >
                            </div>
                            <div class="p-3">
                                <p class="text-xs font-semibold leading-snug text-stone-900">{{ $profile['name'] }}</p>
                                @if (! empty($profile['description']))
                                    <p class="mt-1 text-[0.68rem] leading-4 text-stone-500">{{ $profile['description'] }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-10 text-center">
                    <a href="{{ route('products.index') }}"
                       class="inline-flex items-center gap-2 rounded-lg border border-stone-300 bg-white px-5 py-2.5 text-sm font-semibold text-stone-700 shadow-sm transition hover:bg-stone-50">
                        ← Back to all products
                    </a>
                </div>
            </div>
        </section>
    @endif

    {{-- RELATED FAMILIES --}}
    @if (! empty($relatedProducts))
        <section class="border-t border-stone-100 py-14">
            <div class="page-grid">
                <h2 class="mb-7 font-display text-xl font-semibold tracking-tight text-stone-900">Other Product Families</h2>
                <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($relatedProducts as $rel)
                        <a href="{{ $rel['path'] }}"
                           class="group flex items-center gap-4 overflow-hidden rounded-xl border border-stone-200 bg-white p-4 shadow-sm transition duration-300 hover:-translate-y-0.5 hover:shadow-md">
                            <div class="h-16 w-16 shrink-0 overflow-hidden rounded-lg bg-stone-100">
                                <img src="{{ $rel['image'] }}" alt="{{ $rel['name'] }}"
                                     class="h-full w-full object-cover transition duration-300 group-hover:scale-[1.05]">
                            </div>
                            <div class="min-w-0">
                                <p class="font-semibold text-stone-900">{{ $rel['name'] }}</p>
                                <p class="mt-0.5 text-xs text-stone-500 line-clamp-2">{{ $rel['tagline'] }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

@endsection
