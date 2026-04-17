@extends('layouts.admin')

@section('admin-content')
    <div class="space-y-8">
        <section class="rounded-lg border border-stone-200 bg-white p-8 shadow-sm">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-[#a25f38]">Product capabilities</p>
                    <h1 class="mt-3 text-3xl font-semibold tracking-tight text-stone-950">Edit Project</h1>
                    <p class="mt-4 text-sm leading-7 text-stone-600">Edit the project details.</p>
                </div>
            </div>
        </section>

        <section class="rounded-lg border border-stone-200 bg-white p-8 shadow-sm">
            <form method="POST" action="{{ route('admin.home.projects-in-use.update', $index) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @if ($errors->any())
                    <div class="mb-5 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                        <p class="font-semibold">There were problems with your submission.</p>
                        <ul class="mt-2 space-y-1 list-disc pl-5 text-rose-700">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="space-y-6">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-stone-900">Project image</label>
                        <div class="mb-4 overflow-hidden border border-stone-200 bg-stone-100">
                            <img src="{{ $project['image'] }}" alt="{{ $project['caption'] }}" class="h-32 w-full object-cover">
                        </div>
                        <input
                            type="file"
                            name="image_upload"
                            accept="image/*"
                            class="block w-full text-sm text-stone-600 file:mr-4 file:rounded file:border-0 file:bg-stone-100 file:px-3 file:py-2 file:text-sm file:font-medium file:text-stone-700 hover:file:bg-stone-200"
                        >
                        @error('image_upload')
                            <p class="mt-2 text-sm text-rose-700">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-stone-500">Maximum file size: 6MB. Supported formats: JPG, PNG, GIF, WebP.</p>
                        <input type="hidden" name="image" value="{{ old('image', $project['image']) }}">
                        @error('image')
                            <p class="mt-2 text-sm text-rose-700">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-stone-500">Leave empty to keep current image.</p>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-stone-900">Caption *</label>
                        <input type="text" name="caption" value="{{ old('caption', $project['caption']) }}" required class="w-full border border-stone-300 px-3 py-2 text-sm focus:border-stone-500 focus:outline-none">
                        @error('caption')
                            <p class="mt-2 text-sm text-rose-700">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label class="mb-2 block text-sm font-medium text-stone-900">Product *</label>
                            <input type="text" name="product" value="{{ old('product', $project['product']) }}" required class="w-full border border-stone-300 px-3 py-2 text-sm focus:border-stone-500 focus:outline-none">
                            @error('product')
                                <p class="mt-2 text-sm text-rose-700">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium text-stone-900">Category *</label>
                            <input type="text" name="category" value="{{ old('category', $project['category']) }}" required class="w-full border border-stone-300 px-3 py-2 text-sm focus:border-stone-500 focus:outline-none">
                            @error('category')
                                <p class="mt-2 text-sm text-rose-700">{{ $message }}</p>
                            @enderror
                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label class="mb-2 block text-sm font-medium text-stone-900">Tag *</label>
                            <input type="text" name="tag" value="{{ old('tag', $project['tag']) }}" required class="w-full border border-stone-300 px-3 py-2 text-sm focus:border-stone-500 focus:outline-none">
                            @error('tag')
                                <p class="mt-2 text-sm text-rose-700">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium text-stone-900">Layout</label>
                            <select name="span" class="w-full border border-stone-300 px-3 py-2 text-sm focus:border-stone-500 focus:outline-none">
                                <option value="normal" {{ old('span', $project['span']) == 'normal' ? 'selected' : '' }}>Normal</option>
                                <option value="wide" {{ old('span', $project['span']) == 'wide' ? 'selected' : '' }}>Wide</option>
                            </select>
                            @error('span')
                                <p class="mt-2 text-sm text-rose-700">{{ $message }}</p>
                            @enderror
                    <div class="flex gap-4">
                        <a href="{{ route('admin.home.projects-in-use.index') }}" class="border border-stone-300 px-4 py-2 text-sm font-medium text-stone-700 hover:bg-stone-50">
                            Cancel
                        </a>
                        <button type="submit" class="bg-[#b86033] px-5 py-2 text-sm font-semibold text-white hover:bg-[#cd6e3a]">
                            Update Project
                        </button>
                    </div>
                </div>
            </form>
        </section>
    </div>
@endsection