@extends('layouts.site')

@section('content')

    {{-- Marquee placed above hero, below topbar --}}
    <div class="bg-white">
        <div class="page-grid py-3">
            <div class="overflow-hidden rounded-sm bg-white">
                <div class="animate-marquee flex min-w-full items-center gap-10 px-4 py-3">
                    <span class="text-stone-900 font-normal text-sm sm:text-base whitespace-nowrap">
                        "Welcome to Butende Brick Works! To place an order: Browse products, use our calculator to estimate quantities, then proceed to make your order. Create an account to place and track your orders easily."
                    </span>
                    <span class="text-stone-900 font-normal text-sm sm:text-base whitespace-nowrap">
                        "Welcome to Butende Brick Works! To place an order: Browse products, use our calculator to estimate quantities, then proceed to make your order. Create an account to place and track your orders easily."
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== HERO + CALCULATOR ===== --}}
    <section id="hero" class="relative overflow-hidden bg-[#3d1505]">

        {{-- Background image — full opacity so it shows through the overlay --}}
        <img src="{{ $company['hero_image'] }}" alt="Butende Brick Works"
             class="absolute inset-0 h-full w-full object-cover object-center">

        {{-- Dark theme-colour overlay over the photo --}}
        <div class="absolute inset-0" style="background: rgba(61,21,5,0.82);"></div>

        <div class="page-grid relative py-16 sm:py-20 lg:py-28">
            <div class="grid gap-10 lg:grid-cols-2 lg:gap-16 lg:items-start">

                {{-- ── Left: Brand copy ─────────────────────────── --}}
                <div class="flex flex-col justify-center pt-4 lg:pt-8">
                    <div class="flex flex-wrap items-center gap-3 mb-6">
                        <span class="inline-block rounded-sm border border-white/20 bg-white/10 px-3 py-1 text-[0.68rem] font-semibold uppercase tracking-[0.28em] text-white/80">
                            Since {{ $company['founded'] }}
                        </span>
                        <span class="inline-block rounded-sm border border-[#e8a06a]/30 bg-[#e8a06a]/10 px-3 py-1 text-[0.68rem] font-semibold uppercase tracking-[0.28em] text-[#e8a06a]">
                            Best Clay Products
                        </span>
                    </div>

                    <p class="text-[0.7rem] font-semibold uppercase tracking-[0.3em] text-[#f0d5be]">Build with fired clay confidence</p>
                    <h1 class="mt-3 font-display text-[1.85rem] font-semibold leading-[1.08] tracking-tight text-white sm:text-[2.4rem] lg:text-[3rem]">
                        {{ $heroSlides[0]['headline'] }}
                    </h1>
                    <p class="mt-5 max-w-xl text-[0.97rem] leading-7 text-stone-300">
                        {{ $heroSlides[0]['body'] }}
                    </p>

                    <div class="mt-8 flex flex-wrap gap-3">
                        <a href="/bricks" class="inline-flex items-center gap-2 rounded-sm bg-white px-6 py-2.5 text-sm font-semibold text-[#6e2f0e] transition hover:bg-stone-100">Browse Products</a>
                        <a href="/about" class="inline-flex items-center gap-2 rounded-sm border border-white/25 px-6 py-2.5 text-sm font-semibold text-white backdrop-blur-sm transition hover:bg-white/10">About Us</a>
                    </div>
                </div>

                {{-- ── Right: 3-Step Calculator ──────────────────── --}}
                @php
                    $groupedProducts = $calcProducts->groupBy('category');
                    // Only show categories that actually have products
                    $availableCategories = $calcCategories;
                @endphp

                <div x-data="heroCalc({{ $calcProducts->map(fn($p) => [
                    'id'           => $p->id,
                    'name'         => $p->name,
                    'category'     => $p->category,
                    'categoryKey'  => \Illuminate\Support\Str::slug($p->category ?: 'other'),
                    'coverage'     => (float) $p->coverage,
                    'bpsm'         => (int) $p->units_per_square_metre,
                ]) ->values()->toJson() }})"
                     x-init="init()"
                     @keydown.escape.window="closeEstimateModal()"
                     class="relative">

                    <div class="relative overflow-hidden rounded-sm border border-white/15 bg-white/10 shadow-2xl backdrop-blur-md">

                        {{-- Amber top accent --}}
                        <div class="h-0.5 w-full bg-gradient-to-r from-[#e8a06a] via-[#b86033] to-transparent"></div>

                        {{-- Header --}}
                        <div class="flex items-center gap-3 border-b border-white/10 bg-black/15 px-6 py-4">
                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-sm bg-[#e8a06a]/20 border border-[#e8a06a]/20">
                                <svg class="h-4 w-4 text-[#e8a06a]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 15.75V18m-7.5-6.75h.008v.008H8.25v-.008Zm0 2.25h.008v.008H8.25V13.5Zm0 2.25h.008v.008H8.25v-.008Zm0 2.25h.008v.008H8.25V18Zm2.498-6.75h.007v.008h-.007v-.008Zm0 2.25h.007v.008h-.007V13.5Zm0 2.25h.007v.008h-.007v-.008Zm0 2.25h.007v.008h-.007V18Zm2.504-6.75h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V13.5Zm0 2.25h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V18Zm2.498-6.75h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V13.5ZM8.25 6h7.5v2.25h-7.5V6ZM12 2.25c-1.892 0-3.758.11-5.593.322C5.307 2.7 4.5 3.616 4.5 4.698V18a2.25 2.25 0 0 0 2.25 2.25h10.5A2.25 2.25 0 0 0 19.5 18V4.698c0-1.082-.807-1.998-1.907-2.126A48.32 48.32 0 0 0 12 2.25Z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-white">Brick &amp; Product Estimator</p>
                                <p class="text-[11px] text-white/45">Instant quantity estimate</p>
                            </div>
                        </div>

                        <div class="px-6 py-5 space-y-4">

                            {{-- Row 1: Category (full width) --}}
                            <div>
                                <label class="mb-1.5 block text-[10px] font-semibold uppercase tracking-[0.18em] text-white/55">Product Category</label>
                                <div class="relative">
                                    <select x-model="categoryKey" @change="handleCategoryChange($event.target.value)"
                                            class="w-full appearance-none rounded-sm border border-white/20 bg-white/10 px-4 py-2.5 text-sm text-white outline-none transition focus:border-[#e8a06a] focus:ring-1 focus:ring-[#e8a06a]/30">
                                        <option value="" style="background:#3d1505">— Choose a category —</option>
                                        @foreach ($availableCategories as $cat)
                                            @if ($groupedProducts->get($cat, collect())->isNotEmpty())
                                                <option value="{{ \Illuminate\Support\Str::slug(trim($cat)) }}" style="background:#3d1505">{{ $cat }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center">
                                        <svg class="h-4 w-4 text-white/40" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                                    </div>
                                </div>
                            </div>

                            {{-- Row 2: Product + Area on same line --}}
                            <div class="grid grid-cols-2 gap-3">

                                {{-- Product --}}
                                <div>
                                    <label class="mb-1.5 block text-[10px] font-semibold uppercase tracking-[0.18em] transition-colors duration-200"
                                           :class="categoryKey ? 'text-white/55' : 'text-white/25'">Product</label>
                                    <div class="relative">
                                        <select x-ref="productSelect" x-model="selectedProductId" @change="setProductById($event.target.value)" :disabled="!categoryKey"
                                                class="w-full appearance-none rounded-sm border border-white/20 bg-white/10 px-4 py-2.5 text-sm text-white outline-none transition focus:border-[#e8a06a] focus:ring-1 focus:ring-[#e8a06a]/30"
                                                :class="categoryKey ? 'opacity-100 cursor-pointer' : 'opacity-50 cursor-not-allowed'">
                                            <option value="" style="background:#3d1505">— Choose a category first —</option>
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center">
                                            <svg class="h-4 w-4 text-white/40" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                                        </div>
                                    </div>
                                </div>

                                {{-- Area --}}
                                <div>
                                    <label class="mb-1.5 block text-[10px] font-semibold uppercase tracking-[0.18em] transition-colors duration-200"
                                           :class="selectedProduct ? 'text-white/55' : 'text-white/25'">Area (m²)</label>
                                    <div class="relative">
                                        <input type="number" min="0.1" step="0.1" placeholder="e.g. 50"
                                               x-model.number="sqm"
                                               :disabled="!selectedProduct"
                                               @keydown.enter="calculate()"
                                               class="w-full rounded-sm border border-white/20 bg-white/10 px-4 py-2.5 pr-10 text-sm text-white placeholder-white/35 outline-none transition focus:border-[#e8a06a] focus:ring-1 focus:ring-[#e8a06a]/30"
                                               :class="selectedProduct ? 'opacity-100 cursor-text' : 'opacity-50 cursor-not-allowed'">
                                        <span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-[11px] font-bold transition-colors duration-200"
                                              :class="selectedProduct ? 'text-[#e8a06a]/50' : 'text-white/20'">m²</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Calculate button --}}
                            <button type="button" @click="calculate()" :disabled="!selectedProduct || !sqm"
                                    class="w-full rounded-sm px-6 py-2 text-sm font-bold tracking-wide transition-all duration-200 focus:outline-none"
                                    :class="selectedProduct && sqm
                                        ? 'bg-[#e8a06a] text-[#3d1505] hover:bg-[#d4904f] hover:-translate-y-px shadow-md hover:shadow-[0_4px_16px_rgba(232,160,106,0.35)] active:translate-y-0'
                                        : 'bg-[#e8a06a]/20 text-white/50 cursor-not-allowed'">
                                <span class="flex items-center justify-center gap-2">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.59 14.37a6 6 0 0 1-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 0 0 6.16-12.12A14.98 14.98 0 0 0 9.631 8.41m5.96 5.96a14.926 14.926 0 0 1-5.841 2.58m-.119-8.54a6 6 0 0 0-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 0 0-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 0 1-2.448-2.448 14.9 14.9 0 0 1 .06-.312m-2.24 2.39a4.493 4.493 0 0 0-1.757 4.306 4.493 4.493 0 0 0 4.306-1.758M16.5 9a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/></svg>
                                    Calculate Estimate
                                </span>
                            </button>

                        </div>

                        <div class="border-t border-white/8 px-6 pb-4 pt-3">
                        </div>

                    </div>
                    {{-- /calculator --}}

                    <template x-teleport="body">
                        <div
                            x-cloak
                            x-show="showEstimateModal"
                            x-transition:enter="transition ease-out duration-250"
                            x-transition:enter-start="opacity-0"
                            x-transition:enter-end="opacity-100"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0"
                            class="fixed inset-0 z-[120] flex items-center justify-center bg-black/65 p-4"
                            @click.self="closeEstimateModal()"
                        >
                            <div class="w-full max-w-md rounded-sm bg-white shadow-2xl">
                                <div class="flex items-start justify-between gap-4 border-b border-stone-200 px-5 py-4">
                                    <div>
                                        <p class="text-[0.65rem] font-semibold uppercase tracking-[0.22em] text-[#b86033]">Calculation Result</p>
                                        <h3 class="mt-1 text-lg font-semibold text-stone-900">Products needed</h3>
                                    </div>
                                    <button
                                        type="button"
                                        @click="closeEstimateModal()"
                                        class="flex h-9 w-9 items-center justify-center rounded-full bg-stone-100 text-stone-500 transition hover:bg-stone-200 hover:text-stone-900"
                                        aria-label="Close estimator result"
                                    >
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>

                                <div class="space-y-4 px-5 py-5">
                                    <p class="text-sm leading-7 text-stone-700" x-text="customerMessage()"></p>

                                    <div class="grid gap-3 sm:grid-cols-2">
                                        <div class="rounded-sm border border-stone-200 bg-stone-50 px-4 py-3">
                                            <p class="text-[0.62rem] font-semibold uppercase tracking-[0.18em] text-stone-400">Product</p>
                                            <p class="mt-1 text-sm font-semibold text-stone-900" x-text="selectedProduct ? selectedProduct.name : ''"></p>
                                        </div>
                                        <div class="rounded-sm border border-stone-200 bg-stone-50 px-4 py-3">
                                            <p class="text-[0.62rem] font-semibold uppercase tracking-[0.18em] text-stone-400">Construction Area</p>
                                            <p class="mt-1 text-sm font-semibold text-stone-900" x-text="formattedArea()"></p>
                                        </div>
                                    </div>

                                    <div class="rounded-sm border border-[#e8a06a]/35 bg-[#fff6ef] px-4 py-4 text-center">
                                        <p class="text-[0.62rem] font-semibold uppercase tracking-[0.18em] text-[#b86033]">Estimated Quantity</p>
                                        <p class="mt-2 text-3xl font-bold text-[#6e2f0e]" x-text="formattedUnits()"></p>
                                    </div>

                                    <div class="grid gap-3 sm:grid-cols-2">
                                        <a
                                            :href="quoteUrl()"
                                            class="inline-flex items-center justify-center rounded-sm border border-[#b86033] bg-white px-4 py-3 text-sm font-semibold text-[#b86033] transition hover:bg-[#fff5ee]"
                                        >
                                            Ask Quotation
                                        </a>
                                        <a
                                            :href="orderUrl()"
                                            class="inline-flex items-center justify-center rounded-sm bg-[#6e2f0e] px-4 py-3 text-sm font-semibold text-white transition hover:bg-[#55200a]"
                                        >
                                            Make Order Now
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>

            </div>
        </div>
    </section>

