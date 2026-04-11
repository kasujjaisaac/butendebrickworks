@extends('layouts.site')

@section('content')

    {{-- HERO --}}
    <section class="relative overflow-hidden bg-[#6e2f0e] py-16 md:py-24">
        <div class="absolute inset-0 bg-[linear-gradient(135deg,#4a1e08_0%,#6e2f0e_50%,#8a3c12_100%)]"></div>
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(255,255,255,0.06),transparent_55%)]"></div>
        <div class="absolute inset-0 opacity-[0.03]" style="background-image:repeating-linear-gradient(0deg,#fff 0px,#fff 18px,transparent 18px,transparent 36px),repeating-linear-gradient(90deg,#fff 0px,#fff 1px,transparent 1px,transparent 60px);"></div>
        <div class="page-grid relative">
            <nav class="mb-6 flex items-center gap-2 text-xs text-white/50" aria-label="Breadcrumb">
                <a href="/" class="transition hover:text-white/80">Home</a>
                <svg class="h-3 w-3 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                <span class="text-white/80">Products Calculator</span>
            </nav>
            <div class="max-w-2xl">
                <span class="inline-block rounded-sm border border-white/25 bg-white/10 px-3 py-1 text-[0.68rem] font-semibold uppercase tracking-[0.28em] text-white/80">Free Tool</span>
                <h1 class="mt-4 font-display text-3xl font-semibold leading-snug tracking-tight text-white md:text-4xl">
                    How many bricks does your project need?
                </h1>
                <p class="mt-4 max-w-lg text-base leading-7 text-white/65">
                    Select a product, enter your area, and get an instant estimate. No sign-up required.
                    When you are ready, create a free account to save your quotation and place an order.
                </p>
            </div>
        </div>
    </section>

    {{-- CALCULATOR SECTION --}}
    <section class="page-grid py-16">
        <div class="mx-auto max-w-3xl">
            <div class="overflow-hidden rounded-xl border border-stone-200 bg-white shadow-md">

                {{-- Card header --}}
                <div class="border-b border-stone-100 bg-stone-50 px-8 py-5 flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-[#b86033]/10">
                        <svg class="h-5 w-5 text-[#b86033]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 15.75V18m-7.5-6.75h.008v.008H8.25v-.008Zm0 2.25h.008v.008H8.25V13.5Zm0 2.25h.008v.008H8.25v-.008Zm0 2.25h.008v.008H8.25V18Zm2.498-6.75h.007v.008h-.007v-.008Zm0 2.25h.007v.008h-.007V13.5Zm0 2.25h.007v.008h-.007v-.008Zm0 2.25h.007v.008h-.007V18Zm2.504-6.75h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V13.5Zm0 2.25h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V18Zm2.498-6.75h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V13.5ZM8.25 6h7.5v2.25h-7.5V6ZM12 2.25c-1.892 0-3.758.11-5.593.322C5.307 2.7 4.5 3.616 4.5 4.698V18a2.25 2.25 0 0 0 2.25 2.25h10.5A2.25 2.25 0 0 0 19.5 18V4.698c0-1.082-.807-1.998-1.907-2.126A48.32 48.32 0 0 0 12 2.25Z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-stone-900">Instant Cost Estimator</p>
                        <p class="text-sm text-stone-500">Results update live as you type</p>
                    </div>
                </div>

                <div class="px-8 py-8 space-y-6">

                    @if ($products->isEmpty())
                        <div class="rounded-lg border border-amber-200 bg-amber-50 px-6 py-5 text-center text-sm text-amber-800">
                            No products are currently available. Please check back soon.
                        </div>
                    @else

                        {{-- Step 1: Product --}}
                        <div>
                            <label class="block text-sm font-semibold text-stone-700 mb-1.5">
                                1. Select a product <span class="text-red-500">*</span>
                            </label>
                            <div class="grid gap-3 sm:grid-cols-2" id="product-cards">
                                @foreach ($products as $prod)
                                    <label class="product-card group relative flex cursor-pointer items-start gap-3 rounded-xl border-2 border-stone-200 p-4 transition hover:border-[#b86033]/50"
                                           data-id="{{ $prod->id }}"
                                           data-coverage="{{ $prod->coverage }}"
                                           data-name="{{ $prod->name }}">
                                        <input type="radio" name="_product_select" value="{{ $prod->id }}" class="sr-only product-radio">

                                        {{-- Product image --}}
                                        @if ($prod->image)
                                            <img src="{{ Storage::url($prod->image) }}" alt="{{ $prod->name }}"
                                                 class="h-14 w-14 rounded-lg object-cover border border-stone-200 shrink-0">
                                        @else
                                            <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-lg bg-stone-100 text-stone-400">
                                                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"/></svg>
                                            </div>
                                        @endif

                                        <div class="min-w-0 flex-1">
                                            <p class="font-semibold text-stone-900 text-sm leading-tight">{{ $prod->name }}</p>
                                            @if ($prod->category)
                                                <p class="mt-0.5 text-xs text-stone-400">{{ $prod->category }}</p>
                                            @endif

                                            {{-- Specs mini-table --}}
                                            <table class="mt-2 w-full text-xs text-stone-600 border-collapse">
                                                @if ($prod->dimensions_inch)
                                                    <tr>
                                                        <td class="py-0.5 text-stone-400 pr-2">Dimensions</td>
                                                        <td class="py-0.5 font-medium font-mono">{{ $prod->formatted_dimensions }}&Prime;</td>
                                                    </tr>
                                                @endif
                                                @if ($prod->weight_kg)
                                                    <tr>
                                                        <td class="py-0.5 text-stone-400 pr-2">Weight</td>
                                                        <td class="py-0.5 font-medium">{{ $prod->weight_kg }} kg</td>
                                                    </tr>
                                                @endif
                                                @if ($prod->coverage > 0)
                                                    <tr>
                                                        <td class="py-0.5 text-stone-400 pr-2">Coverage</td>
                                                        <td class="py-0.5 font-medium">{{ number_format($prod->coverage, 4) }} m²/unit</td>
                                                    </tr>
                                                @endif
                                            </table>
                                        </div>

                                        {{-- Selected indicator --}}
                                        <div class="card-check absolute top-3 right-3 hidden h-5 w-5 items-center justify-center rounded-full bg-[#b86033]">
                                            <svg class="h-3 w-3 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Step 2: Area --}}
                        <div>
                            <label for="calc_sqm" class="block text-sm font-semibold text-stone-700 mb-1.5">
                                2. Enter the area you want to cover <span class="text-red-500">*</span>
                            </label>
                            <div class="relative max-w-xs">
                                <input type="number" id="calc_sqm" min="0.01" step="0.01" placeholder="e.g. 50"
                                       class="w-full rounded-xl border border-stone-300 px-5 py-3 pr-14 text-stone-900 text-base shadow-sm focus:border-[#b86033] focus:ring-2 focus:ring-[#b86033]/20 focus:outline-none">
                                <span class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-sm font-semibold text-stone-400">m²</span>
                            </div>
                            <p class="mt-1.5 text-xs text-stone-400">Enter the total floor or wall area in square metres.</p>
                        </div>

                        {{-- Result panel --}}
                        <div id="calc-result" class="hidden rounded-xl border-2 border-[#b86033]/30 bg-[#fff8f4] p-6">
                            <p class="text-xs font-semibold uppercase tracking-widest text-[#b86033] mb-4">Your Estimate</p>
                            <div class="flex items-center gap-4 mb-5">
                                <div class="flex-1 rounded-xl bg-white border border-stone-200 px-6 py-5 text-center">
                                    <p class="text-xs font-medium text-stone-500 mb-1">Units Required</p>
                                    <p id="res-units" class="text-4xl font-extrabold text-stone-900">—</p>
                                    <p id="res-product-name" class="text-xs text-stone-400 mt-1 truncate">—</p>
                                </div>
                                <div class="flex-1 rounded-xl bg-white border border-stone-200 px-6 py-5 text-center">
                                    <p class="text-xs font-medium text-stone-500 mb-1">Area to Cover</p>
                                    <p id="res-area" class="text-4xl font-extrabold text-stone-900">—</p>
                                    <p class="text-xs text-stone-400 mt-1">square metres</p>
                                </div>
                            </div>

                            <p class="text-xs text-stone-500 border-t border-stone-200 pt-4 mb-4">
                                * This is an estimate. Actual quantities may vary based on mortar joints, waste, and laying pattern.
                                Contact us to get a formal quotation with confirmed pricing.
                            </p>

                            {{-- CTA --}}
                            <div class="flex flex-col items-center gap-3 sm:flex-row">
                                @auth
                                    <a id="portal-cta" href="{{ route('quotation.create') }}"
                                       class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-xl bg-[#b86033] px-6 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-[#a0532b]">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z"/></svg>
                                        Save Official Quotation
                                    </a>
                                    <p class="text-xs text-stone-500 text-center">This will save your estimate as a formal quotation in your portal.</p>
                                @else
                                    <a id="portal-cta" href="{{ route('register') }}"
                                       class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-xl bg-[#b86033] px-6 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-[#a0532b]">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/></svg>
                                        Create free account &amp; save quotation
                                    </a>
                                    <a id="login-cta" href="{{ route('login') }}"
                                       class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-xl border border-stone-300 bg-white px-6 py-3 text-sm font-semibold text-stone-700 transition hover:bg-stone-50">
                                        Already have an account? Sign in
                                    </a>
                                @endauth
                            </div>
                        </div>

                    @endif
                </div>
            </div>

            {{-- How it works --}}
            <div class="mt-12">
                <h2 class="text-center text-lg font-bold text-stone-900 mb-8">How it works</h2>
                <div class="grid gap-6 sm:grid-cols-3">
                    @foreach ([['1', 'Select your product', 'Choose from our range of bricks, tiles, or blocks.'], ['2', 'Enter your area', 'Tell us the total square metres you need to cover.'], ['3', 'Save & order', 'Create a free account to get a formal quotation and place your order.']] as [$num, $title, $body])
                        <div class="rounded-xl border border-stone-200 bg-white p-6 text-center">
                            <div class="mx-auto mb-4 flex h-10 w-10 items-center justify-center rounded-full bg-[#b86033] text-base font-bold text-white">
                                {{ $num }}
                            </div>
                            <h3 class="font-semibold text-stone-900">{{ $title }}</h3>
                            <p class="mt-2 text-sm text-stone-500 leading-relaxed">{{ $body }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
    <script>
    (function () {
        const cards    = document.querySelectorAll('.product-card');
        const sqmInput = document.getElementById('calc_sqm');
        const result   = document.getElementById('calc-result');
        const resUnits = document.getElementById('res-units');
        const resArea  = document.getElementById('res-area');
        const resName  = document.getElementById('res-product-name');
        const ctaEl    = document.getElementById('portal-cta');

        let selected = null;

        function calculate() {
            if (!selected) return;
            const sqm = parseFloat(sqmInput.value);
            if (isNaN(sqm) || sqm <= 0) { result.classList.add('hidden'); return; }

            const coverage = parseFloat(selected.dataset.coverage);
            let units;

            if (coverage > 0) {
                units = Math.ceil(sqm / coverage);
            } else {
                // fallback: assume 60 per m²
                units = Math.ceil(sqm * 60);
            }

            resUnits.textContent = units.toLocaleString('en-UG');
            resArea.textContent  = sqm.toLocaleString('en-UG');
            resName.textContent  = selected.dataset.name;

            // Update CTA link to pre-fill the portal form
            if (ctaEl) {
                const base = ctaEl.href.split('?')[0];
                ctaEl.href = base + '?product_id=' + selected.dataset.id + '&sqm=' + sqm;
            }

            result.classList.remove('hidden');
        }

        cards.forEach(function (card) {
            card.addEventListener('click', function () {
                // Deselect all
                cards.forEach(function (c) {
                    c.classList.remove('border-[#b86033]', 'bg-[#fff8f4]');
                    c.classList.add('border-stone-200');
                    c.querySelector('.card-check').classList.add('hidden');
                    c.querySelector('.card-check').classList.remove('flex');
                });

                // Select clicked
                card.classList.remove('border-stone-200');
                card.classList.add('border-[#b86033]', 'bg-[#fff8f4]');
                const check = card.querySelector('.card-check');
                check.classList.remove('hidden');
                check.classList.add('flex');

                selected = card;
                calculate();
            });
        });

        sqmInput.addEventListener('input', calculate);
    })();
    </script>
    @endpush

@endsection
