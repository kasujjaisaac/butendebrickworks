<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title ?? $company['name'] }}</title>
        <meta name="description" content="{{ $metaDescription ?? $company['meta_description'] }}">
        <meta name="theme-color" content="#b86033">
        <link rel="icon" type="image/jpeg" href="{{ asset('images/butende-logo.jpg') }}">
        <link rel="apple-touch-icon" href="{{ asset('images/butende-logo.jpg') }}">
        <meta property="og:title" content="{{ $title ?? $company['name'] }}">
        <meta property="og:description" content="{{ $metaDescription ?? $company['meta_description'] }}">
        <meta property="og:type" content="website">
        <meta property="og:site_name" content="{{ $company['name'] }}">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="site-shell">
        @php
            $currentPath = trim(request()->path(), '/');
        @endphp

        <div
            id="page-top"
            x-data="{ open: false, showTop: false, scrolled: false }"
            x-init="window.addEventListener('scroll', () => { showTop = window.scrollY > 420; scrolled = window.scrollY > 80 })"
            class="min-h-screen"
        >
            <header
                class="z-50 transition-all duration-300"
                :class="scrolled ? 'fixed top-0 left-0 right-0 shadow-lg' : 'relative'"
            >
                <div class="utility-bar hidden bg-[#6e2f0e] text-white lg:block">
                    <div class="page-grid flex items-center justify-between gap-4 py-2.5 text-sm">
                        <div class="flex flex-wrap items-center gap-4">
                            <a href="mailto:{{ $company['emails'][0] }}" class="flex items-center gap-1.5 text-white/80 transition hover:text-white">
                                <svg class="h-3.5 w-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"/></svg>
                                {{ $company['emails'][0] }}
                            </a>
                            <span class="text-white/30">|</span>
                            <a href="tel:{{ $company['primary_phone_href'] }}" class="flex items-center gap-1.5 text-white/80 transition hover:text-white">
                                <svg class="h-3.5 w-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z"/></svg>
                                {{ $company['phones'][0] }}
                            </a>
                            <span class="text-white/30">|</span>
                            <span class="flex items-center gap-1.5 text-white/80">
                                <svg class="h-3.5 w-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/></svg>
                                {{ $company['address'] }}
                            </span>
                        </div>
                        <div class="flex items-center gap-4 text-white/80">
                            <span class="flex items-center gap-1.5">
                                <svg class="h-3.5 w-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                                {{ $company['hours'] }}
                            </span>
                            <span class="text-white/30">|</span>
                            @foreach ($company['socials'] as $social)
                                <a
                                    href="{{ $social['href'] }}"
                                    target="_blank"
                                    rel="noreferrer"
                                    aria-label="{{ $social['name'] }}"
                                    class="flex h-7 w-7 items-center justify-center rounded-sm border border-white/25 text-white/70 transition hover:border-white/50 hover:text-white"
                                >
                                    @if ($social['icon'] === 'facebook')
                                        <svg viewBox="0 0 24 24" class="h-3.5 w-3.5 fill-current" aria-hidden="true"><path d="M13.5 22v-8.2h2.8l.4-3.2h-3.2V8.5c0-.9.3-1.6 1.7-1.6h1.8V4.1c-.3 0-1.4-.1-2.6-.1-2.6 0-4.4 1.6-4.4 4.5v2.1H8v3.2h2.7V22h2.8Z"/></svg>
                                    @elseif ($social['icon'] === 'whatsapp')
                                        <svg viewBox="0 0 24 24" class="h-3.5 w-3.5 fill-current" aria-hidden="true"><path d="M20.5 11.8A8.5 8.5 0 0 1 8 19.3L3 21l1.8-4.8a8.5 8.5 0 1 1 15.7-4.4Zm-8.4-7A7 7 0 0 0 6 15.4l.2.3-1 2.8 2.9-.9.3.2a7 7 0 1 0 3.7-13Zm4.2 8.9c-.2-.1-1.3-.6-1.5-.6s-.4-.1-.6.2-.7.8-.8 1c-.2.2-.3.2-.6.1a5.8 5.8 0 0 1-1.7-1.1 6.3 6.3 0 0 1-1.2-1.5c-.1-.3 0-.4.1-.5l.4-.5.2-.4a.5.5 0 0 0 0-.5c-.1-.1-.6-1.4-.8-1.9-.2-.5-.4-.4-.6-.4h-.5a1 1 0 0 0-.7.3c-.2.2-.9.8-.9 1.9s.9 2.2 1 2.4c.1.1 1.8 2.8 4.3 3.8.6.3 1.1.4 1.4.5.6.2 1.1.2 1.5.1.5-.1 1.3-.6 1.5-1.1.2-.5.2-1 .1-1.1 0-.1-.2-.2-.4-.3Z"/></svg>
                                    @else
                                        <svg viewBox="0 0 24 24" class="h-3.5 w-3.5 fill-current" aria-hidden="true"><path d="M3 6.8A1.8 1.8 0 0 1 4.8 5h14.4A1.8 1.8 0 0 1 21 6.8v10.4a1.8 1.8 0 0 1-1.8 1.8H4.8A1.8 1.8 0 0 1 3 17.2V6.8Zm2 .3v.3l7 5.2 7-5.2V7H5Zm14 10V9.7l-6.4 4.7a1 1 0 0 1-1.2 0L5 9.7v7.4h14Z"/></svg>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="nav-shell">
                    <div class="page-grid flex items-center justify-between py-4">
                        <a href="/" class="flex min-w-0 items-center gap-4">
                            <div class="logo-panel shrink-0">
                                <img src="{{ asset($company['logo_path']) }}" alt="{{ $company['name'] }} logo" class="h-11 w-auto object-contain">
                            </div>
                        </a>

                        <nav class="relative hidden items-center gap-2 xl:flex">
                            @foreach ($navigation as $item)
                                @php
                                    $path = trim($item['path'], '/');
                                    $childActive = collect($item['children'] ?? [])->contains(function (array $child) use ($currentPath) {
                                        $childPath = trim($child['path'], '/');
                                        return $currentPath === $childPath || ($childPath !== '' && str_starts_with($currentPath, $childPath.'/'));
                                    });
                                    $isActive = $path === ''
                                        ? $currentPath === ''
                                        : $currentPath === $path || str_starts_with($currentPath, $path.'/') || $childActive;
                                    $isMega = ! empty($item['children']) && $item['label'] === 'Products';
                                @endphp

                                <div class="{{ $isMega ? 'group' : 'group relative' }}">
                                    @if (! empty($item['children']))
                                        <span class="{{ $isActive ? 'nav-pill nav-pill-active' : 'nav-pill' }} inline-flex cursor-default select-none items-center gap-1.5">
                                            {{ $item['label'] }}
                                            <svg class="h-3.5 w-3.5 transition-transform duration-200 group-hover:rotate-180 {{ $isActive ? 'text-white/70' : 'text-stone-400' }}" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
                                            </svg>
                                        </span>
                                    @else
                                        <a href="{{ $item['path'] }}" class="{{ $isActive ? 'nav-pill nav-pill-active' : 'nav-pill' }}">
                                            {{ $item['label'] }}
                                        </a>
                                    @endif

                                    @if ($isMega)
                                        {{-- ===== MEGA MENU: Products ===== --}}
                                        <div class="pointer-events-none absolute left-1/2 top-full z-30 -translate-x-1/2 pt-2 opacity-0 transition duration-200 group-hover:pointer-events-auto group-hover:opacity-100">
                                            <div class="w-[780px] overflow-hidden rounded-sm border border-stone-100 bg-white shadow-2xl">

                                                {{-- Header --}}
                                                <div class="flex items-center justify-between border-b border-stone-100 bg-stone-50 px-5 py-3">
                                                    <p class="text-[0.62rem] font-semibold uppercase tracking-widest text-stone-400">Our Product Range</p>
                                                    <p class="text-[0.62rem] text-stone-400">Fired clay · Made in Uganda</p>
                                                </div>

                                                {{-- Cards: "All Products" full-width, then 2-col grid --}}
                                                <div class="p-3">
                                                    @php
                                                        $navChildren = $item['children'];
                                                    @endphp

                                                    {{-- All Products — full-width banner row --}}
                                                    <a href="{{ $navChildren[0]['path'] }}"
                                                       class="group/card mb-2 flex items-center gap-4 rounded-sm border border-stone-100 bg-stone-50 px-4 py-3 transition hover:border-[#b86033]/25 hover:bg-[#fdf3ec]">
                                                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-sm border border-stone-200 bg-white text-stone-400 transition group-hover/card:border-[#b86033]/40 group-hover/card:text-[#b86033]">
                                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z"/></svg>
                                                        </span>
                                                        <div class="flex-1 min-w-0">
                                                            <p class="text-sm font-semibold text-stone-900 transition group-hover/card:text-[#b86033]">{{ $navChildren[0]['label'] }}</p>
                                                        </div>
                                                        <svg class="h-4 w-4 shrink-0 text-stone-300 transition group-hover/card:translate-x-0.5 group-hover/card:text-[#b86033]" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
                                                    </a>

                                                    {{-- Category cards: 4-column grid –– row 1: Bricks/Floor Tiles/Ventilators/Decorative Bricks, row 2: Other Products --}}
                                                    <div class="grid grid-cols-4 gap-1.5">
                                                        @foreach (array_slice($navChildren, 1) as $child)
                                                            <a href="{{ $child['path'] }}"
                                                               class="group/card block rounded-sm border border-stone-100 p-3.5 transition hover:border-[#b86033]/25 hover:bg-[#fdf3ec]">
                                                                <p class="text-sm font-semibold text-stone-900 transition group-hover/card:text-[#b86033]">{{ $child['label'] }}</p>
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                {{-- Footer --}}
                                                <div class="flex items-center justify-between border-t border-stone-100 bg-stone-50 px-5 py-3">
                                                    <p class="text-xs text-stone-400">Fired clay · Matanga, Masaka, Uganda</p>
                                                    <a href="{{ route('calculator') }}" class="inline-flex items-center gap-1.5 text-[0.68rem] font-semibold text-[#b86033] transition hover:text-[#a0532b]">
                                                        Brick Calculator
                                                        <svg class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
                                                    </a>
                                                </div>

                                            </div>
                                        </div>

                                    @elseif (! empty($item['children']))
                                        {{-- ===== Standard dropdown ===== --}}
                                        <div class="pointer-events-none absolute left-0 top-full z-30 pt-4 opacity-0 transition duration-200 group-hover:pointer-events-auto group-hover:opacity-100">
                                            <div class="w-56 rounded-sm border border-stone-100 bg-white p-1.5 shadow-xl">
                                                @foreach ($item['children'] as $child)
                                                    <a href="{{ $child['path'] }}" class="block rounded-sm px-4 py-2.5 text-sm text-stone-700 transition hover:bg-[#fdf3ec] hover:text-[#b86033]">
                                                        {{ $child['label'] }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </nav>

                        <div class="hidden items-center gap-3 lg:flex">
                            <a href="/contact" class="cta-secondary-dark">Contact Us</a>
                            <a href="{{ route('login') }}" class="cta-primary-dark">Login</a>
                        </div>

                        <button
                            type="button"
                            class="inline-flex h-10 w-10 items-center justify-center rounded-sm border border-stone-200 bg-white/70 text-stone-900 transition hover:bg-white xl:hidden"
                            @click="open = ! open"
                            aria-label="Toggle navigation"
                        >
                            <svg x-show="! open" x-cloak class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/></svg>
                            <svg x-show="open" x-cloak class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </div>

                <div x-cloak x-show="open" x-transition.opacity class="pb-4 xl:hidden">
                    <div class="nav-shell border-t-0">
                        <div class="page-grid space-y-3 py-4">
                            @foreach ($navigation as $item)
                                <div class="rounded-sm border border-[#ead0bb]/70 bg-white/60 p-4">
                                    @if (! empty($item['children']))
                                        <span class="flex items-center justify-between text-base font-semibold text-stone-950">
                                            {{ $item['label'] }}
                                            <svg class="h-4 w-4 text-stone-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/></svg>
                                        </span>
                                    @else
                                        <a href="{{ $item['path'] }}" class="block text-base font-semibold text-stone-950">{{ $item['label'] }}</a>
                                    @endif
                                    @if (! empty($item['children']))
                                        <div class="mt-3 grid gap-2 pl-1">
                                            @foreach ($item['children'] as $child)
                                                <a href="{{ $child['path'] }}" class="text-sm text-stone-700 transition hover:text-stone-950">{{ $child['label'] }}</a>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                            <div class="grid gap-3 sm:grid-cols-2">
                                <a href="/contact" class="cta-secondary-dark">Contact Us</a>
                                <a href="{{ route('login') }}" class="cta-primary-dark">Login</a>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            {{-- Spacer to prevent content jump when header becomes fixed --}}
            <div x-show="scrolled" x-cloak style="height: var(--nav-height, 65px)"></div>

            <main class="site-main">
                @yield('content')
            </main>

            @if ($currentPath === '' || $currentPath === 'contact')
                @include('site.partials.talk-to-us')
            @endif

            @yield('after_cta')

            <footer class="mt-8">
                <div class="footer-shell">
                    <div class="page-grid py-12">
                        @php
                            $mainLinks = [
                                ['label' => 'Home', 'path' => '/'],
                                ['label' => 'About Us', 'path' => '/about'],
                                ['label' => 'Capabilities', 'path' => '/services'],
                                ['label' => 'Products', 'path' => '/products'],
                                ['label' => 'FAQ', 'path' => '/help-center'],
                                ['label' => 'Contact', 'path' => '/contact'],
                            ];

                            $opportunityLinks = [
                                ['label' => 'Opportunities', 'path' => '/opportunities'],
                                ['label' => 'Talk to Us', 'path' => '/contact'],
                            ];
                        @endphp

                        <div class="grid gap-10 lg:grid-cols-[1fr_2fr] xl:grid-cols-[1fr_1.8fr_1.3fr]">

                            {{-- Col 1: Brand --}}
                            <div class="space-y-5">
                                <div class="flex items-center gap-4">
                                    <div class="logo-panel">
                                        <img src="{{ asset($company['logo_path']) }}" alt="{{ $company['name'] }} logo" class="h-11 w-auto object-contain">
                                    </div>
                                    <div>
                                        <p class="font-display text-lg font-semibold text-white">{{ $company['name'] }}</p>
                                        <p class="text-sm text-white/70">{{ $company['tagline'] }}</p>
                                    </div>
                                </div>
                                <p class="footer-note max-w-md">
                                    Established in {{ $company['founded'] }}, Butende Brick Works continues to supply fired clay products for homes,
                                    institutions, and commercial projects that value strength, warmth, and long-term performance.
                                </p>
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-white/80">Social media</p>
                                    <div class="mt-3 flex flex-wrap gap-3">
                                        @foreach ($company['socials'] as $social)
                                            <a href="{{ $social['href'] }}" target="_blank" rel="noreferrer"
                                               aria-label="{{ $social['name'] }}" class="social-icon-button">
                                                @if ($social['icon'] === 'facebook')
                                                    <svg viewBox="0 0 24 24" class="h-5 w-5 fill-current" aria-hidden="true"><path d="M13.5 22v-8.2h2.8l.4-3.2h-3.2V8.5c0-.9.3-1.6 1.7-1.6h1.8V4.1c-.3 0-1.4-.1-2.6-.1-2.6 0-4.4 1.6-4.4 4.5v2.1H8v3.2h2.7V22h2.8Z"/></svg>
                                                @elseif ($social['icon'] === 'whatsapp')
                                                    <svg viewBox="0 0 24 24" class="h-5 w-5 fill-current" aria-hidden="true"><path d="M20.5 11.8A8.5 8.5 0 0 1 8 19.3L3 21l1.8-4.8a8.5 8.5 0 1 1 15.7-4.4Zm-8.4-7A7 7 0 0 0 6 15.4l.2.3-1 2.8 2.9-.9.3.2a7 7 0 1 0 3.7-13Zm4.2 8.9c-.2-.1-1.3-.6-1.5-.6s-.4-.1-.6.2-.7.8-.8 1c-.2.2-.3.2-.6.1a5.8 5.8 0 0 1-1.7-1.1 6.3 6.3 0 0 1-1.2-1.5c-.1-.3 0-.4.1-.5l.4-.5.2-.4a.5.5 0 0 0 0-.5c-.1-.1-.6-1.4-.8-1.9-.2-.5-.4-.4-.6-.4h-.5a1 1 0 0 0-.7.3c-.2.2-.9.8-.9 1.9s.9 2.2 1 2.4c.1.1 1.8 2.8 4.3 3.8.6.3 1.1.4 1.4.5.6.2 1.1.2 1.5.1.5-.1 1.3-.6 1.5-1.1.2-.5.2-1 .1-1.1 0-.1-.2-.2-.4-.3Z"/></svg>
                                                @else
                                                    <svg viewBox="0 0 24 24" class="h-5 w-5 fill-current" aria-hidden="true"><path d="M3 6.8A1.8 1.8 0 0 1 4.8 5h14.4A1.8 1.8 0 0 1 21 6.8v10.4a1.8 1.8 0 0 1-1.8 1.8H4.8A1.8 1.8 0 0 1 3 17.2V6.8Zm2 .3v.3l7 5.2 7-5.2V7H5Zm14 10V9.7l-6.4 4.7a1 1 0 0 1-1.2 0L5 9.7v7.4h14Z"/></svg>
                                                @endif
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            {{-- Col 2: Links (2×2 sub-grid) --}}
                            <div class="w-full max-w-7xl mx-auto grid grid-cols-2 gap-6 lg:grid-cols-4">
                                <!-- Main Pages -->
                                <div>
                                    <h2 class="footer-heading">Main Pages</h2>
                                    <div class="mt-5 flex flex-col gap-2">
                                        @foreach ($mainLinks as $link)
                                            <a href="{{ $link['path'] }}" class="footer-link">{{ $link['label'] }}</a>
                                        @endforeach
                                    </div>
                                </div>
                                <!-- Products -->
                                <div>
                                    <h2 class="footer-heading">Products</h2>
                                    <div class="mt-5 flex flex-col gap-2">
                                        @php
                                            $productNavLinks = collect($navigation)->firstWhere('label', 'Products')['children'] ?? [];
                                        @endphp
                                        @foreach ($productNavLinks as $link)
                                            <a href="{{ $link['path'] }}" class="footer-link">{{ $link['label'] }}</a>
                                        @endforeach
                                    </div>
                                </div>
                                <!-- Support -->
                                <div>
                                    <h2 class="footer-heading">Support</h2>
                                    <div class="mt-5 flex flex-col gap-2">
                                        @foreach ($opportunityLinks as $link)
                                            <a href="{{ $link['path'] }}" class="footer-link">{{ $link['label'] }}</a>
                                        @endforeach
                                    </div>
                                </div>
                                <!-- Hours -->
                                <div>
                                    <h2 class="footer-heading">Hours</h2>
                                    <div class="mt-5 flex flex-col gap-2 text-sm text-white/65">
                                        <p>{{ $company['hours'] }}</p>
                                        <p class="mt-3 text-xs text-white/45">Closed on Sundays and public holidays.</p>
                                    </div>
                                </div>
                            </div>

                            {{-- Col 3: Quick Quote Form --}}
                            <div>
                                <h2 class="footer-heading">Quick Quote</h2>
                                <p class="mt-2 text-xs leading-5 text-white/55">Get a fast pricing estimate — we reply within one working day.</p>

                                @if (session('talk_to_us_success'))
                                    <div class="mt-4 rounded-sm border border-emerald-400/30 bg-emerald-400/10 px-4 py-3 text-xs font-medium text-emerald-300">
                                        Message sent — we'll be in touch shortly.
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('talk-to-us.store') }}" class="mt-4 grid gap-2.5">
                                    @csrf
                                    <input type="hidden" name="enquiry_type" value="quote">
                                    <input type="hidden" name="source_url" value="{{ url()->current() }}">

                                    <input type="text" name="name" value="{{ old('name') }}"
                                        class="footer-input" placeholder="Your name" required>

                                    <input type="email" name="email" value="{{ old('email') }}"
                                        class="footer-input" placeholder="Email address" required>

                                    <input type="text" name="phone" value="{{ old('phone') }}"
                                        class="footer-input" placeholder="Phone number">

                                    <select name="product_interest" class="footer-input" required>
                                        <option value="" disabled selected>Select product category</option>
                                        @foreach ($productCategories as $cat)
                                            <option value="{{ $cat['name'] }}" @selected(old('product_interest') === $cat['name'])
                                                class="text-stone-900">{{ $cat['name'] }}</option>
                                        @endforeach
                                    </select>

                                    <input type="text" name="quantity" value="{{ old('quantity') }}"
                                        class="footer-input" placeholder="Quantity or scope" required>

                                    <button type="submit" class="cta-form-submit mt-1">
                                        Request Quote
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
                                    </button>
                                </form>
                            </div>

                        </div>

                        <div class="mt-12 flex flex-col gap-4 border-t border-white/20 pt-6 text-sm text-white/70 sm:flex-row sm:items-center sm:justify-between">
                            <p>© {{ now()->year }} {{ $company['name'] }}. All rights reserved.</p>
                            <p>Clay products with strength, warmth, and long-term performance.</p>
                        </div>
                    </div>
                </div>
            </footer>

            <div class="pointer-events-none fixed bottom-5 right-5 z-50 flex flex-col items-end gap-3">
                <a
                    href="https://wa.me/{{ $company['whatsapp_href'] }}"
                    target="_blank"
                    rel="noreferrer"
                    class="pointer-events-auto floating-circle"
                    aria-label="Chat with us on WhatsApp"
                    title="Chat with us"
                >
                    <svg viewBox="0 0 24 24" class="h-5 w-5 fill-current" aria-hidden="true">
                        <path d="M20.5 11.8A8.5 8.5 0 0 1 8 19.3L3 21l1.8-4.8a8.5 8.5 0 1 1 15.7-4.4Zm-8.4-7A7 7 0 0 0 6 15.4l.2.3-1 2.8 2.9-.9.3.2a7 7 0 1 0 3.7-13Zm4.2 8.9c-.2-.1-1.3-.6-1.5-.6s-.4-.1-.6.2-.7.8-.8 1c-.2.2-.3.2-.6.1a5.8 5.8 0 0 1-1.7-1.1 6.3 6.3 0 0 1-1.2-1.5c-.1-.3 0-.4.1-.5l.4-.5.2-.4a.5.5 0 0 0 0-.5c-.1-.1-.6-1.4-.8-1.9-.2-.5-.4-.4-.6-.4h-.5a1 1 0 0 0-.7.3c-.2.2-.9.8-.9 1.9s.9 2.2 1 2.4c.1.1 1.8 2.8 4.3 3.8.6.3 1.1.4 1.4.5.6.2 1.1.2 1.5.1.5-.1 1.3-.6 1.5-1.1.2-.5.2-1 .1-1.1 0-.1-.2-.2-.4-.3Z"/>
                    </svg>
                </a>

                <button
                    type="button"
                    class="pointer-events-auto floating-circle"
                    x-show="showTop"
                    x-transition.opacity
                    @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
                    aria-label="Back to top"
                    title="Back to top"
                >
                    <svg viewBox="0 0 24 24" class="h-5 w-5 fill-current" aria-hidden="true">
                        <path d="M12 5.5 5.7 11.8l1.4 1.4 3.9-3.9V19h2V9.3l3.9 3.9 1.4-1.4L12 5.5Z"/>
                    </svg>
                </button>
            </div>
        </div>
        @stack('scripts')
    </body>
</html>
