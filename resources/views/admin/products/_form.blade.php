{{-- Shared form partial used by both create.blade.php and edit.blade.php --}}

{{-- Error summary --}}
@if ($errors->any())
    <div class="mb-6 flex gap-3 rounded-xl border border-red-200 bg-red-50 p-4">
        <svg class="mt-0.5 h-5 w-5 shrink-0 text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/>
        </svg>
        <div>
            <p class="text-sm font-semibold text-red-700">Please fix the following errors:</p>
            <ul class="mt-1 list-disc list-inside space-y-0.5 text-sm text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

<div class="grid gap-6 xl:grid-cols-3">

    {{-- ═══════════════════════════════════════════════════ --}}
    {{-- LEFT COLUMN — main detail cards (2/3 width)        --}}
    {{-- ═══════════════════════════════════════════════════ --}}
    <div class="xl:col-span-2 space-y-5">

        {{-- ── CARD: Basic Information ─────────────────── --}}
        <div class="rounded-xl border border-[#e8d5c5] bg-white shadow-sm overflow-hidden">
            <div class="flex items-center gap-2.5 border-b border-[#f0e4d8] bg-[#fdf8f5] px-6 py-3.5">
                <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-[#6e2f0e]/10">
                    <svg class="h-3.5 w-3.5 text-[#6e2f0e]" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/>
                    </svg>
                </span>
                <h3 class="text-sm font-semibold text-stone-800">Basic Information</h3>
            </div>
            <div class="p-6 space-y-5">

                {{-- Product Name --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-stone-700 mb-1.5">
                        Product Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="name" name="name"
                           value="{{ old('name', $product->name ?? '') }}"
                           placeholder="e.g. Standard Wire-Cut Brick"
                           class="w-full rounded-lg border px-4 py-2.5 text-sm text-stone-900 placeholder-stone-400 shadow-sm transition focus:outline-none focus:ring-2 focus:ring-[#b86033]/25
                                  {{ $errors->has('name') ? 'border-red-400 bg-red-50 focus:border-red-400 focus:ring-red-200/40' : 'border-[#d8c0ad] bg-white focus:border-[#b86033]' }}">
                    @error('name')<p class="mt-1.5 flex items-center gap-1 text-xs text-red-600"><svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/></svg>{{ $message }}</p>@enderror
                </div>

                {{-- Category --}}
                <div>
                    <label for="category" class="block text-sm font-medium text-stone-700 mb-1.5">
                        Category <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select id="category" name="category"
                                class="w-full appearance-none rounded-lg border px-4 py-2.5 pr-10 text-sm text-stone-900 shadow-sm transition focus:outline-none focus:ring-2 focus:ring-[#b86033]/25
                                       {{ $errors->has('category') ? 'border-red-400 bg-red-50 focus:border-red-400 focus:ring-red-200/40' : 'border-[#d8c0ad] bg-white focus:border-[#b86033]' }}">
                            <option value="">Select a category…</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat }}" {{ old('category', $product->category ?? '') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                        <span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-stone-400">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/></svg>
                        </span>
                    </div>
                    @error('category')<p class="mt-1.5 flex items-center gap-1 text-xs text-red-600"><svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/></svg>{{ $message }}</p>@enderror
                </div>

                {{-- Description --}}
                <div>
                    <label for="description" class="block text-sm font-medium text-stone-700 mb-1.5">
                        Description <span class="text-stone-400 text-xs font-normal">(optional)</span>
                    </label>
                    <textarea id="description" name="description" rows="3"
                              placeholder="Brief description of this product's uses, finish, and quality…"
                              class="w-full resize-none rounded-lg border px-4 py-2.5 text-sm text-stone-900 placeholder-stone-400 shadow-sm transition focus:outline-none focus:ring-2 focus:ring-[#b86033]/25
                                     {{ $errors->has('description') ? 'border-red-400 bg-red-50 focus:border-red-400' : 'border-[#d8c0ad] bg-white focus:border-[#b86033]' }}">{{ old('description', $product->description ?? '') }}</textarea>
                    @error('description')<p class="mt-1.5 flex items-center gap-1 text-xs text-red-600"><svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/></svg>{{ $message }}</p>@enderror
                </div>

            </div>
        </div>

    </div>

    {{-- ═══════════════════════════════════════════════════ --}}
    {{-- RIGHT COLUMN — image, visibility, help           --}}
    {{-- ═══════════════════════════════════════════════════ --}}
    <div class="space-y-5">

        {{-- ── CARD: Product Image ─────────────────────── --}}
        <div class="rounded-xl border border-[#e8d5c5] bg-white shadow-sm overflow-hidden">
            <div class="flex items-center gap-2.5 border-b border-[#f0e4d8] bg-[#fdf8f5] px-5 py-3.5">
                <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-[#6e2f0e]/10">
                    <svg class="h-3.5 w-3.5 text-[#6e2f0e]" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"/>
                    </svg>
                </span>
                <h3 class="text-sm font-semibold text-stone-800">Product Image</h3>
            </div>
            <div class="p-5 space-y-4">

                {{-- Current image (edit mode) --}}
                @if (! empty($product->image))
                    <div>
                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}"
                             class="h-44 w-full rounded-lg object-cover border border-[#e8d5c5]">
                        <p class="mt-1.5 text-center text-xs text-stone-400">Current image — upload below to replace</p>
                    </div>
                @endif

                {{-- Preview panel (filled by JS) --}}
                <div id="img-preview-wrap" class="hidden">
                    <img id="img-preview" src="" alt="Preview"
                         class="h-44 w-full rounded-lg object-cover border border-[#e8d5c5]">
                    <p class="mt-1.5 text-center text-xs text-stone-400">Preview — not yet saved</p>
                </div>

                {{-- Drop zone --}}
                <label id="drop-zone"
                       for="image"
                       class="group flex cursor-pointer flex-col items-center justify-center gap-2 rounded-xl border-2 border-dashed border-[#d8c0ad] bg-[#fdf8f5] px-4 py-8 text-center transition hover:border-[#b86033] hover:bg-[#fef5ee]">
                    <span class="flex h-11 w-11 items-center justify-center rounded-full bg-stone-100 transition group-hover:bg-[#6e2f0e]/10">
                        <svg class="h-5 w-5 text-stone-400 transition group-hover:text-[#b86033]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5"/>
                        </svg>
                    </span>
                    <span>
                        <span class="text-sm font-semibold text-[#6e2f0e]">Click to upload</span>
                        <span class="text-sm text-stone-500"> or drag and drop</span>
                    </span>
                    <span class="text-xs text-stone-400">JPG, PNG, WebP — max 3 MB</span>
                    <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/webp" class="sr-only">
                </label>

                <p id="img-name" class="hidden truncate text-center text-xs font-medium text-[#6e2f0e]"></p>

                @error('image')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>

        {{-- ── CARD: Visibility ────────────────────────── --}}
        <div class="rounded-xl border border-[#e8d5c5] bg-white shadow-sm overflow-hidden">
            <div class="flex items-center gap-2.5 border-b border-[#f0e4d8] bg-[#fdf8f5] px-5 py-3.5">
                <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-[#6e2f0e]/10">
                    <svg class="h-3.5 w-3.5 text-[#6e2f0e]" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                    </svg>
                </span>
                <h3 class="text-sm font-semibold text-stone-800">Visibility</h3>
            </div>
            <div class="p-5">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-sm font-medium text-stone-800">Active on site</p>
                        <p class="mt-0.5 text-xs text-stone-500 leading-relaxed">Active products appear in the catalogue and quotation form.</p>
                    </div>
                    <label class="relative inline-flex shrink-0 cursor-pointer items-center">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" id="is_active" name="is_active" value="1"
                               class="sr-only peer"
                               {{ old('is_active', ($product->is_active ?? true) ? '1' : '0') == '1' ? 'checked' : '' }}>
                        <div class="h-6 w-11 rounded-full bg-stone-200 shadow-inner transition
                                    peer-checked:bg-[#b86033]
                                    peer-focus:ring-2 peer-focus:ring-[#b86033]/30"></div>
                        <div class="absolute left-0.5 top-0.5 h-5 w-5 rounded-full bg-white shadow transition peer-checked:translate-x-5"></div>
                    </label>
                </div>
            </div>
        </div>

        {{-- ── CARD: Product Specifications ────────────── --}}
        <div class="rounded-xl border border-[#e8d5c5] bg-white shadow-sm overflow-hidden">
            <div class="flex items-center gap-2.5 border-b border-[#f0e4d8] bg-[#fdf8f5] px-5 py-3.5">
                <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-[#6e2f0e]/10">
                    <svg class="h-3.5 w-3.5 text-[#6e2f0e]" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 1 0 7.5 7.5h-7.5V6Z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0 0 13.5 3v7.5Z"/>
                    </svg>
                </span>
                <h3 class="text-sm font-semibold text-stone-800">Product Specifications</h3>
            </div>
            <div class="p-5 space-y-4">

                {{-- Weight --}}
                <div>
                    <label for="weight_kg" class="block text-sm font-medium text-stone-700 mb-1.5">Weight</label>
                    <div class="relative">
                        <input type="number" id="weight_kg" name="weight_kg" step="0.01" min="0"
                               value="{{ old('weight_kg', $product->weight_kg ?? '') }}"
                               placeholder="0.00"
                               class="w-full rounded-lg border px-4 py-2.5 pr-11 text-sm text-stone-900 placeholder-stone-400 shadow-sm transition focus:outline-none focus:ring-2 focus:ring-[#b86033]/25
                                      {{ $errors->has('weight_kg') ? 'border-red-400 bg-red-50' : 'border-[#d8c0ad] bg-white focus:border-[#b86033]' }}">
                        <span class="pointer-events-none absolute right-0 top-0 bottom-0 flex items-center justify-center w-10 rounded-r-lg border-l border-[#d8c0ad] bg-stone-50 text-xs font-medium text-stone-500">kg</span>
                    </div>
                    @error('weight_kg')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                {{-- Dimensions --}}
                <div>
                    <label for="dimensions_inch" class="block text-sm font-medium text-stone-700 mb-1.5">Dimensions</label>
                    <div class="relative">
                        <input type="text" id="dimensions_inch" name="dimensions_inch"
                               value="{{ old('dimensions_inch', $product->dimensions_inch ?? '') }}"
                               placeholder="9 × 4.5 × 3"
                               class="w-full rounded-lg border px-4 py-2.5 pr-14 text-sm text-stone-900 placeholder-stone-400 shadow-sm transition focus:outline-none focus:ring-2 focus:ring-[#b86033]/25
                                      {{ $errors->has('dimensions_inch') ? 'border-red-400 bg-red-50' : 'border-[#d8c0ad] bg-white focus:border-[#b86033]' }}">
                        <span class="pointer-events-none absolute right-0 top-0 bottom-0 flex items-center justify-center w-14 rounded-r-lg border-l border-[#d8c0ad] bg-stone-50 text-xs font-medium text-stone-500">inch</span>
                    </div>
                    @error('dimensions_inch')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                {{-- Coverage sqm --}}
                <div>
                    <label for="coverage_sqm" class="block text-sm font-medium text-stone-700 mb-1.5">
                        Coverage / unit
                        <span class="ml-1 inline-flex items-center rounded bg-amber-100 px-1.5 py-0.5 text-[10px] font-semibold text-amber-700 uppercase tracking-wide">calculator</span>
                    </label>
                    <div class="relative">
                        <input type="number" id="coverage_sqm" name="coverage_sqm" step="0.000001" min="0"
                               value="{{ old('coverage_sqm', $product->coverage_sqm ?? '') }}"
                               placeholder="0.016667"
                               class="w-full rounded-lg border px-4 py-2.5 pr-11 text-sm text-stone-900 placeholder-stone-400 shadow-sm transition focus:outline-none focus:ring-2 focus:ring-[#b86033]/25
                                      {{ $errors->has('coverage_sqm') ? 'border-red-400 bg-red-50' : 'border-[#d8c0ad] bg-white focus:border-[#b86033]' }}">
                        <span class="pointer-events-none absolute right-0 top-0 bottom-0 flex items-center justify-center w-10 rounded-r-lg border-l border-[#d8c0ad] bg-stone-50 text-xs font-medium text-stone-500">m²</span>
                    </div>
                    @error('coverage_sqm')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                {{-- Coverage help note --}}
                <div class="flex gap-2.5 rounded-lg border border-amber-200 bg-amber-50 px-4 py-3">
                    <svg class="mt-0.5 h-4 w-4 shrink-0 text-amber-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 0 0 1.5-.189m-1.5.189a6.01 6.01 0 0 1-1.5-.189m3.75 7.478a12.06 12.06 0 0 1-4.5 0m3.75 2.383a14.406 14.406 0 0 1-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 1 0-7.517 0c.85.493 1.509 1.333 1.509 2.316V18"/>
                    </svg>
                    <p class="text-xs text-amber-800 leading-relaxed">
                        <strong class="font-semibold">Coverage tip:</strong>
                        Coverage = 1 ÷ (units per m²). A standard brick at 60 per m² covers <strong>0.016667 m²</strong>. This value powers the online calculator.
                    </p>
                </div>

            </div>
        </div>

    </div>
</div>

{{-- Image preview JS --}}
<script>
    (function () {
        const input = document.getElementById('image');
        const preview = document.getElementById('img-preview');
        const previewWrap = document.getElementById('img-preview-wrap');
        const nameTag = document.getElementById('img-name');
        const dropZone = document.getElementById('drop-zone');

        if (!input) return;

        function loadFile(file) {
            if (!file || !file.type.startsWith('image/')) return;
            const reader = new FileReader();
            reader.onload = e => {
                preview.src = e.target.result;
                previewWrap.classList.remove('hidden');
                nameTag.textContent = file.name;
                nameTag.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }

        input.addEventListener('change', () => { if (input.files[0]) loadFile(input.files[0]); });

        dropZone.addEventListener('dragover', e => { e.preventDefault(); dropZone.classList.add('border-[#b86033]', 'bg-[#fef5ee]'); });
        dropZone.addEventListener('dragleave', () => { dropZone.classList.remove('border-[#b86033]', 'bg-[#fef5ee]'); });
        dropZone.addEventListener('drop', e => {
            e.preventDefault();
            dropZone.classList.remove('border-[#b86033]', 'bg-[#fef5ee]');
            const file = e.dataTransfer.files[0];
            if (file) {
                const dt = new DataTransfer();
                dt.items.add(file);
                input.files = dt.files;
                loadFile(file);
            }
        });
    })();
</script>
