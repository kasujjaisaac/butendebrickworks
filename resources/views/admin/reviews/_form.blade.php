{{-- Shared form partial for reviews create and edit --}}

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

    {{-- ── LEFT: review content (2/3) ── --}}
    <div class="space-y-5 xl:col-span-2">

        {{-- Reviewer details --}}
        <div class="overflow-hidden rounded-sm border border-[#e8d5c5] bg-white shadow-sm">
            <div class="flex items-center gap-2.5 border-b border-[#f0e4d8] bg-[#fdf8f5] px-5 py-3.5">
                <span class="flex h-7 w-7 items-center justify-center rounded-sm bg-[#6e2f0e]/10">
                    <svg class="h-3.5 w-3.5 text-[#6e2f0e]" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/></svg>
                </span>
                <h3 class="text-sm font-semibold text-stone-800">Reviewer</h3>
            </div>
            <div class="grid gap-4 p-5 sm:grid-cols-2">

                {{-- Name --}}
                <div class="sm:col-span-2">
                    <label for="reviewer_name" class="mb-1.5 block text-sm font-medium text-stone-700">
                        Full Name <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text" id="reviewer_name" name="reviewer_name"
                        value="{{ old('reviewer_name', $review->reviewer_name ?? '') }}"
                        placeholder="e.g. John Mukasa"
                        class="w-full rounded-sm border px-4 py-2.5 text-sm text-stone-900 placeholder-stone-400 shadow-sm transition focus:outline-none focus:ring-2 focus:ring-[#b86033]/25
                               {{ $errors->has('reviewer_name') ? 'border-red-400 bg-red-50' : 'border-[#d8c0ad] bg-white focus:border-[#b86033]' }}"
                    >
                    @error('reviewer_name')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                {{-- Position --}}
                <div>
                    <label for="position" class="mb-1.5 block text-sm font-medium text-stone-700">
                        Position / Role <span class="text-xs font-normal text-stone-400">(optional)</span>
                    </label>
                    <input
                        type="text" id="position" name="position"
                        value="{{ old('position', $review->position ?? '') }}"
                        placeholder="e.g. Site Manager"
                        class="w-full rounded-sm border px-4 py-2.5 text-sm text-stone-900 placeholder-stone-400 shadow-sm transition focus:outline-none focus:ring-2 focus:ring-[#b86033]/25
                               {{ $errors->has('position') ? 'border-red-400 bg-red-50' : 'border-[#d8c0ad] bg-white focus:border-[#b86033]' }}"
                    >
                    @error('position')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                {{-- Company --}}
                <div>
                    <label for="company" class="mb-1.5 block text-sm font-medium text-stone-700">
                        Company / Organisation <span class="text-xs font-normal text-stone-400">(optional)</span>
                    </label>
                    <input
                        type="text" id="company" name="company"
                        value="{{ old('company', $review->company ?? '') }}"
                        placeholder="e.g. Kampala Construction Ltd"
                        class="w-full rounded-sm border px-4 py-2.5 text-sm text-stone-900 placeholder-stone-400 shadow-sm transition focus:outline-none focus:ring-2 focus:ring-[#b86033]/25
                               {{ $errors->has('company') ? 'border-red-400 bg-red-50' : 'border-[#d8c0ad] bg-white focus:border-[#b86033]' }}"
                    >
                    @error('company')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

            </div>
        </div>

        {{-- Rating + Review text --}}
        <div class="overflow-hidden rounded-sm border border-[#e8d5c5] bg-white shadow-sm">
            <div class="flex items-center gap-2.5 border-b border-[#f0e4d8] bg-[#fdf8f5] px-5 py-3.5">
                <span class="flex h-7 w-7 items-center justify-center rounded-sm bg-[#6e2f0e]/10">
                    <svg class="h-3.5 w-3.5 text-[#6e2f0e]" viewBox="0 0 20 20" fill="currentColor"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 0 0 .95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 0 0-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 0 0-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 0 0-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 0 0 .951-.69l1.07-3.292Z"/></svg>
                </span>
                <h3 class="text-sm font-semibold text-stone-800">Review</h3>
            </div>
            <div class="space-y-5 p-5">

                {{-- Star rating picker --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-stone-700">
                        Star Rating <span class="text-red-500">*</span>
                    </label>
                    <div
                        class="flex items-center gap-1"
                        x-data="{ rating: {{ old('rating', $review->rating ?? 5) }} }"
                    >
                        @for ($i = 1; $i <= 5; $i++)
                            <button
                                type="button"
                                @click="rating = {{ $i }}"
                                class="text-3xl leading-none transition-transform hover:scale-110 focus:outline-none"
                                :class="rating >= {{ $i }} ? 'text-amber-400' : 'text-stone-200'"
                            >★</button>
                        @endfor
                        <input type="hidden" name="rating" :value="rating">
                        <span class="ml-3 text-sm text-stone-500" x-text="rating + ' / 5'"></span>
                    </div>
                    @error('rating')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                {{-- Content --}}
                <div>
                    <label for="content" class="mb-1.5 block text-sm font-medium text-stone-700">
                        Review Text <span class="text-red-500">*</span>
                    </label>
                    <textarea
                        id="content" name="content" rows="6"
                        placeholder="What did the customer say about Butende Brick Works or the products?"
                        class="w-full rounded-sm border px-4 py-3 text-sm text-stone-900 placeholder-stone-400 shadow-sm transition focus:outline-none focus:ring-2 focus:ring-[#b86033]/25
                               {{ $errors->has('content') ? 'border-red-400 bg-red-50' : 'border-[#d8c0ad] bg-white focus:border-[#b86033]' }}"
                    >{{ old('content', $review->content ?? '') }}</textarea>
                    <p class="mt-1 text-xs text-stone-400">Max 2,000 characters. Will appear in the carousel on the home page.</p>
                    @error('content')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

            </div>
        </div>

    </div>

    {{-- ── RIGHT: photo + settings ── --}}
    <div class="space-y-5">

        {{-- Visibility --}}
        <div class="overflow-hidden rounded-sm border border-[#e8d5c5] bg-white shadow-sm">
            <div class="flex items-center gap-2.5 border-b border-[#f0e4d8] bg-[#fdf8f5] px-5 py-3.5">
                <span class="flex h-7 w-7 items-center justify-center rounded-sm bg-[#6e2f0e]/10">
                    <svg class="h-3.5 w-3.5 text-[#6e2f0e]" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                </span>
                <h3 class="text-sm font-semibold text-stone-800">Visibility</h3>
            </div>
            <div class="divide-y divide-[#f5ede6] p-5">

                {{-- Approve --}}
                <label class="flex cursor-pointer items-start gap-3 pb-4">
                    <input
                        type="checkbox" name="is_approved" value="1"
                        {{ old('is_approved', ($review->is_approved ?? false) ? '1' : null) ? 'checked' : '' }}
                        class="mt-0.5 h-4 w-4 rounded border-[#d8c0ad] text-[#b86033] focus:ring-[#b86033]/25"
                    >
                    <div>
                        <span class="text-sm font-medium text-stone-700">Approved</span>
                        <p class="mt-0.5 text-xs text-stone-400">Show this review on the website.</p>
                    </div>
                </label>

                {{-- Featured --}}
                <label class="flex cursor-pointer items-start gap-3 pt-4">
                    <input
                        type="checkbox" name="is_featured" value="1"
                        {{ old('is_featured', ($review->is_featured ?? false) ? '1' : null) ? 'checked' : '' }}
                        class="mt-0.5 h-4 w-4 rounded border-[#d8c0ad] text-[#b86033] focus:ring-[#b86033]/25"
                    >
                    <div>
                        <span class="text-sm font-medium text-stone-700">Featured</span>
                        <p class="mt-0.5 text-xs text-stone-400">Highlight in the home page carousel.</p>
                    </div>
                </label>

            </div>
        </div>

        {{-- Photo upload --}}
        <div class="overflow-hidden rounded-sm border border-[#e8d5c5] bg-white shadow-sm">
            <div class="flex items-center gap-2.5 border-b border-[#f0e4d8] bg-[#fdf8f5] px-5 py-3.5">
                <span class="flex h-7 w-7 items-center justify-center rounded-sm bg-[#6e2f0e]/10">
                    <svg class="h-3.5 w-3.5 text-[#6e2f0e]" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/></svg>
                </span>
                <h3 class="text-sm font-semibold text-stone-800">Reviewer Photo</h3>
            </div>
            <div class="p-5">

                @if (!empty($review->photo))
                    <div class="mb-4 flex items-center gap-3">
                        <img
                            src="{{ Storage::disk('public')->url($review->photo) }}"
                            alt="Current photo"
                            class="h-16 w-16 rounded-full object-cover border border-[#d8c0ad]"
                        >
                        <p class="text-xs text-stone-500">Upload a new photo to replace.</p>
                    </div>
                @endif

                <div
                    id="photo-drop-zone"
                    class="flex cursor-pointer flex-col items-center justify-center gap-2 rounded-sm border-2 border-dashed border-[#d8c0ad] bg-[#fdf8f5] px-4 py-8 text-center transition hover:border-[#b86033] hover:bg-[#fdf3ec]"
                    onclick="document.getElementById('photo').click()"
                >
                    <svg class="h-8 w-8 text-[#b86033]/60" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5"/>
                    </svg>
                    <div>
                        <p class="text-sm font-medium text-stone-700">Click to upload photo</p>
                        <p class="mt-0.5 text-xs text-stone-400">JPG, PNG or WebP — max 1 MB</p>
                    </div>
                    <div id="photo-filename" class="hidden rounded-sm bg-[#b86033]/10 px-3 py-1 text-xs font-medium text-[#6e2f0e]"></div>
                </div>

                <input
                    type="file" id="photo" name="photo" accept="image/jpeg,image/png,image/webp"
                    class="sr-only"
                    onchange="
                        const f = this.files[0];
                        const el = document.getElementById('photo-filename');
                        if (f) { el.textContent = f.name; el.classList.remove('hidden'); }
                        else { el.classList.add('hidden'); }
                    "
                >
                @error('photo')<p class="mt-2 text-xs text-red-600">{{ $message }}</p>@enderror

            </div>
        </div>

    </div>

</div>
