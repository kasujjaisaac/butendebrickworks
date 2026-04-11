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
                <span class="text-white/90">Products</span>
            </nav>
            <div class="max-w-2xl">
                <span class="inline-block rounded-sm border border-white/25 bg-white/10 px-3 py-1 text-[0.68rem] font-semibold uppercase tracking-[0.28em] text-white/80">Our Products</span>
                <h1 class="mt-4 font-display text-3xl font-semibold leading-snug tracking-tight text-white md:text-4xl">
                    Clay products for projects that need structure, beauty, and long service life.
                </h1>
                <p class="mt-4 text-base leading-7 text-white/70">
                    Every product is fired clay — durable, warm, and built to last in Uganda's climate.
                </p>
            </div>

            {{-- Category quick-jump --}}
            @if ($grouped->isNotEmpty())
                <div class="mt-8 flex flex-wrap gap-2">
                    @foreach ($grouped->keys() as $cat)
                        <a href="#cat-{{ Str::slug($cat) }}"
                           class="rounded-full border border-white/25 bg-white/10 px-3.5 py-1.5 text-xs font-semibold text-white/80 transition hover:bg-white/20 hover:text-white">
                            {{ $cat }}
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- CATALOGUE --}}
    @if ($products->isEmpty())
        <section class="page-grid py-24 text-center">
            <div class="mx-auto max-w-sm">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-stone-100 text-stone-400">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z"/></svg>
                </div>
                <p class="mt-4 text-lg font-semibold text-stone-900">Products coming soon</p>
                <p class="mt-2 text-sm leading-6 text-stone-500">Our catalogue is being updated. Contact us directly to enquire about available products.</p>
                <a href="{{ route('contact') }}" class="mt-6 inline-flex items-center gap-2 rounded-lg bg-[#6e2f0e] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#8c3d12]">Contact Us</a>
            </div>
        </section>
    @else
        @foreach ($grouped as $category => $catProducts)
            <section id="cat-{{ Str::slug($category) }}" class="border-t border-stone-100 py-12 first:border-t-0">
                <div class="page-grid">

                    {{-- Category heading --}}
                    <div class="mb-6 flex items-center justify-between gap-4 rounded bg-[#6e2f0e] px-5 py-3">
                        <h2 class="font-display text-lg font-semibold tracking-tight text-white">{{ $category }}</h2>
                        <p class="shrink-0 text-xs text-white/70">{{ $catProducts->count() }} {{ Str::plural('product', $catProducts->count()) }}</p>
                    </div>

                    {{-- Product cards --}}
                    <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 2xl:grid-cols-7">
                        @foreach ($catProducts as $product)
                            <article class="group flex flex-col overflow-hidden rounded-lg border border-stone-200 bg-white shadow-sm transition duration-200 hover:border-[#b86033]/40 hover:shadow-md">

                                {{-- Image --}}
                                <a href="{{ route('products.show', $product) }}" class="flex items-start justify-center aspect-square overflow-hidden bg-white">
                                    @if ($product->image)
                                        <img src="{{ Storage::url($product->image) }}"
                                            alt="{{ $product->name }}"
                                            style="width:50%;height:50%;"
                                            class="mx-auto object-contain -mb-2 transition duration-500 group-hover:scale-[1.04]">
                                    @else
                                        <div class="flex h-full w-full items-center justify-center">
                                            <svg class="h-8 w-8 text-stone-300" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"/></svg>
                                        </div>
                                    @endif
                                </a>

                                {{-- Body --}}
                                <div class="flex flex-1 flex-col bg-stone-50 p-2.5">

                                    {{-- Name --}}
                                    <a href="{{ route('products.show', $product) }}"
                                       class="text-center text-sm font-semibold leading-snug text-black transition group-hover:text-[#6e2f0e] line-clamp-2">{{ $product->name }}</a>

                                    {{-- Description --}}
                                    @if ($product->description)
                                        <p class="mt-1 text-xs leading-5 text-stone-500 line-clamp-2">{{ $product->description }}</p>
                                    @endif

{{-- Specs table --}}
                                        @if ($product->dimensions_inch || $product->weight_kg || $product->coverage)
                                            <table class="mt-auto mt-2 w-full border-t border-stone-100 pt-2 text-[14px]">
                                                <tbody>
                                                    @if ($product->dimensions_inch)
                                                        <tr class="border-b border-stone-100">
                                                            <td class="py-0.5 pr-1 text-[14px] font-medium tracking-wide text-stone-400">Size</td>
                                                            <td class="py-0.5 font-mono text-[14px] font-semibold text-black">{{ $product->formatted_dimensions }}&Prime;</td>
                                                        </tr>
                                                    @endif
                                                    @if ($product->weight_kg)
                                                        <tr class="border-b border-stone-100">
                                                            <td class="py-0.5 pr-1 text-[14px] font-medium tracking-wide text-stone-400">Weight</td>
                                                            <td class="py-0.5 font-mono text-[14px] font-semibold text-black">{{ rtrim(rtrim(number_format($product->weight_kg, 1, '.', ''), '0'), '.') }}&thinsp;kg</td>
                                                        </tr>
                                                    @endif
                                                    @if ($product->coverage)
                                                        <tr>
                                                            <td class="py-0.5 pr-1 text-[14px] font-medium tracking-wide text-stone-400">Coverage</td>
                                                            <td class="py-0.5 font-mono text-[14px] font-semibold text-black">{{ (int) $product->coverage }}&thinsp;m²</td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        @endif
                                        <a href="{{ route('products.show', $product) }}"
                                           class="mt-2 flex w-full items-center justify-center gap-1 rounded bg-[#b86033] py-1.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#6e2f0e]">
                                            View details
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
                                        </a>

                                </div>
                            </article>
                        @endforeach
                    </div>

                </div>
            </section>
        @endforeach
    @endif

@endsection
