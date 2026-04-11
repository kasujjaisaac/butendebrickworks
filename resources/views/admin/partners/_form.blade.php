{{-- Shared form partial for partners create and edit --}}

@if ($errors->any())
    <div class="mb-6 flex gap-3 rounded-sm border border-red-200 bg-red-50 p-4">
        <svg class="mt-0.5 h-5 w-5 shrink-0 text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/>
        </svg>
        <div>
            <p class="text-sm font-semibold text-red-700">Please fix the following errors:</p>
            <ul class="mt-1 list-inside list-disc space-y-0.5 text-sm text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

<div class="grid gap-6 xl:grid-cols-3">

    {{-- ── LEFT: partner details (2/3) ── --}}
    <div class="space-y-5 xl:col-span-2">

        <div class="overflow-hidden rounded-sm border border-[#e8d5c5] bg-white shadow-sm">
            <div class="flex items-center gap-2.5 border-b border-[#f0e4d8] bg-[#fdf8f5] px-5 py-3.5">
                <span class="flex h-7 w-7 items-center justify-center rounded-sm bg-[#6e2f0e]/10">
                    <svg class="h-3.5 w-3.5 text-[#6e2f0e]" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/>
                    </svg>
                </span>
                <h3 class="text-sm font-semibold text-stone-800">Partner Details</h3>
            </div>
            <div class="space-y-5 p-5">

                {{-- Name --}}
                <div>
                    <label for="name" class="mb-1.5 block text-sm font-medium text-stone-700">
                        Name <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text" id="name" name="name"
                        value="{{ old('name', $partner['name'] ?? '') }}"
                        placeholder="e.g. Uganda National Bureau of Standards"
                        class="w-full rounded-sm border px-4 py-2.5 text-sm text-stone-900 placeholder-stone-400 shadow-sm transition focus:outline-none focus:ring-2 focus:ring-[#b86033]/25
                               {{ $errors->has('name') ? 'border-red-400 bg-red-50 focus:border-red-400' : 'border-[#d8c0ad] bg-white focus:border-[#b86033]' }}"
                    >
                    @error('name')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                {{-- Type / Role --}}
                <div>
                    <label for="type" class="mb-1.5 block text-sm font-medium text-stone-700">
                        Type / Role <span class="text-xs font-normal text-stone-400">(optional)</span>
                    </label>
                    <input
                        type="text" id="type" name="type"
                        value="{{ old('type', $partner['type'] ?? '') }}"
                        placeholder="e.g. Certification Body, Distribution Partner…"
                        class="w-full rounded-sm border px-4 py-2.5 text-sm text-stone-900 placeholder-stone-400 shadow-sm transition focus:outline-none focus:ring-2 focus:ring-[#b86033]/25
                               {{ $errors->has('type') ? 'border-red-400 bg-red-50 focus:border-red-400' : 'border-[#d8c0ad] bg-white focus:border-[#b86033]' }}"
                    >
                    @error('type')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

            </div>
        </div>

    </div>

    {{-- ── RIGHT: logo upload (1/3) ── --}}
    <div class="space-y-5">

        <div class="overflow-hidden rounded-sm border border-[#e8d5c5] bg-white shadow-sm">
            <div class="flex items-center gap-2.5 border-b border-[#f0e4d8] bg-[#fdf8f5] px-5 py-3.5">
                <span class="flex h-7 w-7 items-center justify-center rounded-sm bg-[#6e2f0e]/10">
                    <svg class="h-3.5 w-3.5 text-[#6e2f0e]" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"/>
                    </svg>
                </span>
                <h3 class="text-sm font-semibold text-stone-800">Logo</h3>
            </div>
            <div class="p-5">

                @php
                    $currentLogo = $partner['logo'] ?? null;
                    $hasLogo     = $currentLogo && file_exists(public_path($currentLogo));
                @endphp

                {{-- Current logo preview (edit mode) --}}
                @if ($hasLogo)
                    <div class="mb-4">
                        <p class="mb-2 text-xs font-medium text-stone-500 uppercase tracking-wide">Current Logo</p>
                        <div class="flex items-center gap-3">
                            <img
                                src="{{ $currentLogo }}"
                                alt="Current partner logo"
                                class="h-16 w-auto max-w-[8rem] rounded-sm border border-[#e8d5c5] bg-[#fdf8f5] object-contain p-1"
                            >
                            <p class="text-xs text-stone-500">Upload a new image to replace.</p>
                        </div>
                    </div>
                @endif

                {{-- Upload area --}}
                <div
                    id="logo-drop-zone"
                    class="flex cursor-pointer flex-col items-center justify-center gap-2 rounded-sm border-2 border-dashed border-[#d8c0ad] bg-[#fdf8f5] px-4 py-8 text-center transition hover:border-[#b86033] hover:bg-[#fdf3ec]"
                    onclick="document.getElementById('logo').click()"
                >
                    <svg class="h-8 w-8 text-[#b86033]/60" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5"/>
                    </svg>
                    <div>
                        <p class="text-sm font-medium text-stone-700">click to upload</p>
                        <p class="mt-0.5 text-xs text-stone-400">JPG, PNG or WebP — max 2 MB</p>
                    </div>
                    <div id="logo-filename" class="hidden rounded-sm bg-[#b86033]/10 px-3 py-1 text-xs font-medium text-[#6e2f0e]"></div>
                </div>

                <input
                    type="file" id="logo" name="logo" accept="image/jpeg,image/png,image/webp"
                    class="sr-only"
                    onchange="
                        const f = this.files[0];
                        const el = document.getElementById('logo-filename');
                        if (f) { el.textContent = f.name; el.classList.remove('hidden'); }
                        else { el.classList.add('hidden'); }
                    "
                >
                @error('logo')<p class="mt-2 text-xs text-red-600">{{ $message }}</p>@enderror

            </div>
        </div>

    </div>

</div>
