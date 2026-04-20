@extends('layouts.site')

@section('content')

    {{-- ===== HERO ===== --}}
    <section class="relative overflow-hidden bg-[#6e2f0e] py-20 md:py-28">
        <div class="absolute inset-0 bg-[linear-gradient(135deg,#4a1e08_0%,#6e2f0e_50%,#8a3c12_100%)]"></div>
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(255,255,255,0.06),transparent_55%)]"></div>
        <div class="absolute inset-0 opacity-[0.03]" style="background-image:repeating-linear-gradient(0deg,#fff 0px,#fff 18px,transparent 18px,transparent 36px),repeating-linear-gradient(90deg,#fff 0px,#fff 1px,transparent 1px,transparent 60px);"></div>
        <div class="page-grid relative">
            <nav class="mb-8 flex items-center gap-2 text-xs text-white/50" aria-label="Breadcrumb">
                <a href="/" class="transition hover:text-white/80">Home</a>
                <svg class="h-3 w-3 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                <span class="text-white/80">Contact</span>
            </nav>
            <div class="grid gap-10 lg:grid-cols-2 lg:items-end">
                <div>
                    <span class="inline-block rounded-sm border border-white/25 bg-white/10 px-3 py-1 text-[0.68rem] font-semibold uppercase tracking-[0.28em] text-white/80">Get in touch</span>
                    <h1 class="mt-5 font-display text-4xl font-semibold leading-tight tracking-tight text-white md:text-5xl">
                        Reach the yard, the office, or the team.
                    </h1>
                    <p class="mt-5 max-w-md text-base leading-7 text-white/65">Whether you need a quote, product guidance, or just want to know what's available — we reply fast.</p>
                </div>
                {{-- Quick contact chips --}}
                <div class="flex flex-wrap gap-3 lg:justify-end lg:self-end">
                    <a href="tel:+{{ $company['primary_phone_href'] }}" class="flex items-center gap-2.5 rounded-sm border border-white/20 bg-white/10 px-4 py-2.5 text-sm font-semibold text-white backdrop-blur-sm transition hover:bg-white/20">
                        <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z"/></svg>
                        Call us
                    </a>
                    <a href="https://wa.me/{{ $company['whatsapp_href'] }}" target="_blank" rel="noreferrer" class="flex items-center gap-2.5 rounded-sm border border-white/20 bg-white/10 px-4 py-2.5 text-sm font-semibold text-white backdrop-blur-sm transition hover:bg-white/20">
                        <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                        WhatsApp
                    </a>
                    <a href="mailto:{{ $company['emails'][0] }}" class="flex items-center gap-2.5 rounded-sm border border-white/20 bg-white/10 px-4 py-2.5 text-sm font-semibold text-white backdrop-blur-sm transition hover:bg-white/20">
                        <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"/></svg>
                        Email
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== CONTACT DETAILS BAR ===== --}}
    <div class="border-b border-stone-200 bg-stone-50">
        <div class="page-grid grid grid-cols-2 gap-px overflow-hidden md:grid-cols-4">
            {{-- Email --}}
            <div class="flex items-start gap-3 bg-stone-50 px-2 py-5 sm:px-4">
                <div class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-sm bg-[#b86033]/10">
                    <svg class="h-4 w-4 text-[#b86033]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"/></svg>
                </div>
                <div>
                    <p class="text-[0.6rem] font-semibold uppercase tracking-widest text-stone-400">Email</p>
                    @foreach ($company['emails'] as $email)
                        <a href="mailto:{{ $email }}" class="mt-0.5 block text-xs font-medium text-stone-700 transition hover:text-[#b86033]">{{ $email }}</a>
                    @endforeach
                </div>
            </div>
            {{-- Phone --}}
            <div class="flex items-start gap-3 bg-stone-50 px-2 py-5 sm:px-4">
                <div class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-sm bg-[#b86033]/10">
                    <svg class="h-4 w-4 text-[#b86033]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z"/></svg>
                </div>
                <div>
                    <p class="text-[0.6rem] font-semibold uppercase tracking-widest text-stone-400">Phone</p>
                    @foreach ($company['phones'] as $phone)
                        <p class="mt-0.5 text-xs font-medium text-stone-700">{{ $phone }}</p>
                    @endforeach
                </div>
            </div>
            {{-- Address --}}
            <div class="flex items-start gap-3 bg-stone-50 px-2 py-5 sm:px-4">
                <div class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-sm bg-[#b86033]/10">
                    <svg class="h-4 w-4 text-[#b86033]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/></svg>
                </div>
                <div>
                    <p class="text-[0.6rem] font-semibold uppercase tracking-widest text-stone-400">Address</p>
                    <p class="mt-0.5 text-xs font-medium text-stone-700">{{ $company['address'] }}</p>
                    <p class="text-xs text-stone-400">{{ $company['address_hint'] }}</p>
                </div>
            </div>
            {{-- Hours --}}
            <div class="flex items-start gap-3 bg-stone-50 px-2 py-5 sm:px-4">
                <div class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-sm bg-[#b86033]/10">
                    <svg class="h-4 w-4 text-[#b86033]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                </div>
                <div>
                    <p class="text-[0.6rem] font-semibold uppercase tracking-widest text-stone-400">Hours</p>
                    <p class="mt-0.5 text-xs font-medium text-stone-700">{{ $company['hours'] }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== FORM + MAP SPLIT ===== --}}
    <section class="bg-white py-20"
        x-data="{
            tab: '{{ old('enquiry_type', 'general') }}',
            submitted: {{ session('talk_to_us_success') ? 'true' : 'false' }}
        }"
    >
        <div class="page-grid">
            <div class="grid gap-10 lg:grid-cols-[1fr_420px] xl:gap-16">

                {{-- ===== FORM ===== --}}
                <div>
                    <span class="eyebrow-light">Send a message</span>
                    <h2 class="section-title mt-4">How can we help?</h2>
                    <p class="mt-3 text-sm leading-7 text-stone-500">Fill in the form and our team will get back to you as soon as possible.</p>

                    {{-- Success --}}
                    @if (session('talk_to_us_success'))
                        <div class="mt-6 flex items-start gap-3 rounded-sm border border-emerald-200 bg-emerald-50 px-5 py-4">
                            <svg class="mt-0.5 h-5 w-5 shrink-0 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                            <p class="text-sm font-medium text-emerald-700">{{ session('talk_to_us_success') }}</p>
                        </div>
                    @endif

                    {{-- Validation errors --}}
                    @if ($errors->any())
                        <div class="mt-6 flex items-start gap-3 rounded-sm border border-rose-200 bg-rose-50 px-5 py-4">
                            <svg class="mt-0.5 h-5 w-5 shrink-0 text-rose-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z"/></svg>
                            <p class="text-sm font-medium text-rose-700">{{ $errors->first('form') ?: 'Please review the highlighted fields and try again.' }}</p>
                        </div>
                    @endif

                    {{-- Tab switcher: General / Request a Quote --}}
                    <div class="mt-8 flex overflow-hidden rounded-sm border border-stone-200 bg-stone-50 p-1" role="group">
                        <button
                            type="button"
                            @click="tab = 'general'"
                            :class="tab === 'general' ? 'bg-white text-stone-900 shadow-sm' : 'text-stone-500 hover:text-stone-700'"
                            class="flex-1 rounded-[2px] px-4 py-2 text-xs font-semibold uppercase tracking-[0.15em] transition duration-150"
                        >General message</button>
                        <button
                            type="button"
                            @click="tab = 'quote'"
                            :class="tab === 'quote' ? 'bg-white text-stone-900 shadow-sm' : 'text-stone-500 hover:text-stone-700'"
                            class="flex-1 rounded-[2px] px-4 py-2 text-xs font-semibold uppercase tracking-[0.15em] transition duration-150"
                        >Request a quote</button>
                    </div>

                    <form method="POST" action="{{ route('talk-to-us.store') }}" class="mt-7 grid gap-5">
                        @csrf
                        <input type="hidden" name="source_url" value="{{ url()->current() }}">
                        <input type="hidden" name="enquiry_type" :value="tab">
                        @include('site.partials.public-form-hardening-fields', ['honeypotId' => 'contact-honeypot'])

                        {{-- Name + Email --}}
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label for="c-name" class="form-label-light">Full name <span class="text-rose-500">*</span></label>
                                <input id="c-name" type="text" name="name" value="{{ old('name') }}"
                                    class="form-input @error('name') border-rose-400 @enderror"
                                    placeholder="Your full name" required>
                                @error('name')<p class="form-error-light">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="c-email" class="form-label-light">Email address <span class="text-rose-500">*</span></label>
                                <input id="c-email" type="email" name="email" value="{{ old('email') }}"
                                    class="form-input @error('email') border-rose-400 @enderror"
                                    placeholder="you@example.com" required>
                                @error('email')<p class="form-error-light">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        {{-- Phone --}}
                        <div>
                            <label for="c-phone" class="form-label-light">Phone number <span class="text-stone-400 font-normal normal-case tracking-normal">(optional)</span></label>
                            <input id="c-phone" type="text" name="phone" value="{{ old('phone') }}"
                                class="form-input @error('phone') border-rose-400 @enderror"
                                placeholder="+256 …">
                            @error('phone')<p class="form-error-light">{{ $message }}</p>@enderror
                        </div>

                        {{-- ===== GENERAL fields ===== --}}
                        <div x-show="tab === 'general'"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                        >
                            <div class="grid gap-5">
                                <div>
                                    <label for="c-subject" class="form-label-light">Subject <span class="text-rose-500">*</span></label>
                                    <input id="c-subject" type="text" name="subject" value="{{ old('subject') }}"
                                        class="form-input @error('subject') border-rose-400 @enderror"
                                        placeholder="e.g. Product enquiry">
                                    @error('subject')<p class="form-error-light">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="c-message" class="form-label-light">Message <span class="text-rose-500">*</span></label>
                                    <textarea id="c-message" name="message"
                                        class="form-textarea @error('message') border-rose-400 @enderror"
                                        placeholder="Tell us what you need or how we can help…"
                                        rows="5">{{ old('message') }}</textarea>
                                    @error('message')<p class="form-error-light">{{ $message }}</p>@enderror
                                </div>
                            </div>
                        </div>

                        {{-- ===== QUOTE fields ===== --}}
                        <div x-cloak x-show="tab === 'quote'"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                        >
                            <div class="grid gap-5">
                                <div class="grid gap-4 sm:grid-cols-2">
                                    <div>
                                        <label for="c-product" class="form-label-light">Product interest <span class="text-rose-500">*</span></label>
                                        <input id="c-product" type="text" name="product_interest" value="{{ old('product_interest') }}"
                                            class="form-input @error('product_interest') border-rose-400 @enderror"
                                            placeholder="e.g. Bricks, Floor Tiles">
                                        @error('product_interest')<p class="form-error-light">{{ $message }}</p>@enderror
                                    </div>
                                    <div>
                                        <label for="c-project-type" class="form-label-light">Project type <span class="text-rose-500">*</span></label>
                                        <input id="c-project-type" type="text" name="project_type" value="{{ old('project_type') }}"
                                            class="form-input @error('project_type') border-rose-400 @enderror"
                                            placeholder="e.g. Residential, Church">
                                        @error('project_type')<p class="form-error-light">{{ $message }}</p>@enderror
                                    </div>
                                </div>
                                <div>
                                    <label for="c-quantity" class="form-label-light">Quantity or scope <span class="text-rose-500">*</span></label>
                                    <input id="c-quantity" type="text" name="quantity" value="{{ old('quantity') }}"
                                        class="form-input @error('quantity') border-rose-400 @enderror"
                                        placeholder="e.g. 5,000 bricks, 3 bags of tiles">
                                    @error('quantity')<p class="form-error-light">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="c-details" class="form-label-light">Additional details <span class="text-stone-400 font-normal normal-case tracking-normal">(optional)</span></label>
                                    <textarea id="c-details" name="details"
                                        class="form-textarea @error('details') border-rose-400 @enderror"
                                        placeholder="Delivery location, timeline, special requirements…"
                                        rows="4">{{ old('details') }}</textarea>
                                    @error('details')<p class="form-error-light">{{ $message }}</p>@enderror
                                </div>
                            </div>
                        </div>

                        {{-- Submit --}}
                        <div class="pt-1">
                            <button type="submit" class="cta-form-submit-light">
                                <span x-text="tab === 'quote' ? 'Send quote request' : 'Send message'">Send message</span>
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
                            </button>
                            <p class="mt-3 text-center text-[0.65rem] font-medium uppercase tracking-widest text-stone-400">Your information is stored securely and never shared</p>
                        </div>
                    </form>
                </div>

                {{-- ===== RIGHT ASIDE ===== --}}
                <aside class="sticky top-6 self-start space-y-6">

                    {{-- Map --}}
                    <div class="overflow-hidden rounded-sm border border-stone-200 shadow-sm">
                        <div class="border-b border-stone-100 bg-stone-50 px-4 py-3">
                            <p class="text-[0.62rem] font-semibold uppercase tracking-widest text-stone-400">Find us</p>
                            <p class="mt-0.5 text-sm font-semibold text-stone-800">{{ $company['address'] }}</p>
                        </div>
                        <iframe
                            src="{{ $company['map_embed'] }}"
                            title="Butende Brick Works location on Google Maps"
                            class="block h-64 w-full border-0"
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                        ></iframe>
                        <div class="border-t border-stone-100 bg-white px-4 py-3">
                            <a href="{{ $company['map_url'] }}" target="_blank" rel="noreferrer"
                               class="inline-flex items-center gap-1.5 text-xs font-semibold text-[#b86033] transition hover:text-[#a0532b]">
                                Open in Google Maps
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                            </a>
                        </div>
                    </div>

                    {{-- Quick-action links --}}
                    <div class="rounded-sm border border-stone-200 bg-white p-5 shadow-sm">
                        <p class="text-[0.62rem] font-semibold uppercase tracking-widest text-stone-400">Prefer a direct line?</p>
                        <div class="mt-4 space-y-3">
                            <a href="tel:+{{ $company['primary_phone_href'] }}"
                               class="flex items-center gap-3 rounded-sm border border-stone-100 bg-stone-50 px-4 py-3 transition hover:border-stone-200 hover:bg-stone-100">
                                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-sm bg-[#b86033]/10">
                                    <svg class="h-4 w-4 text-[#b86033]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z"/></svg>
                                </span>
                                <div>
                                    <p class="text-xs font-semibold text-stone-800">Call the team</p>
                                    <p class="text-xs text-stone-500">{{ $company['phones'][0] }}</p>
                                </div>
                            </a>
                            <a href="https://wa.me/{{ $company['whatsapp_href'] }}" target="_blank" rel="noreferrer"
                               class="flex items-center gap-3 rounded-sm border border-stone-100 bg-stone-50 px-4 py-3 transition hover:border-stone-200 hover:bg-stone-100">
                                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-sm bg-[#b86033]/10">
                                    <svg class="h-4 w-4 text-[#b86033]" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                                </span>
                                <div>
                                    <p class="text-xs font-semibold text-stone-800">WhatsApp</p>
                                    <p class="text-xs text-stone-500">Quick conversation for quotes</p>
                                </div>
                            </a>
                            <a href="mailto:{{ $company['emails'][0] }}"
                               class="flex items-center gap-3 rounded-sm border border-stone-100 bg-stone-50 px-4 py-3 transition hover:border-stone-200 hover:bg-stone-100">
                                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-sm bg-[#b86033]/10">
                                    <svg class="h-4 w-4 text-[#b86033]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"/></svg>
                                </span>
                                <div>
                                    <p class="text-xs font-semibold text-stone-800">Email</p>
                                    <p class="text-xs text-stone-500">{{ $company['emails'][0] }}</p>
                                </div>
                            </a>
                        </div>
                    </div>

                </aside>
            </div>
        </div>
    </section>

    {{-- ===== CLOSING CTA ===== --}}
    <section class="bg-[#4a1e08] py-16">
        <div class="page-grid">
            <div class="grid gap-8 lg:grid-cols-[1fr_auto] lg:items-center">
                <div>
                    <span class="inline-block rounded-sm border border-white/25 bg-white/10 px-3 py-1 text-[0.68rem] font-semibold uppercase tracking-[0.28em] text-white/80">Explore first</span>
                    <h2 class="mt-4 font-display text-2xl font-semibold text-white md:text-3xl">Not sure what you need yet?</h2>
                    <p class="mt-3 max-w-lg text-sm leading-7 text-white/65">See how our bricks, tiles, and clay products perform in real projects — then get in touch when you're ready.</p>
                </div>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('capabilities') }}" class="inline-flex items-center gap-2 rounded-sm bg-[#b86033] px-6 py-3 text-sm font-semibold text-white transition hover:bg-[#a0532b]">
                        View capabilities
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
                    </a>
                    <a href="{{ route('faq') }}" class="inline-flex items-center gap-2 rounded-sm border border-white/25 px-6 py-3 text-sm font-semibold text-white transition hover:bg-white/10">
                        Read FAQs
                    </a>
                </div>
            </div>
        </div>
    </section>

@endsection
