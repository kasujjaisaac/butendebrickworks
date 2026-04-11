@extends('layouts.admin')

@php
    $previewUrl = function (?string $path): ?string {
        if (! is_string($path) || $path === '') {
            return null;
        }

        if (filter_var($path, FILTER_VALIDATE_URL) || str_starts_with($path, '/')) {
            return $path;
        }

        return asset($path);
    };

    $logoPreview = $previewUrl($company['logo_path'] ?? null);
    $heroPreview = $previewUrl($company['hero_image'] ?? null);
    $aboutPreview = $previewUrl($company['about_image'] ?? null);
@endphp

@section('admin-content')
    <div class="space-y-8">
        <section class="rounded-sm border border-[#d8c0ad] bg-white p-6 shadow-[0_12px_28px_rgba(0,0,0,0.04)]">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-[#a25f38]">Publishing Rules</p>
                    <h2 class="mt-2 font-display text-2xl font-semibold text-stone-950">Homepage content editor</h2>
                </div>
                <p class="max-w-2xl text-sm leading-7 text-stone-600">
                    Edit the homepage here. Changes publish instantly to the live site, and uploaded images are stored on the public disk.
                </p>
            </div>
        </section>

        <section class="rounded-sm border border-[#d8c0ad] bg-white p-6 shadow-[0_12px_28px_rgba(0,0,0,0.04)]">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-[#a25f38]">Company Profile</p>
                    <h2 class="mt-2 font-display text-2xl font-semibold text-stone-950">Business identity, contact details, and images</h2>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.home.company.update') }}" enctype="multipart/form-data" class="mt-8 space-y-8" x-data='{
                emails: @js($company["emails"] ?? []),
                phones: @js($company["phones"] ?? []),
                story: @js($company["story"] ?? []),
            }'>
                @csrf
                @method('PUT')

                <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-4">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-stone-900">Company name</label>
                        <input type="text" name="name" value="{{ old('name', $company['name']) }}" class="outline-form-input">
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium text-stone-900">Short name</label>
                        <input type="text" name="short_name" value="{{ old('short_name', $company['short_name']) }}" class="outline-form-input">
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium text-stone-900">Founded</label>
                        <input type="text" name="founded" value="{{ old('founded', $company['founded']) }}" class="outline-form-input">
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium text-stone-900">Years label</label>
                        <input type="text" name="years" value="{{ old('years', $company['years']) }}" class="outline-form-input">
                    </div>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-stone-900">Tagline</label>
                    <input type="text" name="tagline" value="{{ old('tagline', $company['tagline']) }}" class="outline-form-input">
                </div>

                <div class="grid gap-5 xl:grid-cols-3">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-stone-900">Mission</label>
                        <textarea name="mission" class="outline-form-textarea">{{ old('mission', $company['mission']) }}</textarea>
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium text-stone-900">Vision</label>
                        <textarea name="vision" class="outline-form-textarea">{{ old('vision', $company['vision']) }}</textarea>
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium text-stone-900">History</label>
                        <textarea name="history" class="outline-form-textarea">{{ old('history', $company['history']) }}</textarea>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-sm font-semibold text-stone-950">Story paragraphs</p>
                            <p class="text-sm text-stone-500">These paragraphs feed the About page story section.</p>
                        </div>
                        <button type="button" class="rounded-sm border border-[#b86033] px-4 py-2 text-sm font-medium text-stone-900 transition hover:bg-[#fff1e7]" @click="story.push('')">
                            Add paragraph
                        </button>
                    </div>

                    <div class="space-y-4">
                        <template x-for="(paragraph, index) in story" :key="index">
                            <div class="rounded-sm border border-[#ead7c9] bg-[#fff9f4] p-4">
                                <div class="flex items-center justify-between gap-4">
                                    <p class="text-sm font-semibold text-stone-950" x-text="`Paragraph ${index + 1}`"></p>
                                    <button type="button" class="text-sm font-medium text-rose-600" @click="story.splice(index, 1)" x-show="story.length > 1">Remove</button>
                                </div>
                                <textarea :name="`story[${index}]`" x-model="story[index]" class="outline-form-textarea mt-3"></textarea>
                            </div>
                        </template>
                    </div>
                </div>

                <div class="grid gap-5 xl:grid-cols-2">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <p class="text-sm font-semibold text-stone-950">Email addresses</p>
                            </div>
                            <button type="button" class="rounded-sm border border-[#b86033] px-4 py-2 text-sm font-medium text-stone-900 transition hover:bg-[#fff1e7]" @click="emails.push('')">
                                Add email
                            </button>
                        </div>
                        <template x-for="(email, index) in emails" :key="index">
                            <div class="flex gap-3">
                                <input type="email" :name="`emails[${index}]`" x-model="emails[index]" class="outline-form-input">
                                <button type="button" class="rounded-sm border border-[#ead7c9] px-4 py-3 text-sm font-medium text-rose-600" @click="emails.splice(index, 1)" x-show="emails.length > 1">Remove</button>
                            </div>
                        </template>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <p class="text-sm font-semibold text-stone-950">Phone numbers</p>
                            </div>
                            <button type="button" class="rounded-sm border border-[#b86033] px-4 py-2 text-sm font-medium text-stone-900 transition hover:bg-[#fff1e7]" @click="phones.push('')">
                                Add phone
                            </button>
                        </div>
                        <template x-for="(phone, index) in phones" :key="index">
                            <div class="flex gap-3">
                                <input type="text" :name="`phones[${index}]`" x-model="phones[index]" class="outline-form-input">
                                <button type="button" class="rounded-sm border border-[#ead7c9] px-4 py-3 text-sm font-medium text-rose-600" @click="phones.splice(index, 1)" x-show="phones.length > 1">Remove</button>
                            </div>
                        </template>
                    </div>
                </div>

                <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-4">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-stone-900">Primary phone href</label>
                        <input type="text" name="primary_phone_href" value="{{ old('primary_phone_href', $company['primary_phone_href']) }}" class="outline-form-input">
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium text-stone-900">WhatsApp number</label>
                        <input type="text" name="whatsapp_href" value="{{ old('whatsapp_href', $company['whatsapp_href']) }}" class="outline-form-input">
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium text-stone-900">Hours</label>
                        <input type="text" name="hours" value="{{ old('hours', $company['hours']) }}" class="outline-form-input">
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium text-stone-900">Facebook URL</label>
                        <input type="url" name="facebook" value="{{ old('facebook', $company['facebook']) }}" class="outline-form-input">
                    </div>
                </div>

                <div class="grid gap-5 xl:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-stone-900">Address</label>
                        <input type="text" name="address" value="{{ old('address', $company['address']) }}" class="outline-form-input">
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium text-stone-900">Address hint</label>
                        <input type="text" name="address_hint" value="{{ old('address_hint', $company['address_hint']) }}" class="outline-form-input">
                    </div>
                </div>

                <div class="grid gap-5 xl:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-stone-900">Map URL</label>
                        <input type="url" name="map_url" value="{{ old('map_url', $company['map_url']) }}" class="outline-form-input">
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium text-stone-900">Map embed URL</label>
                        <input type="url" name="map_embed" value="{{ old('map_embed', $company['map_embed']) }}" class="outline-form-input">
                    </div>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-stone-900">Meta description</label>
                    <textarea name="meta_description" class="outline-form-textarea">{{ old('meta_description', $company['meta_description']) }}</textarea>
                </div>

                <div class="grid gap-5 xl:grid-cols-3">
                    <div class="rounded-sm border border-[#ead7c9] bg-[#fff9f4] p-4">
                        <label class="mb-3 block text-sm font-medium text-stone-900">Logo upload</label>
                        @if ($logoPreview)
                            <img src="{{ $logoPreview }}" alt="Current logo" class="mb-4 h-24 w-auto rounded-sm border border-[#ead7c9] bg-white object-contain p-2">
                        @endif
                        <input type="file" name="logo_upload" accept="image/*" class="block w-full text-sm text-stone-600">
                    </div>
                    <div class="rounded-sm border border-[#ead7c9] bg-[#fff9f4] p-4">
                        <label class="mb-3 block text-sm font-medium text-stone-900">Hero image upload</label>
                        @if ($heroPreview)
                            <img src="{{ $heroPreview }}" alt="Current hero image" class="mb-4 h-32 w-full rounded-sm border border-[#ead7c9] object-cover">
                        @endif
                        <input type="file" name="hero_image_upload" accept="image/*" class="block w-full text-sm text-stone-600">
                    </div>
                    <div class="rounded-sm border border-[#ead7c9] bg-[#fff9f4] p-4">
                        <label class="mb-3 block text-sm font-medium text-stone-900">About image upload</label>
                        @if ($aboutPreview)
                            <img src="{{ $aboutPreview }}" alt="Current about image" class="mb-4 h-32 w-full rounded-sm border border-[#ead7c9] object-cover">
                        @endif
                        <input type="file" name="about_image_upload" accept="image/*" class="block w-full text-sm text-stone-600">
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="rounded-sm bg-[#b86033] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#cd6e3a]">
                        Save Company Settings
                    </button>
                </div>
            </form>
        </section>

        <div class="grid gap-8 xl:grid-cols-2">
            <section class="rounded-sm border border-[#d8c0ad] bg-white p-6 shadow-[0_12px_28px_rgba(0,0,0,0.04)]">
                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-[#a25f38]">Hero Slides</p>
                <h2 class="mt-2 font-display text-2xl font-semibold text-stone-950">Rotating hero messages</h2>

                <form method="POST" action="{{ route('admin.home.hero-slides.update') }}" class="mt-6 space-y-4" x-data='{ items: @js($heroSlides) }'>
                    @csrf
                    @method('PUT')

                    <template x-for="(item, index) in items" :key="index">
                        <div class="rounded-sm border border-[#ead7c9] bg-[#fff9f4] p-4">
                            <div class="flex items-center justify-between gap-4">
                                <p class="text-sm font-semibold text-stone-950" x-text="`Slide ${index + 1}`"></p>
                                <button type="button" class="text-sm font-medium text-rose-600" @click="items.splice(index, 1)" x-show="items.length > 1">Remove</button>
                            </div>

                            <div class="mt-4 space-y-4">
                                <div>
                                    <label class="mb-2 block text-sm font-medium text-stone-900">Headline</label>
                                    <input type="text" :name="`items[${index}][headline]`" x-model="item.headline" class="outline-form-input">
                                </div>
                                <div>
                                    <label class="mb-2 block text-sm font-medium text-stone-900">Body</label>
                                    <textarea :name="`items[${index}][body]`" x-model="item.body" class="outline-form-textarea"></textarea>
                                </div>
                                <div class="grid gap-4 md:grid-cols-2">
                                    <div>
                                        <label class="mb-2 block text-sm font-medium text-stone-900">Primary button label</label>
                                        <input type="text" :name="`items[${index}][primary][label]`" x-model="item.primary.label" class="outline-form-input">
                                    </div>
                                    <div>
                                        <label class="mb-2 block text-sm font-medium text-stone-900">Primary button link</label>
                                        <input type="text" :name="`items[${index}][primary][link]`" x-model="item.primary.link" class="outline-form-input">
                                    </div>
                                    <div>
                                        <label class="mb-2 block text-sm font-medium text-stone-900">Secondary button label</label>
                                        <input type="text" :name="`items[${index}][secondary][label]`" x-model="item.secondary.label" class="outline-form-input">
                                    </div>
                                    <div>
                                        <label class="mb-2 block text-sm font-medium text-stone-900">Secondary button link</label>
                                        <input type="text" :name="`items[${index}][secondary][link]`" x-model="item.secondary.link" class="outline-form-input">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>

                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <button type="button" class="rounded-sm border border-[#b86033] px-4 py-2 text-sm font-medium text-stone-900 transition hover:bg-[#fff1e7]" @click="items.push({ headline: '', body: '', primary: { label: '', link: '#request-quote' }, secondary: { label: '', link: '/products' } })">
                            Add Slide
                        </button>
                        <button type="submit" class="rounded-sm bg-[#b86033] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#cd6e3a]">
                            Save Hero Slides
                        </button>
                    </div>
                </form>
            </section>

            <section class="rounded-sm border border-[#d8c0ad] bg-white p-6 shadow-[0_12px_28px_rgba(0,0,0,0.04)]">
                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-[#a25f38]">Stats Band</p>
                <h2 class="mt-2 font-display text-2xl font-semibold text-stone-950">Homepage numbers</h2>

                <form method="POST" action="{{ route('admin.home.stats.update') }}" class="mt-6 space-y-4" x-data='{ items: @js($stats) }'>
                    @csrf
                    @method('PUT')

                    <template x-for="(item, index) in items" :key="index">
                        <div class="grid gap-4 rounded-sm border border-[#ead7c9] bg-[#fff9f4] p-4 md:grid-cols-[1fr_1fr_auto]">
                            <div>
                                <label class="mb-2 block text-sm font-medium text-stone-900">Value</label>
                                <input type="text" :name="`items[${index}][value]`" x-model="item.value" class="outline-form-input">
                            </div>
                            <div>
                                <label class="mb-2 block text-sm font-medium text-stone-900">Label</label>
                                <input type="text" :name="`items[${index}][label]`" x-model="item.label" class="outline-form-input">
                            </div>
                            <div class="flex items-end">
                                <button type="button" class="rounded-sm border border-[#ead7c9] px-4 py-3 text-sm font-medium text-rose-600" @click="items.splice(index, 1)" x-show="items.length > 1">Remove</button>
                            </div>
                        </div>
                    </template>

                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <button type="button" class="rounded-sm border border-[#b86033] px-4 py-2 text-sm font-medium text-stone-900 transition hover:bg-[#fff1e7]" @click="items.push({ value: '', label: '' })">
                            Add Stat
                        </button>
                        <button type="submit" class="rounded-sm bg-[#b86033] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#cd6e3a]">
                            Save Stats
                        </button>
                    </div>
                </form>
            </section>

            <section class="rounded-sm border border-[#d8c0ad] bg-white p-6 shadow-[0_12px_28px_rgba(0,0,0,0.04)]">
                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-[#a25f38]">What We Do</p>
                <h2 class="mt-2 font-display text-2xl font-semibold text-stone-950">Capability cards</h2>

                <form method="POST" action="{{ route('admin.home.capabilities.update') }}" class="mt-6 space-y-4" x-data='{ items: @js($capabilities) }'>
                    @csrf
                    @method('PUT')

                    <template x-for="(item, index) in items" :key="index">
                        <div class="rounded-sm border border-[#ead7c9] bg-[#fff9f4] p-4">
                            <div class="flex items-center justify-between gap-4">
                                <p class="text-sm font-semibold text-stone-950" x-text="`Card ${index + 1}`"></p>
                                <button type="button" class="text-sm font-medium text-rose-600" @click="items.splice(index, 1)" x-show="items.length > 1">Remove</button>
                            </div>
                            <div class="mt-4 space-y-4">
                                <div>
                                    <label class="mb-2 block text-sm font-medium text-stone-900">Title</label>
                                    <input type="text" :name="`items[${index}][title]`" x-model="item.title" class="outline-form-input">
                                </div>
                                <div>
                                    <label class="mb-2 block text-sm font-medium text-stone-900">Description</label>
                                    <textarea :name="`items[${index}][description]`" x-model="item.description" class="outline-form-textarea"></textarea>
                                </div>
                            </div>
                        </div>
                    </template>

                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <button type="button" class="rounded-sm border border-[#b86033] px-4 py-2 text-sm font-medium text-stone-900 transition hover:bg-[#fff1e7]" @click="items.push({ title: '', description: '' })">
                            Add Card
                        </button>
                        <button type="submit" class="rounded-sm bg-[#b86033] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#cd6e3a]">
                            Save Capabilities
                        </button>
                    </div>
                </form>
            </section>

            <section class="rounded-sm border border-[#d8c0ad] bg-white p-6 shadow-[0_12px_28px_rgba(0,0,0,0.04)]">
                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-[#a25f38]">How We Work</p>
                <h2 class="mt-2 font-display text-2xl font-semibold text-stone-950">Process steps</h2>

                <form method="POST" action="{{ route('admin.home.process.update') }}" class="mt-6 space-y-4" x-data='{ items: @js($process) }'>
                    @csrf
                    @method('PUT')

                    <template x-for="(item, index) in items" :key="index">
                        <div class="rounded-sm border border-[#ead7c9] bg-[#fff9f4] p-4">
                            <div class="flex items-center justify-between gap-4">
                                <p class="text-sm font-semibold text-stone-950" x-text="`Step ${index + 1}`"></p>
                                <button type="button" class="text-sm font-medium text-rose-600" @click="items.splice(index, 1)" x-show="items.length > 1">Remove</button>
                            </div>
                            <div class="mt-4 space-y-4">
                                <div>
                                    <label class="mb-2 block text-sm font-medium text-stone-900">Title</label>
                                    <input type="text" :name="`items[${index}][title]`" x-model="item.title" class="outline-form-input">
                                </div>
                                <div>
                                    <label class="mb-2 block text-sm font-medium text-stone-900">Description</label>
                                    <textarea :name="`items[${index}][description]`" x-model="item.description" class="outline-form-textarea"></textarea>
                                </div>
                            </div>
                        </div>
                    </template>

                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <button type="button" class="rounded-sm border border-[#b86033] px-4 py-2 text-sm font-medium text-stone-900 transition hover:bg-[#fff1e7]" @click="items.push({ title: '', description: '' })">
                            Add Step
                        </button>
                        <button type="submit" class="rounded-sm bg-[#b86033] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#cd6e3a]">
                            Save Process
                        </button>
                    </div>
                </form>
            </section>

            <section class="rounded-sm border border-[#d8c0ad] bg-white p-6 shadow-[0_12px_28px_rgba(0,0,0,0.04)]">
                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-[#a25f38]">Client Reviews</p>
                <h2 class="mt-2 font-display text-2xl font-semibold text-stone-950">Sliding testimonial content</h2>

                <form method="POST" action="{{ route('admin.home.testimonials.update') }}" class="mt-6 space-y-4" x-data='{ items: @js($testimonials) }'>
                    @csrf
                    @method('PUT')

                    <template x-for="(item, index) in items" :key="index">
                        <div class="rounded-sm border border-[#ead7c9] bg-[#fff9f4] p-4">
                            <div class="flex items-center justify-between gap-4">
                                <p class="text-sm font-semibold text-stone-950" x-text="`Review ${index + 1}`"></p>
                                <button type="button" class="text-sm font-medium text-rose-600" @click="items.splice(index, 1)" x-show="items.length > 1">Remove</button>
                            </div>
                            <div class="mt-4 space-y-4">
                                <div class="grid gap-4 md:grid-cols-2">
                                    <div>
                                        <label class="mb-2 block text-sm font-medium text-stone-900">Reviewer name</label>
                                        <input type="text" :name="`items[${index}][name]`" x-model="item.name" class="outline-form-input">
                                    </div>
                                    <div>
                                        <label class="mb-2 block text-sm font-medium text-stone-900">Role</label>
                                        <input type="text" :name="`items[${index}][role]`" x-model="item.role" class="outline-form-input">
                                    </div>
                                </div>
                                <div>
                                    <label class="mb-2 block text-sm font-medium text-stone-900">Quote</label>
                                    <textarea :name="`items[${index}][quote]`" x-model="item.quote" class="outline-form-textarea"></textarea>
                                </div>
                            </div>
                        </div>
                    </template>

                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <button type="button" class="rounded-sm border border-[#b86033] px-4 py-2 text-sm font-medium text-stone-900 transition hover:bg-[#fff1e7]" @click="items.push({ name: '', role: '', quote: '' })">
                            Add Review
                        </button>
                        <button type="submit" class="rounded-sm bg-[#b86033] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#cd6e3a]">
                            Save Reviews
                        </button>
                    </div>
                </form>
            </section>

            <section class="rounded-sm border border-[#d8c0ad] bg-white p-6 shadow-[0_12px_28px_rgba(0,0,0,0.04)]">
                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-[#a25f38]">Clients and Partners</p>
                <h2 class="mt-2 font-display text-2xl font-semibold text-stone-950">Partner logo band content</h2>

                <form method="POST" action="{{ route('admin.home.partners.update') }}" class="mt-6 space-y-4" x-data='{ items: @js($partners) }'>
                    @csrf
                    @method('PUT')

                    <template x-for="(item, index) in items" :key="index">
                        <div class="grid gap-4 rounded-sm border border-[#ead7c9] bg-[#fff9f4] p-4 md:grid-cols-[1fr_1fr_auto]">
                            <div>
                                <label class="mb-2 block text-sm font-medium text-stone-900">Partner name</label>
                                <input type="text" :name="`items[${index}][name]`" x-model="item.name" class="outline-form-input">
                            </div>
                            <div>
                                <label class="mb-2 block text-sm font-medium text-stone-900">Type or role</label>
                                <input type="text" :name="`items[${index}][type]`" x-model="item.type" class="outline-form-input">
                            </div>
                            <div class="flex items-end">
                                <button type="button" class="rounded-sm border border-[#ead7c9] px-4 py-3 text-sm font-medium text-rose-600" @click="items.splice(index, 1)" x-show="items.length > 1">Remove</button>
                            </div>
                        </div>
                    </template>

                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <button type="button" class="rounded-sm border border-[#b86033] px-4 py-2 text-sm font-medium text-stone-900 transition hover:bg-[#fff1e7]" @click="items.push({ name: '', type: '' })">
                            Add Partner
                        </button>
                        <button type="submit" class="rounded-sm bg-[#b86033] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#cd6e3a]">
                            Save Partners
                        </button>
                    </div>
                </form>
            </section>
        </div>
    </div>
@endsection
