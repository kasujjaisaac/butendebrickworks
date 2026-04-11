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
                <span class="text-white/80">FAQs</span>
            </nav>
            <div class="max-w-2xl">
                <span class="inline-block rounded-sm border border-white/25 bg-white/10 px-3 py-1 text-[0.68rem] font-semibold uppercase tracking-[0.28em] text-white/80">Frequently Asked Questions</span>
                <h1 class="mt-5 font-display text-4xl font-semibold leading-tight tracking-tight text-white md:text-5xl">
                    Questions we hear most often.
                </h1>
                <p class="mt-5 max-w-lg text-base leading-7 text-white/65">Everything about our products, ordering, location, and careers — answered clearly.</p>
            </div>
        </div>
    </section>

    {{-- FAQ data --}}
    <script type="application/json" id="faqs-data">@json($faqs)</script>

    {{-- ===== MAIN ===== --}}
    <section class="bg-white py-20" x-data="faqPage()">
        <div class="page-grid">
            <div class="grid gap-12 lg:grid-cols-[1fr_340px] xl:grid-cols-[1fr_380px]">

                {{-- ===== LEFT: search + tabs + accordion ===== --}}
                <div>

                    {{-- Search bar --}}
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-4 flex items-center">
                            <svg class="h-4 w-4 text-stone-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/></svg>
                        </div>
                        <input
                            type="search"
                            x-model="search"
                            placeholder="Search questions…"
                            class="w-full rounded-sm border border-stone-200 bg-stone-50 py-3 pl-11 pr-10 text-sm text-stone-800 placeholder-stone-400 outline-none transition focus:border-[#b86033] focus:bg-white focus:ring-2 focus:ring-[#b86033]/15"
                        >
                        <div class="absolute inset-y-0 right-3 flex items-center" x-cloak x-show="search">
                            <button
                                @click="search = ''"
                                class="rounded p-1 text-stone-400 transition hover:text-stone-700"
                                aria-label="Clear search"
                            >
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                    </div>

                    {{-- Category tabs --}}
                    <div class="mt-5 flex flex-wrap gap-2" role="group" aria-label="Filter by category">
                        <template x-for="cat in categories" :key="cat">
                            <button
                                type="button"
                                @click="activeCategory = cat"
                                :class="activeCategory === cat
                                    ? 'bg-[#b86033] text-white border-[#b86033]'
                                    : 'bg-white text-stone-600 border-stone-200 hover:border-stone-300 hover:bg-stone-50'"
                                class="inline-flex items-center gap-2 rounded-sm border px-3.5 py-1.5 text-xs font-semibold uppercase tracking-[0.15em] transition duration-150"
                            >
                                <span x-text="cat"></span>
                                <span
                                    :class="activeCategory === cat ? 'bg-white/20 text-white' : 'bg-stone-100 text-stone-500'"
                                    class="inline-flex h-4 min-w-[1rem] items-center justify-center rounded-full px-1 text-[0.6rem] font-bold leading-none"
                                    x-text="countFor(cat)"
                                ></span>
                            </button>
                        </template>
                    </div>

                    {{-- Result count --}}
                    <p class="mt-5 text-xs text-stone-400">
                        Showing <span class="font-semibold text-stone-600" x-text="filtered.length"></span>
                        <span x-text="filtered.length === 1 ? 'question' : 'questions'"></span>
                    </p>

                    {{-- Accordion --}}
                    <div class="mt-4 space-y-3">

                        {{-- Empty state --}}
                        <template x-if="filtered.length === 0">
                            <div class="rounded-sm border border-dashed border-stone-200 px-6 py-12 text-center">
                                <svg class="mx-auto h-9 w-9 text-stone-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z"/></svg>
                                <p class="mt-3 text-sm font-medium text-stone-400">No matching questions found.</p>
                                <button
                                    @click="search = ''; activeCategory = 'All'"
                                    class="mt-2 text-xs font-semibold text-[#b86033] underline underline-offset-2 transition hover:text-[#a0532b]"
                                >Clear filters</button>
                            </div>
                        </template>

                        {{-- FAQ items --}}
                        <template x-for="(faq, i) in filtered" :key="faq.question">
                            <div
                                class="group overflow-hidden rounded-sm border bg-white shadow-sm transition duration-200"
                                :class="openItem === i
                                    ? 'border-[#b86033] shadow-[0_0_0_3px_rgba(184,96,51,0.07)]'
                                    : 'border-stone-200 hover:border-stone-300 hover:shadow'"
                            >
                                {{-- Toggle button --}}
                                <button
                                    type="button"
                                    @click="toggle(i)"
                                    class="flex w-full items-center gap-4 px-5 py-4 text-left md:px-6 md:py-5"
                                    :aria-expanded="openItem === i"
                                >
                                    {{-- Left accent bar --}}
                                    <span
                                        class="h-5 w-0.5 shrink-0 rounded-full transition duration-200"
                                        :class="openItem === i ? 'bg-[#b86033]' : 'bg-stone-200 group-hover:bg-stone-300'"
                                    ></span>
                                    {{-- Question text --}}
                                    <span
                                        class="flex-1 font-display text-base font-semibold leading-snug transition duration-150"
                                        :class="openItem === i ? 'text-[#b86033]' : 'text-stone-900'"
                                        x-text="faq.question"
                                    ></span>
                                    {{-- Animated chevron --}}
                                    <svg
                                        class="h-4 w-4 shrink-0 transition duration-300"
                                        :class="openItem === i ? 'rotate-180 text-[#b86033]' : 'text-stone-400 group-hover:text-stone-600'"
                                        fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"
                                        aria-hidden="true"
                                    >
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
                                    </svg>
                                </button>

                                {{-- Answer panel --}}
                                <div
                                    x-cloak
                                    x-show="openItem === i"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 -translate-y-1"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    x-transition:leave="transition ease-in duration-150"
                                    x-transition:leave-start="opacity-100 translate-y-0"
                                    x-transition:leave-end="opacity-0 -translate-y-1"
                                    class="border-t border-stone-100 px-5 pb-6 pt-4 md:px-6"
                                >
                                    <p class="text-sm leading-7 text-stone-600" x-text="faq.answer"></p>
                                    <div class="mt-4 flex items-center gap-2">
                                        <span class="inline-block h-px w-5 bg-stone-200"></span>
                                        <span class="text-[0.62rem] font-semibold uppercase tracking-widest text-stone-400" x-text="faq.category"></span>
                                    </div>
                                </div>
                            </div>
                        </template>

                    </div>
                </div>

                {{-- ===== RIGHT: sticky aside ===== --}}
                <aside class="sticky top-6 self-start space-y-5">

                    {{-- Contact card --}}
                    <div class="overflow-hidden rounded-sm border border-stone-200 bg-white shadow-sm">
                        <div class="relative overflow-hidden bg-[#4a1e08] px-6 pt-6 pb-9">
                            <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_bottom_right,rgba(184,96,51,0.4),transparent_65%)]"></div>
                            <div class="relative">
                                <span class="inline-block rounded-sm border border-white/25 bg-white/10 px-2.5 py-0.5 text-[0.6rem] font-semibold uppercase tracking-widest text-white/70">Need help?</span>
                                <h2 class="mt-3 font-display text-xl font-semibold leading-snug text-white">The fastest route is a direct conversation.</h2>
                            </div>
                        </div>
                        <div class="px-6 py-5">
                            <p class="text-sm leading-6 text-stone-500">Product availability, quantity guidance, and the right profile for your project are easiest to confirm directly.</p>
                            <div class="mt-5 flex flex-col gap-2.5">
                                <a
                                    href="tel:{{ $company['primary_phone_href'] }}"
                                    class="flex items-center justify-center gap-2 rounded-sm bg-[#b86033] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#a0532b]"
                                >
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z"/></svg>
                                    Call us now
                                </a>
                                <a
                                    href="mailto:{{ $company['emails'][0] }}"
                                    class="flex items-center justify-center gap-2 rounded-sm border border-stone-200 bg-white px-4 py-2.5 text-sm font-semibold text-stone-700 transition hover:border-stone-300 hover:bg-stone-50"
                                >
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"/></svg>
                                    Send email
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Key details card --}}
                    <div class="rounded-sm border border-stone-200 bg-white p-6 shadow-sm">
                        <h3 class="text-[0.65rem] font-semibold uppercase tracking-widest text-stone-400">Key details</h3>
                        <div class="mt-4 space-y-4">
                            <div class="flex gap-3">
                                <div class="mt-0.5 flex h-7 w-7 shrink-0 items-center justify-center rounded-sm bg-[#b86033]/10">
                                    <svg class="h-3.5 w-3.5 text-[#b86033]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/></svg>
                                </div>
                                <div>
                                    <p class="text-[0.62rem] font-semibold uppercase tracking-wider text-stone-400">Address</p>
                                    <p class="mt-0.5 text-sm text-stone-700">{{ $company['address'] }}</p>
                                </div>
                            </div>
                            <div class="flex gap-3">
                                <div class="mt-0.5 flex h-7 w-7 shrink-0 items-center justify-center rounded-sm bg-[#b86033]/10">
                                    <svg class="h-3.5 w-3.5 text-[#b86033]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                                </div>
                                <div>
                                    <p class="text-[0.62rem] font-semibold uppercase tracking-wider text-stone-400">Hours</p>
                                    <p class="mt-0.5 text-sm text-stone-700">{{ $company['hours'] }}</p>
                                </div>
                            </div>
                            <div class="flex gap-3">
                                <div class="mt-0.5 flex h-7 w-7 shrink-0 items-center justify-center rounded-sm bg-[#b86033]/10">
                                    <svg class="h-3.5 w-3.5 text-[#b86033]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"/></svg>
                                </div>
                                <div>
                                    <p class="text-[0.62rem] font-semibold uppercase tracking-wider text-stone-400">Email</p>
                                    <a href="mailto:{{ $company['emails'][0] }}" class="mt-0.5 block text-sm text-[#b86033] transition hover:text-[#a0532b]">{{ $company['emails'][0] }}</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Products nudge --}}
                    <a
                        href="/products"
                        class="flex items-center justify-between gap-4 rounded-sm border border-[#b86033]/20 bg-[#b86033]/5 px-5 py-4 transition hover:bg-[#b86033]/10"
                    >
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-widest text-[#b86033]">Browse our products</p>
                            <p class="mt-0.5 text-xs text-stone-500">See the full fired clay range</p>
                        </div>
                        <svg class="h-4 w-4 shrink-0 text-[#b86033]" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
                    </a>

                </aside>
            </div>
        </div>
    </section>

    {{-- ===== CLOSING CTA ===== --}}
    <section class="bg-[#4a1e08] py-16">
        <div class="page-grid">
            <div class="grid gap-8 lg:grid-cols-[1fr_auto] lg:items-center">
                <div>
                    <span class="inline-block rounded-sm border border-white/25 bg-white/10 px-3 py-1 text-[0.68rem] font-semibold uppercase tracking-[0.28em] text-white/80">Still have questions?</span>
                    <h2 class="mt-4 font-display text-2xl font-semibold text-white md:text-3xl">We're happy to answer directly.</h2>
                    <p class="mt-3 max-w-lg text-sm leading-7 text-white/65">Use the contact page to send a specific question — or call us during working hours for an immediate response.</p>
                </div>
                <div class="flex flex-wrap gap-4">
                    <a href="/contact" class="inline-flex items-center gap-2 rounded-sm bg-[#b86033] px-6 py-3 text-sm font-semibold text-white transition hover:bg-[#a0532b]">
                        Contact us
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
                    </a>
                    <a href="tel:{{ $company['primary_phone_href'] }}" class="inline-flex items-center gap-2 rounded-sm border border-white/25 px-6 py-3 text-sm font-semibold text-white transition hover:bg-white/10">
                        Call now
                    </a>
                </div>
            </div>
        </div>
    </section>

@endsection

