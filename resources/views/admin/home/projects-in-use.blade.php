@extends('layouts.admin')

@section('admin-content')
    <div class="space-y-8">
        <section class="rounded-lg border border-stone-200 bg-white p-8 shadow-sm">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-[#a25f38]">Product capabilities</p>
                    <h1 class="mt-3 text-3xl font-semibold tracking-tight text-stone-950">Products in use gallery</h1>
                    <p class="mt-4 text-sm leading-7 text-stone-600">Manage the image gallery used on the public Products Capabilities page.</p>
                </div>
            </div>
        </section>

        <section class="rounded-lg border border-stone-200 bg-white p-8 shadow-sm">
            <form method="POST" action="{{ route('admin.home.projects-in-use.update') }}" class="space-y-6" x-data="{ items: @js($projectsInUse) }" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <template x-for="(item, index) in items" :key="index">
                    <div class="border border-stone-300 bg-stone-50/80 p-6">
                        <div class="flex items-center justify-between gap-4">
                            <p class="text-sm font-semibold text-stone-950" x-text="`Project ${index + 1}`"></p>
                            <button type="button" class="text-sm font-medium text-rose-600 hover:text-rose-700" @click="items.splice(index, 1)" x-show="items.length > 1">Remove</button>
                        </div>

                        <div class="mt-4 space-y-4">
                            <div>
                                <label class="mb-2 block text-sm font-medium text-stone-900">Project image *</label>
                                <div x-show="item.image && !item.preview" class="mb-4 overflow-hidden border border-stone-200 bg-stone-100">
                                    <img :src="item.image" :alt="item.caption || 'Current image'" class="h-32 w-full object-cover">
                                </div>
                                <div x-show="item.preview" class="mb-4 overflow-hidden border border-stone-200 bg-stone-100">
                                    <img :src="item.preview" :alt="item.caption || 'Preview image'" class="h-32 w-full object-cover">
                                </div>
                                <input
                                    type="file"
                                    :name="`items[${index}][image_upload]`"
                                    accept="image/*"
                                    @change="const file = $event.target.files[0]; if (file) { item.image_upload = file; item.preview = URL.createObjectURL(file); }"
                                    class="block w-full text-sm text-stone-600 file:mr-4 file:rounded file:border-0 file:bg-stone-100 file:px-3 file:py-2 file:text-sm file:font-medium file:text-stone-700 hover:file:bg-stone-200"
                                >
                                <input type="hidden" :name="`items[${index}][image]`" :value="item.image">
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-medium text-stone-900">Caption *</label>
                                <input type="text" :name="`items[${index}][caption]`" x-model="item.caption" placeholder="Brick walling on a residential homestead" class="w-full border border-stone-300 px-3 py-2 text-sm focus:border-stone-500 focus:outline-none">
                            </div>

                            <div class="grid gap-4 md:grid-cols-2">
                                <div>
                                    <label class="mb-2 block text-sm font-medium text-stone-900">Product *</label>
                                    <input type="text" :name="`items[${index}][product]`" x-model="item.product" placeholder="Bricks" class="w-full border border-stone-300 px-3 py-2 text-sm focus:border-stone-500 focus:outline-none">
                                </div>
                                <div>
                                    <label class="mb-2 block text-sm font-medium text-stone-900">Category *</label>
                                    <input type="text" :name="`items[${index}][category]`" x-model="item.category" placeholder="Residential" class="w-full border border-stone-300 px-3 py-2 text-sm focus:border-stone-500 focus:outline-none">
                                </div>
                            </div>

                            <div class="grid gap-4 md:grid-cols-2">
                                <div>
                                    <label class="mb-2 block text-sm font-medium text-stone-900">Tag *</label>
                                    <input type="text" :name="`items[${index}][tag]`" x-model="item.tag" placeholder="Residential" class="w-full border border-stone-300 px-3 py-2 text-sm focus:border-stone-500 focus:outline-none">
                                </div>
                                <div>
                                    <label class="mb-2 block text-sm font-medium text-stone-900">Layout</label>
                                    <select :name="`items[${index}][span]`" x-model="item.span" class="w-full border border-stone-300 px-3 py-2 text-sm focus:border-stone-500 focus:outline-none">
                                        <option value="normal">Normal</option>
                                        <option value="wide">Wide</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>

                <div class="flex flex-wrap items-center justify-between gap-4">
                    <button type="button" class="border border-[#b86033] px-4 py-2 text-sm font-medium text-stone-900 hover:bg-[#fff1e7]" @click="items.push({ image: '', caption: 'Brick walling on a residential homestead', product: 'Bricks', category: 'Residential', tag: 'Residential', span: 'normal', preview: '' })">
                        Add Project
                    </button>
                    <button type="submit" class="bg-[#b86033] px-5 py-3 text-sm font-semibold text-white hover:bg-[#cd6e3a]">
                        Save Gallery
                    </button>
                </div>
            </form>
        </section>
    </div>
@endsection
