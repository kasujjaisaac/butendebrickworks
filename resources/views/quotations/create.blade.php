<x-portal-layout>
    <x-slot name="header">
        <div>
            <p class="text-[10px] font-semibold uppercase tracking-[0.2em] text-stone-400">Quotations</p>
            <h1 class="mt-0.5 text-[15px] font-semibold text-stone-800">Request a Quotation</h1>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            {{-- Error summary --}}
            @if ($errors->any())
                <div class="mb-6 rounded-lg bg-red-50 border border-red-200 p-4">
                    <p class="text-sm font-semibold text-red-700 mb-1">Please fix the following errors:</p>
                    <ul class="list-disc list-inside text-sm text-red-600 space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-xl border border-stone-100 overflow-hidden">

                {{-- Card header --}}
                <div class="bg-[#b86033] px-8 py-5">
                    <p class="text-sm text-white/80">Fill in your construction area below to get an instant quantity estimate and formal quote.</p>
                </div>

                <form method="POST" action="{{ route('quotation.store') }}" class="px-8 py-8 space-y-6">
                    @csrf

                    {{-- Product selector --}}
                    <div>
                        <label for="brick_product_id" class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Brick Product <span class="text-red-500">*</span>
                        </label>
                        <select
                            id="brick_product_id"
                            name="brick_product_id"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-gray-900 shadow-sm focus:border-[#b86033] focus:ring-2 focus:ring-[#b86033]/20 focus:outline-none @error('brick_product_id') border-red-400 bg-red-50 @enderror"
                        >
                            <option value="">-- Select a product --</option>
                            @foreach ($products as $product)
                                <option
                                    value="{{ $product->id }}"
                                    data-bpsm="{{ $product->units_per_square_metre }}"
                                    data-coverage="{{ $product->coverage }}"
                                    {{ (old('brick_product_id') ?? $preProductId) == $product->id ? 'selected' : '' }}
                                >
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('brick_product_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Square metres --}}
                    <div>
                        <label for="square_metres" class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Area (Square Metres) <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input
                                type="number"
                                id="square_metres"
                                name="square_metres"
                                value="{{ old('square_metres', $preSqm ?? '') }}"
                                min="0.01"
                                step="0.01"
                                placeholder="e.g. 50"
                                class="w-full rounded-lg border border-gray-300 px-4 py-2.5 pr-14 text-gray-900 shadow-sm focus:border-[#b86033] focus:ring-2 focus:ring-[#b86033]/20 focus:outline-none @error('square_metres') border-red-400 bg-red-50 @enderror"
                            >
                            <span class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-sm font-medium text-gray-400">m²</span>
                        </div>
                        @error('square_metres')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Live estimate preview --}}
                    <div id="estimate-preview" class="hidden rounded-lg bg-amber-50 border border-amber-200 p-4">
                        <p class="text-xs font-semibold uppercase tracking-widest text-amber-700 mb-3">Estimated Quantity</p>
                        <div class="text-center">
                            <p class="text-xs text-amber-600">Units Required</p>
                            <p id="preview-bricks" class="text-2xl font-bold text-amber-900">—</p>
                        </div>
                    </div>

                    <div class="pt-2">
                        <button
                            type="submit"
                            class="w-full rounded-lg bg-[#b86033] px-6 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-[#a0532b] focus:outline-none focus:ring-2 focus:ring-[#b86033] focus:ring-offset-2"
                        >
                            Calculate &amp; Get Quotation
                        </button>
                    </div>
                </form>
            </div>

            <p class="mt-4 text-center text-xs text-gray-500">
                Units are estimated. Final confirmation provided once your request is reviewed.
            </p>
        </div>
    </div>

    @push('scripts')
    <script>
        (function () {
            const select = document.getElementById('brick_product_id');
            const sqmInput = document.getElementById('square_metres');
            const preview = document.getElementById('estimate-preview');
            const bricksEl = document.getElementById('preview-bricks');

            function update() {
                const opt = select.options[select.selectedIndex];
                const sqm = parseFloat(sqmInput.value);
                if (!opt || !opt.dataset.coverage || isNaN(sqm) || sqm <= 0) {
                    preview.classList.add('hidden');
                    return;
                }
                const coverage = parseFloat(opt.dataset.coverage);
                let bricks;
                if (coverage > 0) {
                    bricks = Math.ceil(sqm / coverage);
                } else {
                    const bpsm = parseInt(opt.dataset.bpsm, 10) || 60;
                    bricks = Math.ceil(sqm * bpsm);
                }
                bricksEl.textContent = bricks.toLocaleString('en-UG');
                preview.classList.remove('hidden');
            }

            select.addEventListener('change', update);
            sqmInput.addEventListener('input', update);
            update();
        })();
    </script>
    @endpush
</x-portal-layout>