@push('scripts')
<script>
function heroCalc(products) {
    const formatter = new Intl.NumberFormat('en-UG');
    const orderBase = @js(route('orders.index'));
    const quoteBase = @js(route('quotation.create'));

    return {
        products,
        categoryKey: '',
        productOptions: [],
        selectedProductId: '',
        selectedProduct: null,
        sqm: '',
        greeting: '',
        result: null,

        init() {
            this.renderProductOptions();
        },

        getSelectedProduct() {
            return this.productOptions.find(product => String(product.id) === String(this.selectedProductId)) || null;
        },

        renderProductOptions() {
            const select = this.$refs.productSelect;

            if (!select) {
                return;
            }

            this.productOptions = this.products.filter(product => product.categoryKey === this.categoryKey);
            select.innerHTML = '';

            const placeholder = document.createElement('option');
            placeholder.value = '';
            placeholder.style.background = '#3d1505';

            if (!this.categoryKey) {
                placeholder.textContent = '— Choose a category first —';
                select.appendChild(placeholder);
                return;
            }

            if (this.productOptions.length === 0) {
                placeholder.textContent = '— No products found —';
                select.appendChild(placeholder);
                return;
            }

            placeholder.textContent = '— Select a product —';
            select.appendChild(placeholder);

            this.productOptions.forEach(product => {
                const option = document.createElement('option');
                option.value = String(product.id);
                option.textContent = product.name;
                option.style.background = '#3d1505';
                select.appendChild(option);
            });
        },

        handleCategoryChange(value = this.categoryKey) {
            this.categoryKey = String(value || '');
            this.selectedProductId = '';
            this.selectedProduct = null;
            this.result = null;
            this.renderProductOptions();
        },

        setProductById(value = this.selectedProductId) {
            this.selectedProductId = String(value || '');
            this.selectedProduct = this.getSelectedProduct();
            this.result = null;
        },

        closeEstimateModal() {
            this.result = null;
            document.body.classList.remove('overflow-hidden');
        },

        getGreeting() {
            const hour = new Date().getHours();

            if (hour < 12) return 'Good morning customer.';
            if (hour < 18) return 'Good afternoon customer.';
            return 'Good evening customer.';
        },

        formattedUnits() {
            return this.result ? formatter.format(this.result.units) : '—';
        },

        formattedArea() {
            return this.sqm ? formatter.format(this.sqm) + ' m²' : '—';
        },

        customerMessage() {
            if (!this.result || !this.selectedProduct) return '';

            return 'Dear customer, as per your desired construction area of ' + this.formattedArea() + ', you will need ' + formatter.format(this.result.units) + ' ' + this.selectedProduct.name + '.';
        },

        orderUrl() {
            if (!this.selectedProduct || !this.result) return orderBase;

            const params = new URLSearchParams({
                product_id: this.selectedProduct.id,
                quantity: this.result.units,
            });

            return orderBase + '?' + params.toString();
        },

        quoteUrl() {
            if (!this.selectedProduct || !this.sqm) return quoteBase;

            const params = new URLSearchParams({
                product_id: this.selectedProduct.id,
                sqm: this.sqm,
            });

            return quoteBase + '?' + params.toString();
        },

        get showEstimateModal() {
            return this.result !== null;
        },

        calculate() {
            this.selectedProduct = this.getSelectedProduct();

            if (!this.selectedProduct || !this.sqm || this.sqm <= 0) {
                this.result = null;
                document.body.classList.remove('overflow-hidden');
                return;
            }

            const coverage = this.selectedProduct.coverage;
            const units = coverage > 0
                ? Math.ceil(this.sqm / coverage)
                : Math.ceil(this.sqm * (this.selectedProduct.bpsm || 60));

            this.greeting = this.getGreeting();
            this.result = { units };
            document.body.classList.add('overflow-hidden');
        }
    };
}
</script>
@endpush

    {{-- ===== Trust Stats Strip ===== --}}
    <div class="relative overflow-hidden border-b border-[#4a1e08] bg-[#6e2f0e]">
        {{-- Dot-grid texture --}}
        <div class="pointer-events-none absolute inset-0 opacity-[0.07]" style="background-image:radial-gradient(circle,#fff 1px,transparent 1px);background-size:1.6rem 1.6rem;"></div>
        {{-- Side vignette --}}
        <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_at_center,transparent_40%,rgba(0,0,0,0.25)_100%)]"></div>
        <div class="page-grid relative">
            <div class="grid grid-cols-2 divide-x divide-white/15 sm:grid-cols-4">
                <div class="flex flex-col items-center gap-1.5 py-5 text-center">
                    <span class="font-display text-2xl font-bold text-white">57+</span>
                    <span class="mx-auto block h-px w-6 rounded-full bg-[#e8a06a]"></span>
                    <span class="text-[0.65rem] font-semibold uppercase tracking-[0.18em] text-white/65">Years of service</span>
                </div>
                <div class="flex flex-col items-center gap-1.5 py-5 text-center">
                    <span class="font-display text-2xl font-bold text-white">5</span>
                    <span class="mx-auto block h-px w-6 rounded-full bg-[#e8a06a]"></span>
                    <span class="text-[0.65rem] font-semibold uppercase tracking-[0.18em] text-white/65">Product families</span>
                </div>
                <div class="flex flex-col items-center gap-1.5 py-5 text-center">
                    <span class="font-display text-2xl font-bold text-white">1967</span>
                    <span class="mx-auto block h-px w-6 rounded-full bg-[#e8a06a]"></span>
                    <span class="text-[0.65rem] font-semibold uppercase tracking-[0.18em] text-white/65">Founded</span>
                </div>
                <div class="flex flex-col items-center gap-1.5 py-5 text-center">
                    <span class="font-display text-2xl font-bold text-white">Masaka</span>
                    <span class="mx-auto block h-px w-6 rounded-full bg-[#e8a06a]"></span>
                    <span class="text-[0.65rem] font-semibold uppercase tracking-[0.18em] text-white/65">Greater Masaka Region</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== About Us Quick Section ===== --}}
    <section class="page-grid mt-12 sm:mt-16 lg:mt-20 mb-4" data-reveal>
        <div class="grid gap-0 lg:grid-cols-[1fr_auto_1fr]">

            {{-- Left: Who We Are --}}
            <div class="py-10 pr-0 lg:pr-12">
                <span class="eyebrow-light">Who We Are</span>
                <h2 class="mt-5 font-display text-2xl font-semibold leading-tight tracking-tight text-stone-950">
                    A fired clay manufacturer rooted in the Greater Masaka Region since {{ $company['founded'] }}.
                </h2>
                <div class="mt-6 space-y-4 text-sm leading-7 text-stone-600">
                    @foreach (array_slice($company['story'], 0, 2) as $paragraph)
                        <p class="text-justify">{{ $paragraph }}</p>
                    @endforeach
                </div>
                <div class="mt-8 flex flex-wrap gap-4">
                    <div class="flex flex-row gap-4 w-full sm:w-auto">
                        <div class="flex flex-1 items-center gap-3 rounded-sm border border-[#b86033]/15 bg-[#b86033]/5 px-5 py-3 justify-center">
                            <span class="text-2xl font-bold text-[#b86033]">{{ $company['years'] }}</span>
                            <span class="text-sm text-stone-600">Years of service</span>
                        </div>
                        <div class="flex flex-1 items-center gap-3 rounded-sm border border-[#b86033]/15 bg-[#b86033]/5 px-5 py-3 justify-center">
                            <span class="text-2xl font-bold text-[#b86033]">{{ $company['founded'] }}</span>
                            <span class="text-sm text-stone-600">Year established</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Divider --}}
            <div class="hidden lg:flex lg:flex-col lg:items-center lg:justify-stretch lg:py-10">
                <div class="h-full w-px bg-[#b86033]/25"></div>
            </div>
            <div class="block h-px bg-[#b86033]/25 lg:hidden my-8"></div>

            {{-- Right: Mission, Vision, Core Values --}}
            <div class="py-10 pl-0 lg:pl-12">

                <div class="mt-6 space-y-6">
                    <div class="group rounded-sm border border-stone-100 bg-white p-5 shadow-sm transition hover:border-[#b86033]/30 hover:shadow-md">
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-[#b86033]">Mission</p>
                        <p class="mt-2 text-sm leading-6 text-stone-700 text-justify">{{ $company['mission'] }}</p>
                    </div>

                    <div class="group rounded-sm border border-stone-100 bg-white p-5 shadow-sm transition hover:border-[#b86033]/30 hover:shadow-md">
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-[#b86033]">Vision</p>
                        <p class="mt-2 text-sm leading-6 text-stone-700 text-justify">{{ $company['vision'] }}</p>
                    </div>

                </div>

                <div class="mt-8">
                    <a href="/about" class="cta-primary-dark inline-flex items-center gap-2">
                        Read More About Us
                        <svg viewBox="0 0 24 24" class="h-4 w-4 fill-current" aria-hidden="true">
                            <path d="M13.2 5.8 19.4 12l-6.2 6.2-1.4-1.4 3.8-3.8H5v-2h10.6l-3.8-3.8 1.4-1.4Z"/>
                        </svg>
                    </a>
                </div>
            </div>

        </div>
    </section>

    {{-- ===== Why Choose Us ===== --}}
    <section class="border-y border-stone-100 py-16" style="background:#FEF2EC;" data-reveal>
        <div class="page-grid">
            <div class="mx-auto max-w-xl text-center">
                <span class="eyebrow-light">Why Choose Us</span>
                <h2 class="section-title mt-4">The fired clay advantage.</h2>
                <p class="mt-3 text-sm leading-7 text-stone-500">From sourcing to supply, here is what separates Butende Brick Works from the rest.</p>
            </div>
            <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <div class="rounded-sm border border-stone-200 bg-white p-6 shadow-sm transition hover:border-[#b86033]/30 hover:shadow-md">
                    <div class="mb-4 flex h-11 w-11 items-center justify-center rounded-sm bg-[#b86033]/10">
                        <svg class="h-5 w-5 text-[#b86033]" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/></svg>
                    </div>
                    <h3 class="font-display text-sm font-semibold text-stone-900">Locally sourced clay</h3>
                    <p class="mt-2 text-xs leading-6 text-stone-500">Clay mined from the Greater Masaka Region gives our products unique character and keeps costs grounded.</p>
                </div>
                <div class="rounded-sm border border-stone-200 bg-white p-6 shadow-sm transition hover:border-[#b86033]/30 hover:shadow-md">
                    <div class="mb-4 flex h-11 w-11 items-center justify-center rounded-sm bg-[#b86033]/10">
                        <svg class="h-5 w-5 text-[#b86033]" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.746 3.746 0 0 1-3.296 1.043 3.745 3.745 0 0 1-3.068 1.593c-1.268 0-2.39-.63-3.068-1.593a3.745 3.745 0 0 1-3.296-1.043 3.746 3.746 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.745 3.745 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z"/></svg>
                    </div>
                    <h3 class="font-display text-sm font-semibold text-stone-900">Kiln-fired quality control</h3>
                    <p class="mt-2 text-xs leading-6 text-stone-500">Every batch is fired to consistent strength — no shortcuts, no fillers, no imitation processes.</p>
                </div>
                <div class="rounded-sm border border-stone-200 bg-white p-6 shadow-sm transition hover:border-[#b86033]/30 hover:shadow-md">
                    <div class="mb-4 flex h-11 w-11 items-center justify-center rounded-sm bg-[#b86033]/10">
                        <svg class="h-5 w-5 text-[#b86033]" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z"/></svg>
                    </div>
                    <h3 class="font-display text-sm font-semibold text-stone-900">Direct manufacturer pricing</h3>
                    <p class="mt-2 text-xs leading-6 text-stone-500">No middlemen — you quote directly with the people who manufacture. Transparent, competitive, and honest.</p>
                </div>
                <div class="rounded-sm border border-stone-200 bg-white p-6 shadow-sm transition hover:border-[#b86033]/30 hover:shadow-md">
                    <div class="mb-4 flex h-11 w-11 items-center justify-center rounded-sm bg-[#b86033]/10">
                        <svg class="h-5 w-5 text-[#b86033]" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z"/></svg>
                    </div>
                    <h3 class="font-display text-sm font-semibold text-stone-900">Diocese-backed, community-rooted</h3>
                    <p class="mt-2 text-xs leading-6 text-stone-500">Since 1967, our profits support pastoral work and community development across the region. Every order contributes.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== Products Preview Section ===== --}}
    <section class="product-glass-section" data-reveal>
        {{-- Subtle dot-grid texture --}}
        <div style="pointer-events:none;position:absolute;inset:0;opacity:0.07;background-image:radial-gradient(circle,#fff 1px,transparent 1px);background-size:1.75rem 1.75rem;"></div>

        <div class="page-grid" style="position:relative;">

            {{-- Section header --}}
            <div style="max-width:42rem;margin:0 auto;display:flex;flex-direction:column;align-items:center;gap:1rem;text-align:center;">
                <span class="eyebrow">Our Products</span>
                <h2 style="margin-top:0.25rem;font-size:1.5rem;font-weight:700;letter-spacing:-0.02em;color:#fff;line-height:1.2;">
                    Fired clay products for every construction need.
                </h2>
                <p style="max-width:36rem;font-size:0.88rem;line-height:1.75;color:rgba(255,255,255,0.75);">
                    From structural bricks to decorative finishes, floor tiles, and ventilators — each product family is crafted from locally sourced clay and built to last.
                </p>
            </div>

            {{-- Glass product cards --}}
            <div class="product-glass-cards-grid">
                @foreach ($productCategories as $product)
                    @include('site.partials.home-product-glass-card', ['product' => $product])
                @endforeach
            </div>

            {{-- Browse all CTA --}}
            <div style="margin-top:2rem;display:flex;justify-content:center;">
                <a href="/products" class="inline-flex items-center gap-2.5 rounded-sm bg-[#b86033] px-8 py-4 text-sm font-semibold text-white transition hover:bg-[#a0532b]">
                    Browse All Products
                    <svg viewBox="0 0 24 24" class="h-4 w-4 fill-current" aria-hidden="true">
                        <path d="M13.2 5.8 19.4 12l-6.2 6.2-1.4-1.4 3.8-3.8H5v-2h10.6l-3.8-3.8 1.4-1.4Z"/>
                    </svg>
                </a>
            </div>

        </div>
    </section>

    {{-- ===== Our Partners Section ===== --}}
    <section class="page-grid mt-12 sm:mt-16 lg:mt-20" data-reveal>
        <div class="text-center">
            <span class="eyebrow-light">Our Partners</span>
            <h2 class="mt-4 font-display text-2xl font-semibold tracking-tight text-stone-950">
                Institutions and professionals we work with.
            </h2>
            <p class="mt-3 text-sm text-stone-500">Trusted by contractors, schools, churches, and institutions across central Uganda.</p>
        </div>

        <div class="mt-10 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-6">
            @foreach ($partners as $partner)
                @include('site.partials.partner-logo-card', ['partner' => $partner])
            @endforeach
        </div>

        <div class="mt-10 flex justify-center">
            <a href="{{ route('capabilities') }}" class="inline-flex items-center gap-2.5 rounded-sm border border-[#b86033]/30 bg-white px-7 py-3 text-sm font-semibold text-[#b86033] shadow-sm transition hover:border-[#b86033]/60 hover:bg-[#FEF2EC]">
                View All Partners
                <svg viewBox="0 0 24 24" class="h-4 w-4 fill-current" aria-hidden="true"><path d="M13.2 5.8 19.4 12l-6.2 6.2-1.4-1.4 3.8-3.8H5v-2h10.6l-3.8-3.8 1.4-1.4Z"/></svg>
            </a>
        </div>
    </section>

    <section class="reviews-section mt-14 sm:mt-20 lg:mt-24" data-reveal>
        <div class="page-grid py-16">

            {{-- Header --}}
            <div class="mx-auto flex max-w-2xl flex-col items-center gap-3 text-center">
                <span class="eyebrow">Client Reviews</span>
                <h2 class="mt-2 font-display text-2xl font-semibold tracking-tight text-stone-950">
                    What builders and project teams say about us.
                </h2>
            </div>

            {{-- Carousel --}}
            <div
                class="review-slider-shell mt-10"
                x-data="testimonialSlider(@js($testimonials))"
                x-init="start()"
                @mouseenter="stop()"
                @mouseleave="start()"
            >
                <div class="overflow-hidden">
                    <div
                        class="flex transition-transform duration-500 ease-out"
                        :style="`transform: translateX(-${slideIndex * 100}%);`"
                    >
                        @foreach ($testimonials as $testimonial)
                            @include('site.partials.review-card', ['testimonial' => $testimonial])
                        @endforeach
                    </div>
                </div>

                {{-- Controls --}}
                <div class="mt-8 flex items-center justify-center gap-6">
                    <button type="button" class="reviews-nav-btn" @click="prev()" aria-label="Previous">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M10.8 18.2 4.6 12l6.2-6.2 1.4 1.4L8.4 11H19v2H8.4l3.8 3.8-1.4 1.4Z"/></svg>
                    </button>

                    <div class="flex items-center gap-2">
                        @foreach ($testimonials as $testimonial)
                            <button
                                type="button"
                                class="review-dot"
                                :class="{ 'review-dot-active': slideIndex === {{ $loop->index }} }"
                                @click="goTo({{ $loop->index }})"
                                aria-label="Show review {{ $loop->iteration }}"
                            ></button>
                        @endforeach
                    </div>

                    <button type="button" class="reviews-nav-btn" @click="next()" aria-label="Next">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M13.2 5.8 19.4 12l-6.2 6.2-1.4-1.4 3.8-3.8H5v-2h10.6l-3.8-3.8 1.4-1.4Z"/></svg>
                    </button>
                </div>
            </div>

        </div>
    </section>
