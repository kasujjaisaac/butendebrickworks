@extends('layouts.site')

@section('content')
    <section class="relative overflow-hidden bg-[#6e2f0e] py-16 md:py-20">
        <div class="absolute inset-0 bg-[linear-gradient(135deg,#4a1e08_0%,#6e2f0e_50%,#8a3c12_100%)]"></div>
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(255,255,255,0.06),transparent_55%)]"></div>
        <div class="page-grid relative">
            <nav class="mb-6 flex items-center gap-2 text-xs text-white/55" aria-label="Breadcrumb">
                <a href="/" class="transition hover:text-white/90">Home</a>
                <svg class="h-3 w-3 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                <a href="{{ route('products.index') }}" class="transition hover:text-white/90">Products</a>
                <svg class="h-3 w-3 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                <span class="text-white/90">{{ $categoryName }}</span>
            </nav>
            <div class="max-w-2xl">
                <span class="inline-block rounded-sm border border-white/25 bg-white/10 px-3 py-1 text-[0.68rem] font-semibold uppercase tracking-[0.28em] text-white/80">Category</span>
                <h1 class="mt-4 font-display text-3xl font-semibold leading-snug tracking-tight text-white md:text-4xl">
                    {{ $categoryName }}
                </h1>
            </div>
        </div>
    </section>

    @if ($categoryProducts->isEmpty())
        <section class="page-grid py-20 text-center">
            <div class="mx-auto max-w-md border border-stone-200 bg-white px-8 py-12 shadow-sm">
                <p class="text-lg font-semibold text-stone-900">No products yet</p>
                <p class="mt-3 text-sm leading-7 text-stone-500">This category does not have any active products yet.</p>
            </div>
        </section>
    @else
        <section class="page-grid py-8 md:py-10">
            <div class="border border-stone-200 bg-white">
                <div class="border-b border-stone-200 bg-stone-50 px-4 py-3 sm:px-5">
                    <div class="flex items-center justify-between gap-3">
                        <div>
                            <h2 class="text-sm font-semibold text-stone-950 sm:text-base">{{ $categoryName }}</h2>
                            <p class="mt-1 text-[0.68rem] uppercase tracking-[0.16em] text-stone-500">{{ $categoryProducts->count() }} {{ Str::plural('product', $categoryProducts->count()) }}</p>
                        </div>
                        <a href="{{ route('products.index') }}" class="inline-flex items-center gap-1 border border-stone-300 px-2.5 py-2 text-[0.62rem] font-semibold uppercase tracking-[0.14em] text-stone-700 transition hover:border-[#b86033]/35 hover:text-[#8c3d12]">
                            All products
                        </a>
                    </div>
                </div>

                <div class="grid gap-2 p-2 sm:grid-cols-2 sm:gap-3 sm:p-3 lg:grid-cols-3 xl:grid-cols-4">
                    @foreach ($categoryProducts as $product)
                        @include('site.products.partials.product-card', ['product' => $product, 'showCategory' => false])
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
