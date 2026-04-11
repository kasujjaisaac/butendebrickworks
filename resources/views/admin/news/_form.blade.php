{{-- Shared form partial for create and edit --}}

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

    {{-- ── LEFT: main content (2/3) ── --}}
    <div class="space-y-5 xl:col-span-2">

        {{-- Title --}}
        <div class="overflow-hidden rounded-sm border border-[#e8d5c5] bg-white shadow-sm">
            <div class="flex items-center gap-2.5 border-b border-[#f0e4d8] bg-[#fdf8f5] px-5 py-3.5">
                <span class="flex h-7 w-7 items-center justify-center rounded-sm bg-[#6e2f0e]/10">
                    <svg class="h-3.5 w-3.5 text-[#6e2f0e]" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z"/></svg>
                </span>
                <h3 class="text-sm font-semibold text-stone-800">Post Details</h3>
            </div>
            <div class="space-y-5 p-5">

                {{-- Title --}}
                <div>
                    <label for="title" class="mb-1.5 block text-sm font-medium text-stone-700">
                        Title <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text" id="title" name="title"
                        value="{{ old('title', $post->title ?? '') }}"
                        placeholder="e.g. Our New Range of Face Bricks"
                        class="w-full rounded-sm border px-4 py-2.5 text-sm text-stone-900 placeholder-stone-400 shadow-sm transition focus:outline-none focus:ring-2 focus:ring-[#b86033]/25
                               {{ $errors->has('title') ? 'border-red-400 bg-red-50 focus:border-red-400' : 'border-[#d8c0ad] bg-white focus:border-[#b86033]' }}"
                    >
                    @error('title')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                {{-- Category --}}
                <div>
                    <label for="category" class="mb-1.5 block text-sm font-medium text-stone-700">
                        Category <span class="text-red-500">*</span>
                    </label>
                    <select
                        id="category" name="category"
                        class="w-full rounded-sm border px-4 py-2.5 text-sm text-stone-900 shadow-sm transition focus:outline-none focus:ring-2 focus:ring-[#b86033]/25
                               {{ $errors->has('category') ? 'border-red-400 bg-red-50 focus:border-red-400' : 'border-[#d8c0ad] bg-white focus:border-[#b86033]' }}"
                    >
                        @foreach (['News', 'Publication', 'Guide', 'Announcement', 'Design', 'Industry'] as $cat)
                            <option value="{{ $cat }}" {{ old('category', $post->category ?? 'News') === $cat ? 'selected' : '' }}>
                                {{ $cat }}
                            </option>
                        @endforeach
                    </select>
                    @error('category')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                {{-- Excerpt --}}
                <div>
                    <label for="excerpt" class="mb-1.5 block text-sm font-medium text-stone-700">
                        Excerpt <span class="text-xs font-normal text-stone-400">(optional — shown on listing page)</span>
                    </label>
                    <textarea
                        id="excerpt" name="excerpt" rows="2"
                        placeholder="A short summary shown on the news listing page…"
                        class="w-full resize-none rounded-sm border px-4 py-2.5 text-sm text-stone-900 placeholder-stone-400 shadow-sm transition focus:outline-none focus:ring-2 focus:ring-[#b86033]/25
                               {{ $errors->has('excerpt') ? 'border-red-400 bg-red-50' : 'border-[#d8c0ad] bg-white focus:border-[#b86033]' }}"
                    >{{ old('excerpt', $post->excerpt ?? '') }}</textarea>
                    @error('excerpt')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

            </div>
        </div>

        {{-- Content --}}
        <div class="overflow-hidden rounded-sm border border-[#e8d5c5] bg-white shadow-sm">
            <div class="flex items-center gap-2.5 border-b border-[#f0e4d8] bg-[#fdf8f5] px-5 py-3.5">
                <span class="flex h-7 w-7 items-center justify-center rounded-sm bg-[#6e2f0e]/10">
                    <svg class="h-3.5 w-3.5 text-[#6e2f0e]" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12"/></svg>
                </span>
                <h3 class="text-sm font-semibold text-stone-800">Content</h3>
            </div>
            <div class="p-5">
                <textarea
                    id="content" name="content" rows="16"
                    placeholder="Write your post content here…"
                    class="w-full rounded-sm border px-4 py-3 font-mono text-sm text-stone-900 placeholder-stone-400 shadow-sm transition focus:outline-none focus:ring-2 focus:ring-[#b86033]/25
                           {{ $errors->has('content') ? 'border-red-400 bg-red-50' : 'border-[#d8c0ad] bg-white focus:border-[#b86033]' }}"
                >{{ old('content', $post->content ?? '') }}</textarea>
                @error('content')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>

    </div>

    {{-- ── RIGHT: image + publish ── --}}
    <div class="space-y-5">

        {{-- Publish settings --}}
        <div class="overflow-hidden rounded-sm border border-[#e8d5c5] bg-white shadow-sm">
            <div class="flex items-center gap-2.5 border-b border-[#f0e4d8] bg-[#fdf8f5] px-5 py-3.5">
                <span class="flex h-7 w-7 items-center justify-center rounded-sm bg-[#6e2f0e]/10">
                    <svg class="h-3.5 w-3.5 text-[#6e2f0e]" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253"/></svg>
                </span>
                <h3 class="text-sm font-semibold text-stone-800">Visibility</h3>
            </div>
            <div class="p-5">
                <label class="flex cursor-pointer items-center gap-3">
                    <input
                        type="checkbox"
                        name="is_published"
                        value="1"
                        {{ old('is_published', $post->is_published ?? false) ? 'checked' : '' }}
                        class="h-4 w-4 rounded border-[#d8c0ad] text-[#b86033] focus:ring-[#b86033]/25"
                    >
                    <span class="text-sm font-medium text-stone-700">Publish this post</span>
                </label>
                <p class="mt-2 text-xs text-stone-400">Unpublished posts are saved as drafts and not visible on the site.</p>
            </div>
        </div>

        {{-- Featured image --}}
        <div class="overflow-hidden rounded-sm border border-[#e8d5c5] bg-white shadow-sm">
            <div class="flex items-center gap-2.5 border-b border-[#f0e4d8] bg-[#fdf8f5] px-5 py-3.5">
                <span class="flex h-7 w-7 items-center justify-center rounded-sm bg-[#6e2f0e]/10">
                    <svg class="h-3.5 w-3.5 text-[#6e2f0e]" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"/></svg>
                </span>
                <h3 class="text-sm font-semibold text-stone-800">Featured Image</h3>
            </div>
            <div class="p-5 space-y-3">
                @if (!empty($post->image))
                    <div class="overflow-hidden rounded-sm border border-[#e8d5c5]">
                        <img src="{{ Storage::url($post->image) }}" alt="Current image" class="w-full object-cover" style="max-height:160px">
                    </div>
                    <p class="text-xs text-stone-400">Upload a new image to replace the current one.</p>
                @endif
                <label
                    for="image"
                    class="flex cursor-pointer flex-col items-center justify-center gap-2 rounded-sm border-2 border-dashed border-[#d8c0ad] bg-[#fdf8f5] px-4 py-6 text-center transition hover:border-[#b86033] hover:bg-[#fff7f0]"
                >
                    <svg class="h-8 w-8 text-stone-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5"/></svg>
                    <span class="text-sm text-stone-500">Click to upload <span class="font-medium text-[#b86033]">or drag & drop</span></span>
                    <span class="text-xs text-stone-400">PNG, JPG, WEBP up to 2 MB</span>
                    <input type="file" id="image" name="image" accept="image/*" class="sr-only">
                </label>
                @error('image')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>

    </div>
</div>