@endsection

@section('after_cta')
    {{-- ===== NEWS & INSIGHTS ===== --}}
    <section class="bg-stone-50 py-20 border-t border-stone-100">
        <div class="page-grid">
            {{-- Header --}}
            <div class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <span class="eyebrow-light">News &amp; Publications</span>
                    <h2 class="section-title mt-4">From the yard to your feed.</h2>
                    <p class="mt-3 max-w-lg text-sm leading-7 text-stone-500">Practical guides, design inspiration, and industry perspectives from the team behind Butende Brick Works.</p>
                </div>
                <a href="{{ route('news.list') }}" class="inline-flex shrink-0 items-center gap-2 rounded-sm border border-stone-300 bg-white px-5 py-2.5 text-xs font-semibold uppercase tracking-[0.15em] text-stone-700 transition hover:border-stone-400 hover:bg-stone-50">
                    All posts
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
                </a>
            </div>

            @if ($blogPosts->isNotEmpty())
                @php
                    $catColors = [
                        'News'         => '#b86033',
                        'Publication'  => '#6e2f0e',
                        'Guide'        => '#4a1e08',
                        'Announcement' => '#1a5c3a',
                        'Design'       => '#2f4a6e',
                        'Industry'     => '#4e3b2a',
                    ];
                @endphp

                {{-- Cards --}}
                <div class="mt-12 grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                    @foreach ($blogPosts as $post)
                        @php $color = $catColors[$post->category] ?? '#b86033'; @endphp
                        <a href="{{ route('news.show', $post->slug) }}" class="group flex flex-col overflow-hidden rounded-sm border border-stone-200 bg-white shadow-sm transition hover:shadow-md">

                            {{-- Thumbnail / gradient --}}
                            <div class="relative h-44 overflow-hidden"
                                style="background: linear-gradient(135deg, {{ $color }}ee 0%, {{ $color }}88 100%);">
                                @if ($post->image)
                                    <img
                                        src="{{ Storage::disk('public')->url($post->image) }}"
                                        alt="{{ $post->title }}"
                                        class="absolute inset-0 h-full w-full object-cover transition duration-500 group-hover:scale-105"
                                    >
                                    <div class="absolute inset-0" style="background: linear-gradient(to top, {{ $color }}cc 0%, transparent 60%);"></div>
                                @else
                                    <div class="absolute inset-0 opacity-[0.07]" style="background-image: repeating-linear-gradient(0deg,#fff 0px,#fff 18px,transparent 18px,transparent 36px),repeating-linear-gradient(90deg,#fff 0px,#fff 1px,transparent 1px,transparent 60px);"></div>
                                @endif
                                <div class="absolute bottom-4 left-5">
                                    <span class="inline-block rounded-sm border border-white/30 bg-white/20 px-2.5 py-1 text-[0.62rem] font-semibold uppercase tracking-widest text-white backdrop-blur-sm">
                                        {{ $post->category }}
                                    </span>
                                </div>
                            </div>

                            {{-- Body --}}
                            <div class="flex flex-1 flex-col p-6">
                                <div class="text-[0.65rem] font-medium uppercase tracking-widest text-stone-400">
                                    {{ $post->published_at->format('d M Y') }}
                                </div>
                                <h3 class="mt-3 font-display text-base font-semibold leading-snug text-stone-900 transition group-hover:text-[#b86033]">
                                    {{ $post->title }}
                                </h3>
                                @if ($post->excerpt)
                                    <p class="mt-3 flex-1 text-xs leading-6 text-stone-500 line-clamp-3">
                                        {{ $post->excerpt }}
                                    </p>
                                @endif
                                <div class="mt-5 border-t border-stone-100 pt-4">
                                    <span class="inline-flex items-center gap-1 text-[0.65rem] font-semibold uppercase tracking-widest text-[#b86033] opacity-0 transition group-hover:opacity-100">
                                        Read more
                                        <svg class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="mt-10 text-center">
                    <a href="{{ route('news.list') }}" class="inline-flex items-center gap-2 rounded-sm border border-stone-300 bg-white px-6 py-2.5 text-sm font-medium text-stone-700 transition hover:bg-stone-50 hover:border-stone-400">
                        View all news &amp; publications
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
                    </a>
                </div>
            @else
                <div class="mt-12 flex flex-col items-center justify-center rounded-sm border border-dashed border-stone-200 bg-white py-16 text-center">
                    <p class="text-sm text-stone-400">No posts published yet. Check back soon.</p>
                </div>
            @endif
        </div>
    </section>
@endsection
