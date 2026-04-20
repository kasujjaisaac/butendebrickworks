@extends('layouts.site')

@section('content')

    @php
        $categories = $products
            ->map(fn ($product) => $product->category ?: 'Other')
            ->filter()
            ->unique()
            ->values();
    @endphp

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
                    How many fired clay products does your project need?
                </h1>
                <p class="mt-4 max-w-lg text-base leading-7 text-white/65">
                    Choose a category, select the product you want to build with, and enter your project area.
                    The calculator will tell you how many units you need and let you continue straight to ordering or requesting a quotation.
                </p>
            </div>
        </div>
    </section>

    {{-- CALCULATOR SECTION --}}
    <section class="page-grid py-16">
        <div class="mx-auto max-w-3xl">
            <div class="overflow-hidden rounded-xl border border-stone-200 bg-white shadow-md">

                {{-- Card header --}}
                <div class="flex items-center gap-3 border-b border-stone-100 bg-stone-50 px-8 py-5">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-[#b86033]/10">
                        <svg class="h-5 w-5 text-[#b86033]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 15.75V18m-7.5-6.75h.008v.008H8.25v-.008Zm0 2.25h.008v.008H8.25V13.5Zm0 2.25h.008v.008H8.25v-.008Zm0 2.25h.008v.008H8.25V18Zm2.498-6.75h.007v.008h-.007v-.008Zm0 2.25h.007v.008h-.007V13.5Zm0 2.25h.007v.008h-.007v-.008Zm0 2.25h.007v.008h-.007V18Zm2.504-6.75h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V13.5Zm0 2.25h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V18Zm2.498-6.75h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V13.5ZM8.25 6h7.5v2.25h-7.5V6ZM12 2.25c-1.892 0-3.758.11-5.593.322C5.307 2.7 4.5 3.616 4.5 4.698V18a2.25 2.25 0 0 0 2.25 2.25h10.5A2.25 2.25 0 0 0 19.5 18V4.698c0-1.082-.807-1.998-1.907-2.126A48.32 48.32 0 0 0 12 2.25Z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-stone-900">Quantity Estimator</p>
                        <p class="text-sm text-stone-500">Find out how many units your project needs</p>
                    </div>
                </div>

                <div class="space-y-6 px-8 py-8">

                    @if ($products->isEmpty())
                        <div class="rounded-lg border border-amber-200 bg-amber-50 px-6 py-5 text-center text-sm text-amber-800">
                            No products are currently available. Please check back soon.
                        </div>
                    @else
                        <div class="grid gap-6 md:grid-cols-2">
                            <div>
                                <label for="calc-category" class="mb-1.5 block text-sm font-semibold text-stone-700">
                                    1. Select a category <span class="text-red-500">*</span>
                                </label>
                                <select
                                    id="calc-category"
                                    class="w-full rounded-xl border border-stone-300 px-4 py-3 text-sm text-stone-900 shadow-sm focus:border-[#b86033] focus:ring-2 focus:ring-[#b86033]/20 focus:outline-none"
                                >
                                    <option value="">Choose a category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category }}">{{ $category }}</option>
                                    @endforeach
                                </select>
                                <p class="mt-1.5 text-xs text-stone-400">Choose the family of product you want to build with.</p>
                            </div>

                            <div>
                                <label for="calc-product" class="mb-1.5 block text-sm font-semibold text-stone-700">
                                    2. Select a product <span class="text-red-500">*</span>
                                </label>
                                <select
                                    id="calc-product"
                                    disabled
                                    class="w-full rounded-xl border border-stone-300 bg-stone-50 px-4 py-3 text-sm text-stone-900 shadow-sm focus:border-[#b86033] focus:ring-2 focus:ring-[#b86033]/20 focus:outline-none disabled:cursor-not-allowed disabled:text-stone-400"
                                >
                                    <option value="">Choose a category first</option>
                                </select>
                                <p class="mt-1.5 text-xs text-stone-400">Products will appear here after you select a category.</p>
                            </div>
                        </div>

                        <div class="rounded-xl border border-stone-200 bg-stone-50 px-5 py-4">
                            <div class="grid gap-5 md:grid-cols-[minmax(0,1fr)_auto] md:items-end">
                                <div>
                                    <label for="calc_sqm" class="mb-1.5 block text-sm font-semibold text-stone-700">
                                        3. Enter the area you want to build <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative max-w-sm">
                                        <input
                                            type="number"
                                            id="calc_sqm"
                                            min="0.01"
                                            step="0.01"
                                            placeholder="e.g. 50"
                                            class="w-full rounded-xl border border-stone-300 px-5 py-3 pr-14 text-base text-stone-900 shadow-sm focus:border-[#b86033] focus:ring-2 focus:ring-[#b86033]/20 focus:outline-none"
                                        >
                                        <span class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-sm font-semibold text-stone-400">m²</span>
                                    </div>
                                    <p class="mt-1.5 text-xs text-stone-400">Enter the total wall or floor area in square metres.</p>
                                </div>

                                <button
                                    type="button"
                                    id="calc-submit"
                                    class="inline-flex items-center justify-center rounded-xl bg-[#b86033] px-6 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-[#a0532b] focus:outline-none focus:ring-2 focus:ring-[#b86033] focus:ring-offset-2"
                                >
                                    Calculate Quantity
                                </button>
                            </div>

                            <div id="calc-inline-error" class="mt-4 hidden rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700"></div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- How it works --}}
            <div class="mt-12">
                <h2 class="mb-8 text-center text-lg font-bold text-stone-900">How it works</h2>
                <div class="grid gap-6 sm:grid-cols-3">
                    @foreach ([['1', 'Choose category', 'Start with the type of product you want to build with.'], ['2', 'Enter your area', 'Provide the total square metres for your project area.'], ['3', 'Review popup', 'See the quantity you need, then order immediately or request a quotation.']] as [$num, $title, $body])
                        <div class="rounded-xl border border-stone-200 bg-white p-6 text-center">
                            <div class="mx-auto mb-4 flex h-10 w-10 items-center justify-center rounded-full bg-[#b86033] text-base font-bold text-white">
                                {{ $num }}
                            </div>
                            <h3 class="font-semibold text-stone-900">{{ $title }}</h3>
                            <p class="mt-2 text-sm leading-relaxed text-stone-500">{{ $body }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    @if ($products->isNotEmpty())
        <div id="calculator-popup" class="fixed inset-0 z-[100] hidden bg-black/60 px-4 py-6 sm:px-6">
            <div class="flex min-h-full items-center justify-center">
                <div class="w-full max-w-2xl overflow-hidden rounded-2xl bg-white shadow-2xl">
                    <div class="flex items-start justify-between gap-4 border-b border-stone-100 bg-stone-50 px-6 py-5">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-[#b86033]">Calculator Result</p>
                            <h2 class="mt-1 text-xl font-semibold text-stone-900">Products needed for your project</h2>
                        </div>
                        <button
                            type="button"
                            id="calc-popup-close"
                            class="flex h-10 w-10 items-center justify-center rounded-full bg-white text-stone-500 transition hover:bg-stone-100 hover:text-stone-900"
                            aria-label="Close quantity popup"
                        >
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <div class="px-6 py-6">
                        <div class="rounded-2xl border border-[#b86033]/20 bg-[#fff8f4] px-5 py-5">
                            <p id="calc-popup-greeting" class="text-sm font-semibold text-[#6e2f0e]"></p>
                            <p id="calc-popup-message" class="mt-3 text-base leading-7 text-stone-700"></p>
                            <div class="mt-5 grid gap-3 sm:grid-cols-2">
                                <div class="rounded-xl border border-stone-200 bg-white px-4 py-4">
                                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-stone-400">Selected Product</p>
                                    <p id="calc-popup-product" class="mt-2 text-lg font-semibold text-stone-900"></p>
                                </div>
                                <div class="rounded-xl border border-stone-200 bg-white px-4 py-4">
                                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-stone-400">Area Entered</p>
                                    <p id="calc-popup-area" class="mt-2 text-lg font-semibold text-stone-900"></p>
                                </div>
                            </div>
                            <p class="mt-4 text-xs leading-5 text-stone-500">
                                If you continue to order or request a quotation, the selected product and calculated quantity will be carried forward for you.
                            </p>
                        </div>

                        <div class="mt-6 flex flex-col gap-3 sm:flex-row">
                            <a
                                id="calc-popup-order"
                                href="{{ route('orders.index') }}"
                                class="inline-flex flex-1 items-center justify-center rounded-xl bg-[#6e2f0e] px-5 py-3 text-sm font-bold text-white transition hover:bg-[#5a2509]"
                            >
                                Order Now
                            </a>
                            <a
                                id="calc-popup-quote"
                                href="{{ route('quotation.create') }}"
                                class="inline-flex flex-1 items-center justify-center rounded-xl border border-[#b86033] bg-white px-5 py-3 text-sm font-bold text-[#b86033] transition hover:bg-[#fff4ed]"
                            >
                                Request Quotation
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @push('scripts')
    <script>
    (function () {
        const products = @json($productsJson);

        const categorySelect = document.getElementById('calc-category');
        const productSelect = document.getElementById('calc-product');
        const sqmInput = document.getElementById('calc_sqm');
        const submitButton = document.getElementById('calc-submit');
        const inlineError = document.getElementById('calc-inline-error');
        const popup = document.getElementById('calculator-popup');
        const closeButton = document.getElementById('calc-popup-close');
        const popupGreeting = document.getElementById('calc-popup-greeting');
        const popupMessage = document.getElementById('calc-popup-message');
        const popupProduct = document.getElementById('calc-popup-product');
        const popupArea = document.getElementById('calc-popup-area');
        const orderButton = document.getElementById('calc-popup-order');
        const quoteButton = document.getElementById('calc-popup-quote');
        const numberFormatter = new Intl.NumberFormat('en-UG');

        if (!categorySelect || !productSelect || !sqmInput || !submitButton || !inlineError) {
            return;
        }

        function resetInlineError() {
            inlineError.textContent = '';
            inlineError.classList.add('hidden');
        }

        function showInlineError(message) {
            inlineError.textContent = message;
            inlineError.classList.remove('hidden');
        }

        function getGreeting() {
            const hour = new Date().getHours();

            if (hour < 12) return 'Good morning customer.';
            if (hour < 18) return 'Good afternoon customer.';
            return 'Good evening customer.';
        }

        function closePopup() {
            if (!popup) return;

            popup.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        function openPopup(product, area, units) {
            if (!popup || !popupGreeting || !popupMessage || !popupProduct || !popupArea || !orderButton || !quoteButton) {
                return;
            }

            popupGreeting.textContent = getGreeting();
            popupMessage.textContent = 'According to the measurements you have entered, you will need ' + numberFormatter.format(units) + ' ' + product.name + ' for your construction.';
            popupProduct.textContent = numberFormatter.format(units) + ' ' + product.name;
            popupArea.textContent = numberFormatter.format(area) + ' m²';

            const orderBase = orderButton.href.split('?')[0];
            const quoteBase = quoteButton.href.split('?')[0];

            orderButton.href = orderBase + '?product_id=' + encodeURIComponent(product.id) + '&quantity=' + encodeURIComponent(units);
            quoteButton.href = quoteBase + '?product_id=' + encodeURIComponent(product.id) + '&sqm=' + encodeURIComponent(area);

            popup.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function populateProducts(category) {
            const matchingProducts = products.filter(product => product.category === category);

            productSelect.innerHTML = '';

            if (!category || matchingProducts.length === 0) {
                productSelect.disabled = true;
                productSelect.classList.add('bg-stone-50');
                productSelect.innerHTML = '<option value="">Choose a category first</option>';
                return;
            }

            productSelect.disabled = false;
            productSelect.classList.remove('bg-stone-50');

            const placeholder = document.createElement('option');
            placeholder.value = '';
            placeholder.textContent = 'Choose a product';
            productSelect.appendChild(placeholder);

            matchingProducts.forEach(function (product) {
                const option = document.createElement('option');
                option.value = String(product.id);
                option.textContent = product.name;
                productSelect.appendChild(option);
            });
        }

        function calculateUnits(area, product) {
            if (product.coverage > 0) {
                return Math.ceil(area / product.coverage);
            }

            return Math.ceil(area * product.bricks_per_square_metre);
        }

        categorySelect.addEventListener('change', function () {
            resetInlineError();
            populateProducts(categorySelect.value);
        });

        submitButton.addEventListener('click', function () {
            resetInlineError();

            const selectedCategory = categorySelect.value;
            const selectedProduct = products.find(product => String(product.id) === productSelect.value);
            const area = parseFloat(sqmInput.value);

            if (!selectedCategory) {
                showInlineError('Please select a product category first.');
                return;
            }

            if (!selectedProduct) {
                showInlineError('Please select the product you want to calculate.');
                return;
            }

            if (Number.isNaN(area) || area <= 0) {
                showInlineError('Please enter a valid project area in square metres.');
                return;
            }

            openPopup(selectedProduct, area, calculateUnits(area, selectedProduct));
        });

        if (closeButton) {
            closeButton.addEventListener('click', closePopup);
        }

        if (popup) {
            popup.addEventListener('click', function (event) {
                if (event.target === popup) {
                    closePopup();
                }
            });
        }

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                closePopup();
            }
        });
    })();
    </script>
    @endpush

@endsection
